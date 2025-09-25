<?php
namespace App\Models;

use CodeIgniter\Model;

class Rol extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'idrol';

    protected $allowedFields = ['rol', 'descripcion'];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $validationRules = [
        'rol'         => 'required|min_length[3]|is_unique[roles.rol,idrol,{idrol}]',
        'descripcion' => 'permit_empty|max_length[150]',
    ];

    protected $validationMessages = [
        'rol' => [
            'required'   => 'El nombre del rol es obligatorio.',
            'min_length' => 'El rol debe tener al menos 3 caracteres.',
            'is_unique'  => 'Ese rol ya está registrado.',
        ],
        'descripcion' => [
            'max_length' => 'La descripción no puede superar los 150 caracteres.',
        ],
    ];
}
