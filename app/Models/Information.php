<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
