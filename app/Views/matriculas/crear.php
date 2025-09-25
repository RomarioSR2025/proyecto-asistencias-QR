<?= $header; ?>

<div class="container mt-4">
  <h4 class="mb-4 text-center">Nueva Matrícula</h4>

  <form action="<?= base_url('matriculas/guardar'); ?>" method="post" class="mt-3">
    
    <!-- Datos del Alumno -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <strong>Datos del Alumno</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Alumno -->
          <div class="col-md-6 mb-3">
            <label for="idalumno" class="form-label">Alumno</label>
            <select name="idalumno" id="idalumno" class="form-select" required>
              <option value="">-- Seleccionar Alumno --</option>
              <?php foreach ($alumnos as $alumno): ?>
                <option value="<?= esc($alumno['idpersona']); ?>">
                  <?= esc($alumno['apepaterno'].' '.$alumno['apematerno'].', '.$alumno['nombres']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Fecha de Nacimiento -->
          <div class="col-md-6 mb-3">
            <label for="fechanacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" required>
          </div>

          <!-- Dirección -->
          <div class="col-md-6 mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Av. Siempre Viva 123" required>
          </div>

          <!-- Teléfono -->
          <div class="col-md-6 mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej: 123456789" required>
          </div>

          <!-- Correo Electrónico -->
          <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ej: ejemplo@dominio.com" required>
          </div>

          <!-- Género -->
          <div class="col-md-6 mb-3">
            <label for="genero" class="form-label">Género</label>
            <select name="genero" id="genero" class="form-select" required>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
          </div>

          <!-- Nacionalidad -->
          <div class="col-md-6 mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" placeholder="Ej: Peruano, Chileno, etc." required>
          </div>

          <!-- Tipo de Documento -->
          <div class="col-md-6 mb-3">
            <label for="tipodocumento" class="form-label">Tipo de Documento</label>
            <select name="tipodocumento" id="tipodocumento" class="form-select" required>
              <option value="DNI">DNI</option>
              <option value="Pasaporte">Pasaporte</option>
              <option value="Carnet Extranjería">Carnet Extranjería</option>
            </select>
          </div>

          <!-- Número de Documento -->
          <div class="col-md-6 mb-3">
            <label for="numdocumento" class="form-label">Número de Documento</label>
            <input type="text" class="form-control" id="numdocumento" name="numdocumento" placeholder="Ej: 12345678" required>
          </div>
        </div>
      </div>
    </div>

    <!-- Datos del Apoderado -->
    <div class="card mb-4">
      <div class="card-header bg-info text-white">
        <strong>Datos del Apoderado</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="idapoderado" class="form-label">Apoderado</label>
            <select name="idapoderado" id="idapoderado" class="form-select" required>
              <option value="">-- Seleccionar Apoderado --</option>
              <?php foreach ($apoderados as $apoderado): ?>
                <option value="<?= esc($apoderado['idpersona']); ?>">
                  <?= esc($apoderado['apepaterno'].' '.$apoderado['apematerno'].', '.$apoderado['nombres']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Parentesco -->
          <div class="col-md-6 mb-3">
            <label for="parentesco" class="form-label">Parentesco</label>
            <input type="text" class="form-control" id="parentesco" name="parentesco" placeholder="Ej: Padre, Madre, Tío" required>
          </div>

          <!-- Teléfono del Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="telefono_apoderado" class="form-label">Teléfono del Apoderado</label>
            <input type="text" class="form-control" id="telefono_apoderado" name="telefono_apoderado" placeholder="Ej: 987654321" required>
          </div>

          <!-- Correo Electrónico del Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="email_apoderado" class="form-label">Correo Electrónico del Apoderado</label>
            <input type="email" class="form-control" id="email_apoderado" name="email_apoderado" placeholder="Ej: apoderado@dominio.com" required>
          </div>

          <!-- Dirección del Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="direccion_apoderado" class="form-label">Dirección del Apoderado</label>
            <input type="text" class="form-control" id="direccion_apoderado" name="direccion_apoderado" placeholder="Ej: Av. Libertador 456" required>
          </div>

          <!-- Tipo de Documento del Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="tipodocumento_apoderado" class="form-label">Tipo de Documento del Apoderado</label>
            <select name="tipodocumento_apoderado" id="tipodocumento_apoderado" class="form-select" required>
              <option value="DNI">DNI</option>
              <option value="Pasaporte">Pasaporte</option>
              <option value="Carnet Extranjería">Carnet Extranjería</option>
            </select>
          </div>

          <!-- Número de Documento del Apoderado -->
          <div class="col-md-6 mb-3">
            <label for="numdocumento_apoderado" class="form-label">Número de Documento del Apoderado</label>
            <input type="text" class="form-control" id="numdocumento_apoderado" name="numdocumento_apoderado" placeholder="Ej: 23456789" required>
          </div>
        </div>
      </div>
    </div>

    <!-- Datos de la Matrícula -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <strong>Datos de la Matrícula</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Grupo -->
          <div class="col-md-6 mb-3">
            <label for="idgrupo" class="form-label">Grupo</label>
            <select name="idgrupo" id="idgrupo" class="form-select" required>
              <option value="">-- Seleccionar Grupo --</option>
              <?php foreach ($grupos as $grupo): ?>
                <option value="<?= esc($grupo['idgrupo']); ?>">
                  <?= esc($grupo['grado'].' '.$grupo['seccion'].' - '.$grupo['nivel'].' ('.$grupo['alectivo'].')'); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Fecha de Matrícula -->
          <div class="col-md-6 mb-3">
            <label for="fechamatricula" class="form-label">Fecha de Matrícula</label>
            <input type="date" class="form-control" id="fechamatricula" name="fechamatricula" required>
          </div>

          <!-- Año Escolar -->
          <div class="col-md-6 mb-3">
            <label for="anio_escolar" class="form-label">Año Escolar</label>
            <input type="number" class="form-control" id="anio_escolar" name="anio_escolar" min="2000" max="2100" value="<?= date('Y'); ?>" required>
          </div>

          <!-- Turno -->
          <div class="col-md-6 mb-3">
            <label for="turno" class="form-label">Turno</label>
            <select name="turno" id="turno" class="form-select" required>
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
            </select>
          </div>

          <!-- Estado -->
          <div class="col-md-6 mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Guardar
      </button>
      <a href="<?= base_url('matriculas/listar'); ?>" class="btn btn-secondary">
        <i class="bi bi-x-circle"></i> Cancelar
      </a>
    </div>
  </form>
</div>

<?= $footer; ?>

