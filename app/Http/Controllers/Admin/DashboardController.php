<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_ashons' => \App\Models\Ashon::count(),
            'total_centars' => \App\Models\Centars::count(),
            'total_markas' => \App\Models\Marka::count(),
            'total_agents' => \App\Models\User::where('role', 'agent')->count(),
            'total_results' => \App\Models\Result::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
