<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class CriteriaAnswer extends Model
{
    use HasFactory, Uuids;
    protected $table = 'criteria_answers';
    protected $fillable = [
        'criteria_id',
        'index',
        'answer',
        'extra_answer_type',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
