<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idusuario';

    protected $allowedFields = ['idpersona', 'nomuser', 'passuser', 'estado'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    // 🔐 Reglas de validación básicas
    protected $validationRules = [
        'nomuser'   => 'required|min_length[4]',
        'passuser'  => 'permit_empty|min_length[6]', // en actualizar puede venir vacío
        'idpersona' => 'required|is_natural_no_zero',
        'estado'    => 'in_list[Activo,Inactivo]',
    ];

    protected $validationMessages = [
        'nomuser' => [
            'required'   => 'El nombre de usuario es obligatorio.',
            'min_length' => 'El usuario debe tener al menos 4 caracteres.',
        ],
        'passuser' => [
            'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
        ],
        'idpersona' => [
            'required'           => 'Debe seleccionar una persona.',
            'is_natural_no_zero' => 'La persona seleccionada no es válida.',
        ],
    ];

    /**
     * 🔎 Trae todos los usuarios con sus datos de persona y rol
     */
    public function getUsuariosConPersona($idusuario = null)
    {
        $builder = $this->select('
                    usuarios.idusuario, 
                    usuarios.nomuser, 
                    usuarios.estado, 
                    personas.apepaterno, 
                    personas.apematerno, 
                    personas.nombres, 
                    personas.email, 
                    personas.telefono, 
                    personas.sexo, 
                    personas.imagenperfil,
                    roles.rol
                ')
                ->join('personas', 'personas.idpersona = usuarios.idpersona')
                ->join('usuario_rol', 'usuario_rol.idusuario = usuarios.idusuario', 'left')
                ->join('roles', 'roles.idrol = usuario_rol.idrol', 'left');

        if ($idusuario !== null) {
            return $builder->where('usuarios.idusuario', $idusuario)->first();
        }

        return $builder->findAll();
    }
}
