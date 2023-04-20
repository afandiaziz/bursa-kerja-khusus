<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocuments extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    protected $table = 'user_documents';
    protected $fillable = [
        'user_id',
        'criteria_id',
        'filename',
        'path',
        'mime_type',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
