<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $jobId;

    public function __construct($jobId = null)
    {
        $this->jobId = $jobId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Application::with(['user', 'job']);
        
        if ($this->jobId) {
            $query->where('job_id', $this->jobId);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelamar',
            'Email',
            'Lowongan',
            'Perusahaan',
            'CV',
            'Status',
            'Tanggal Lamar',
        ];
    }

    /**
     * @param Application $application
     * @return array
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->user->name ?? '-',
            $application->user->email ?? '-',
            $application->job->title ?? '-',
            $application->job->company ?? '-',
            $application->cv,
            $application->status,
            $application->created_at->format('d-m-Y H:i'),
        ];
    }
}