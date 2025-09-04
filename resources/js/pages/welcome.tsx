import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    const { auth } = usePage<{ auth: { user: { role: string } | null } }>().props;

    return (
        <>
            <Head title="Sistem Informasi Administrasi Surat Desa" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
                {/* Navigation */}
                <nav className="bg-white shadow-sm border-b">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center">
                                <div className="text-xl font-bold text-blue-600">
                                    🏛️ SIASDES
                                </div>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link href="/dashboard">
                                        <Button>Dashboard</Button>
                                    </Link>
                                ) : (
                                    <>
                                        <Link href="/login">
                                            <Button variant="outline">Masuk</Button>
                                        </Link>
                                        <Link href="/register">
                                            <Button>Daftar</Button>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center">
                        <h1 className="text-5xl font-bold text-gray-900 mb-6">
                            🏛️ Sistem Informasi <br />
                            <span className="text-blue-600">Administrasi Surat Desa</span>
                        </h1>
                        
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                            Platform digital untuk memfasilitasi pengelolaan data dan permohonan surat di tingkat desa. 
                            Proses yang efisien, transparan, dan mudah diakses oleh seluruh masyarakat.
                        </p>

                        <div className="flex justify-center space-x-4 mb-12">
                            {!auth.user && (
                                <>
                                    <Link href="/register">
                                        <Button size="lg" className="text-lg px-8 py-4">
                                            📝 Daftar Sekarang
                                        </Button>
                                    </Link>
                                    <Link href="/login">
                                        <Button variant="outline" size="lg" className="text-lg px-8 py-4">
                                            🔑 Masuk
                                        </Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">
                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Dashboard Terpadu</h3>
                            <p className="text-gray-600">
                                Akses informasi dan statistik penting dalam satu tampilan yang mudah dipahami.
                            </p>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">📄</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Permohonan Surat Online</h3>
                            <p className="text-gray-600">
                                Ajukan berbagai jenis surat seperti surat domisili, surat usaha, dan lainnya secara online.
                            </p>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Data Penduduk</h3>
                            <p className="text-gray-600">
                                Pengelolaan data keluarga dan penduduk yang terintegrasi dan terorganisir.
                            </p>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">⚡</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Proses Cepat</h3>
                            <p className="text-gray-600">
                                Pemrosesan permohonan surat yang efisien dengan tracking status real-time.
                            </p>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">🔒</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Aman & Terpercaya</h3>
                            <p className="text-gray-600">
                                Sistem keamanan berlapis dengan verifikasi email dan kontrol akses berbasis peran.
                            </p>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                            <div className="text-4xl mb-4">📱</div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">Multi-Platform</h3>
                            <p className="text-gray-600">
                                Akses dari mana saja menggunakan perangkat desktop, tablet, atau smartphone.
                            </p>
                        </div>
                    </div>

                    {/* User Roles Section */}
                    <div className="mt-20">
                        <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                            🎯 Fitur untuk Setiap Peran
                        </h2>
                        
                        <div className="grid md:grid-cols-3 gap-8">
                            <div className="bg-blue-50 rounded-lg p-6">
                                <div className="text-center mb-4">
                                    <div className="text-4xl mb-2">👩‍💼</div>
                                    <h3 className="text-xl font-semibold text-blue-900">Admin Desa</h3>
                                </div>
                                <ul className="text-blue-800 space-y-2">
                                    <li>• Kelola data penduduk & keluarga</li>
                                    <li>• Proses permohonan surat</li>
                                    <li>• Generate laporan</li>
                                    <li>• Manajemen user & blok wilayah</li>
                                </ul>
                            </div>

                            <div className="bg-green-50 rounded-lg p-6">
                                <div className="text-center mb-4">
                                    <div className="text-4xl mb-2">👨‍👩‍👧‍👦</div>
                                    <h3 className="text-xl font-semibold text-green-900">Masyarakat</h3>
                                </div>
                                <ul className="text-green-800 space-y-2">
                                    <li>• Ajukan pembuatan surat online</li>
                                    <li>• Upload persyaratan dokumen</li>
                                    <li>• Track status permohonan</li>
                                    <li>• Download surat yang sudah jadi</li>
                                </ul>
                            </div>

                            <div className="bg-purple-50 rounded-lg p-6">
                                <div className="text-center mb-4">
                                    <div className="text-4xl mb-2">🏛️</div>
                                    <h3 className="text-xl font-semibold text-purple-900">Kepala Desa</h3>
                                </div>
                                <ul className="text-purple-800 space-y-2">
                                    <li>• Monitoring statistik desa</li>
                                    <li>• Akses laporan komprehensif</li>
                                    <li>• Overview permohonan surat</li>
                                    <li>• Dashboard eksekutif</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="mt-20 bg-blue-600 rounded-lg p-8 text-center text-white">
                            <h2 className="text-3xl font-bold mb-4">
                                🚀 Mulai Digitalisasi Administrasi Desa Anda
                            </h2>
                            <p className="text-xl mb-6">
                                Bergabunglah dengan sistem informasi administrasi surat desa yang modern dan efisien
                            </p>
                            <Link href="/register">
                                <Button size="lg" variant="secondary" className="text-lg px-8 py-4">
                                    📝 Daftar Sebagai Warga
                                </Button>
                            </Link>
                        </div>
                    )}
                </div>

                {/* Footer */}
                <footer className="bg-gray-800 text-white py-8">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <p className="text-gray-300">
                            © 2024 Sistem Informasi Administrasi Surat Desa. 
                            Memudahkan pelayanan publik di tingkat desa.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}