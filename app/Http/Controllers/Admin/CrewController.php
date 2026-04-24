<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crew;
use App\Models\CrewRole;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function index()
    {
        $crews = Crew::all();
        $roles = CrewRole::all();
        return view('admin.crew.index', compact('crews', 'roles'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:crew_roles,name',
        ]);

        CrewRole::create($validated);
        return back()->with('success', 'Role added successfully.');
    }

    public function storeCrew(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Crew::create($validated);
        return back()->with('success', 'Crew member added successfully.');
    }
}
