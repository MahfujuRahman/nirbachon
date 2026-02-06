<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $agent = auth()->user();
        $results = $agent->results()->with(['centar', 'marka', 'images'])->latest()->paginate(10);

        // Get other images (images without result_id)
        $otherImages = \App\Models\ResultImage::whereNull('result_id')
            ->where('user_id', $agent->id)
            ->with(['ashon', 'centar', 'marka'])
            ->latest()
            ->get();

        return view('agent.dashboard', compact('results', 'otherImages'));
    }
}
