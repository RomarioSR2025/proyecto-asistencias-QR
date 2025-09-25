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

    /**
     * Obtiene todos los usuarios con su información de persona y rol.
     * Si se pasa $idusuario, devuelve un solo usuario.
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
                roles.rol,
                roles.idrol
            ')
            ->join('personas', 'personas.idpersona = usuarios.idpersona')
            ->join('usuario_rol', 'usuario_rol.idusuario = usuarios.idusuario', 'left')
            ->join('roles', 'roles.idrol = usuario_rol.idrol', 'left');

        if ($idusuario !== null) {
            return $builder->where('usuarios.idusuario', $idusuario)->first();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene los roles asignados a un usuario.
     */
    public function getRoles($idusuario)
    {
        $builder = $this->db->table('usuario_rol');
        $builder->select('roles.idrol, roles.rol, roles.descripcion');
        $builder->join('roles', 'roles.idrol = usuario_rol.idrol');
        $builder->where('usuario_rol.idusuario', $idusuario);

        return $builder->get()->getResultArray();
    }

    /**
     * Asigna un rol a un usuario.
     */
    public function asignarRol($idusuario, $idrol)
    {
        $builder = $this->db->table('usuario_rol');
        return $builder->insert([
            'idusuario' => $idusuario,
            'idrol'     => $idrol
        ]);
    }

    /**
     * Quita todos los roles de un usuario.
     */
    public function quitarRoles($idusuario)
    {
        $builder = $this->db->table('usuario_rol');
        return $builder->where('idusuario', $idusuario)->delete();
    }
}
