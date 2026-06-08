<?php

namespace App\DTO;

use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;

readonly class KaryawanDTO
{
    public function __construct(
        public string $namaLengkap,
        public string $email,
        public string $nip,
        public string $divisi,
        public string $jabatan,
        public string $role,
        public bool $aktif
    ) {}

    /**
     * Create a DTO from a StoreKaryawanRequest or UpdateKaryawanRequest.
     */
    public static function fromRequest(StoreKaryawanRequest|UpdateKaryawanRequest $request): self
    {
        return new self(
            namaLengkap: $request->input('namaLengkap'),
            email: $request->input('email'),
            nip: $request->input('nip'),
            divisi: $request->input('divisi'),
            jabatan: $request->input('jabatan'),
            role: $request->input('role'),
            aktif: (bool) $request->input('aktif')
        );
    }

    /**
     * Create a DTO from an associative array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            namaLengkap: $data['namaLengkap'],
            email: $data['email'],
            nip: $data['nip'],
            divisi: $data['divisi'],
            jabatan: $data['jabatan'],
            role: $data['role'],
            aktif: (bool) $data['aktif']
        );
    }

    /**
     * Convert DTO to an array for database operation.
     */
    public function toArray(): array
    {
        return [
            'namaLengkap' => $this->namaLengkap,
            'email' => $this->email,
            'nip' => $this->nip,
            'divisi' => $this->divisi,
            'jabatan' => $this->jabatan,
            'role' => $this->role,
            'aktif' => $this->aktif,
        ];
    }
}
