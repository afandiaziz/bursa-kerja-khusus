<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class CriteriaAnswer extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $table = 'criteria_answers';
    protected $guarded = [
        'id',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
