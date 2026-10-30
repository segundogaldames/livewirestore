<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'text'];

    public function getImageURL(): string
    {
        if ($this->image) {
            return URL::asset('storage/' . $this->image);
        }

        // Retorna una ruta o string vacío si no hay imagen
        return '';
    }
}
