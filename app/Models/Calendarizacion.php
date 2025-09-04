<?php
namespace App\Models;

use CodeIgniter\Model;

class Calendarizacion extends Model
{
    protected $table      = 'calendarizaciones';
    protected $primaryKey = 'idcalendarizacion';

    protected $allowedFields = [
        'fechainicio',
        'fechafin',
        'horainicio',
        'horafin'
    ];

    protected $returnType   = 'array';
    protected $useTimestamps = false;

    // Opcional: método para formatear/filtrar si lo necesitas
    public function listarTodas()
    {
        return $this->orderBy('fechainicio', 'ASC')->findAll();
    }
}
