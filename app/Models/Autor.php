<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = "autor";
    protected $fillable = array('nombres', 'apellidos', 'fechaNacimiento', 'nacionalidad');
    public $timestamps = false;

    public function libros() {	
		    return $this->belongsToMany('App\Models\Libro', 'detalleAutorLibro', 'idAutor', 'idLibro');
	  }
}
