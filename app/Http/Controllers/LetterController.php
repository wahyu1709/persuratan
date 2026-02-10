<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Clock\now;
use Illuminate\Validation\ValidationException;

class LetterController extends Controller
{
    // mahasiswa ajukan & lihat surat

    public function create()
    {
        $letterTypes = LetterType::active()->get();
        return view('letters.create', compact('letterTypes'));
    }

    public function store(Request $request){
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
        ]);

        $letterType = LetterType::findOrFail($request->letter_type_id);

        // validasi field dinamis
        $rules = [];
        $customMessage = [];

        if ($letterType->required_fields){
            foreach ($letterType->required_fields as $field){
                $rules[$field] = 'required|string|max:255';
                $customMessage["{$field}.required"] = "Kolom {$field} wajib diisi.";
            }
        }

        $dynamicData = $request->validate($rules, $customMessage);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('attachment')){
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        Letter::create([
            'user_id' => auth()->id(),
            'letter_type_id' => $letterType->id,
            'data' => $dynamicData,
            'file_path' => $filePath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('letters.my')->with('success', 'Surat berhasil diajukan!');
    }

    public function myLetters(){
        $letters = auth()->user()->submittedLetters()->latest()->get();
        return view('letters.my', compact('letters'));
    }

    // Staff: Kelola surat divisi

    public function index(){
        // hanya surat dari divisi user yang sedang login
        $letters = Letter::forCurrentUserDivision()
        ->with('student', 'letterType')
        ->latest()
        ->paginate(10);

        return view('admin.letters.index', compact('letters'));
    }

    public function approve(Letter $letter){
        $this->authorize('approve', $letter);

        $letter->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Surat berhasil disetujui!');
    }

    public function reject(Request $request, Letter $letter){
        $this->authorize('approve', $letter); // reject = bagian dari approval

        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $letter->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Surat telah ditolak!');
    }

    // Ketua divisi: Hapus surat

    public function destroy(Letter $letter){
        $this->authorize('delete', $letter);

        // Hapus file lampiran jika ada
        if ($letter->file_path){
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return back()->with('success', 'Surat berhasil dihapus!');
    }
}
