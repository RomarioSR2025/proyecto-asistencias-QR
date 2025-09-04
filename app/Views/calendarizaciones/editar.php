<?= $header; ?>

<div class="container mt-3">
  <h4>Editar Calendarización</h4>

  <form action="<?= base_url('calendarizaciones/actualizar/'.$calendarizacion['idcalendarizacion']); ?>" method="post">
    <div class="mb-3">
      <label class="form-label">Fecha inicio</label>
      <input type="date" name="fechainicio" class="form-control" value="<?= $calendarizacion['fechainicio']; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha fin</label>
      <input type="date" name="fechafin" class="form-control" value="<?= $calendarizacion['fechafin']; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora inicio</label>
      <input type="time" name="horainicio" class="form-control" value="<?= $calendarizacion['horainicio']; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora fin</label>
      <input type="time" name="horafin" class="form-control" value="<?= $calendarizacion['horafin']; ?>" required>
    </div>

    <button class="btn btn-success" type="submit">Actualizar</button>
    <a href="<?= base_url('calendarizaciones/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>
