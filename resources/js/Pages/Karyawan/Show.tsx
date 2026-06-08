import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { PageProps } from '@/types';
import SecondaryButton from '@/Components/SecondaryButton';

interface Karyawan {
    id: string;
    namaLengkap: string;
    email: string;
    nip: string;
    divisi: string;
    jabatan: string;
    role: 'admin' | 'it' | 'user';
    aktif: boolean;
    created_at: string;
    updated_at: string;
}

interface Props extends PageProps {
    karyawan: Karyawan;
}

export default function Show({ auth, karyawan }: Props) {
    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Detail Karyawan</h2>}
        >
            <Head title={`Detail Karyawan - ${karyawan.namaLengkap}`} />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div className="flex justify-between items-center border-b pb-4 mb-6">
                            <div>
                                <h3 className="text-2xl font-bold text-gray-900">{karyawan.namaLengkap}</h3>
                                <p className="text-sm text-gray-500">NIP: {karyawan.nip}</p>
                            </div>
                            <div>
                                <span
                                    className={`px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                        karyawan.aktif
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800'
                                    }`}
                                >
                                    {karyawan.aktif ? 'Aktif' : 'Non-Aktif'}
                                </span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                                <p className="mt-1 text-sm text-gray-900">{karyawan.email}</p>
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Divisi</label>
                                <p className="mt-1 text-sm text-gray-900">{karyawan.divisi}</p>
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Jabatan</label>
                                <p className="mt-1 text-sm text-gray-900">{karyawan.jabatan}</p>
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Role Hak Akses</label>
                                <p className="mt-1 text-sm text-gray-900 capitalize">{karyawan.role}</p>
                            </div>
                        </div>

                        <div className="flex items-center justify-end border-t pt-4">
                            <Link href={route('karyawan.index')}>
                                <SecondaryButton className="mr-3">Kembali ke Daftar</SecondaryButton>
                            </Link>
                            <Link href={route('karyawan.edit', karyawan.id)}>
                                <span className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer">
                                    Edit Karyawan
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
