<?php

namespace Tests\Unit\DTO;

use App\DTO\KaryawanDTO;
use App\Http\Requests\StoreKaryawanRequest;
use Tests\TestCase;

class KaryawanDTOTest extends TestCase
{
    /**
     * Test fromArray and toArray methods.
     */
    public function test_can_instantiate_from_array_and_convert_back_to_array(): void
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

        $dto = KaryawanDTO::fromArray($data);

        $this->assertEquals($data['namaLengkap'], $dto->namaLengkap);
        $this->assertEquals($data['email'], $dto->email);
        $this->assertEquals($data['nip'], $dto->nip);
        $this->assertEquals($data['divisi'], $dto->divisi);
        $this->assertEquals($data['jabatan'], $dto->jabatan);
        $this->assertEquals($data['role'], $dto->role);
        $this->assertTrue($dto->aktif);

        $this->assertEquals($data, $dto->toArray());
    }

    /**
     * Test fromRequest method with a StoreKaryawanRequest.
     */
    public function test_can_instantiate_from_request(): void
    {
        $request = new StoreKaryawanRequest();
        $request->merge([
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '87654321',
            'divisi' => 'HRD',
            'jabatan' => 'Manager',
            'role' => 'user',
            'aktif' => false,
        ]);

        $dto = KaryawanDTO::fromRequest($request);

        $this->assertEquals('Jane Doe', $dto->namaLengkap);
        $this->assertEquals('janedoe@example.com', $dto->email);
        $this->assertEquals('87654321', $dto->nip);
        $this->assertEquals('HRD', $dto->divisi);
        $this->assertEquals('Manager', $dto->jabatan);
        $this->assertEquals('user', $dto->role);
        $this->assertFalse($dto->aktif);
    }
}
