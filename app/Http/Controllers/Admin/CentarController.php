<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ashon;
use App\Models\Centars;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CentarsImport;

class CentarController extends Controller
{
    public function index()
    {
        $centars = Centars::with('ashon')->latest()->paginate(20);
        return view('admin.centars.index', compact('centars'));
    }

    public function create()
    {
        $ashons = Ashon::all();
        return view('admin.centars.create', compact('ashons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ashon_id' => 'required|exists:ashons,id',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Centars::create($request->all());

        return redirect()->route('admin.centars.index')->with('success', 'Centar created successfully.');
    }

    public function edit(Centars $centar)
    {
        $ashons = Ashon::all();
        return view('admin.centars.edit', compact('centar', 'ashons'));
    }

    public function update(Request $request, Centars $centar)
    {
        $request->validate([
            'ashon_id' => 'required|exists:ashons,id',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $centar->update($request->all());

        return redirect()->route('admin.centars.index')->with('success', 'Centar updated successfully.');
    }

    public function destroy(Centars $centar)
    {
        $centar->delete();
        return redirect()->route('admin.centars.index')->with('success', 'Centar deleted successfully.');
    }

    public function importForm()
    {
        return view('admin.centars.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $beforeCount = Centars::count();
            Excel::import(new CentarsImport, $request->file('file'));
            $afterCount = Centars::count();
            $imported = $afterCount - $beforeCount;

            return redirect()->route('admin.centars.index')
                ->with('success', "Successfully imported {$imported} new centars. Duplicates were skipped.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing centars: ' . $e->getMessage());
        }
    }
}
