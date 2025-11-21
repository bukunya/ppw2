<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\JobAppliedMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewApplicationNotification;
use App\Models\User;
use App\Jobs\SendApplicationMailJob;
use App\Mail\ApplicationStatusMail;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $jobId = null)
    {
        $query = Application::with(['user', 'job']);

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

        $applications = $query->get();

        return view('applications.index', compact('applications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        try {
            $cvPath = $request->file('cv')->store('cvs', 'public');

            $application = Application::create([
                'user_id' => auth()->id(),
                'job_id' => $jobId,
                'cv' => $cvPath,
                'status' => 'Pending',
            ]);

            // Kirim email ke user via Queue
            dispatch(new SendApplicationMailJob($application->job, auth()->user()));

            // Kirim notifikasi ke Admin
            $admin = User::where('role', 'admin')->first();
            $admin->notify(new NewApplicationNotification($application));

            return back()->with('success', 'Lamaran berhasil dikirim! Cek email Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['cv' => 'The cv failed to upload: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:Accepted,Rejected,Pending'
        ]);

        $application = Application::findOrFail($id);
        $oldStatus = $application->status;
        $application->update([
            'status' => $request->status
        ]);

        // Kirim email jika status berubah
        if ($oldStatus !== $request->status) {
            Mail::to($application->user->email)->send(new ApplicationStatusMail($application, $request->status));
        }

        return back()->with('success', 'Status lamaran berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);
        return view('applications.show', compact('application'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        
        // Delete CV file if exists
        if ($application->cv && \Storage::disk('public')->exists($application->cv)) {
            \Storage::disk('public')->delete($application->cv);
        }
        
        $application->delete();
        
        return back()->with('success', 'Lamaran berhasil dihapus');
    }

    /**
     * Export applications to Excel.
     */
    public function export(Request $request)
    {
        $jobId = $request->query('job_id');
        
        if ($jobId) {
            // Export applications for specific job
            return Excel::download(new ApplicationsExport($jobId), 'applications_job_' . $jobId . '.xlsx');
        }
        
        // Export all applications
        return Excel::download(new ApplicationsExport(), 'applications.xlsx');
    }
}