<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use FilesystemIterator;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    public function dashboard()
    {
        $tenantsCount = \App\Models\Tenant::count();
        $activeTenantsCount = \App\Models\Tenant::has('domains')->count();
        $activePercentage = $tenantsCount > 0 ? round(($activeTenantsCount / $tenantsCount) * 100) : 0;

        $recentTenants = \App\Models\Tenant::with('domains')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $databaseUsage = $this->getDatabaseUsagePercent();
        $storageUsage = $this->getStorageUsagePercent();
        $lastBackup = $this->getLastBackupTime();


        return view('admin.dashboard.index', compact(
            'tenantsCount',
            'activeTenantsCount',
            'activePercentage',
            'recentTenants',
            'databaseUsage',
            'storageUsage',
            'lastBackup',

        ));
    }

    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        log::debug('Credentials received', ['username' => $credentials['username'], ['PASSWORD' => $credentials['password']]]);


        $admin = Admin::where('username', $credentials['username'])->first();

        if (!$admin) {
            Log::warning('Admin not found', ['username' => $credentials['username']]);
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }


        if (!Hash::check($credentials['password'], $admin->password)) {
            Log::warning('Password mismatch', ['admin_id' => $admin->id]);
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }


        Auth::guard('admin')->login($admin, $request->filled('remember'));

        if ($request->wantsJson()) {
            return response()->json([
                'redirect' => route('admin.dashboard')
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    // widgets
    private function getDatabaseUsagePercent()
    {
        $dbName = config('database.connections.mysql.database');

        $sizeInMB = DB::select("
        SELECT SUM(data_length + index_length) / 1024 / 1024 AS size 
        FROM information_schema.tables 
        WHERE table_schema = ?
    ", [$dbName])[0]->size ?? 0;

        $maxAllowedMB = 500; // set your own max allowed size
        return round(($sizeInMB / $maxAllowedMB) * 100, 2);
    }
    private function getStorageUsagePercent()
    {
        $storagePath = storage_path('app');
        $sizeInBytes = $this->getFolderSize($storagePath);
        $sizeInMB = $sizeInBytes / 1024 / 1024;

        $maxAllowedMB = 1000; // set your own limit
        return round(($sizeInMB / $maxAllowedMB) * 100, 2);
    }

    private function getFolderSize($dir)
    {
        $size = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
    private function getLastBackupTime()
    {
        $backupDir = storage_path('backups');

        if (!is_dir($backupDir)) {
            return 'No backup found';
        }

        $files = scandir($backupDir, SCANDIR_SORT_DESCENDING);
        foreach ($files as $file) {
            if (is_file($backupDir . '/' . $file)) {
                return date('M d, Y H:i', filemtime($backupDir . '/' . $file));
            }
        }
        return 'No backup found';
    }
}
