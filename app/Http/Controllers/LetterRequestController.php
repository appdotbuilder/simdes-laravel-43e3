<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequestRequest;
use App\Http\Requests\UpdateLetterRequestRequest;
use App\Models\LetterRequest;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LetterRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $requests = LetterRequest::with(['user.resident', 'letterType'])
                ->latest('submitted_at')
                ->paginate(15);
        } else {
            $requests = $user->letterRequests()
                ->with('letterType')
                ->latest('submitted_at')
                ->paginate(15);
        }

        return Inertia::render('letter-requests/index', [
            'requests' => $requests,
            'canManage' => $user->role === 'admin',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $letterTypes = LetterType::active()->get();

        return Inertia::render('letter-requests/create', [
            'letterTypes' => $letterTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLetterRequestRequest $request)
    {
        $validated = $request->validated();
        
        // Generate unique request number
        $validated['request_number'] = 'REQ-' . now()->format('Ymd') . '-' . str_pad(
            (string)(LetterRequest::whereDate('created_at', today())->count() + 1), 
            4, 
            '0', 
            STR_PAD_LEFT
        );
        
        $validated['user_id'] = Auth::id();
        $validated['submitted_at'] = now();
        
        // Handle file attachments
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('letter-attachments', 'public');
                $attachments[] = $path;
            }
            $validated['attachments'] = $attachments;
        }

        $letterRequest = LetterRequest::create($validated);

        return redirect()->route('letter-requests.show', $letterRequest)
            ->with('success', 'Permohonan surat berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterRequest $letterRequest)
    {
        $letterRequest->load(['user.resident', 'letterType', 'processedBy']);
        
        // Check authorization
        $user = Auth::user();
        if ($user->role === 'resident' && $letterRequest->user_id !== $user->id) {
            abort(403);
        }

        return Inertia::render('letter-requests/show', [
            'request' => $letterRequest,
            'canManage' => $user->role === 'admin',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterRequest $letterRequest)
    {
        // Only admin can edit
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return Inertia::render('letter-requests/edit', [
            'request' => $letterRequest->load(['user.resident', 'letterType']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterRequestRequest $request, LetterRequest $letterRequest)
    {
        $validated = $request->validated();
        
        // Set processed by and timestamp
        if (isset($validated['status']) && $validated['status'] !== $letterRequest->status) {
            $validated['processed_by'] = Auth::id();
            $validated['processed_at'] = now();
            
            if ($validated['status'] === 'completed') {
                $validated['completed_at'] = now();
            }
        }
        
        // Handle final letter upload
        if ($request->hasFile('final_letter')) {
            $path = $request->file('final_letter')->store('final-letters', 'public');
            $validated['final_letter_path'] = $path;
        }

        $letterRequest->update($validated);

        return redirect()->route('letter-requests.show', $letterRequest)
            ->with('success', 'Status permohonan surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterRequest $letterRequest)
    {
        // Only admin can delete
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Delete attachments
        if ($letterRequest->attachments) {
            foreach ($letterRequest->attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }

        // Delete final letter
        if ($letterRequest->final_letter_path) {
            Storage::disk('public')->delete($letterRequest->final_letter_path);
        }

        $letterRequest->delete();

        return redirect()->route('letter-requests.index')
            ->with('success', 'Permohonan surat berhasil dihapus.');
    }
}