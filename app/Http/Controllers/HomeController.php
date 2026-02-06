<?php

namespace App\Http\Controllers;

use App\Models\Ashon;
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

        // Get live results grouped by marka
        $results = Result::query()
            ->when($selectedAshon, function ($query) use ($selectedAshon) {
                $query->where('ashon_id', $selectedAshon);
            })
            ->select('marka_id', DB::raw('SUM(total_vote) as total_votes'))
            ->groupBy('marka_id')
            ->with('marka')
            ->get()
            ->sortByDesc('total_votes');

        // Calculate total votes
        $totalVotes = $results->sum('total_votes');

        // Calculate percentages
        $results = $results->map(function ($result) use ($totalVotes) {
            $result->percentage = $totalVotes > 0 ? round(($result->total_votes / $totalVotes) * 100, 2) : 0;
            return $result;
        });

        return view('home', compact('results', 'ashons', 'selectedAshon', 'totalVotes'));
    }
}
