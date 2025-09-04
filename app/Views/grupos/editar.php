<?= $header; ?>

<div class="container mt-3">
  <h4>Editar Grupo</h4>

  <form action="<?= base_url('grupos/actualizar/'.$grupo['idgrupo']); ?>" method="post">
    <div class="mb-3">
      <label class="form-label">Año lectivo</label>
      <input type="text" name="alectivo" class="form-control" value="<?= esc($grupo['alectivo']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Nivel</label>
      <input type="text" name="nivel" class="form-control" value="<?= esc($grupo['nivel']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Grado</label>
      <input type="text" name="grado" class="form-control" value="<?= esc($grupo['grado']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Sección</label>
      <input type="text" name="seccion" class="form-control" value="<?= esc($grupo['seccion']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Calendarización (opcional)</label>
      <select name="idcalendarizacion" class="form-select">
        <option value="">-- Seleccione --</option>
        <?php foreach ($calendarizaciones as $c): ?>
          <option value="<?= $c['idcalendarizacion']; ?>" <?= ($grupo['idcalendarizacion'] == $c['idcalendarizacion']) ? 'selected' : ''; ?>>
            <?= $c['fechainicio'].' → '.$c['fechafin'].' | '.$c['horainicio'].' - '.$c['horafin']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button class="btn btn-success" type="submit">Actualizar</button>
    <a href="<?= base_url('grupos/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>
