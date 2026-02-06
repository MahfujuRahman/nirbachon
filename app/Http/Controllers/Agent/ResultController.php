<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\ResultImage;
use App\Models\Ashon;
use App\Models\Centars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    public function create()
    {
        $agent = auth()->user();
        $ashons = Ashon::all();
        $centars = Centars::all();

        return view('agent.results.create', compact('ashons', 'centars', 'agent'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ashon_id' => 'required|exists:ashons,id',
            'centar_id' => 'required|exists:centars,id',
            'total_vote' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $agent = auth()->user();

        $result = Result::create([
            'ashon_id' => $request->ashon_id,
            'centar_id' => $request->centar_id,
            'marka_id' => $agent->marka_id,
            'user_id' => $agent->id,
            'total_vote' => $request->total_vote,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('results', $filename, 'public');

                ResultImage::create([
                    'result_id' => $result->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('agent.dashboard')->with('success', 'Result uploaded successfully.');
    }

    public function edit(Result $result)
    {
        // Only allow editing own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        $ashons = Ashon::all();
        $centars = Centars::all();

        return view('agent.results.edit', compact('result', 'ashons', 'centars'));
    }

    public function update(Request $request, Result $result)
    {
        // Only allow editing own results
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'ashon_id' => 'required|exists:ashons,id',
            'centar_id' => 'required|exists:centars,id',
            'total_vote' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $result->update([
            'ashon_id' => $request->ashon_id,
            'centar_id' => $request->centar_id,
            'total_vote' => $request->total_vote,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('results', $filename, 'public');

                ResultImage::create([
                    'result_id' => $result->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('agent.dashboard')->with('success', 'Result updated successfully.');
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
}
