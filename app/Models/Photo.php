<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = "photos";

    protected $fillable = ['image_path', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Video::class);
    }

}
