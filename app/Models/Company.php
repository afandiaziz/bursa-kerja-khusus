<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Uuids;

class Company extends Model
{
    use HasFactory, Uuids;
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
