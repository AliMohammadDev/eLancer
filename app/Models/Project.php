<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
  use HasFactory;
  const TYPE_FIXED = 'fixed';
  const TYPE_HOURLY = 'hourly';
  // protected $guarded = [];
  protected $fillable = [
    'title',
    'name',
    'category_id',
    'user_id',
    'description',
    'budget',
    'status',
    'type'
  ];

  public function user()
  {
    return $this->belongsTo(
      User::class,
      'user_id',
      'id'
    );
  }
  public static function types()
  {
    return [
      self::TYPE_FIXED => 'Fixed',
      self::TYPE_HOURLY => 'Hourly',
    ];
  }
  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function tags()
  {
    return $this->belongsToMany(
      Tag::class,
      'project_tag',
      'project_id',
      'tag_id',
      'id',
      'id'
    );
  }
  public function syncTags(array $tags)
  {
    $tags_id = [];

    foreach ($tags as $tag_name) {
      $tag = Tag::firstOrCreate([
        'slug' => Str::slug($tag_name),
      ], [
        'name' => trim($tag_name)
      ]);
      $tags_id[] = $tag->id;
    }
    // $project->tags()->sync($tags_id);
    $this->tags()->sync($tags_id);
  }
}
