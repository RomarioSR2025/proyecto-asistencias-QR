<?php
namespace App\Models;

use CodeIgniter\Model;

class Asistencia extends Model
{
    protected $table      = 'asistencia';
    protected $primaryKey = 'idasistencia';

    protected $allowedFields = [
        'idmatricula',
        'fecha',
        'hentrada',
        'hsalida',
        'mintardanza',
        'estado',
        'metodo'
    ];

    protected $returnType    = 'array';
    protected $useTimestamps = false;

    /**
     * 🔍 Devuelve asistencias con info de alumno y grupo
     */
    public function getAsistenciasConDetalles($filtros = [])
    {
        $builder = $this->select("
                asistencia.*,
                CONCAT(p.apepaterno, ' ', p.apematerno, ' ', p.nombres) AS alumno,
                CONCAT(g.grado, ' ', g.seccion, ' - ', g.nivel, ' (', g.alectivo, ')') AS grupo
            ")
            ->join('matriculas m', 'm.idmatricula = asistencia.idmatricula')
            ->join('personas p', 'p.idpersona = m.idalumno')
            ->join('grupos g', 'g.idgrupo = m.idgrupo');

        // filtro por fecha
        if (!empty($filtros['fecha'])) {
            $builder->where('asistencia.fecha', $filtros['fecha']);
        }

        // filtro por grupo
        if (!empty($filtros['idgrupo'])) {
            $builder->where('g.idgrupo', $filtros['idgrupo']);
        }

        return $builder->orderBy('p.apepaterno', 'ASC')->findAll();
    }
}
