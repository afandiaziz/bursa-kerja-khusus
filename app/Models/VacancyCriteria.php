<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancyCriteria extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $table = 'vacancy_criteria';
    protected $guarded = [
        'id',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
