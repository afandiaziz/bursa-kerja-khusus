<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class CriteriaTypeAnswer extends Model
{
    use HasFactory, Uuids;
    protected $fillable = [
        'criteria_id',
        'answer',
        'extra_answer_type',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
