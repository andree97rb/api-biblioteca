<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $table = "editorial";
    protected $fillable = array('nombre', 'pais');
    public $timestamps = false;

    public function libros()
    {
        return $this->hasMany('App\Models\Libro', 'idEditorial');
    }
}
