<?= $header; ?>

<div class="container mt-3">
  <h4>Nueva Calendarización</h4>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
  <?php endif; ?>

  <form action="<?= base_url('calendarizaciones/guardar'); ?>" method="post">
    <div class="mb-3">
      <label class="form-label">Fecha inicio</label>
      <input type="date" name="fechainicio" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha fin</label>
      <input type="date" name="fechafin" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora inicio</label>
      <input type="time" name="horainicio" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora fin</label>
      <input type="time" name="horafin" class="form-control" required>
    </div>

    <button class="btn btn-success" type="submit">Guardar</button>
    <a href="<?= base_url('calendarizaciones/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>
