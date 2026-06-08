<?php

namespace Tests\Unit\Request;

use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class KaryawanRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test StoreKaryawanRequest rules with valid data.
     */
    public function test_store_request_passes_with_valid_data(): void
    {
        $request = new StoreKaryawanRequest();
        $rules = $request->rules();

        $data = [
            'namaLengkap' => 'John Doe',
            'email' => 'johndoe@example.com',
            'nip' => '12345678',
            'divisi' => 'IT',
            'jabatan' => 'Developer',
            'role' => 'it',
            'aktif' => true,
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /**
     * Test StoreKaryawanRequest rules with invalid data.
     */
    public function test_store_request_fails_with_invalid_data(): void
    {
        $request = new StoreKaryawanRequest();
        $rules = $request->rules();

        $data = [
            'namaLengkap' => '', // Required
            'email' => 'not-an-email', // Email format
            'nip' => '', // Required
            'divisi' => '', // Required
            'jabatan' => '', // Required
            'role' => 'invalid-role', // Must be in:admin,it,user
            'aktif' => 'not-boolean', // Must be boolean
        ];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('namaLengkap', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('nip', $validator->errors()->toArray());
        $this->assertArrayHasKey('divisi', $validator->errors()->toArray());
        $this->assertArrayHasKey('jabatan', $validator->errors()->toArray());
        $this->assertArrayHasKey('role', $validator->errors()->toArray());
        $this->assertArrayHasKey('aktif', $validator->errors()->toArray());
    }

    /**
     * Test UpdateKaryawanRequest rules.
     */
    public function test_update_request_passes_with_valid_data(): void
    {
        $request = new UpdateKaryawanRequest();
        
        // Mock route retrieval to ignore specific ID for unique validation
        $request->setMethod('PUT');
        $request->setRouteResolver(function () {
            $routeMock = $this->createMock(\Illuminate\Routing\Route::class);
            $routeMock->method('parameter')
                ->with('karyawan')
                ->willReturn('some-uuid-1234');
            return $routeMock;
        });

        $rules = $request->rules();

        $data = [
            'namaLengkap' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'nip' => '87654321',
            'divisi' => 'Finance',
            'jabatan' => 'Accountant',
            'role' => 'user',
            'aktif' => false,
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }
}
