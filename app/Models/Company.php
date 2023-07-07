<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $table = 'companies';
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'company_id', 'id');
    }
    public function vacanciesActive()
    {
        return Vacancy::active()->where('company_id', $this->id);
    }
    public function vacanciesNotActive()
    {
        return Vacancy::notActive()->where('company_id', $this->id);
    }
}
