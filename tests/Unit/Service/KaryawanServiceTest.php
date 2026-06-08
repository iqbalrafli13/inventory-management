<?php

namespace Tests\Unit\Service;

use App\DTO\KaryawanDTO;
use App\Models\Karyawan;
use App\Repositories\Contracts\KaryawanRepositoryInterface;
use App\Services\KaryawanService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class KaryawanServiceTest extends TestCase
{
    protected $repositoryMock;
    protected KaryawanService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = $this->createMock(KaryawanRepositoryInterface::class);
        $this->service = new KaryawanService($this->repositoryMock);
    }

    /**
     * Test getting paginated list of employees.
     */
    public function test_get_paginated_karyawans(): void
    {
        $paginatorMock = $this->createMock(LengthAwarePaginator::class);
        
        $this->repositoryMock->expects($this->once())
            ->method('paginate')
            ->with(10, 'search-term')
            ->willReturn($paginatorMock);

        $result = $this->service->getPaginatedKaryawans('search-term', 10);

        $this->assertSame($paginatorMock, $result);
    }

    /**
     * Test getting an employee by ID.
     */
    public function test_get_karyawan_by_id(): void
    {
        $karyawan = new Karyawan();
        
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with('some-id')
            ->willReturn($karyawan);

        $result = $this->service->getKaryawanById('some-id');

        $this->assertSame($karyawan, $result);
    }

    /**
     * Test creating a Karyawan.
     */
    public function test_create_karyawan(): void
    {
        $dto = new KaryawanDTO(
            namaLengkap: 'John Doe',
            email: 'johndoe@example.com',
            nip: '1234',
            divisi: 'IT',
            jabatan: 'Dev',
            role: 'it',
            aktif: true
        );

        $karyawan = new Karyawan();

        $this->repositoryMock->expects($this->once())
            ->method('create')
            ->with($dto->toArray())
            ->willReturn($karyawan);

        $result = $this->service->createKaryawan($dto);

        $this->assertSame($karyawan, $result);
    }

    /**
     * Test updating a Karyawan.
     */
    public function test_update_karyawan(): void
    {
        $dto = new KaryawanDTO(
            namaLengkap: 'Jane Doe',
            email: 'janedoe@example.com',
            nip: '5678',
            divisi: 'HR',
            jabatan: 'Manager',
            role: 'admin',
            aktif: false
        );

        $this->repositoryMock->expects($this->once())
            ->method('update')
            ->with('some-id', $dto->toArray())
            ->willReturn(true);

        $result = $this->service->updateKaryawan('some-id', $dto);

        $this->assertTrue($result);
    }

    /**
     * Test deleting a Karyawan.
     */
    public function test_delete_karyawan(): void
    {
        $this->repositoryMock->expects($this->once())
            ->method('delete')
            ->with('some-id')
            ->willReturn(true);

        $result = $this->service->deleteKaryawan('some-id');

        $this->assertTrue($result);
    }
}
