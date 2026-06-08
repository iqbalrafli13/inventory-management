<?php

namespace App\Repositories\Eloquent;

use App\Models\Karyawan;
use App\Repositories\Contracts\KaryawanRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class KaryawanRepository implements KaryawanRepositoryInterface
{
    /**
     * Get paginated employees with search functionality.
     */
    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Karyawan::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('namaLengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find an employee by ID.
     */
    public function findById(string $id): ?Karyawan
    {
        return Karyawan::find($id);
    }

    /**
     * Create a new employee.
     */
    public function create(array $data): Karyawan
    {
        return Karyawan::create($data);
    }

    /**
     * Update an employee by ID.
     */
    public function update(string $id, array $data): bool
    {
        $karyawan = Karyawan::findOrFail($id);
        return $karyawan->update($data);
    }

    /**
     * Delete an employee by ID.
     */
    public function delete(string $id): bool
    {
        $karyawan = Karyawan::findOrFail($id);
        return $karyawan->delete();
    }
}
