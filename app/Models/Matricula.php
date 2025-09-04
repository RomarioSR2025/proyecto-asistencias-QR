<?php
namespace App\Models;

use CodeIgniter\Model;

class Matricula extends Model
{
    protected $table      = 'matriculas';
    protected $primaryKey = 'idmatricula';

    protected $allowedFields = [
        'idalumno',
        'idgrupo',
        'fechamatricula',
        'estado',
        'idapoderado',
        'parentesco',
        'anio_escolar',
        'turno',
        'codigo_qr'
    ];

    protected $returnType   = 'array';
    protected $useTimestamps = false;

    // 🔹 Método para traer matrículas con detalles
    public function getMatriculasConDetalles()
    {
        return $this->select("
                matriculas.*,
                CONCAT(alumno.nombres, ' ', alumno.apepaterno, ' ', alumno.apematerno) AS alumno,
                CONCAT(apoderado.nombres, ' ', apoderado.apepaterno, ' ', apoderado.apematerno) AS apoderado,
                CONCAT(grupos.grado, ' ', grupos.seccion, ' - ', grupos.nivel, ' (', grupos.alectivo, ')') AS grupo
            ")
            ->join('personas AS alumno', 'alumno.idpersona = matriculas.idalumno', 'left')
            ->join('personas AS apoderado', 'apoderado.idpersona = matriculas.idapoderado', 'left')
            ->join('grupos', 'grupos.idgrupo = matriculas.idgrupo', 'left')
            ->orderBy('matriculas.idmatricula', 'ASC')
            ->findAll();
    }

    public function getAlumnosPorGrupo($idgrupo)
    {
    return $this->select('matriculas.idmatricula, 
                          CONCAT(p.nombres, " ", p.apepaterno, " ", p.apematerno) as alumno')
                ->join('personas p', 'p.idpersona = matriculas.idalumno')
                ->where('matriculas.idgrupo', $idgrupo)
                ->where('matriculas.estado', 'Activo')
                ->findAll();
    }
}
