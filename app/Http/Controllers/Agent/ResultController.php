<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\ResultImage;
use App\Models\Ashon;
use App\Models\Centars;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    public function create()
    {
        $agent = auth()->user();
        $centars = Centars::where('id', auth()->user()->centar_id)->get();
        $markas = Marka::get();
        return view('agent.results.create', compact('centars', 'agent', 'markas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'centar_id' => 'required|exists:centars,id',
            'marka_id' => 'required|exists:markas,id',
            'total_vote' => 'required|numeric|min:0',
            'candidate_name' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $agent = auth()->user();

        $existingResult = Result::where('user_id', $agent->id)
            ->where('centar_id', $request->centar_id)
            ->where('marka_id', $request->marka_id)
            ->first();

        if ($existingResult) {
            return redirect()->back()->withErrors(['error' => 'You have already submitted a result for this centar and marka.']);
        }

        $result = Result::create([
            'ashon_id' => 1,
            'centar_id' => $request->centar_id,
            'marka_id' => $request->marka_id,
            'user_id' => $agent->id,
            'total_vote' => $request->total_vote,
            'candidate_name' => $request->candidate_name,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('results', $filename, 'public');

                ResultImage::create([
                    'result_id' => $result->id,
                    'ashon_id' => 1,
                    'centar_id' => $request->centar_id,
                    'marka_id' => $request->marka_id,
                    'user_id' => $agent->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('agent.dashboard')->with('success', 'Result uploaded successfully with ' . ($request->hasFile('images') ? count($request->file('images')) : 0) . ' images.');
    }

    public function edit(Result $result)
    {
        // Only allow editing own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        $centars = Centars::where('id', auth()->user()->centar_id)->get();
        $markas = Marka::get();
        return view('agent.results.edit', compact('result', 'centars', 'markas'));
    }

    public function update(Request $request, Result $result)
    {
        // Only allow editing own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        // Log what we received for debugging
        \Log::info('Update request received', [
            'has_files' => $request->hasFile('images'),
            'all_files' => $request->allFiles(),
            'images_input' => $request->input('images'),
        ]);

        $request->validate([
            'centar_id' => 'required|exists:centars,id',
            'marka_id' => 'required|exists:markas,id',
            'total_vote' => 'required|numeric|min:0',
            'candidate_name' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $result->update([
            'centar_id' => $request->centar_id,
            'marka_id' => $request->marka_id,
            'total_vote' => $request->total_vote,
            'candidate_name' => $request->candidate_name,
        ]);

        $imageCount = 0;
        if ($request->hasFile('images')) {
            \Log::info('Processing images', ['count' => count($request->file('images'))]);

            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('results', $filename, 'public');

                ResultImage::create([
                    'result_id' => $result->id,
                    'image' => $path,
                ]);
                $imageCount++;

                \Log::info('Image uploaded', ['filename' => $filename, 'path' => $path]);
            }
        } else {
            \Log::info('No images in request');
        }

        $message = $imageCount > 0
            ? "Result updated successfully with {$imageCount} new image(s)."
            : 'Result updated successfully.';

        return redirect()->route('agent.dashboard')->with('success', $message);
    }

    public function deleteImage(ResultImage $image)
    {
        // Only allow deleting own result images
        if ($image->result->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function createOtherImages()
    {
        $agent = auth()->user();
        $ashons = Ashon::all();
        $centars = Centars::where('id', auth()->user()->centar_id)->get();
        $markas = Marka::all();

        return view('agent.other-images.create', compact('ashons', 'centars', 'markas', 'agent'));
    }

    public function storeOtherImages(Request $request)
    {
        $request->validate([
            'centar_id' => 'required|exists:centars,id',
            'marka_id' => 'required|exists:markas,id',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $agent = auth()->user();
        $imageCount = 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('other-images', $filename, 'public');

                ResultImage::create([
                    'result_id' => null,  // No result_id for other images
                    'ashon_id' => 1,
                    'centar_id' => $request->centar_id,
                    'marka_id' => $request->marka_id,
                    'user_id' => $agent->id,
                    'image' => $path,
                ]);
                $imageCount++;
            }
        }

        return redirect()->route('agent.dashboard')->with('success', "Successfully uploaded {$imageCount} image(s) to Others section.");
    }

    public function deleteOtherImage(ResultImage $image)
    {
        // Only allow deleting own images and ensure it's an "other" image (no result_id)
        if ($image->user_id !== auth()->id() || $image->result_id !== null) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
