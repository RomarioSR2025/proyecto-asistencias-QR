<?php
namespace App\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\Persona;

class AsistenciaController extends BaseController
{
    public function listar()
    {
        $asistenciaModel = new Asistencia();
        $grupoModel = new Grupo();

        $filtros = [
            'fecha'   => $this->request->getGet('fecha') ?? date('Y-m-d'),
            'idgrupo' => $this->request->getGet('idgrupo') ?? ''
        ];

        $data['asistencias'] = $asistenciaModel->getAsistenciasConDetalles($filtros);
        $data['grupos'] = $grupoModel->findAll();
        $data['filtros'] = $filtros;

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('asistencias/listar', $data);
    }

    /**
     * Mostrar formulario para tomar asistencia.
     * Acepta $idgrupo por URL o por GET (por seguridad).
     */
    public function tomar($idgrupo = null)
    {
        // Prioriza parámetro de función, si no viene tomar de GET
        $idgrupo = $idgrupo ?? $this->request->getGet('idgrupo');

        if (empty($idgrupo)) {
            // Si no hay grupo, redirigimos al listado con mensaje
            return redirect()->to(base_url('asistencias/listar'))
                             ->with('error', 'Seleccione un grupo para tomar asistencia.');
        }

        $grupoModel     = new Grupo();
        $matriculaModel = new Matricula();

        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');

        // info del grupo
        $grupo = $grupoModel->find((int)$idgrupo);
        if (!$grupo) {
            return redirect()->to(base_url('asistencias/listar'))
                             ->with('error', 'Grupo no encontrado.');
        }

        // alumnos matriculados en el grupo (activos)
        $alumnos = $matriculaModel
            ->select('matriculas.idmatricula, personas.nombres, personas.apepaterno, personas.apematerno')
            ->join('personas', 'personas.idpersona = matriculas.idalumno')
            ->where('matriculas.idgrupo', (int)$idgrupo)
            ->where('matriculas.estado', 'Activo')
            ->findAll();

        $data = [
            'grupo'    => $grupo,
            'alumnos'  => $alumnos,
            'fecha'    => $fecha,
            'header'   => view('layouts/header'),
            'footer'   => view('layouts/footer'),
        ];

        return view('asistencias/tomar', $data);
    }

    /**
     * Guardar asistencia. No requiere $idgrupo en la firma:
     * toma idgrupo de POST (form), o redirige si falta.
     */
    public function guardar()
    {
        $asistenciaModel = new Asistencia();

        // fecha y idgrupo vienen desde el formulario
        $fecha   = $this->request->getPost('fecha') ?? date('Y-m-d');
        $idgrupo = $this->request->getPost('idgrupo') ?? $this->request->getPost('grupo') ?? '';

        // Soportar dos formatos de envío:
        // 1) nombre="asistencias[0][idmatricula]" etc.  -> POST['asistencias'] is array of rows
        // 2) nombre="estado[<idmatricula>]" etc.       -> POST['estado'] keyed by idmatricula
        $rows_by_index = $this->request->getPost('asistencias');
        $estados_by_id = $this->request->getPost('estado');      // opcional
        $hentrada_by_id = $this->request->getPost('hentrada');  // opcional (if used)
        $hsalida_by_id  = $this->request->getPost('hsalida');   // opcional
        $metodo_by_id   = $this->request->getPost('metodo');    // opcional

        // Caso A: filas indexadas (array de filas)
        if (!empty($rows_by_index) && is_array($rows_by_index)) {
            foreach ($rows_by_index as $row) {
                // row puede tener idmatricula, estado, hentrada, hsalida, mintardanza, metodo
                $idmatricula = (int) ($row['idmatricula'] ?? 0);
                if ($idmatricula <= 0) continue;

                $data = [
                    'idmatricula' => $idmatricula,
                    'fecha'       => $fecha,
                    'hentrada'    => $row['hentrada'] ?? null,
                    'hsalida'     => $row['hsalida'] ?? null,
                    'mintardanza' => $row['mintardanza'] ?? 0,
                    'estado'      => $row['estado'] ?? 'Asistió',
                    'metodo'      => $row['metodo'] ?? 'Manual',
                ];

                // upsert según unique (idmatricula, fecha)
                $exist = $asistenciaModel->where('idmatricula', $idmatricula)->where('fecha', $fecha)->first();
                if ($exist) {
                    $asistenciaModel->update($exist['idasistencia'], $data);
                } else {
                    $asistenciaModel->insert($data);
                }
            }
        }
        // Caso B: inputs por id (estado[idmatricula], hentrada[idmatricula], ...)
        elseif (!empty($estados_by_id) && is_array($estados_by_id)) {
            foreach ($estados_by_id as $idmatricula => $estado) {
                $idmatricula = (int)$idmatricula;
                if ($idmatricula <= 0) continue;

                $data = [
                    'idmatricula' => $idmatricula,
                    'fecha'       => $fecha,
                    'estado'      => $estado,
                    'hentrada'    => $hentrada_by_id[$idmatricula] ?? null,
                    'hsalida'     => $hsalida_by_id[$idmatricula] ?? null,
                    'mintardanza' => 0,
                    'metodo'      => $metodo_by_id[$idmatricula] ?? 'Manual',
                ];

                // calcular mintardanza si se requiere (ejemplo: límite 08:00)
                if (!empty($data['hentrada'])) {
                    $horaEntrada = strtotime($data['hentrada']);
                    $horaLimite = strtotime('08:00:00'); // ajustar según tu regla
                    $data['mintardanza'] = $horaEntrada > $horaLimite ? round(($horaEntrada - $horaLimite) / 60) : 0;
                }

                $exist = $asistenciaModel->where('idmatricula', $idmatricula)->where('fecha', $fecha)->first();
                if ($exist) {
                    $asistenciaModel->update($exist['idasistencia'], $data);
                } else {
                    $asistenciaModel->insert($data);
                }
            }
        } else {
            // nada para guardar
            return redirect()->back()->with('error', 'No hay datos de asistencia para guardar.');
        }

        // redirigir al listado para ver resultados
        $redir = base_url("asistencias/listar?fecha={$fecha}") . ($idgrupo ? "&idgrupo={$idgrupo}" : "");
        return redirect()->to($redir)->with('success', 'Asistencia guardada correctamente.');
    }
}
