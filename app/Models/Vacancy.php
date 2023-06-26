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

    public static function activeById($id)
    {
        $vacany = Vacancy::select(
            'vacancies.id',
            'vacancies.company_id',
            'vacancies.position',
            'vacancies.job_type',
            'vacancies.description',
            'vacancies.information',
            'vacancies.created_at',
            'vacancies.updated_at',
            'vacancies.deadline',
            'vacancies.max_applicants',
        )
            ->with('company:id,name,logo,phone,email,address,website')
            ->with(['vacancyCriteria' => function ($vacancyCriteria) {
                $vacancyCriteria->select('id', 'vacancy_id', 'criteria_id');
                $vacancyCriteria->with(['criteria' => function ($criteria) {
                    $criteria->where('active', 1);
                }]);
            }])
            ->where('deadline', '>=', date('Y-m-d'))
            ->whereHas('company', function ($company) {
                $company->where('status', 1);
            })
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                    ->whereNull('max_applicants')
                    ->orWhere('id', $id)
                    ->whereRaw('(select count(*) from `applicants` where `vacancies`.`id` = `applicants`.`vacancy_id` and `verified` = 1 and `applicants`.`deleted_at` is null) < max_applicants')
                    ->whereNotNull('max_applicants');
            })
            ->orderBy('deadline', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->first();
        return $vacany;
    }

    public static function active($id = null)
    {
        $vacany = Vacancy::withCount(['applicants' => function ($applicant) {
            $applicant->where('verified', 1);
        }])
            ->orderBy('deadline', 'DESC')
            ->orderBy('updated_at', 'DESC');
        if ($id) {
            $vacany = $vacany->where('id', $id);
        }
        $vacany = $vacany
            ->where('deadline', '>=', date('Y-m-d'))
            ->where(function ($query) {
                $query->whereNull('max_applicants')
                    ->whereHas('company', function ($company) {
                        $company->where('status', 1);
                    })
                    ->orWhereNotNull('max_applicants')
                    ->whereRaw('(select count(*) from `applicants` where `vacancies`.`id` = `applicants`.`vacancy_id` and `verified` = 1 and `applicants`.`deleted_at` is null) < max_applicants');
            });
        return $vacany;
    }

    public static function notActive($id = null)
    {
        $vacany = Vacancy::withCount(['applicants' => function ($applicant) {
            $applicant->where('verified', 1);
        }])
            ->orderBy('deadline', 'DESC')
            ->orderBy('updated_at', 'DESC');
        if ($id) {
            $vacany = $vacany->where('id', $id);
        }
        $vacany = $vacany
            ->where(function ($query) {
                $query->where('deadline', '<', date('Y-m-d'))
                    ->orWhere('deadline', '>=', date('Y-m-d'))
                    ->whereRaw('(select count(*) from `applicants` where `vacancies`.`id` = `applicants`.`vacancy_id` and `verified` = 1 and `applicants`.`deleted_at` is null) >= max_applicants');
            });
        return $vacany;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id')->select('name', 'logo', 'phone', 'email', 'address', 'website');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'vacancy_id', 'id');
    }

    public function vacancyCriteria(): HasMany
    {
        return $this->hasMany(VacancyCriteria::class, 'vacancy_id', 'id')->select('criteria_id')->whereHas('criteria', function ($criteria) {
            $criteria->where('active', 1);
        });
    }

    public function vacancyCriteriaOrdered()
    {
        $data = $this->vacancyCriteria()->get();
        $selectedCriteria = [];
        $data->each(function ($item) use (&$selectedCriteria) {
            $selectedCriteria[] = $item->criteria_id;
        });
        $criteria = Criteria::whereIn('id', $selectedCriteria)->where('active', 1)->where('parent_id', null)->orderBy('parent_order', 'ASC')->get();
        return $criteria;
    }

    public function vacancyCriteriaNotSelected()
    {
        $data = $this->vacancyCriteriaOrdered();
        $selectedCriteria = [];
        $data->each(function ($item) use (&$selectedCriteria) {
            $selectedCriteria[] = $item->id;
        });
        $criteria = Criteria::whereNotIn('id', $selectedCriteria)->where('active', 1)->where('parent_id', null)->orderBy('parent_order', 'ASC')->get();
        return $criteria;
    }
}
