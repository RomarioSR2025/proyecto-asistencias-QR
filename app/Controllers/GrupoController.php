<?php
namespace App\Controllers;

use App\Models\Grupo;
use App\Models\Calendarizacion;

class GrupoController extends BaseController
{
    public function listar()
    {
        $model = new Grupo();
        $data['grupos'] = $model->getGruposConCalendarizacion();

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('grupos/listar', $data);
    }

    public function crear()
    {
        $cal = new Calendarizacion();
        $data['calendarizaciones'] = $cal->listarTodas(); // o findAll()

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('grupos/crear', $data);
    }

    public function guardar()
    {
        $model = new Grupo();

        $data = [
            'alectivo'         => $this->request->getPost('alectivo'),
            'nivel'            => $this->request->getPost('nivel'),
            'grado'            => $this->request->getPost('grado'),
            'seccion'          => $this->request->getPost('seccion'),
            'idcalendarizacion'=> $this->request->getPost('idcalendarizacion') ?: null,
        ];

        $model->insert($data);
        return redirect()->to(base_url('grupos/listar'))->with('success', 'Grupo creado.');
    }

    public function editar($id)
    {
        $model = new Grupo();
        $cal = new Calendarizacion();

        $data['grupo'] = $model->find($id);
        if (!$data['grupo']) {
            return redirect()->to(base_url('grupos/listar'))->with('error', 'Registro no encontrado.');
        }

        $data['calendarizaciones'] = $cal->listarTodas();

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('grupos/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new Grupo();

        $data = [
            'alectivo'         => $this->request->getPost('alectivo'),
            'nivel'            => $this->request->getPost('nivel'),
            'grado'            => $this->request->getPost('grado'),
            'seccion'          => $this->request->getPost('seccion'),
            'idcalendarizacion'=> $this->request->getPost('idcalendarizacion') ?: null,
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('grupos/listar'))->with('success', 'Grupo actualizado.');
    }

    public function borrar($id)
    {
        $model = new Grupo();
        $model->delete($id);
        return redirect()->to(base_url('grupos/listar'))->with('success', 'Grupo eliminado.');
    }
}
