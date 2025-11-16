<?php

namespace App\Imports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;

class JobsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JobVacancy([
            'title' => $row[0] ?? null,
            'description' => $row[1] ?? null,
            'location' => $row[2] ?? null,
            'company' => $row[3] ?? null,
            'salary' => $row[4] ?? null,
        ]);
    }
}
