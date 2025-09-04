<?php
namespace App\Controllers;

use App\Models\Matricula;
use App\Models\Persona;
use App\Models\Grupo;

class MatriculaController extends BaseController
{
    public function listar()
    {
    $model = new Matricula();
    $grupoModel = new Grupo();

    $data['matriculas'] = $model->getMatriculasConDetalles();
    $data['grupos']     = $grupoModel->getGruposConCalendarizacion();

    $data['header'] = view('layouts/header');
    $data['footer'] = view('layouts/footer');

    return view('matriculas/listar', $data);
    }

    public function crear()
    {
    $personaModel = new Persona();
    $grupoModel   = new Grupo();

    $data['alumnos']    = $personaModel->findAll();
    $data['apoderados'] = $personaModel->findAll();
    $data['grupos']     = $grupoModel->getGruposConCalendarizacion();

    $data['header'] = view('layouts/header');
    $data['footer'] = view('layouts/footer');

    return view('matriculas/crear', $data);
    }

    public function guardar()
    {
        $model = new Matricula();

        $data = [
            'idalumno'      => $this->request->getPost('idalumno'),
            'idgrupo'       => $this->request->getPost('idgrupo'),
            'fechamatricula'=> $this->request->getPost('fechamatricula'),
            'estado'        => $this->request->getPost('estado'),
            'idapoderado'   => $this->request->getPost('idapoderado'),
            'parentesco'    => $this->request->getPost('parentesco'),
            'anio_escolar'  => $this->request->getPost('anio_escolar'),
            'turno'         => $this->request->getPost('turno'),
            'codigo_qr'     => uniqid('QR-'), // ⚡ genera un código QR único
        ];

        $model->insert($data);
        return redirect()->to(base_url('matriculas/listar'))->with('success', 'Matrícula registrada.');
    }

   public function editar($id)
    {
    $model = new Matricula();
    $personaModel = new Persona();
    $grupoModel   = new Grupo();

    $data['matricula']  = $model->find($id);
    $data['alumnos']    = $personaModel->findAll();
    $data['apoderados'] = $personaModel->findAll();
    $data['grupos']     = $grupoModel->getGruposConCalendarizacion();

    if (!$data['matricula']) {
        return redirect()->to(base_url('matriculas/listar'))->with('error', 'No encontrada.');
    }

    $data['header'] = view('layouts/header');
    $data['footer'] = view('layouts/footer');

    return view('matriculas/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new Matricula();

        $data = [
            'idalumno'      => $this->request->getPost('idalumno'),
            'idgrupo'       => $this->request->getPost('idgrupo'),
            'fechamatricula'=> $this->request->getPost('fechamatricula'),
            'estado'        => $this->request->getPost('estado'),
            'idapoderado'   => $this->request->getPost('idapoderado'),
            'parentesco'    => $this->request->getPost('parentesco'),
            'anio_escolar'  => $this->request->getPost('anio_escolar'),
            'turno'         => $this->request->getPost('turno'),
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('matriculas/listar'))->with('success', 'Matrícula actualizada.');
    }

    public function borrar($id)
    {
        $model = new Matricula();
        $model->delete($id);
        return redirect()->to(base_url('matriculas/listar'))->with('success', 'Matrícula eliminada.');
    }
}
