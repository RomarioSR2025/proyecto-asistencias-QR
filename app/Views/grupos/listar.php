<?= $header; ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center my-3">
    <h4>Grupos</h4>
    <a href="<?= base_url('grupos/crear'); ?>" class="btn btn-primary btn-sm">Nuevo Grupo</a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
  <?php endif; ?>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Año lectivo</th>
        <th>Nivel</th>
        <th>Grado</th>
        <th>Sección</th>
        <th>Calendarización</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($grupos) && is_array($grupos)): ?>
        <?php foreach ($grupos as $g): ?>
          <tr>
            <td><?= $g['idgrupo']; ?></td>
            <td><?= esc($g['alectivo']); ?></td>
            <td><?= esc($g['nivel']); ?></td>
            <td><?= esc($g['grado']); ?></td>
            <td><?= esc($g['seccion']); ?></td>
            <td>
              <?php if (!empty($g['fechainicio'])): ?>
                <?= $g['fechainicio']; ?> → <?= $g['fechafin']; ?>
                <br>
                <?= $g['horainicio']; ?> - <?= $g['horafin']; ?>
              <?php else: ?>
                <span class="text-muted">Sin calendarización</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('grupos/editar/'.$g['idgrupo']); ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="<?= base_url('grupos/borrar/'.$g['idgrupo']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar?');">Borrar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7" class="text-center">No hay registros</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>
