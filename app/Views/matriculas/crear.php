<?= $header; ?>

<div class="container mt-4">
  <h4>Nueva Matrícula</h4>
  <form action="<?= base_url('matriculas/guardar'); ?>" method="post" class="mt-3">

    <!-- Alumno -->
    <div class="mb-3">
      <label for="idalumno" class="form-label">Alumno</label>
      <select name="idalumno" id="idalumno" class="form-select" required>
        <option value="">-- Seleccionar Alumno --</option>
        <?php foreach ($alumnos as $alumno): ?>
          <option value="<?= $alumno['idpersona']; ?>">
            <?= $alumno['apepaterno'].' '.$alumno['apematerno'].', '.$alumno['nombres']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Apoderado -->
    <div class="mb-3">
      <label for="idapoderado" class="form-label">Apoderado</label>
      <select name="idapoderado" id="idapoderado" class="form-select" required>
        <option value="">-- Seleccionar Apoderado --</option>
        <?php foreach ($apoderados as $apoderado): ?>
          <option value="<?= $apoderado['idpersona']; ?>">
            <?= $apoderado['apepaterno'].' '.$apoderado['apematerno'].', '.$apoderado['nombres']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Parentesco -->
    <div class="mb-3">
      <label for="parentesco" class="form-label">Parentesco</label>
      <input type="text" class="form-control" id="parentesco" name="parentesco" placeholder="Ej: Padre, Madre, Tío" required>
    </div>

    <!-- Grupo -->
    <div class="mb-3">
      <label for="idgrupo" class="form-label">Grupo</label>
      <select name="idgrupo" id="idgrupo" class="form-select" required>
        <option value="">-- Seleccionar Grupo --</option>
        <?php foreach ($grupos as $grupo): ?>
          <option value="<?= $grupo['idgrupo']; ?>">
            <?= $grupo['grado'].' '.$grupo['seccion'].' - '.$grupo['nivel'].' ('.$grupo['alectivo'].')'; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Fecha matrícula -->
    <div class="mb-3">
      <label for="fechamatricula" class="form-label">Fecha de Matrícula</label>
      <input type="date" class="form-control" id="fechamatricula" name="fechamatricula" required>
    </div>

    <!-- Año escolar -->
    <div class="mb-3">
      <label for="anio_escolar" class="form-label">Año Escolar</label>
      <input type="number" class="form-control" id="anio_escolar" name="anio_escolar" min="2000" max="2100" value="<?= date('Y'); ?>" required>
    </div>

    <!-- Turno -->
    <div class="mb-3">
      <label for="turno" class="form-label">Turno</label>
      <select name="turno" id="turno" class="form-select" required>
        <option value="Mañana">Mañana</option>
        <option value="Tarde">Tarde</option>
      </select>
    </div>

    <!-- Estado -->
    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select name="estado" id="estado" class="form-select" required>
        <option value="Activo">Activo</option>
        <option value="Inactivo">Inactivo</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="<?= base_url('matriculas/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>
