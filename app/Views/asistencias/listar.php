<?= $header; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📋 Listado de Asistencias</h4>
  </div>

  <!-- Filtros -->
  <form action="<?= base_url('asistencias/listar'); ?>" method="get" class="row g-2 mb-4">
    <div class="col-md-3">
      <label for="fecha" class="form-label">📅 Fecha</label>
      <input type="date" name="fecha" class="form-control" 
             value="<?= esc($filtros['fecha'] ?? date('Y-m-d')); ?>">
    </div>
    <div class="col-md-4">
      <label for="idgrupo" class="form-label">🏫 Grupo</label>
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
    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-outline-primary w-100">
        🔍 Filtrar
      </button>
    </div>
    <div class="col-md-3 d-flex align-items-end gap-2">
      <?php if (!empty($filtros['idgrupo'])): ?>
        <a href="<?= base_url('asistencias/tomar/'.$filtros['idgrupo'].'?fecha='.($filtros['fecha'] ?? date('Y-m-d'))); ?>"
           class="btn btn-success w-100">
          ✅ Tomar Asistencia
        </a>
      <?php endif; ?>
      <?php if (!empty($asistencias)): ?>
        <a href="<?= base_url('asistencias/exportar?fecha='.$filtros['fecha'].'&idgrupo='.$filtros['idgrupo']); ?>"
           class="btn btn-outline-secondary w-100">
          ⬇️ Exportar
        </a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Tabla de Asistencias -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
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
            <?php
              $badgeClass = match($a['estado']) {
                'Asistió'    => 'success',
                'Falta'      => 'danger',
                'Tardanza'   => 'warning',
                'Justificado'=> 'info',
                default      => 'secondary',
              };
            ?>
            <tr class="text-center">
              <td><?= $i + 1; ?></td>
              <td class="text-start"><?= esc($a['alumno']); ?></td>
              <td><?= esc($a['grupo']); ?></td>
              <td><?= esc($a['fecha']); ?></td>
              <td><?= $a['hentrada'] ?? '--'; ?></td>
              <td><?= $a['hsalida'] ?? '--'; ?></td>
              <td><?= $a['mintardanza'] ?? '0'; ?></td>
              <td>
                <span class="badge bg-<?= $badgeClass; ?>">
                  <?= $a['estado']; ?>
                </span>
              </td>
              <td><?= esc($a['metodo']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center text-muted">
              😕 No se encontraron registros de asistencia para los filtros seleccionados.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $footer; ?>
