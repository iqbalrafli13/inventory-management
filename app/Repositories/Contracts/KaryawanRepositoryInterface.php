<?php

namespace App\Repositories\Contracts;

use App\Models\Karyawan;
use Illuminate\Pagination\LengthAwarePaginator;

interface KaryawanRepositoryInterface
{
    /**
     * Get paginated employees with search functionality.
     */
    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator;

    /**
     * Find an employee by ID.
     */
    public function findById(string $id): ?Karyawan;

    /**
     * Create a new employee.
     */
    public function create(array $data): Karyawan;

    /**
     * Update an employee by ID.
     */
    public function update(string $id, array $data): bool;

    /**
     * Delete an employee by ID.
     */
    public function delete(string $id): bool;
}
