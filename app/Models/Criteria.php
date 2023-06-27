<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'criteria';
    protected $orderBy = 'parent_order';
    protected $orderDirection = 'asc';
    protected $guarded = [
        'id',
    ];
    protected $hidden = [];
    protected $casts = [
        'required' => 'boolean',
        'active' => 'boolean',
        'is_multiple' => 'boolean',
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
        return $this->hasMany(Criteria::class, 'parent_id')->orderBy('child_order', 'asc');
    }

    public function criteriaAnswer()
    {
        return $this->hasMany(CriteriaAnswer::class, 'criteria_id')->orderBy('index', 'asc');
    }

    // public function criteriaDocuments()
    // {
    //     return $this->hasMany(CriteriaDocuments::class, 'criteria_id');
    // }

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

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();
        if (empty($ordered)) {
            return $query;
        }

        return $query->orderBy($this->orderBy, $this->orderDirection);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });

        static::deleted(function ($item) {
            $item->criteriaAnswer()->each(function ($sub) {
                $sub->delete();
            });
            $item->children()->each(function ($sub) {
                $sub->delete();
            });
        });
    }
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
