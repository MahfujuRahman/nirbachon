<?php

namespace App\Http\Controllers;

use App\Models\Ashon;
use App\Models\Centars;
use App\Models\Marka;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $ashons = Ashon::all();
        $selectedAshon = request('ashon_id', Ashon::first()?->id);
        $selectedCentar = request('centar_id');

        // Get centars for filter
        $centars = Centars::query()
            ->when($selectedAshon, function ($query) use ($selectedAshon) {
                $query->where('ashon_id', $selectedAshon);
            })
            ->orderBy('title')
            ->get();

        // Get overall results grouped by marka
        $overallResults = Result::query()
            ->when($selectedAshon, function ($query) use ($selectedAshon) {
                $query->where('ashon_id', $selectedAshon);
            })
            ->select('marka_id', DB::raw('SUM(total_vote) as total_votes'))
            ->groupBy('marka_id')
            ->with('marka')
            ->get()
            ->sortByDesc('total_votes');

        // Calculate total votes for overall
        $totalVotes = $overallResults->sum('total_votes');

        // Calculate percentages for overall
        $overallResults = $overallResults->map(function ($result) use ($totalVotes) {
            $result->percentage = $totalVotes > 0 ? round(($result->total_votes / $totalVotes) * 100, 2) : 0;
            return $result;
        });

        // Get centar-wise results
        $centarResults = Result::query()
            ->when($selectedAshon, function ($query) use ($selectedAshon) {
                $query->where('ashon_id', $selectedAshon);
            })
            ->when($selectedCentar, function ($query) use ($selectedCentar) {
                $query->where('centar_id', $selectedCentar);
            })
            ->with(['centar', 'marka'])
            ->select('centar_id', 'marka_id', DB::raw('SUM(total_vote) as total_votes'))
            ->groupBy('centar_id', 'marka_id')
            ->get()
            ->groupBy('centar_id');

        // Process centar results
        $centarResults = $centarResults->map(function ($centarGroup) {
            $totalVotes = $centarGroup->sum('total_votes');
            $results = $centarGroup->sortByDesc('total_votes')->map(function ($result) use ($totalVotes) {
                $result->percentage = $totalVotes > 0 ? round(($result->total_votes / $totalVotes) * 100, 2) : 0;
                return $result;
            });
            return [
                'centar' => $centarGroup->first()->centar,
                'total_votes' => $totalVotes,
                'results' => $results,
            ];
        })->sortByDesc('total_votes');

        return view('home', compact('overallResults', 'centarResults', 'ashons', 'centars', 'selectedAshon', 'selectedCentar', 'totalVotes'));
    }
}
