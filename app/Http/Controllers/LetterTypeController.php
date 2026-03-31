<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LetterTypeController extends Controller
{
    public function index()
    {
        $letterTypes = LetterType::with('division')->latest()->get();
        $divisions = Division::all();
        return view('admin.letter-types.index', compact('letterTypes', 'divisions'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.letter-types.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:letter_types,code',
            'division_id' => 'required|exists:divisions,id',
            'required_fields' => 'nullable|array',
            'required_fields.*' => 'string|max:50',
            // hapus 'active' dari validate
        ]);

        LetterType::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'division_id' => $validated['division_id'],
            'required_fields' => $validated['required_fields'] ?? [],
            'active' => $request->boolean('active'), // pakai ini
        ]);

        return redirect()->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit(LetterType $letterType)
    {
        $divisions = Division::all();
        return view('admin.letter-types.edit', compact('letterType', 'divisions'));
    }

    public function update(Request $request, LetterType $letterType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:letter_types,code,' . $letterType->id,
            'division_id' => 'required|exists:divisions,id',
            'required_fields' => 'nullable|array',
            'required_fields.*' => 'string|max:50',
            // hapus 'active' dari validate
        ]);

        $letterType->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'division_id' => $validated['division_id'],
            'required_fields' => $validated['required_fields'] ?? [],
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(LetterType $letterType)
    {
        $letterType->delete();
        return back()->with('success', 'Jenis surat berhasil dihapus.');
    }
}