<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Models\landing_page_items;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\landing_page_sections;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class WebController extends Controller
{
    //
    public function settings()
    {
        $sections = landing_page_sections::with('items')->get();
        return view('admin.web.index', compact('sections'));
    }

    public function storeItem(Request $request)
    {
        Log::info('storeItem called', ['request' => $request->all()]);

        // Step 1: Validate input
        $validated = $request->validate([
            'section_id' => 'required|exists:landing_page_sections,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);
        Log::info('Validation passed', ['validated' => $validated]);

        // Step 2: Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('web', 'public');
            Log::info('Image uploaded', ['imagePath' => $imagePath]);
        } else {
            Log::info('No image uploaded');
        }

        // Step 3: Create item in database
        $item = landing_page_items::create([
            'section_id' => $validated['section_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'order' => $validated['order'] ?? 0,
        ]);
        Log::info('Item created', ['item_id' => $item->id]);

        // Step 4: Redirect with success
        Log::info('Redirecting back with success message');
        return redirect()->back()->with('success', 'Item added successfully');
    }


    public function updateItem(Request $request, landing_page_items $item)
    {
        Log::info('--- Update Item Process Started ---', ['item_id' => $item->id]);

        try {
            // Step 1: Validate
            Log::info('Validating request data...', ['request_data' => $request->all()]);
            $request->merge([
                'is_active' => $request->has('is_active') ? true : false
            ]);
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'button_text' => 'nullable|string|max:50',
                'button_link' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
                'is_active' => 'boolean',
            ]);
            Log::info('Validation passed.', ['validated_data' => $validated]);
        } catch (ValidationException $e) {
            Log::error('Validation failed.', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e; // Re-throw so Laravel still handles the error normally
        }

        // Step 2: Handle image upload
        if ($request->hasFile('image')) {
            Log::info('Image file detected.');

            if ($item->image_path) {
                Log::info('Deleting old image.', ['old_image_path' => $item->image_path]);
                Storage::disk('public')->delete($item->image_path);
            }

            $newImagePath = $request->file('image')->store('web', 'public');
            $validated['image_path'] = $newImagePath;

            Log::info('New image uploaded.', ['new_image_path' => $newImagePath]);
        } else {
            Log::info('No new image uploaded.');
        }

        // Step 3: Update item in DB
        Log::info('Updating item in database...', [
            'item_id' => $item->id,
            'update_data' => $validated
        ]);
        $item->update($validated);

        Log::info('Item update completed successfully.', ['item_id' => $item->id]);
        Log::info('--- Update Item Process Ended ---');

        return redirect()->back()->with('success', 'Item updated successfully');
    }


    public function deleteItem(landing_page_items $item)
    {
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}
