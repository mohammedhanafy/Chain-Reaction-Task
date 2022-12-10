<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'phone', 'job_title', 'job_description', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
