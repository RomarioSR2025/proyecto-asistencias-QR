<?php

namespace App\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Calendarizacion;
use App\Models\Grupo;
use App\Models\Matricula;

class Home extends BaseController
{
    public function index(): string
    {
        $personaModel = new Persona();
        $usuarioModel = new Usuario();
        $calendarModel = new Calendarizacion();
        $grupoModel = new Grupo();
        $matriculaModel = new Matricula();

        // Conteos básicos
        $data['totalPersonas'] = $personaModel->countAllResults();
        $data['totalUsuarios'] = $usuarioModel->countAllResults();
        $data['totalCalendarizaciones'] = $calendarModel->countAllResults();
        $data['totalGrupos'] = $grupoModel->countAllResults();
        $data['totalMatriculas'] = $matriculaModel->countAllResults();

        // Datos para la gráfica: matrículas por año escolar
        $matriculas = $matriculaModel->select('anio_escolar, COUNT(*) as total')
                                     ->groupBy('anio_escolar')
                                     ->findAll();
        $data['matriculasPorAnio'] = $matriculas;

        // Layouts
        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('welcome_message', $data);
    }
}
