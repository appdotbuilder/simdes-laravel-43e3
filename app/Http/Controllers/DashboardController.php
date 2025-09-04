<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Family;
use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'village_head') {
            return $this->villageHeadDashboard();
        } else {
            return $this->residentDashboard();
        }
    }

    /**
     * Display admin dashboard.
     */
    protected function adminDashboard()
    {
        $stats = [
            'total_residents' => Resident::active()->count(),
            'total_families' => Family::active()->count(),
            'total_blocks' => Block::active()->count(),
            'pending_requests' => LetterRequest::where('status', 'pending')->count(),
            'completed_requests' => LetterRequest::where('status', 'completed')->count(),
            'active_letter_types' => LetterType::active()->count(),
        ];

        $recentRequests = LetterRequest::with(['user', 'letterType'])
            ->latest('submitted_at')
            ->limit(10)
            ->get();

        return Inertia::render('dashboard', [
            'role' => 'admin',
            'stats' => $stats,
            'recentRequests' => $recentRequests,
        ]);
    }

    /**
     * Display village head dashboard.
     */
    protected function villageHeadDashboard()
    {
        $stats = [
            'total_residents' => Resident::active()->count(),
            'total_families' => Family::active()->count(),
            'monthly_requests' => LetterRequest::whereMonth('submitted_at', now()->month)
                ->whereYear('submitted_at', now()->year)
                ->count(),
            'completed_requests' => LetterRequest::where('status', 'completed')->count(),
        ];

        return Inertia::render('dashboard', [
            'role' => 'village_head',
            'stats' => $stats,
        ]);
    }

    /**
     * Display resident dashboard.
     */
    protected function residentDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'my_requests' => $user->letterRequests()->count(),
            'pending_requests' => $user->letterRequests()->where('status', 'pending')->count(),
            'completed_requests' => $user->letterRequests()->where('status', 'completed')->count(),
            'available_letter_types' => LetterType::active()->count(),
        ];

        $myRequests = $user->letterRequests()
            ->with('letterType')
            ->latest('submitted_at')
            ->limit(5)
            ->get();

        return Inertia::render('dashboard', [
            'role' => 'resident',
            'stats' => $stats,
            'myRequests' => $myRequests,
        ]);
    }
}