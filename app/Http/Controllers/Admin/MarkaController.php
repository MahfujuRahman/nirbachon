<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marka;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class MarkaController extends Controller
{
    public function index()
    {
        $markas = Marka::latest()->paginate(20);
        return view('admin.markas.index', compact('markas'));
    }

    public function create()
    {
        return view('admin.markas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize image to 200x200 using Intervention Image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());
            $img->cover(200, 200);

            // Save to storage
            $path = 'markas/' . $filename;
            Storage::disk('public')->put($path, $img->encode());

            $data['image'] = $path;
        }

        Marka::create($data);

        return redirect()->route('admin.markas.index')->with('success', 'Marka created successfully.');
    }

    public function edit(Marka $marka)
    {
        return view('admin.markas.edit', compact('marka'));
    }

    public function update(Request $request, Marka $marka)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($marka->image) {
                Storage::disk('public')->delete($marka->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize image to 200x200 using Intervention Image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());
            $img->cover(200, 200);

            // Save to storage
            $path = 'markas/' . $filename;
            Storage::disk('public')->put($path, $img->encode());

            $data['image'] = $path;
        }

        $marka->update($data);

        return redirect()->route('admin.markas.index')->with('success', 'Marka updated successfully.');
    }

    public function destroy(Marka $marka)
    {
        if ($marka->image) {
            Storage::disk('public')->delete($marka->image);
        }

        $marka->delete();
        return redirect()->route('admin.markas.index')->with('success', 'Marka deleted successfully.');
    }
}
