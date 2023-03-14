<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Exhibition extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOAD_PATH = 'images/exhibition/';

    const UPLOAD_COVER_PATH = 'images/exhibition/cover_images/';

    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'cover_image',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ExhibitionImage::class);
    }

    protected function start_date(): Attribute {
        return Attribute::make(
            get: fn (string $value) => date('d M Y', strtotime($value)),
        );
    }

    protected function end_date(): Attribute {
        return Attribute::make(
            get: fn (string $value) => date('d M Y', strtotime($value)),
        );
    }

}
