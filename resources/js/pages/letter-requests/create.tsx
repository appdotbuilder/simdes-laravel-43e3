import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';

interface LetterType {
    id: number;
    name: string;
    description: string;
    requirements: string[];
    fee: number;
    processing_days: number;
}



interface Props {
    letterTypes: LetterType[];
    [key: string]: unknown;
}

export default function CreateLetterRequest({ letterTypes }: Props) {
    const [selectedLetterType, setSelectedLetterType] = useState<LetterType | null>(null);
    
    const { data, setData, post, processing, errors } = useForm({
        letter_type_id: '',
        purpose: '',
        attachments: [] as File[],
        additional_data: {} as Record<string, string>,
    });

    const handleLetterTypeChange = (letterTypeId: string) => {
        setData('letter_type_id', letterTypeId);
        const selected = letterTypes.find(type => type.id.toString() === letterTypeId);
        setSelectedLetterType(selected || null);
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const files = Array.from(e.target.files || []);
        setData('attachments', files);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('letter-requests.store'));
    };

    const formatRupiah = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    };

    return (
        <>
            <Head title="Ajukan Surat Baru" />
            <AppLayout>
                <div className="p-6 max-w-4xl mx-auto">
                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">
                            📝 Ajukan Permohonan Surat Baru
                        </h1>
                        <p className="text-gray-600">
                            Pilih jenis surat yang ingin Anda ajukan dan lengkapi persyaratan yang diperlukan
                        </p>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-8">
                        {/* Letter Type Selection */}
                        <div className="bg-white rounded-lg shadow p-6">
                            <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                1️⃣ Pilih Jenis Surat
                            </h2>
                            
                            <div className="grid gap-4">
                                {letterTypes.map((letterType) => (
                                    <div
                                        key={letterType.id}
                                        className={`border rounded-lg p-4 cursor-pointer transition-colors ${
                                            data.letter_type_id === letterType.id.toString()
                                                ? 'border-blue-500 bg-blue-50'
                                                : 'border-gray-200 hover:border-gray-300'
                                        }`}
                                        onClick={() => handleLetterTypeChange(letterType.id.toString())}
                                    >
                                        <div className="flex items-start justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center mb-2">
                                                    <input
                                                        type="radio"
                                                        name="letter_type_id"
                                                        value={letterType.id}
                                                        checked={data.letter_type_id === letterType.id.toString()}
                                                        onChange={() => handleLetterTypeChange(letterType.id.toString())}
                                                        className="mr-3"
                                                    />
                                                    <h3 className="text-lg font-semibold text-gray-900">
                                                        {letterType.name}
                                                    </h3>
                                                </div>
                                                <p className="text-gray-600 mb-2">{letterType.description}</p>
                                                <div className="flex items-center text-sm text-gray-500 space-x-4">
                                                    <span>💰 Biaya: {formatRupiah(letterType.fee)}</span>
                                                    <span>⏱️ Proses: {letterType.processing_days} hari kerja</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            
                            {errors.letter_type_id && (
                                <p className="text-red-600 text-sm mt-2">{errors.letter_type_id}</p>
                            )}
                        </div>

                        {/* Requirements */}
                        {selectedLetterType && (
                            <div className="bg-white rounded-lg shadow p-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                    2️⃣ Persyaratan Dokumen
                                </h2>
                                
                                <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                    <h3 className="text-lg font-medium text-yellow-800 mb-2">
                                        📋 Dokumen yang harus disiapkan:
                                    </h3>
                                    <ul className="list-disc list-inside space-y-1 text-yellow-700">
                                        {selectedLetterType.requirements.map((requirement, index) => (
                                            <li key={index}>{requirement}</li>
                                        ))}
                                    </ul>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Lampiran Dokumen
                                    </label>
                                    <input
                                        type="file"
                                        multiple
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        onChange={handleFileChange}
                                        className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    />
                                    <p className="text-xs text-gray-500 mt-1">
                                        Maksimal 5 file, format JPG, PNG, atau PDF, ukuran maksimal 2MB per file
                                    </p>
                                    {errors.attachments && (
                                        <p className="text-red-600 text-sm mt-1">{errors.attachments}</p>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* Purpose */}
                        {selectedLetterType && (
                            <div className="bg-white rounded-lg shadow p-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                    3️⃣ Tujuan Pembuatan Surat
                                </h2>
                                
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Jelaskan tujuan dan keperluan pembuatan surat ini *
                                    </label>
                                    <textarea
                                        value={data.purpose}
                                        onChange={(e) => setData('purpose', e.target.value)}
                                        rows={4}
                                        className="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Contoh: Untuk keperluan mendaftar beasiswa S1 di Universitas XYZ..."
                                        required
                                    />
                                    <p className="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                                    {errors.purpose && (
                                        <p className="text-red-600 text-sm mt-1">{errors.purpose}</p>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* Submit */}
                        {selectedLetterType && (
                            <div className="bg-white rounded-lg shadow p-6">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <h3 className="text-lg font-semibold text-gray-900">
                                            🚀 Siap untuk mengajukan permohonan?
                                        </h3>
                                        <p className="text-gray-600">
                                            Pastikan semua data sudah benar dan dokumen sudah dilampirkan.
                                        </p>
                                    </div>
                                    <div className="space-x-4">
                                        <Button
                                            type="button"
                                            variant="outline"
                                            onClick={() => window.history.back()}
                                        >
                                            ◀️ Kembali
                                        </Button>
                                        <Button
                                            type="submit"
                                            disabled={processing}
                                            className="min-w-[120px]"
                                        >
                                            {processing ? '⏳ Memproses...' : '📤 Ajukan Permohonan'}
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        )}
                    </form>
                </div>
            </AppLayout>
        </>
    );
}