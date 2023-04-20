<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserDocuments extends Model
{
    use HasFactory, Uuids;
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
