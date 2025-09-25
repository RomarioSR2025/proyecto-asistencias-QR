<?php
namespace App\Controllers;

use App\Models\Matricula;
use App\Models\Persona;
use App\Models\Grupo;
use Dompdf\Dompdf;
use Dompdf\Options;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class MatriculaController extends BaseController
{
    protected $matriculaModel;
    protected $personaModel;
    protected $grupoModel;

    public function __construct()
    {
        $this->matriculaModel = new Matricula();
        $this->personaModel = new Persona();
        $this->grupoModel = new Grupo();
    }

    public function listar()
{
    // Filtros desde GET
    $anio   = $this->request->getGet('anio');
    $nivel  = $this->request->getGet('nivel');
    $grado  = $this->request->getGet('grado');

    // Base de datos: todas las matrículas
    $matriculas = $this->matriculaModel->getMatriculasConDetalles();

    // Aplicar filtros si vienen seleccionados
    if (!empty($anio)) {
        $matriculas = array_filter($matriculas, fn($m) => $m['anio_escolar'] == $anio);
    }
    if (!empty($nivel)) {
        $matriculas = array_filter($matriculas, fn($m) => $m['nivel'] == $nivel);
    }
    if (!empty($grado)) {
        $matriculas = array_filter($matriculas, fn($m) => $m['grado'] == $grado);
    }

    // Obtener los grupos para construir selects
    $grupos = $this->grupoModel->getGruposConCalendarizacion();

    // Sacamos valores únicos para los filtros
    $anios   = array_unique(array_column($grupos, 'alectivo'));
    $niveles = array_unique(array_column($grupos, 'nivel'));
    $grados  = array_unique(array_column($grupos, 'grado'));

    // Ordenarlos
    sort($anios);
    sort($niveles);
    sort($grados);

    $data = [
        'matriculas' => $matriculas,
        'grupos'     => $grupos,
        'anios'      => $anios,
        'niveles'    => $niveles,
        'grados'     => $grados,
        'filtros'    => [
            'anio'  => $anio,
            'nivel' => $nivel,
            'grado' => $grado,
        ],
        'header' => view('layouts/header'),
        'footer' => view('layouts/footer')
    ];

    return view('matriculas/listar', $data);
}


    public function crear()
    {
        $personas = $this->personaModel->findAll();

        $data = [
            'alumnos'    => $personas,
            'apoderados' => $personas,
            'grupos'     => $this->grupoModel->getGruposConCalendarizacion(),
            'header'     => view('layouts/header'),
            'footer'     => view('layouts/footer')
        ];

        return view('matriculas/crear', $data);
    }

    public function guardar()
    {
        $post = $this->request->getPost();

        if (empty($post['idalumno']) || empty($post['idgrupo']) || empty($post['idapoderado'])) {
            return redirect()->back()->with('error', 'Datos obligatorios incompletos.');
        }

        $alumno = $this->personaModel->find($post['idalumno']);
        $apoderado = $this->personaModel->find($post['idapoderado']);
        $grupo = $this->grupoModel->find($post['idgrupo']);

        if (!$alumno || !$apoderado || !$grupo) {
            return redirect()->back()->with('error', 'Alumno, Apoderado o Grupo no encontrados.');
        }

        $qrContent = sprintf(
            "Alumno: %s %s %s\nApoderado: %s %s %s\nGrupo: %s %s - %s (%s)\nAño Escolar: %s\nTurno: %s\nEstado: %s",
            $alumno['nombres'], $alumno['apepaterno'], $alumno['apematerno'],
            $apoderado['nombres'], $apoderado['apepaterno'], $apoderado['apematerno'],
            $grupo['grado'], $grupo['seccion'], $grupo['nivel'], $grupo['alectivo'],
            $post['anio_escolar'], $post['turno'], $post['estado']
        );

        $uploadDir = FCPATH . 'uploads/qr/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            return redirect()->back()->with('error', 'No se pudo crear el directorio para QR.');
        }

        $qrFileName = 'qr_' . time() . '_' . bin2hex(random_bytes(4)) . '.svg';
        $qrPath = $uploadDir . $qrFileName;
        $qrUrl = 'uploads/qr/' . $qrFileName;

        try {
            $renderer = new ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $writer->writeFile($qrContent, $qrPath);
        } catch (\Throwable $e) {
            log_message('error', 'Error generando QR: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo generar el QR.');
        }

        $data = [
            'idalumno'      => $post['idalumno'],
            'idgrupo'       => $post['idgrupo'],
            'fechamatricula'=> $post['fechamatricula'] ?? date('Y-m-d'),
            'estado'        => $post['estado'] ?? 'activo',
            'idapoderado'   => $post['idapoderado'],
            'parentesco'    => $post['parentesco'] ?? '',
            'anio_escolar'  => $post['anio_escolar'] ?? '',
            'turno'         => $post['turno'] ?? '',
            'codigo_qr'     => $qrUrl,
        ];

        $this->matriculaModel->insert($data);

        return redirect()->to(base_url('matriculas/listar'))
                         ->with('success', 'Matrícula registrada con QR.');
    }

    public function carnet($id)
    {
        $matricula = $this->matriculaModel->find($id);

        if (!$matricula) {
            return redirect()->to(base_url('matriculas/listar'))
                             ->with('error', 'Matrícula no encontrada.');
        }

        $alumno = $this->personaModel->find($matricula['idalumno']);
        $grupo = $this->grupoModel->find($matricula['idgrupo']);
        $qrPath = base_url($matricula['codigo_qr']);

        $html = '
        <style>
            .carnet {
                width: 350px;
                height: 180px;
                border: 2px solid #000;
                border-radius: 10px;
                font-family: Arial, sans-serif;
                padding: 10px;
                background: #f7f7f7;
                position: relative;
            }
            .carnet h3 {
                margin: 0 0 10px 0;
                text-align: center;
                font-size: 18px;
                color: #d40000;
            }
            .info {
                font-size: 14px;
                margin-bottom: 15px;
            }
            .info b {
                color: #333;
            }
            .qr {
                text-align: center;
            }
            .qr img {
                width: 100px;
                height: 100px;
                margin-top: 10px;
            }
        </style>
        <div class="carnet">
            <h3>UNIDAD EDUCATIVA<br>CARNET ESCOLAR</h3>
            <div class="info">
                <b>Nombre:</b> ' . esc($alumno['nombres']) . ' ' . esc($alumno['apepaterno']) . ' ' . esc($alumno['apematerno']) . '<br>
                <b>Grupo:</b> ' . esc($grupo['grado']) . ' ' . esc($grupo['seccion']) . ' - ' . esc($grupo['nivel']) . '<br>
                <b>Año Escolar:</b> ' . esc($matricula['anio_escolar']) . '<br>
                <b>Turno:</b> ' . esc($matricula['turno']) . '<br>
                <b>Estado:</b> ' . esc($matricula['estado']) . '
            </div>
            <div class="qr">
                <img src="' . $qrPath . '" alt="QR del estudiante" />
            </div>
        </div>';

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A6', 'landscape');
        $dompdf->render();
        $dompdf->stream("Carnet_Alumno_" . $alumno['nombres'] . ".pdf", ["Attachment" => true]);
    }
}

