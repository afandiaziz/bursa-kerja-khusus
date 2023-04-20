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
        'type_upload',
        'max_files',
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

    public function criteriaAnswer()
    {
        return $this->hasMany(CriteriaAnswer::class, 'criteria_id')->orderBy('index', 'asc');
    }

    public function criteriaDocuments()
    {
        return $this->hasMany(CriteriaDocuments::class, 'criteria_id');
    }

    public static function criteriaCreate($criteriaValues, $criteriaAnswerValues = [])
    {
        $criteriaId = Criteria::create($criteriaValues);
        if (count($criteriaAnswerValues)) {
            foreach ($criteriaAnswerValues as $index => $item) {
                CriteriaAnswer::create([
                    'criteria_id' => $criteriaId->id,
                    'index' => $index,
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
