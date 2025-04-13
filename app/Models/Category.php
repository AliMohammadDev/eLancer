<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'art_file',
        'slug'
    ];
    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id', 'id');
    }
}
