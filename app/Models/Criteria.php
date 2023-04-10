<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Criteria extends Model
{
    use HasFactory, Uuids;
    protected $table = 'criteria';
    protected $fillable = [
        'name',
        'criteria_type_id',
        'parent_id',
        'parent_order',
        'child_order',
        'max_length',
        'min_length',
        'max_number',
        'min_number',
        'max_size',
        'format_file',
        'custom_label',
        'mask',
        'required',
        'active',
    ];

    public function criteriaType()
    {
        return $this->belongsTo(CriteriaType::class);
    }

    public function parent()
    {
        return $this->belongsTo(Criteria::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Criteria::class, 'parent_id');
    }

    public function criteriaTypeAnswer()
    {
        return $this->hasMany(CriteriaTypeAnswer::class, 'criteria_id');
    }

    public static function criteriaCreate($criteriaValues, $criteriaAnswerValues = [])
    {
        $criteriaId = Criteria::create($criteriaValues);
        if (count($criteriaAnswerValues)) {
            foreach ($criteriaAnswerValues as $item) {
                CriteriaTypeAnswer::create([
                    'criteria_id' => $criteriaId->id,
                    'answer' => $item,
                ]);
            }
        }
        return true;
    }

    protected $orderBy = 'parent_order';
    protected $orderDirection = 'asc';

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();
        if (empty($ordered)) {
            return $query;
        }

        return $query->orderBy($this->orderBy, $this->orderDirection);
    }
}
