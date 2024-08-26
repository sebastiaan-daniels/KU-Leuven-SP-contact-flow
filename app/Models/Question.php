<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relationship between models
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class)->withDefault();
    }
    public function types()
    {
        return $this->belongsTo(Type::class)->withDefault();
    }

    public function question()
    {
        return $this->belongsTo(Question::class)->withDefault();
    }
}
