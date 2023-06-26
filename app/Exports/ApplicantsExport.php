<?php

namespace App\Exports;

use App\Models\Vacancy;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicantsExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $id = null;
    protected $q = null;
    public function __construct($id, $q = 'all')
    {
        $this->id = $id;
        $this->q = $q;
    }

    public function view(): View
    {
        switch ($this->q) {
            case 'verified':
                $applicants = Vacancy::findOrFail($this->id)->applicants->where('verified', 1);
                break;
            case 'unverified':
                $applicants = Vacancy::findOrFail($this->id)->applicants->where('verified', 0);
                break;

            default:
                $applicants = Vacancy::findOrFail($this->id)->applicants;
                break;
        }
        return view('exports.vacancy', [
            'applicants' => $applicants
        ]);
    }
}
