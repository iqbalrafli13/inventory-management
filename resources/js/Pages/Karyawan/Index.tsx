import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, router } from '@inertiajs/react';
import { PageProps } from '@/types';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import TextInput from '@/Components/TextInput';
import { FormEventHandler } from 'react';

interface Karyawan {
    id: string;
    namaLengkap: string;
    email: string;
    nip: string;
    divisi: string;
    jabatan: string;
    role: 'admin' | 'it' | 'user';
    aktif: boolean;
}

interface Props extends PageProps {
    karyawans: {
        data: Karyawan[];
        links: any[];
        current_page: number;
        last_page: number;
        total: number;
    };
    filters: {
        search: string;
    };
}

export default function Index({ auth, karyawans, filters }: Props) {
    const { data, setData, get } = useForm({
        search: filters.search || '',
    });

    const handleSearch: FormEventHandler = (e) => {
        e.preventDefault();
        get(route('karyawan.index'), {
            preserveState: true,
            replace: true,
        });
    };

    const handleDelete = (id: string) => {
        if (confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) {
            router.delete(route('karyawan.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Master Karyawan</h2>}
        >
            <Head title="Master Karyawan" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div className="flex justify-between items-center mb-6">
                            <form onSubmit={handleSearch} className="flex items-center gap-2">
                                <TextInput
                                    placeholder="Cari nama, email, atau NIP..."
                                    className="w-64"
                                    value={data.search}
                                    onChange={(e) => setData('search', e.target.value)}
                                />
                                <PrimaryButton type="submit">Cari</PrimaryButton>
                            </form>

                            <Link href={route('karyawan.create')}>
                                <PrimaryButton>Tambah Karyawan</PrimaryButton>
                            </Link>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Divisi / Jabatan</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {karyawans.data.length > 0 ? (
                                        karyawans.data.map((karyawan) => (
                                            <tr key={karyawan.id}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{karyawan.namaLengkap}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{karyawan.nip}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{karyawan.email}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div>{karyawan.divisi}</div>
                                                    <div className="text-xs text-gray-400">{karyawan.jabatan}</div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                        karyawan.role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                        karyawan.role === 'it' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'
                                                    }`}>
                                                        {karyawan.role.toUpperCase()}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                        karyawan.aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                                    }`}>
                                                        {karyawan.aktif ? 'Aktif' : 'Nonaktif'}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <Link
                                                        href={route('karyawan.edit', karyawan.id)}
                                                        className="text-indigo-600 hover:text-indigo-900 mr-4"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button
                                                        onClick={() => handleDelete(karyawan.id)}
                                                        className="text-red-600 hover:text-red-900"
                                                    >
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-4 text-center text-gray-500">Tidak ada data karyawan ditemukan.</td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>

                        {/* Simple Pagination */}
                        <div className="mt-6 flex justify-center">
                            {karyawans.links.map((link, index) => (
                                <Link
                                    key={index}
                                    href={link.url || ''}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                    className={`mx-1 px-3 py-1 border rounded ${
                                        link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'
                                    } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
