<?php

namespace App\Services;

use App\DTO\KaryawanDTO;
use App\Models\Karyawan;
use App\Repositories\Contracts\KaryawanRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class KaryawanService
{
    public function __construct(
        protected KaryawanRepositoryInterface $karyawanRepository
    ) {}

    /**
     * Get paginated employees list.
     */
    public function getPaginatedKaryawans(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->karyawanRepository->paginate($perPage, $search);
    }

    /**
     * Get details of a single employee by ID.
     */
    public function getKaryawanById(string $id): ?Karyawan
    {
        return $this->karyawanRepository->findById($id);
    }

    /**
     * Create a new employee.
     */
    public function createKaryawan(KaryawanDTO $dto): Karyawan
    {
        return $this->karyawanRepository->create($dto->toArray());
    }

    /**
     * Update an existing employee.
     */
    public function updateKaryawan(string $id, KaryawanDTO $dto): bool
    {
        return $this->karyawanRepository->update($id, $dto->toArray());
    }

    /**
     * Delete an employee.
     */
    public function deleteKaryawan(string $id): bool
    {
        return $this->karyawanRepository->delete($id);
    }
}
