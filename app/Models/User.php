<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user_detail that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant_details(): HasMany
    {
        return $this->hasMany(ApplicantDetail::class, 'user_id', 'id');
    }

    public function user_details(): HasMany
    {
        // return $this->hasMany(UserDetail::class)->whereHas('criteria', function ($query) {
        //     $query->whereNull('parent_id');
        // });
        return $this->hasMany(UserDetail::class);
    }

    public function keywords(): HasMany
    {
        return $this->hasMany(Keyword::class);
    }

    public function user_details_child($parentId)
    {
        return $this->hasMany(UserDetail::class)
            ->select('user_details.*')
            ->whereHas('criteria', function ($query) use ($parentId) {
                $query->where('parent_id', $parentId);
            })
            ->join('criteria', 'criteria.id', '=', 'user_details.criteria_id')
            ->orderBy('criteria.child_order', 'asc');
    }

    // public function user_details_total_child($parentId)
    // {
    //     $array = $this->hasMany(UserDetail::class)
    //         ->selectRaw('count(criteria_id) as count')
    //         ->whereHas('criteria', function ($query) use ($parentId) {
    //             $query->where('parent_id', $parentId);
    //         })
    //         ->groupBy('criteria_id')
    //         ->pluck('count')->toArray();
    //     return count($array) > 0 ? max($array) : 0;
    // }

    public function applications(): HasMany
    {
        return $this->hasMany(Applicant::class)->orderBy('created_at', 'desc');
    }
    public function notifiedVacancies(): HasMany
    {
        return $this->hasMany(NotifiedVacancy::class)->orderBy('created_at', 'desc');
    }
}
