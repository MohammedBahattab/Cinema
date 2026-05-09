<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    // عرض صفحة الاستديو
    public function index()
    {
        $studios = Studio::all();
        return view('admin.studios.index', compact('studios'));
    }
    
    // الدالة الخاصه بعرض الانشاء 

    public function create()
    {
        return view('admin.studios.create');
    }

    // تخزين بيانات الاستديو
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'founded_year' => 'nullable|digits:4|integer',
        ]);

        Studio::create($validated);
        return redirect()->route('admin.studios.index')->with('success', 'Studio created successfully.');
    }

    // الدالة الخاصه بعرض التعديل

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    // تحديث البيانات وتعديلها

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'founded_year' => 'nullable|digits:4|integer',
        ]);

        $studio->update($validated);
        return redirect()->route('admin.studios.index')->with('success', 'Studio updated successfully.');
    }

    public function destroy(Studio $studio)
    {
        $studio->delete();
        return redirect()->route('admin.studios.index')->with('success', 'Studio deleted successfully.');
    }
}
