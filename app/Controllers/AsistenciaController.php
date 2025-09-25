<?php
namespace App\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\Persona;
use App\Models\QrLog;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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


    public function tomar($idgrupo = null)
    {
        $idgrupo = $idgrupo ?? $this->request->getGet('idgrupo');

        if (empty($idgrupo)) {
            return redirect()->to(base_url('asistencias/listar'))
                             ->with('error', 'Seleccione un grupo para tomar asistencia.');
        }

        $grupoModel     = new Grupo();
        $matriculaModel = new Matricula();

        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');

        $grupo = $grupoModel->find((int)$idgrupo);
        if (!$grupo) {
            return redirect()->to(base_url('asistencias/listar'))
                             ->with('error', 'Grupo no encontrado.');
        }

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


    public function guardar()
    {
        $asistenciaModel = new Asistencia();

        $fecha   = $this->request->getPost('fecha') ?? date('Y-m-d');
        $idgrupo = $this->request->getPost('idgrupo') ?? $this->request->getPost('grupo') ?? '';

        $rows_by_index = $this->request->getPost('asistencias');
        $estados_by_id = $this->request->getPost('estado');     
        $hentrada_by_id = $this->request->getPost('hentrada');  
        $hsalida_by_id  = $this->request->getPost('hsalida');   
        $metodo_by_id   = $this->request->getPost('metodo');   

        if (!empty($rows_by_index) && is_array($rows_by_index)) {
            foreach ($rows_by_index as $row) {
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

                $exist = $asistenciaModel->where('idmatricula', $idmatricula)->where('fecha', $fecha)->first();
                if ($exist) {
                    $asistenciaModel->update($exist['idasistencia'], $data);
                } else {
                    $asistenciaModel->insert($data);
                }
            }
        }
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
            return redirect()->back()->with('error', 'No hay datos de asistencia para guardar.');
        }

        $redir = base_url("asistencias/listar?fecha={$fecha}") . ($idgrupo ? "&idgrupo={$idgrupo}" : "");
        return redirect()->to($redir)->with('success', 'Asistencia guardada correctamente.');
    }

    public function registrarPorQR($codigo_qr)
    {
        $fecha = date('Y-m-d');
        $hora  = date('H:i:s');
        $horaLimite = strtotime('08:00:00');

        $idgrupoActual = $this->request->getGet('idgrupo');

        $matriculaModel  = new Matricula();
        $asistenciaModel = new Asistencia();
        $qrLogModel      = new QrLog();

        $matricula = $matriculaModel->where('codigo_qr', $codigo_qr)->first();

        if (!$matricula) {
            return $this->response->setStatusCode(404)->setBody("❌ QR inválido o alumno no registrado.");
        }

        if ($idgrupoActual && $matricula['idgrupo'] != $idgrupoActual) {
            return $this->response->setStatusCode(403)->setBody("🚫 Este alumno no pertenece al grupo seleccionado.");
        }

        $mintardanza = 0;
        $estado = 'Asistió';

        $horaEntrada = strtotime($hora);
        if ($horaEntrada > $horaLimite) {
            $mintardanza = round(($horaEntrada - $horaLimite) / 60);
            $estado = 'Tardanza';
        }

        $datosAsistencia = [
            'idmatricula' => $matricula['idmatricula'],
            'fecha'       => $fecha,
            'hentrada'    => $hora,
            'hsalida'     => null,
            'mintardanza' => $mintardanza,
            'estado'      => $estado,
            'metodo'      => 'QR',
        ];

        $existente = $asistenciaModel->where('idmatricula', $matricula['idmatricula'])
                                     ->where('fecha', $fecha)
                                     ->first();

        if ($existente) {
            $asistenciaModel->update($existente['idasistencia'], $datosAsistencia);
        } else {
            $asistenciaModel->insert($datosAsistencia);
        }

        $qrLogModel->insert([
            'codigo_qr'   => $codigo_qr,
            'fecha'       => $fecha,
            'hora'        => $hora,
            'idmatricula' => $matricula['idmatricula'],
        ]);

        return $this->response->setStatusCode(200)->setBody("✅ Asistencia registrada para el alumno.");
    }


    public function exportar()
    {
        $asistenciaModel = new Asistencia();

        $fecha   = $this->request->getGet('fecha') ?? date('Y-m-d');
        $idgrupo = $this->request->getGet('idgrupo') ?? '';

        $filtros = ['fecha' => $fecha];
        if ($idgrupo !== '') {
            $filtros['idgrupo'] = $idgrupo;
        }

        $asistencias = $asistenciaModel->getAsistenciasConDetalles($filtros);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $columnTitles = ['#', 'Alumno', 'Grupo', 'Fecha', 'Entrada', 'Salida', 'Tardanza (min)', 'Estado', 'Método'];

        // Escribir títulos
        $col = 'A';
        foreach ($columnTitles as $title) {
            $sheet->setCellValue($col.'1', $title);
            $col++;
        }

        // Escribir datos
        $rowNum = 2;
        foreach ($asistencias as $i => $a) {
            $sheet->setCellValue('A'.$rowNum, $i + 1);
            $sheet->setCellValue('B'.$rowNum, $a['alumno']);
            $sheet->setCellValue('C'.$rowNum, $a['grupo']);
            $sheet->setCellValue('D'.$rowNum, $a['fecha']);
            $sheet->setCellValue('E'.$rowNum, $a['hentrada'] ?? '--');
            $sheet->setCellValue('F'.$rowNum, $a['hsalida'] ?? '--');
            $sheet->setCellValue('G'.$rowNum, $a['mintardanza'] ?? 0);
            $sheet->setCellValue('H'.$rowNum, $a['estado']);
            $sheet->setCellValue('I'.$rowNum, $a['metodo']);
            $rowNum++;
        }

        // Autoajustar ancho columnas
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "Asistencias_{$fecha}" . ($idgrupo ? "_grupo{$idgrupo}" : "") . ".xlsx";

        // Enviar headers para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
