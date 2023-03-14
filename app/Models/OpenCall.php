<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OpenCall extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOAD_PATH = 'images/opencall/';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'cover_image',
        'start_date',
        'end_date',
        'is_show_artwork',
        'status',
    ];

    public function formfield() {
        return $this->hasMany(OpenCallFormField::class);
    }

    public function opencallResponse() {
        return $this->hasMany(OpenCallResponse::class);
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
