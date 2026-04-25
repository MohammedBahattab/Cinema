<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crew;
use App\Models\CrewRole;
use App\Models\Movie;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function index()
    {
        $crews = Crew::with('movies')->get();
        $roles = CrewRole::all();
        $movies = Movie::all();
        return view('admin.crew.index', compact('crews', 'roles', 'movies'));
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
            'movies' => 'nullable|array',
            'movies.*.movie_id' => 'required|exists:movies,id',
            'movies.*.role_id' => 'required|exists:crew_roles,id',
        ]);

        $crew = Crew::create(['name' => $validated['name']]);

        if (!empty($validated['movies'])) {
            foreach ($validated['movies'] as $movieData) {
                $crew->movies()->attach($movieData['movie_id'], [
                    'crew_role_id' => $movieData['role_id']
                ]);
            }
        }

        return back()->with('success', 'Crew member and movie associations added successfully.');
    }

    public function edit(Crew $crew)
    {
        $crew->load('movies');
        $roles = CrewRole::all();
        $movies = Movie::all();
        return view('admin.crew.edit', compact('crew', 'roles', 'movies'));
    }

    public function update(Request $request, Crew $crew)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'movies' => 'nullable|array',
            'movies.*.movie_id' => 'required|exists:movies,id',
            'movies.*.role_id' => 'required|exists:crew_roles,id',
        ]);

        $crew->update(['name' => $validated['name']]);

        // Sync associations: Prepare data for sync
        $syncData = [];
        if (!empty($validated['movies'])) {
            foreach ($validated['movies'] as $movieData) {
                // Since a person can have multiple roles in the SAME movie, 
                // standard sync() might not work perfectly if we want duplicates.
                // But for simplicity, we'll assume unique (movie, role) per person.
                $syncData[$movieData['movie_id']] = ['crew_role_id' => $movieData['role_id']];
            }
        }
        
        $crew->movies()->sync($syncData);

        return redirect()->route('admin.crew.index')->with('success', 'Crew member updated successfully.');
    }

    public function destroy(Crew $crew)
    {
        $crew->delete(); // This will also delete pivot entries if defined correctly or use cascade
        return back()->with('success', 'Crew member deleted successfully.');
    }

    public function destroyRole(CrewRole $role)
    {
        // Check if role is in use
        $count = \DB::table('movie_crew')->where('crew_role_id', $role->id)->count();
        if ($count > 0) {
            return back()->with('error', 'Cannot delete role. It is currently assigned to ' . $count . ' crew associations.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
