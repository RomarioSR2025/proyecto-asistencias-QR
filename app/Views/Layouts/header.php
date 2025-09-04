<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Sistema de Asistencia'; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>

  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url(); ?>">Asistencia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == '' ? 'active' : '' ?>" 
             href="<?= base_url(); ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'personas' ? 'active' : '' ?>" 
             href="<?= base_url('personas/listar'); ?>">Personas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'usuarios' ? 'active' : '' ?>" 
             href="<?= base_url('usuarios/listar'); ?>">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'calendarizaciones' ? 'active' : '' ?>" 
             href="<?= base_url('calendarizaciones/listar'); ?>">Calendarizaciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'grupos' ? 'active' : '' ?>" 
             href="<?= base_url('grupos/listar'); ?>">Grupos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= service('uri')->getSegment(1) == 'matriculas' ? 'active' : '' ?>" 
             href="<?= base_url('matriculas/listar'); ?>">Matrículas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= service('uri')->getSegment(1) == 'asistencias' ? 'active' : '' ?>" 
             href="<?= base_url('asistencias/listar'); ?>">Asistencias</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


  <!-- Contenido principal -->
  <main class="container">
