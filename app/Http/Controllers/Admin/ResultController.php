<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Ashon;
use App\Models\Centars;
use App\Models\Marka;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $ashons = Ashon::all();
        $centars = Centars::all();
        $markas = Marka::all();

        $query = Result::with(['ashon', 'centar', 'marka', 'user', 'images']);

        // Filter by ashon
        if ($request->filled('ashon_id')) {
            $query->where('ashon_id', $request->ashon_id);
        }

        // Filter by centar
        if ($request->filled('centar_id')) {
            $query->where('centar_id', $request->centar_id);
        }

        // Filter by marka
        if ($request->filled('marka_id')) {
            $query->where('marka_id', $request->marka_id);
        }

        $results = $query->latest()->paginate(20);

        return view('admin.results.index', compact('results', 'ashons', 'centars', 'markas'));
    }

    public function show(Result $result)
    {
        $result->load(['ashon', 'centar', 'marka', 'user', 'images']);
        return view('admin.results.show', compact('result'));
    }

    public function destroy(Result $result)
    {
        // Delete associated images from storage
        foreach ($result->images as $image) {
            \Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $result->delete();
        return redirect()->route('admin.results.index')->with('success', 'Result deleted successfully.');
    }
}
