<?php 
namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model 
{
    protected $table = 'usuarios';
    protected $primaryKey = 'idusuario';

    protected $allowedFields = [
        'nomuser',
        'passuser',
        'estado',
        'idpersona'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getUsuariosConPersona()
    {
        return $this->select('usuarios.idusuario, usuarios.nomuser, usuarios.estado, 
                              personas.apepaterno, personas.apematerno, personas.nombres, 
                              personas.email, personas.telefono, personas.sexo, personas.imagenperfil')
                    ->join('personas', 'personas.idpersona = usuarios.idpersona')
                    ->findAll();
    }
}
