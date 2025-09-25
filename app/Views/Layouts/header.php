<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= isset($title) ? $title : 'Sistema de Asistencia'; ?></title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

  <style>
    :root {
      --vino: #800020;
      --vino-oscuro: #5a0017;
      --crema: #f8f5f0;
      --crema-oscuro: #eae5dc;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--crema);
    }

    .navbar {
      background-color: var(--vino) !important;
      padding: 0.75rem 1.5rem;
    }

    .navbar-brand,
    .nav-link,
    #userDropdown {
      color: var(--crema) !important;
      transition: color 0.3s ease;
    }

    .nav-link.active {
      font-weight: 600;
      border-bottom: 3px solid var(--crema);
      border-radius: 0;
    }

    .nav-link:hover {
      color: var(--crema-oscuro) !important;
    }

    .btn-logout {
      background-color: var(--vino-oscuro);
      border: none;
      color: var(--crema);
      border-radius: 50px;
      padding: 0.35rem 0.9rem;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background-color: #a0002d;
      transform: scale(1.05);
    }

    .dropdown-menu {
      border-radius: 0.7rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .dropdown-item i {
      margin-right: 8px;
      color: var(--vino);
    }

    /* Botón de login */
    .btn-primary {
      background-color: var(--vino);
      border: none;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: var(--vino-oscuro);
    }

    /* Dark mode */
    [data-bs-theme="dark"] {
      --vino: #5a0017;
      --vino-oscuro: #3a0010;
      --crema: #f0ebe6;
      --crema-oscuro: #ddd6cc;
      background-color: #1e1e1e;
      color: var(--crema);
    }

    [data-bs-theme="dark"] .navbar {
      background-color: var(--vino) !important;
    }

    [data-bs-theme="dark"] .navbar-brand,
    [data-bs-theme="dark"] .nav-link,
    [data-bs-theme="dark"] #userDropdown {
      color: var(--crema) !important;
    }

    /* Animación hover menú */
    .nav-link {
      position: relative;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: var(--crema);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }
  </style>
</head>

<body>
  <?php $usuario_nombre = session('usuario_nombre'); ?>

  <nav class="navbar navbar-expand-lg shadow-sm mb-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="<?= base_url(); ?>">Sistema de Asistencia</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= (service('uri')->getSegment(1) == '') ? 'active' : '' ?>"
              href="<?= base_url(); ?>">Inicio</a>
          </li>
          <?php
          $menu_items = [
            'personas' => 'Alumnos',
            'usuarios' => 'Profesores',
            'calendarizaciones' => 'Calendarizaciones',
            'grupos' => 'Grupos',
            'matriculas' => 'Matrículas',
            'asistencias' => 'Asistencias'
          ];
          foreach ($menu_items as $segment => $label) :
            $active = (service('uri')->getSegment(1) == $segment) ? 'active' : '';
          ?>
            <li class="nav-item">
              <a class="nav-link <?= $active ?>" href="<?= base_url($segment . '/listar'); ?>"><?= $label ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <!-- Toggle tema -->
          <button id="themeToggle" class="btn btn-outline-light btn-sm rounded-circle" title="Cambiar tema">
            <i class="bi bi-moon"></i>
          </button>

          <!-- Usuario / Login -->
          <?php if (session('isLoggedIn')) : ?>
            <a class="btn btn-sm btn-logout d-flex align-items-center" href="<?= base_url('logout'); ?>">
              <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
            </a>

            <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle fw-semibold"
                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i>
                <?= esc($usuario_nombre) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="<?= base_url('perfil'); ?>"><i class="bi bi-person"></i> Perfil</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i
                      class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
              </ul>
            </div>
          <?php else : ?>
            <a class="btn btn-sm btn-primary" href="<?= base_url('login'); ?>">Iniciar sesión</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
    <?= $this->renderSection('content') ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    const toggle = document.getElementById('themeToggle');
    toggle.addEventListener('click', () => {
      const html = document.documentElement;
      const theme = html.getAttribute('data-bs-theme');
      const isLight = theme === 'light';
      html.setAttribute('data-bs-theme', isLight ? 'dark' : 'light');
      toggle.innerHTML = isLight ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
    });
  </script>
</body>

</html>
