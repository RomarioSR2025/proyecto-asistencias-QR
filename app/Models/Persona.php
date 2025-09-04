<?php 
namespace App\Models;

use CodeIgniter\Model;

class Persona extends Model
{
    // Nombre de la tabla
    protected $table = 'personas';

    // Llave primaria
    protected $primaryKey = 'idpersona';

    // Campos permitidos para insertar/actualizar
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

    // Tipo de retorno (array u objeto)
    protected $returnType = 'array';

    // Si no usas created_at, updated_at puedes dejarlo en false
    protected $useTimestamps = false;
}
