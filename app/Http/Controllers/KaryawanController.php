<?php

namespace App\Http\Controllers;

use App\DTO\KaryawanDTO;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\Karyawan;
use App\Services\KaryawanService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KaryawanController extends Controller
{
    public function __construct(
        protected KaryawanService $karyawanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $karyawans = $this->karyawanService->getPaginatedKaryawans($search, 10)
            ->withQueryString();

        return Inertia::render('Karyawan/Index', [
            'karyawans' => $karyawans,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Karyawan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        $dto = KaryawanDTO::fromRequest($request);
        $this->karyawanService->createKaryawan($dto);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return Inertia::render('Karyawan/Show', [
            'karyawan' => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return Inertia::render('Karyawan/Edit', [
            'karyawan' => $karyawan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan)
    {
        $dto = KaryawanDTO::fromRequest($request);
        $this->karyawanService->updateKaryawan($karyawan->id, $dto);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $this->karyawanService->deleteKaryawan($karyawan->id);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
