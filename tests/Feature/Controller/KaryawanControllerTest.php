<?php

namespace Tests\Feature\Controller;

use App\Models\Karyawan;
use App\Models\User;
use App\Services\KaryawanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery\MockInterface;
use Tests\TestCase;

class KaryawanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test index displays paginated list of employees.
     */
    public function test_index_displays_karyawans(): void
    {
        $paginatorMock = $this->createMock(LengthAwarePaginator::class);
        $paginatorMock->method('withQueryString')->willReturnSelf();

        $this->mock(KaryawanService::class, function (MockInterface $mock) use ($paginatorMock) {
            $mock->shouldReceive('getPaginatedKaryawans')
                ->once()
                ->with(null, 10)
                ->andReturn($paginatorMock);
        });

        $response = $this->actingAs($this->user)
            ->get(route('karyawan.index'));

        $response->assertStatus(200);
    }

    /**
     * Test create page renders successfully.
     */
    public function test_create_renders_inertia_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('karyawan.create'));

        $response->assertStatus(200);
    }

    /**
     * Test storing a new employee with valid payload.
     */
    public function test_store_creates_karyawan_and_redirects(): void
    {
        $this->mock(KaryawanService::class, function (MockInterface $mock) {
            $mock->shouldReceive('createKaryawan')
                ->once()
                ->andReturn(new Karyawan());
        });

        $data = [
            'namaLengkap' => 'John Doe',
            'email' => 'johndoe@example.com',
            'nip' => '12345678',
            'divisi' => 'IT',
            'jabatan' => 'Developer',
            'role' => 'it',
            'aktif' => true,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('karyawan.store'), $data);

        $response->assertRedirect(route('karyawan.index'));
        $response->assertSessionHas('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Test show page renders successfully.
     */
    public function test_show_renders_inertia_page(): void
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

        $response = $this->actingAs($this->user)
            ->get(route('karyawan.show', $karyawan->id));

        $response->assertStatus(200);
    }

    /**
     * Test edit page renders successfully.
     */
    public function test_edit_renders_inertia_page(): void
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

        $response = $this->actingAs($this->user)
            ->get(route('karyawan.edit', $karyawan->id));

        $response->assertStatus(200);
    }

    /**
     * Test updating an employee with valid payload.
     */
    public function test_update_updates_karyawan_and_redirects(): void
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

        $this->mock(KaryawanService::class, function (MockInterface $mock) use ($karyawan) {
            $mock->shouldReceive('updateKaryawan')
                ->once()
                ->with($karyawan->id, \Mockery::type('\App\DTO\KaryawanDTO'))
                ->andReturn(true);
        });

        $data = [
            'namaLengkap' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'nip' => '87654321',
            'divisi' => 'HRD',
            'jabatan' => 'Senior Manager',
            'role' => 'admin',
            'aktif' => false,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('karyawan.update', $karyawan->id), $data);

        $response->assertRedirect(route('karyawan.index'));
        $response->assertSessionHas('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Test deleting an employee.
     */
    public function test_destroy_deletes_karyawan_and_redirects(): void
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

        $this->mock(KaryawanService::class, function (MockInterface $mock) use ($karyawan) {
            $mock->shouldReceive('deleteKaryawan')
                ->once()
                ->with($karyawan->id)
                ->andReturn(true);
        });

        $response = $this->actingAs($this->user)
            ->delete(route('karyawan.destroy', $karyawan->id));

        $response->assertRedirect(route('karyawan.index'));
        $response->assertSessionHas('success', 'Karyawan berhasil dihapus.');
    }
}
