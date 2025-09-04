<?= $header; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Listado de Matrículas</h4>
    <a href="<?= base_url('matriculas/crear'); ?>" class="btn btn-primary btn-sm">Nueva Matrícula</a>
  </div>

  <!-- Filtro de búsqueda -->
  <form action="<?= base_url('matriculas/listar'); ?>" method="get" class="row g-2 mb-3">
    <div class="col-md-3">
      <input type="text" name="alumno" class="form-control" 
             placeholder="Buscar por alumno" value="<?= esc($filtros['alumno'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <select name="idgrupo" class="form-select">
        <option value="">-- Grupo --</option>
        <?php foreach ($grupos as $grupo): ?>
          <option value="<?= $grupo['idgrupo']; ?>" 
            <?= isset($filtros['idgrupo']) && $filtros['idgrupo'] == $grupo['idgrupo'] ? 'selected' : ''; ?>>
            <?= $grupo['grado'].' '.$grupo['seccion'].' - '.$grupo['nivel'].' ('.$grupo['alectivo'].')'; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <input type="number" name="anio_escolar" class="form-control" 
             placeholder="Año" value="<?= esc($filtros['anio_escolar'] ?? '') ?>">
    </div>
    <div class="col-md-2">
      <select name="estado" class="form-select">
        <option value="">-- Estado --</option>
        <option value="Activo" <?= ($filtros['estado'] ?? '') == 'Activo' ? 'selected' : ''; ?>>Activo</option>
        <option value="Inactivo" <?= ($filtros['estado'] ?? '') == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-secondary w-100">Filtrar</button>
    </div>
  </form>

  <!-- Tabla -->
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Alumno</th>
        <th>Apoderado</th>
        <th>Parentesco</th>
        <th>Grupo</th>
        <th>Año Escolar</th>
        <th>Turno</th>
        <th>Fecha Matrícula</th>
        <th>Estado</th>
        <th>QR</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($matriculas) && is_array($matriculas)) : ?>
        <?php foreach ($matriculas as $matricula): ?>
          <tr>
            <td><?= $matricula['idmatricula']; ?></td>
            <td><?= $matricula['alumno']; ?></td>
            <td><?= $matricula['apoderado']; ?></td>
            <td><?= $matricula['parentesco']; ?></td>
            <td><?= $matricula['grupo']; ?></td>
            <td><?= $matricula['anio_escolar']; ?></td>
            <td><?= $matricula['turno']; ?></td>
            <td><?= $matricula['fechamatricula']; ?></td>
            <td>
              <span class="badge bg-<?= $matricula['estado'] == 'Activo' ? 'success' : 'secondary'; ?>">
                <?= $matricula['estado']; ?>
              </span>
            </td>
            <td>
              <?php if (!empty($matricula['codigo_qr'])): ?>
                <img src="<?= base_url('uploads/qr/'.$matricula['codigo_qr']); ?>" 
                     alt="QR" width="50" height="50">
              <?php else: ?>
                <span class="text-muted">No QR</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('matriculas/editar/'.$matricula['idmatricula']); ?>" 
                 class="btn btn-warning btn-sm">Editar</a>
              <a href="<?= base_url('matriculas/borrar/'.$matricula['idmatricula']); ?>" 
                 class="btn btn-danger btn-sm" 
                 onclick="return confirm('¿Seguro de eliminar la matrícula?');">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="11" class="text-center">No hay matrículas registradas</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>
