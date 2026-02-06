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

        // Get centar submission statistics first
        $centarsWithResults = Result::select('centar_id')
            ->distinct()
            ->pluck('centar_id')
            ->toArray();

        // Check if filtering by submission status
        $showCentarList = false;
        $filteredCentars = collect();

        if ($request->filled('submitted_centars') && $request->submitted_centars !== 'all') {
            $showCentarList = true;

            if ($request->submitted_centars === 'submit') {
                // Show centars that have submitted
                $filteredCentars = $centars->filter(function($centar) use ($centarsWithResults) {
                    return in_array($centar->id, $centarsWithResults);
                });
            } elseif ($request->submitted_centars === 'nonsubmit') {
                // Show centars that haven't submitted
                $filteredCentars = $centars->filter(function($centar) use ($centarsWithResults) {
                    return !in_array($centar->id, $centarsWithResults);
                });
            }
        }

        $results = $query->latest()->paginate(20);

        // Get detailed centar statistics
        $centarsWithResults = Result::select('centar_id')
            ->distinct()
            ->pluck('centar_id')
            ->toArray();

        $centarStats = $centars->map(function ($centar) use ($centarsWithResults) {
            $hasResults = in_array($centar->id, $centarsWithResults);
            $resultCount = Result::where('centar_id', $centar->id)->count();

            return [
                'id' => $centar->id,
                'title' => $centar->title,
                'address' => $centar->address,
                'has_results' => $hasResults,
                'result_count' => $resultCount,
            ];
        });

        // Create a quick lookup array for centar result counts and votes
        $centarResultData = [];
        foreach ($centars as $centar) {
            $centarResultData[$centar->id] = [
                'count' => Result::where('centar_id', $centar->id)->count(),
                'votes' => Result::where('centar_id', $centar->id)->sum('total_vote'),
            ];
        }

        $submittedCount = $centarStats->where('has_results', true)->count();
        $notSubmittedCount = $centarStats->where('has_results', false)->count();

        return view('admin.results.index', compact(
            'results',
            'ashons',
            'centars',
            'markas',
            'centarStats',
            'submittedCount',
            'notSubmittedCount',
            'showCentarList',
            'filteredCentars',
            'centarsWithResults',
            'centarResultData'
        ));
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
