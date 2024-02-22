<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodboardPhoto extends Model
{
    use HasFactory;

    protected $table = "moodboard_photos";

    protected $fillable = ['image_path', 'moodboard_id'];

    public function moodboard()
    {
        return $this->belongsTo(Moodboard::class);
    }
}
