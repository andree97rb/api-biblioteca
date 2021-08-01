<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAutorLibro extends Model
{
    protected $table = "detalleAutorLibro";
    protected $fillable = array('idAutor', 'idLibro');
    public $timestamps = false;
}
