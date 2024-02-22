<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    use HasFactory;

    protected $table = "moodboards";

    protected $fillable = ['name', 'description', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Video::class);
    }

    public function colors()
    {
        return $this->hasMany(ColorCard::class);
    }

    public function moodboard_photos()
    {
        return $this->hasMany(Moodboard::class);
    }
}
