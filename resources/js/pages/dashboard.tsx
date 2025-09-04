import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';

interface Stats {
    [key: string]: number;
}

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
    };
}

interface Props {
    role: 'admin' | 'resident' | 'village_head';
    stats: Stats;
    recentRequests?: LetterRequest[];
    myRequests?: LetterRequest[];
    [key: string]: unknown;
}

export default function Dashboard({ role, stats, recentRequests, myRequests }: Props) {
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
            <Head title="Dashboard" />
            <AppLayout>
                <div className="p-6">
                    {/* Welcome Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">
                            {role === 'admin' && '👩‍💼 Dashboard Admin'}
                            {role === 'village_head' && '🏛️ Dashboard Kepala Desa'}
                            {role === 'resident' && '👨‍👩‍👧‍👦 Dashboard Warga'}
                        </h1>
                        <p className="text-gray-600">
                            Selamat datang di Sistem Informasi Administrasi Surat Desa
                        </p>
                    </div>

                    {/* Stats Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        {role === 'admin' && (
                            <>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">👥</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Total Penduduk</p>
                                            <p className="text-2xl font-bold text-gray-900">{stats.total_residents}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">🏠</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Total Keluarga</p>
                                            <p className="text-2xl font-bold text-gray-900">{stats.total_families}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">⏳</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Permohonan Pending</p>
                                            <p className="text-2xl font-bold text-yellow-600">{stats.pending_requests}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">✅</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Surat Selesai</p>
                                            <p className="text-2xl font-bold text-green-600">{stats.completed_requests}</p>
                                        </div>
                                    </div>
                                </div>
                            </>
                        )}

                        {role === 'village_head' && (
                            <>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">👥</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Total Penduduk</p>
                                            <p className="text-2xl font-bold text-gray-900">{stats.total_residents}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">🏠</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Total Keluarga</p>
                                            <p className="text-2xl font-bold text-gray-900">{stats.total_families}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">📊</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Permohonan Bulan Ini</p>
                                            <p className="text-2xl font-bold text-blue-600">{stats.monthly_requests}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">✅</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Surat Selesai</p>
                                            <p className="text-2xl font-bold text-green-600">{stats.completed_requests}</p>
                                        </div>
                                    </div>
                                </div>
                            </>
                        )}

                        {role === 'resident' && (
                            <>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">📄</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Total Permohonan</p>
                                            <p className="text-2xl font-bold text-gray-900">{stats.my_requests}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">⏳</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Sedang Proses</p>
                                            <p className="text-2xl font-bold text-yellow-600">{stats.pending_requests}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">✅</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Selesai</p>
                                            <p className="text-2xl font-bold text-green-600">{stats.completed_requests}</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-white rounded-lg shadow p-6">
                                    <div className="flex items-center">
                                        <div className="text-2xl mr-4">📋</div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-600">Jenis Surat Tersedia</p>
                                            <p className="text-2xl font-bold text-blue-600">{stats.available_letter_types}</p>
                                        </div>
                                    </div>
                                </div>
                            </>
                        )}
                    </div>

                    {/* Quick Actions */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {/* Recent/My Requests */}
                        <div className="bg-white rounded-lg shadow">
                            <div className="p-6 border-b border-gray-200">
                                <h2 className="text-lg font-semibold text-gray-900">
                                    {role === 'resident' ? '📄 Permohonan Saya' : '📋 Permohonan Terbaru'}
                                </h2>
                            </div>
                            <div className="p-6">
                                {(role === 'resident' ? myRequests : recentRequests)?.length ? (
                                    <div className="space-y-4">
                                        {(role === 'resident' ? myRequests : recentRequests)!.map((request) => (
                                            <div key={request.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div className="flex-1">
                                                    <p className="font-medium text-gray-900">
                                                        {request.letter_type.name}
                                                    </p>
                                                    <p className="text-sm text-gray-600">
                                                        {request.request_number} 
                                                        {role !== 'resident' && request.user && ` - ${request.user.name}`}
                                                    </p>
                                                    <p className="text-xs text-gray-500">
                                                        {new Date(request.submitted_at).toLocaleDateString('id-ID')}
                                                    </p>
                                                </div>
                                                <span className={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(request.status)}`}>
                                                    {getStatusText(request.status)}
                                                </span>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center text-gray-500 py-8">
                                        <div className="text-4xl mb-4">📭</div>
                                        <p>Belum ada permohonan</p>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Quick Actions */}
                        <div className="bg-white rounded-lg shadow">
                            <div className="p-6 border-b border-gray-200">
                                <h2 className="text-lg font-semibold text-gray-900">🚀 Aksi Cepat</h2>
                            </div>
                            <div className="p-6">
                                <div className="space-y-4">
                                    {role === 'admin' && (
                                        <>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                👥 Kelola Data Penduduk
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📄 Kelola Permohonan Surat
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📊 Lihat Laporan
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                ⚙️ Pengaturan Sistem
                                            </Button>
                                        </>
                                    )}

                                    {role === 'village_head' && (
                                        <>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📊 Lihat Laporan Lengkap
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📈 Statistik Desa
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                👥 Data Penduduk
                                            </Button>
                                        </>
                                    )}

                                    {role === 'resident' && (
                                        <>
                                            <Button className="w-full justify-start text-left">
                                                ➕ Ajukan Surat Baru
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📄 Lihat Semua Permohonan
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                📋 Jenis Surat Tersedia
                                            </Button>
                                            <Button className="w-full justify-start text-left" variant="outline">
                                                👤 Edit Profil
                                            </Button>
                                        </>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AppLayout>
        </>
    );
}