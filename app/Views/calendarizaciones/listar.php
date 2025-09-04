<?= $header; ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center my-3">
    <h4>Calendarizaciones</h4>
    <a href="<?= base_url('calendarizaciones/crear'); ?>" class="btn btn-primary btn-sm">Nueva</a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
  <?php endif; ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Hora Inicio</th>
        <th>Hora Fin</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($calendarizaciones)): ?>
        <?php foreach ($calendarizaciones as $c): ?>
          <tr>
            <td><?= $c['idcalendarizacion']; ?></td>
            <td><?= $c['fechainicio']; ?></td>
            <td><?= $c['fechafin']; ?></td>
            <td><?= $c['horainicio']; ?></td>
            <td><?= $c['horafin']; ?></td>
            <td>
              <a href="<?= base_url('calendarizaciones/editar/'.$c['idcalendarizacion']); ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="<?= base_url('calendarizaciones/borrar/'.$c['idcalendarizacion']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Borrar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">No hay registros</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>
