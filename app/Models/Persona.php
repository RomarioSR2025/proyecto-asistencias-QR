<?php 
namespace App\Models;

use CodeIgniter\Model;

class Persona extends Model
{
    
    protected $table = 'personas';

   
    protected $primaryKey = 'idpersona';

    
    protected $allowedFields = [
        'apepaterno',
        'apematerno',
        'nombres',
        'tipodoc',
        'numerodoc',
        'direccion',
        'telefono',
        'email',
        'fecha_nacimiento',
        'sexo',
        'imagenperfil'
    ];

    
    protected $returnType = 'array';

    
    protected $useTimestamps = false;
}
