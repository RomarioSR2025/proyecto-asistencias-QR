<?php
namespace App\Controllers;

use App\Models\Calendarizacion;

class CalendarizacionController extends BaseController
{
    public function listar()
    {
        $model = new Calendarizacion();
        $data['calendarizaciones'] = $model->listarTodas();

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('calendarizaciones/listar', $data);
    }

    public function crear()
    {
        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('calendarizaciones/crear', $data);
    }

    public function guardar()
    {
        $model = new Calendarizacion();

        // Validación simple (puedes expandir con $this->validate)
        $fechainicio = $this->request->getPost('fechainicio');
        $fechafin    = $this->request->getPost('fechafin');
        $horainicio  = $this->request->getPost('horainicio');
        $horafin     = $this->request->getPost('horafin');

        // Validaciones básicas
        if (empty($fechainicio) || empty($fechafin) || empty($horainicio) || empty($horafin)) {
            return redirect()->back()->with('error', 'Complete todos los campos.')->withInput();
        }

        $data = [
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'horainicio'  => $horainicio,
            'horafin'     => $horafin
        ];

        $model->insert($data);
        return redirect()->to(base_url('calendarizaciones/listar'))->with('success', 'Calendarización creada.');
    }

    public function editar($id)
    {
        $model = new Calendarizacion();
        $data['calendarizacion'] = $model->find($id);

        if (!$data['calendarizacion']) {
            return redirect()->to(base_url('calendarizaciones/listar'))->with('error', 'Registro no encontrado.');
        }

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('calendarizaciones/editar', $data);
    }

    public function actualizar($id)
    {
        $model = new Calendarizacion();

        $fechainicio = $this->request->getPost('fechainicio');
        $fechafin    = $this->request->getPost('fechafin');
        $horainicio  = $this->request->getPost('horainicio');
        $horafin     = $this->request->getPost('horafin');

        if (empty($fechainicio) || empty($fechafin) || empty($horainicio) || empty($horafin)) {
            return redirect()->back()->with('error', 'Complete todos los campos.')->withInput();
        }

        $data = [
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'horainicio'  => $horainicio,
            'horafin'     => $horafin
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('calendarizaciones/listar'))->with('success', 'Calendarización actualizada.');
    }

    public function borrar($id)
    {
        $model = new Calendarizacion();
        $model->delete($id);

        return redirect()->to(base_url('calendarizaciones/listar'))->with('success', 'Calendarización eliminada.');
    }
}
