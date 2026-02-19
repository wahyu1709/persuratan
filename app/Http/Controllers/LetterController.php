<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
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

    public function index()
{
        $pendingLetters = Letter::forCurrentUserDivision()
            ->whereIn('status', ['menunggu', 'verifikasi'])
            ->with('student', 'letterType')
            ->latest()
            ->paginate(10);

        $pendingCount = $pendingLetters->total();

        return view('admin.letters.index', compact('pendingLetters', 'pendingCount'));
    }

    public function show(Letter $letter)
    {
        Gate::authorize('view', $letter);
        return view('letters.show', compact('letter'));
    }

    public function approve(Letter $letter){
        Gate::authorize('approve', $letter);
        $letter->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return back()->with('success', 'Surat telah disetujui.');
    }

    public function reject(Request $request, Letter $letter){
        Gate::authorize('approve', $letter); // reject = bagian dari approval

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
        Gate::authorize('delete', $letter);

        // Hapus file lampiran jika ada
        if ($letter->file_path){
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return back()->with('success', 'Surat berhasil dihapus!');
    }

    public function verify(Letter $letter)
    {
        Gate::authorize('verify', $letter);
        $letter->update(['status' => 'verifikasi']);
        return back()->with('success', 'Dokumen sedang diverifikasi.');
    }

    public function uploadVerified(Request $request, Letter $letter)
    {
        Gate::authorize('verify', $letter); // pastikan staff berwenang

        $request->validate([
            'verified_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
        ]);

        // Hapus file lama jika ada
        if ($letter->verified_file_path) {
            Storage::disk('public')->delete($letter->verified_file_path);
        }

        // Simpan file baru
        $filePath = $request->file('verified_file')->store('verified', 'public');

        $letter->update(['verified_file_path' => $filePath]);

        return back()->with('success', 'Dokumen hasil verifikasi berhasil diunggah.');
    }
}
