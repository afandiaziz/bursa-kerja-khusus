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
    protected $fillable = [
        'name',
        'logo',
        'website',
        'phone',
        'email',
        'address',
        'status',
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'company_id', 'id');
    }
}
