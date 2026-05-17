import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { PageProps } from '@/types';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';
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
    karyawan: Karyawan;
}

export default function Edit({ auth, karyawan }: Props) {
    const { data, setData, patch, processing, errors } = useForm({
        namaLengkap: karyawan.namaLengkap,
        email: karyawan.email,
        nip: karyawan.nip,
        divisi: karyawan.divisi,
        jabatan: karyawan.jabatan,
        role: karyawan.role,
        aktif: karyawan.aktif,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        patch(route('karyawan.update', karyawan.id));
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit Karyawan: {karyawan.namaLengkap}</h2>}
        >
            <Head title={`Edit Karyawan - ${karyawan.namaLengkap}`} />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel htmlFor="namaLengkap" value="Nama Lengkap" />
                                    <TextInput
                                        id="namaLengkap"
                                        className="mt-1 block w-full"
                                        value={data.namaLengkap}
                                        onChange={(e) => setData('namaLengkap', e.target.value)}
                                        required
                                        isFocused
                                    />
                                    <InputError message={errors.namaLengkap} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="nip" value="NIP" />
                                    <TextInput
                                        id="nip"
                                        className="mt-1 block w-full"
                                        value={data.nip}
                                        onChange={(e) => setData('nip', e.target.value)}
                                        required
                                    />
                                    <InputError message={errors.nip} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        className="mt-1 block w-full"
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        required
                                    />
                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="divisi" value="Divisi" />
                                    <TextInput
                                        id="divisi"
                                        className="mt-1 block w-full"
                                        value={data.divisi}
                                        onChange={(e) => setData('divisi', e.target.value)}
                                        required
                                    />
                                    <InputError message={errors.divisi} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="jabatan" value="Jabatan" />
                                    <TextInput
                                        id="jabatan"
                                        className="mt-1 block w-full"
                                        value={data.jabatan}
                                        onChange={(e) => setData('jabatan', e.target.value)}
                                        required
                                    />
                                    <InputError message={errors.jabatan} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="role" value="Role" />
                                    <select
                                        id="role"
                                        className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value={data.role}
                                        onChange={(e) => setData('role', e.target.value as any)}
                                        required
                                    >
                                        <option value="user">User</option>
                                        <option value="it">IT</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    <InputError message={errors.role} className="mt-2" />
                                </div>

                                <div className="flex items-center">
                                    <label className="flex items-center">
                                        <input
                                            type="checkbox"
                                            className="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            checked={data.aktif}
                                            onChange={(e) => setData('aktif', e.target.checked)}
                                        />
                                        <span className="ml-2 text-sm text-gray-600">Status Aktif</span>
                                    </label>
                                    <InputError message={errors.aktif} className="mt-2" />
                                </div>
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <Link href={route('karyawan.index')}>
                                    <SecondaryButton className="mr-3">Batal</SecondaryButton>
                                </Link>
                                <PrimaryButton disabled={processing}>Perbarui Karyawan</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
