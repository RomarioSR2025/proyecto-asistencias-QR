<?= $header; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Listado de Asistencias</h4>
  </div>

<!-- 🔍 Filtros -->
<form action="<?= base_url('asistencias/listar'); ?>" method="get" class="row g-2 mb-3">
  <div class="col-md-3">
    <input type="date" name="fecha" class="form-control" 
           value="<?= esc($filtros['fecha'] ?? date('Y-m-d')); ?>">
  </div>
  <div class="col-md-4">
    <select name="idgrupo" class="form-select">
      <option value="">-- Todos los grupos --</option>
      <?php foreach ($grupos as $grupo): ?>
        <option value="<?= $grupo['idgrupo']; ?>"
          <?= isset($filtros['idgrupo']) && $filtros['idgrupo'] == $grupo['idgrupo'] ? 'selected' : ''; ?>>
          <?= $grupo['grado'].' '.$grupo['seccion'].' - '.$grupo['nivel'].' ('.$grupo['alectivo'].')'; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-2">
    <button type="submit" class="btn btn-outline-secondary w-100">Filtrar</button>
  </div>

  <!-- ✅ Botón para tomar asistencia si hay grupo seleccionado -->
  <div class="col-md-3">
    <?php if (!empty($filtros['idgrupo'])): ?>
      <a href="<?= base_url('asistencias/tomar/'.$filtros['idgrupo'].'?fecha='.($filtros['fecha'] ?? date('Y-m-d'))); ?>"
         class="btn btn-success w-100">
        Tomar Asistencia
      </a>
    <?php endif; ?>
  </div>
</form>

  <!-- 📋 Tabla -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Alumno</th>
        <th>Grupo</th>
        <th>Fecha</th>
        <th>Entrada</th>
        <th>Salida</th>
        <th>Tardanza (min)</th>
        <th>Estado</th>
        <th>Método</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($asistencias) && is_array($asistencias)) : ?>
        <?php foreach ($asistencias as $i => $a): ?>
          <tr>
            <td><?= $i+1; ?></td>
            <td><?= esc($a['alumno']); ?></td>
            <td><?= esc($a['grupo']); ?></td>
            <td><?= esc($a['fecha']); ?></td>
            <td><?= $a['hentrada'] ?? '--'; ?></td>
            <td><?= $a['hsalida'] ?? '--'; ?></td>
            <td><?= $a['mintardanza'] ?? '0'; ?></td>
            <td>
              <?php
                $badgeClass = match($a['estado']) {
                  'Asistió'    => 'success',
                  'Falta'      => 'danger',
                  'Tardanza'   => 'warning',
                  'Justificado'=> 'info',
                  default      => 'secondary',
                };
              ?>
              <span class="badge bg-<?= $badgeClass; ?>">
                <?= $a['estado']; ?>
              </span>
            </td>
            <td><?= $a['metodo']; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="9" class="text-center">No se encontraron registros de asistencia</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>
