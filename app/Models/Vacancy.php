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

    public function requirementsx()
    {
        return $this->belongsToMany(Criteria::class, 'user_details', 'vacancy_id', 'criteria_id')
            ->withPivot('value')
            ->withTimestamps();
    }
    public function requirements()
    {
        $requirements = explode(',', $this->requirements);
        $criteria = [];
        foreach ($requirements as $requirement) {
            $criteria[] = Criteria::find($requirement);
        }
        return $criteria;
    }
}
