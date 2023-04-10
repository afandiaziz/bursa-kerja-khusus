<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class CriteriaType extends Model
{
    use HasFactory, Uuids;
    protected $fillable = [
        'type',
    ];
}
