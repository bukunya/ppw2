<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Return sample data
        return [
            ['Software Engineer', 'Develop and maintain web applications', 'Jakarta', 'PT Tech Indonesia', '10000000'],
            ['Marketing Manager', 'Lead marketing team and campaigns', 'Bandung', 'PT Digital Media', '8000000'],
            ['Data Analyst', 'Analyze data and create reports', 'Surabaya', 'PT Data Solutions', '7000000'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'title',
            'description',
            'location',
            'company',
            'salary',
        ];
    }
}
