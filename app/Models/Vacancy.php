<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'vacancy_id', 'id');
    }

    public function vacancyCriteria(): HasMany
    {
        return $this->hasMany(VacancyCriteria::class, 'vacancy_id', 'id');
    }

    public function vacancyCriteriaOrdered()
    {
        $data = $this->vacancyCriteria()->get();
        $selectedCriteria = [];
        $data->each(function ($item) use (&$selectedCriteria) {
            $selectedCriteria[] = $item->criteria_id;
        });
        $criteria = Criteria::whereIn('id', $selectedCriteria)->orderBy('parent_order', 'ASC')->get();
        return $criteria;
    }
}
