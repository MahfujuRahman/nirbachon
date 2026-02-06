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

        return view('agent.dashboard', compact('results'));
    }
}
