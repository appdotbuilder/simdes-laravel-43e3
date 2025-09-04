import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';

interface LetterRequest {
    id: number;
    request_number: string;
    status: string;
    submitted_at: string;
    letter_type: {
        name: string;
    };
    user?: {
        name: string;
        resident?: {
            name: string;
        };
    };
}

interface PaginationData {
    data: LetterRequest[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

interface Props {
    requests: PaginationData;
    canManage: boolean;
    [key: string]: unknown;
}

export default function LetterRequestsIndex({ requests, canManage }: Props) {
    const getStatusColor = (status: string) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800',
            reviewing: 'bg-blue-100 text-blue-800',
            approved: 'bg-green-100 text-green-800',
            rejected: 'bg-red-100 text-red-800',
            completed: 'bg-purple-100 text-purple-800'
        };
        return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800';
    };

    const getStatusText = (status: string) => {
        const texts = {
            pending: 'Menunggu',
            reviewing: 'Ditinjau',
            approved: 'Disetujui',
            rejected: 'Ditolak',
            completed: 'Selesai'
        };
        return texts[status as keyof typeof texts] || status;
    };

    return (
        <>
            <Head title="Permohonan Surat" />
            <AppLayout>
                <div className="p-6">
                    {/* Header */}
                    <div className="flex justify-between items-center mb-8">
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900 mb-2">
                                📄 {canManage ? 'Kelola Permohonan Surat' : 'Permohonan Surat Saya'}
                            </h1>
                            <p className="text-gray-600">
                                {canManage ? 'Kelola semua permohonan surat dari masyarakat' : 'Lihat status permohonan surat Anda'}
                            </p>
                        </div>
                        {!canManage && (
                            <Link href="/letter-requests/create">
                                <Button>
                                    ➕ Ajukan Surat Baru
                                </Button>
                            </Link>
                        )}
                    </div>

                    {/* Stats Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div className="bg-white rounded-lg shadow p-4">
                            <div className="flex items-center">
                                <div className="text-xl mr-3">📊</div>
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Total</p>
                                    <p className="text-xl font-bold text-gray-900">{requests.total}</p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white rounded-lg shadow p-4">
                            <div className="flex items-center">
                                <div className="text-xl mr-3">⏳</div>
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Pending</p>
                                    <p className="text-xl font-bold text-yellow-600">
                                        {requests.data.filter(r => r.status === 'pending').length}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white rounded-lg shadow p-4">
                            <div className="flex items-center">
                                <div className="text-xl mr-3">🔄</div>
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Diproses</p>
                                    <p className="text-xl font-bold text-blue-600">
                                        {requests.data.filter(r => ['reviewing', 'approved'].includes(r.status)).length}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="bg-white rounded-lg shadow p-4">
                            <div className="flex items-center">
                                <div className="text-xl mr-3">✅</div>
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Selesai</p>
                                    <p className="text-xl font-bold text-green-600">
                                        {requests.data.filter(r => r.status === 'completed').length}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Requests List */}
                    <div className="bg-white rounded-lg shadow overflow-hidden">
                        {requests.data.length ? (
                            <>
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                            <tr>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nomor Permohonan
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Jenis Surat
                                                </th>
                                                {canManage && (
                                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Pemohon
                                                    </th>
                                                )}
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tanggal
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                            {requests.data.map((request) => (
                                                <tr key={request.id} className="hover:bg-gray-50">
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <div className="text-sm font-medium text-gray-900">
                                                            {request.request_number}
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <div className="text-sm text-gray-900">
                                                            {request.letter_type.name}
                                                        </div>
                                                    </td>
                                                    {canManage && (
                                                        <td className="px-6 py-4 whitespace-nowrap">
                                                            <div className="text-sm text-gray-900">
                                                                {request.user?.resident?.name || request.user?.name}
                                                            </div>
                                                        </td>
                                                    )}
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <div className="text-sm text-gray-500">
                                                            {new Date(request.submitted_at).toLocaleDateString('id-ID')}
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(request.status)}`}>
                                                            {getStatusText(request.status)}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <Link href={`/letter-requests/${request.id}`}>
                                                            <Button size="sm" variant="outline">
                                                                👁️ Detail
                                                            </Button>
                                                        </Link>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>

                                {/* Pagination */}
                                {requests.last_page > 1 && (
                                    <div className="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                        <div className="flex justify-between items-center">
                                            <div className="text-sm text-gray-700">
                                                Menampilkan {((requests.current_page - 1) * requests.per_page) + 1} sampai{' '}
                                                {Math.min(requests.current_page * requests.per_page, requests.total)} dari{' '}
                                                {requests.total} hasil
                                            </div>
                                            <div className="flex space-x-2">
                                                {requests.links.map((link, index) => (
                                                    <div key={index}>
                                                        {link.url ? (
                                                            <Link href={link.url}>
                                                                <Button
                                                                    size="sm"
                                                                    variant={link.active ? "default" : "outline"}
                                                                    className="min-w-[40px]"
                                                                >
                                                                    {link.label.replace(/&laquo;|&raquo;/g, '')}
                                                                </Button>
                                                            </Link>
                                                        ) : (
                                                            <Button
                                                                size="sm"
                                                                variant="outline"
                                                                disabled
                                                                className="min-w-[40px]"
                                                            >
                                                                {link.label.replace(/&laquo;|&raquo;/g, '')}
                                                            </Button>
                                                        )}
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </>
                        ) : (
                            <div className="text-center py-12">
                                <div className="text-6xl mb-4">📭</div>
                                <h3 className="text-lg font-medium text-gray-900 mb-2">
                                    Belum ada permohonan surat
                                </h3>
                                <p className="text-gray-600 mb-6">
                                    {canManage 
                                        ? 'Belum ada permohonan surat yang masuk dari masyarakat.'
                                        : 'Anda belum mengajukan permohonan surat apapun.'
                                    }
                                </p>
                                {!canManage && (
                                    <Link href="/letter-requests/create">
                                        <Button>
                                            ➕ Ajukan Surat Pertama
                                        </Button>
                                    </Link>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </AppLayout>
        </>
    );
}