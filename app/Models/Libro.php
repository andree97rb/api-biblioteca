<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = "libro";
    protected $fillable = array('titulo', 'genero', 'idEditorial');
    public $timestamps = false;
  
    public function autores() {	
        return $this->belongsToMany('App\Models\Autor', 'detalleAutorLibro', 'idLibro', 'idAutor');
    }
    
    public function editorial() {
        return $this->belongsTo('App\Models\Editorial', 'idEditorial');
    }
}
