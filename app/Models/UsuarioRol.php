<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioRol extends Model
{
    protected $table = 'usuario_rol';
    protected $primaryKey = 'idusuario'; // ⚠️ CI4 requiere un PK, usamos uno (aunque sea "falso")

    protected $allowedFields = ['idusuario', 'idrol'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';
}
