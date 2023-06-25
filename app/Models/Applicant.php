<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'applicants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'verified' => 'boolean',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function applicant_details(): HasMany
    {
        return $this->hasMany(ApplicantDetail::class)->orderBy('created_at', 'desc');
    }

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
                $getLatest = Applicant::where('vacancy_id', $model->vacancy_id)->orderBy('registration_number', 'DESC')->first()?->registration_number;
                $latestOrder = $getLatest ? (((int)explode('-', $getLatest)[1]) + 1) : 1;
                $model->registration_number = Str::upper(Str::slug(explode('-', $model->vacancy_id)[0] . '-' . Str::padLeft($latestOrder, 5, '0') . '-' . substr(explode('-', $model->{$model->getKeyName()})[0], 0, 3)));
            }
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
