<?php

namespace Tests\Unit\Repository;

use App\Models\Karyawan;
use App\Repositories\Eloquent\KaryawanRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryawanRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected KaryawanRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new KaryawanRepository();
    }

    /**
     * Test creating a Karyawan record.
     */
    public function test_can_create_karyawan(): void
    {
        $data = [
            'namaLengkap' => 'John Doe',
            'email' => 'johndoe@example.com',
            'nip' => '12345678',
            'divisi' => 'IT',
            'jabatan' => 'Developer',
            'role' => 'it',
            'aktif' => true,
        ];

        $karyawan = $this->repository->create($data);

        $this->assertInstanceOf(Karyawan::class, $karyawan);
        $this->assertDatabaseHas('karyawan', [
            'namaLengkap' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /**
     * Test finding a Karyawan by ID.
     */
    public function test_can_find_karyawan_by_id(): void
    {
        $karyawan = Karyawan::create([
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '87654321',
            'divisi' => 'HR',
            'jabatan' => 'Manager',
            'role' => 'admin',
            'aktif' => true,
        ]);

        $found = $this->repository->findById($karyawan->id);

        $this->assertNotNull($found);
        $this->assertEquals($karyawan->id, $found->id);
        $this->assertEquals('Jane Doe', $found->namaLengkap);
    }

    /**
     * Test updating an existing Karyawan.
     */
    public function test_can_update_karyawan(): void
    {
        $karyawan = Karyawan::create([
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '87654321',
            'divisi' => 'HR',
            'jabatan' => 'Manager',
            'role' => 'admin',
            'aktif' => true,
        ]);

        $updateData = [
            'namaLengkap' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'nip' => '87654321',
            'divisi' => 'HRD',
            'jabatan' => 'Senior Manager',
            'role' => 'admin',
            'aktif' => false,
        ];

        $result = $this->repository->update($karyawan->id, $updateData);

        $this->assertTrue($result);
        $this->assertDatabaseHas('karyawan', [
            'id' => $karyawan->id,
            'namaLengkap' => 'Jane Smith',
            'aktif' => false,
        ]);
    }

    /**
     * Test deleting a Karyawan record.
     */
    public function test_can_delete_karyawan(): void
    {
        $karyawan = Karyawan::create([
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '87654321',
            'divisi' => 'HR',
            'jabatan' => 'Manager',
            'role' => 'admin',
            'aktif' => true,
        ]);

        $result = $this->repository->delete($karyawan->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('karyawan', [
            'id' => $karyawan->id,
        ]);
    }

    /**
     * Test paginating and searching Karyawan records.
     */
    public function test_can_paginate_and_search_karyawan(): void
    {
        Karyawan::create([
            'namaLengkap' => 'John Doe',
            'email' => 'johndoe@example.com',
            'nip' => '1111',
            'divisi' => 'IT',
            'jabatan' => 'Dev',
            'role' => 'it',
            'aktif' => true,
        ]);

        Karyawan::create([
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '2222',
            'divisi' => 'HR',
            'jabatan' => 'Manager',
            'role' => 'admin',
            'aktif' => true,
        ]);

        // Search matches namaLengkap
        $paginated = $this->repository->paginate(10, 'John');
        $this->assertCount(1, $paginated->items());
        $this->assertEquals('John Doe', $paginated->items()[0]->namaLengkap);

        // Search matches email
        $paginated = $this->repository->paginate(10, 'janedoe');
        $this->assertCount(1, $paginated->items());
        $this->assertEquals('Jane Doe', $paginated->items()[0]->namaLengkap);

        // Search matches NIP
        $paginated = $this->repository->paginate(10, '2222');
        $this->assertCount(1, $paginated->items());
        $this->assertEquals('Jane Doe', $paginated->items()[0]->namaLengkap);
    }
}
