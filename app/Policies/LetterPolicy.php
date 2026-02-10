<?php

namespace App\Policies;

use App\Models\Letter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LetterPolicy
{
    public function view(User $user, Letter $letter): Response
    {
        // mahasiswa: hanya boleh lihat surat miliknya sendiri
        if ($user->isStudent()){
            return $user->id === $letter->user_id
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses ke surat ini.');
        }

        // staff/ketua: hanya boleh lihat surat dari divisinya
        $letterDivisionId = $letter->letterType->division_id;
        return $user->division_id === $letterDivisionId
            ? Response::allow()
            : Response::deny('Surat ini bukan milik divisi anda.');
    }

    public function approve(User $user, Letter $letter): Response
    {
        // hanya staff/ketua dari divisi surat
        if (!$user->isStaff()){
            return Response::deny('Hanya staff yang dapat menyetujui surat ini.');
        }

        $letterDivisionId = $letter->letterType->division_id;
        if ($user->division_id !== $letterDivisionId){
            return Response::deny('Anda tidak berwenang menyetujui surat ini.');
        }

        // surat harus dalam status 'menunggu'
        if ($letter->status !== 'menunggu'){
            return Response::deny('Surat ini sudah diproses.');
        }

        return Response::allow();
    }

    public function delete(User $user, Letter $letter): Response
    {
        if (!$user->isDivisionHead()){
            return Response::deny('Hanya ketua divisi yang dapat menghapus surat.');
        }

        $letterDivisionId = $letter->letterType->division_id;
        return $user->division_id === $letterDivisionId
            ? Response::allow()
            : Response::deny('Anda tidak berwenang menghapus surat ini.');
    }

    public function update(User $user, Letter $letter): Response
    {
        return $this->delete($user, $letter);
    }
}