<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ashon;
use Illuminate\Http\Request;

class AshonController extends Controller
{
    public function index()
    {
        $ashons = Ashon::latest()->paginate(20);
        return view('admin.ashons.index', compact('ashons'));
    }

    public function create()
    {
        return view('admin.ashons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Ashon::create($request->all());

        return redirect()->route('admin.ashons.index')->with('success', 'Ashon created successfully.');
    }

    public function edit(Ashon $ashon)
    {
        return view('admin.ashons.edit', compact('ashon'));
    }

    public function update(Request $request, Ashon $ashon)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $ashon->update($request->all());

        return redirect()->route('admin.ashons.index')->with('success', 'Ashon updated successfully.');
    }

    public function destroy(Ashon $ashon)
    {
        $ashon->delete();
        return redirect()->route('admin.ashons.index')->with('success', 'Ashon deleted successfully.');
    }
}
