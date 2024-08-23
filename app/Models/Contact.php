<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeSearchName($query, $search = '%')
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    // Relationship between models
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
