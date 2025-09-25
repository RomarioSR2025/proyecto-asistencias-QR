<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Dashboard</a>
      <div class="d-flex">
        <span class="navbar-text me-3">Hola, <?= session('usuario_nombre') ?></span>
        <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <?= $this->extend('Layouts/main') ?>

<?= $this->section('content') ?>

<h1>Bienvenido al panel de administración</h1>
<p>Hola, <?= session('usuario_nombre') ?></p>

<?= $this->endSection() ?>
</body>
</html>
