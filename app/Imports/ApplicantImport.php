<?php

namespace App\Imports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\ToModel;

class ApplicantImport implements ToModel
{
    private $rows = 0;
    public function model(array $row)
    {
        ++$this->rows;
        if ($this->rows > 1) {
            Applicant::where('registration_number', $row[0])->where('verified', 1)
                ->update([
                    'status' => $row[1],
                    'info' => $row[2],
                ]);
        }
    }
}
