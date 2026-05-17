<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('namaLengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $karyawans = $query->latest()->paginate(10)->withQueryString();

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email',
            'nip' => 'required|string|unique:karyawan,nip',
            'divisi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'role' => 'required|in:admin,it,user',
            'aktif' => 'required|boolean',
        ]);

        Karyawan::create($validated);

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
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $karyawan->id,
            'nip' => 'required|string|unique:karyawan,nip,' . $karyawan->id,
            'divisi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'role' => 'required|in:admin,it,user',
            'aktif' => 'required|boolean',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
