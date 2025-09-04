<?= $header; ?>

<div class="container mt-3">
  <div class="my-3">
    <h4>Registro de Persona</h4>
    <a href="<?= base_url("personas/listar"); ?>">Volver</a>
  </div>

  <!-- Mostrar mensaje de error si existe -->
  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?= base_url('personas/guardar'); ?>" enctype="multipart/form-data">
    <div class="card">
      <div class="card-body">

        <div class="mb-3">
          <label for="apepaterno">Apellido Paterno</label>
          <input type="text" class="form-control" name="apepaterno" id="apepaterno" required>
        </div>

        <div class="mb-3">
          <label for="apematerno">Apellido Materno</label>
          <input type="text" class="form-control" name="apematerno" id="apematerno" required>
        </div>

        <div class="mb-3">
          <label for="nombres">Nombres</label>
          <input type="text" class="form-control" name="nombres" id="nombres" required>
        </div>

        <div class="mb-3">
          <label for="tipodoc">Tipo de Documento</label>
          <select class="form-control" name="tipodoc" id="tipodoc" required>
            <option value="DNI">DNI</option>
            <option value="Pasaporte">Pasaporte</option>
            <option value="Carnet">Carnet</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="numerodoc">Número Documento</label>
          <input type="text" class="form-control" name="numerodoc" id="numerodoc" required>
        </div>

        <div class="mb-3">
          <label for="direccion">Dirección</label>
          <input type="text" class="form-control" name="direccion" id="direccion">
        </div>

        <div class="mb-3">
          <label for="telefono">Teléfono</label>
          <input type="text" class="form-control" name="telefono" id="telefono">
        </div>

        <div class="mb-3">
          <label for="email">Correo</label>
          <input type="email" class="form-control" name="email" id="email">
        </div>

        <div class="mb-3">
          <label for="fecha_nacimiento">Fecha de Nacimiento</label>
          <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
        </div>

        <div class="mb-3">
          <label for="sexo">Sexo</label>
          <select class="form-control" name="sexo" id="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="imagenperfil">Imagen de Perfil</label>
          <input type="file" class="form-control" name="imagenperfil" id="imagenperfil">
        </div>

      </div>
      <div class="card-footer text-end">
        <button type="reset" class="btn btn-outline-secondary btn-sm">Cancelar</button>
        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
      </div>
    </div>
  </form>
</div>

<?= $footer; ?>


