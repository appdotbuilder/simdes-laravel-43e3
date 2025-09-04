import React from 'react';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppHeader } from '@/components/app-header';
import { AppContent } from '@/components/app-content';
import { usePage } from '@inertiajs/react';

interface AppLayoutProps {
    children: React.ReactNode;
}

export default function AppLayout({ children }: AppLayoutProps) {
    const { auth } = usePage<{ auth: { user: { role: string } | null } }>().props;

    if (!auth.user) {
        return (
            <div className="min-h-screen bg-gray-100">
                {children}
            </div>
        );
    }

    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <main className="flex flex-1 flex-col overflow-hidden">
                <AppHeader />
                <AppContent>
                    {children}
                </AppContent>
            </main>
        </AppShell>
    );
}