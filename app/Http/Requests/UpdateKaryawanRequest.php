<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $karyawan = $this->route('karyawan');
        $id = is_object($karyawan) ? $karyawan->id : $karyawan;

        return [
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $id,
            'nip' => 'required|string|unique:karyawan,nip,' . $id,
            'divisi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'role' => 'required|in:admin,it,user',
            'aktif' => 'required|boolean',
        ];
    }
}
