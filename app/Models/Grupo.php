<?php
namespace App\Models;

use CodeIgniter\Model;

class Grupo extends Model
{
    protected $table      = 'grupos';
    protected $primaryKey = 'idgrupo';

    protected $allowedFields = [
        'alectivo',
        'nivel',
        'grado',
        'seccion',
        'idcalendarizacion'
    ];

    protected $returnType   = 'array';
    protected $useTimestamps = false;

    // Trae grupos junto con la información de su calendarización (left join por si no tiene)
    public function getGruposConCalendarizacion()
    {
        return $this->select('grupos.*, calendarizaciones.fechainicio, calendarizaciones.fechafin, calendarizaciones.horainicio, calendarizaciones.horafin')
                    ->join('calendarizaciones', 'calendarizaciones.idcalendarizacion = grupos.idcalendarizacion', 'left')
                    ->orderBy('grupos.idgrupo', 'ASC')
                    ->findAll();
    }
}
