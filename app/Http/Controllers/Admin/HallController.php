<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\Request;

class HallController extends Controller
{
    // عرض الصالات
    public function index()
    {
        $halls = Hall::all();
        return view('admin.halls.index', compact('halls'));
    }

    // انشاء الصالة

    public function create()
    {
        return view('admin.halls.create');
    }

    // تخزين بياناتها
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        $hall = Hall::create($validated);

        // انشاء عدد المقاعد تلقائيا بناء على عدد الصفوف والاعمدة
        $seatsToInsert = [];
        for ($r = 1; $r <= $validated['total_rows']; $r++) {
            for ($s = 1; $s <= $validated['seats_per_row']; $s++) {
                $seatsToInsert[] = [
                    'hall_id' => $hall->id,
                    'row_number' => $r,
                    'seat_number' => $s,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        Seat::insert($seatsToInsert);

        return redirect()->route('admin.halls.index')->with('success', 'Hall and seats created successfully.');
    }

    // عرض الصالة مع المقاعد

    public function show(Hall $hall)
    {
        $hall->load('seats');
        return view('admin.halls.show', compact('hall'));
    }

    // حذف الصالة
    public function destroy(Hall $hall)
    {
        $hall->delete();
        return redirect()->route('admin.halls.index')->with('success', 'Hall deleted successfully.');
    }
}
