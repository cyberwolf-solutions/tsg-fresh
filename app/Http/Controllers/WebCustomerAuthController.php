<?php

namespace App\Http\Controllers;

use App\Models\WebCustomer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class WebCustomerAuthController extends Controller
{
    //
    public function register(Request $request)
    {

        // Log::info('Customer registration request received', [
        //     'request_data' => $request->all(),
        // ]);
        $request->validate([
            // 'first_name'        => 'required|string|max:255',
            // 'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:customers,email',
            // 'password'          => 'required|string|min:6|confirmed',
            // 'billing_first_name' => 'required|string|max:255',
            // 'billing_last_name' => 'required|string|max:255',
            // 'street_address'    => 'required|string|max:255',
            // 'town'              => 'required|string|max:255',
            // 'phone'             => 'required|string|max:20',
            // 'billing_email'     => 'required|email',
        ]);

        if (WebCustomer::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'User already exists.'])->withInput();
        }

        $customer = WebCustomer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        BillingAddress::create([
            'customer_id'   => $customer->id,
            'first_name'    => $request->billing_first_name,
            'last_name'     => $request->billing_last_name,
            'street_address' => $request->street_address,
            'town'          => $request->town,
            'phone'         => $request->phone,
            'email'         => $request->billing_email,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->filled('remember'))) {

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('Landing-page.shop-now');
    }


    public function showForgotPasswordForm()
    {
        return view('customer.forgetpassword'); // your blade file
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:web_customers,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        $resetLink = route('customer.reset-password.form', $token);

        // Send email
        Mail::send('customer.customer-reset-password', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Password');
        });

        return back()->with('status', 'We have sent a password reset link to your email.');
    }

    // Show reset form
    public function showResetForm($token)
    {
        return view('customer.resetpassword', ['token' => $token]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        Log::info('Password reset request received', ['request' => $request->all()]);

        $request->validate([
            'email' => 'required|email|exists:web_customers,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ]);
        Log::info('Validation passed for password reset', ['email' => $request->email]);

        $reset = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$reset) {
            Log::warning('Invalid password reset attempt', [
                'email' => $request->email,
                'token' => $request->token
            ]);
            return back()->withErrors(['email' => 'Invalid token or email']);
        }
        Log::info('Valid reset token found', ['email' => $request->email]);

        // Update password
        $customer = WebCustomer::where('email', $request->email)->first();
        if ($customer) {
            $customer->update([
                'password' => Hash::make($request->password)
            ]);
            Log::info('Customer password updated successfully', ['customer_id' => $customer->id]);
        } else {
            Log::error('Customer not found while resetting password', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Customer not found.']);
        }

        // Delete token
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        Log::info('Password reset token deleted', ['email' => $request->email]);

        // ✅ Auto-login the customer
        Auth::guard('customer')->login($customer);
        Log::info('Customer logged in after password reset', ['customer_id' => $customer->id]);

        // Redirect to dashboard
        Log::info('Redirecting customer to dashboard', ['customer_id' => $customer->id]);
        return redirect()->route('customer.dashboard')
            ->with('status', 'Your password has been reset and you are now logged in.');
    }
}
