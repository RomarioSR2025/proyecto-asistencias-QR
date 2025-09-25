<?= $header; ?>

<div class="container mt-4">
  <h4 class="mb-3">Listado de Matrículas</h4>

  <!-- FILTROS -->
  <form method="get" action="<?= base_url('matriculas/listar'); ?>" class="row g-2 mb-3">
    <div class="col-md-3">
      <select name="anio" class="form-select">
        <option value="">-- Año Escolar --</option>
        <?php foreach ($anios as $anio): ?>
          <option value="<?= $anio; ?>" <?= ($anio == $filtros['anio']) ? 'selected' : ''; ?>>
            <?= $anio; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="nivel" class="form-select">
        <option value="">-- Nivel --</option>
        <?php foreach ($niveles as $nivel): ?>
          <option value="<?= $nivel; ?>" <?= ($nivel == $filtros['nivel']) ? 'selected' : ''; ?>>
            <?= $nivel; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="grado" class="form-select">
        <option value="">-- Grado --</option>
        <?php foreach ($grados as $grado): ?>
          <option value="<?= $grado; ?>" <?= ($grado == $filtros['grado']) ? 'selected' : ''; ?>>
            <?= $grado; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-search"></i> Buscar
      </button>
    </div>
  </form>

  <!-- Botón Nueva Matrícula -->
  <a href="<?= base_url('matriculas/crear'); ?>" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nueva Matrícula
  </a>

  <!-- TABLA -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Alumno</th>
          <th>Apoderado</th>
          <th>Grupo</th>
          <th>Año Escolar</th>
          <th>Turno</th>
          <th>Estado</th>
          <th>QR</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($matriculas)): ?>
          <?php foreach ($matriculas as $i => $m): ?>
            <tr>
              <td><?= $i + 1; ?></td>
              <td><?= esc($m['alumno']); ?></td>
              <td><?= esc($m['apoderado']); ?></td>
              <td><?= esc($m['grupo']); ?></td>
              <td><?= esc($m['anio_escolar']); ?></td>
              <td><?= esc($m['turno']); ?></td>
              <td>
                <span class="badge <?= $m['estado'] == 'Activo' ? 'bg-success' : 'bg-danger'; ?>">
                  <?= esc($m['estado']); ?>
                </span>
              </td>
              <td class="text-center">
                <?php if (!empty($m['codigo_qr'])): ?>
                  <img src="<?= base_url($m['codigo_qr']); ?>" alt="QR" class="img-fluid" style="max-width: 100px;">
                <?php else: ?>
                  <span class="badge bg-danger">Sin QR</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="<?= base_url('matriculas/editar/' . $m['idmatricula']); ?>" class="btn btn-sm btn-warning">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="<?= base_url('matriculas/borrar/' . $m['idmatricula']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar esta matrícula?')">
                  <i class="bi bi-trash"></i>
                </a>
                <a href="<?= base_url('matriculas/carnet/' . $m['idmatricula']); ?>" class="btn btn-sm btn-success">
                  <i class="bi bi-card-list"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">No hay matrículas registradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $footer; ?>


<!-- Inicializar Tooltip -->
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
