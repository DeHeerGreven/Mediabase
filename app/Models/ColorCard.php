<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorCard extends Model
{
    use HasFactory;

    protected $table = "color_cards";

    protected $fillable = ['hexcode', 'project_id'];

    public function moodboard()
    {
        return $this->belongsTo(Moodboard::class);
    }
}
