<?= $header; ?>

<div class="container mt-3">
  <div class="my-3">
    <h4>Editar Persona</h4>
    <a href="<?= base_url("personas/listar"); ?>">Volver</a>
  </div>

  <form method="POST" action="<?= base_url('personas/actualizar'); ?>" enctype="multipart/form-data">
    <input type="hidden" name="idpersona" value="<?= $persona['idpersona']; ?>">

    <div class="card">
      <div class="card-body">

        <div class="mb-3">
          <label for="apepaterno" class="form-label">Apellido Paterno</label>
          <input type="text" class="form-control" name="apepaterno" id="apepaterno" 
                 value="<?= $persona['apepaterno']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="apematerno" class="form-label">Apellido Materno</label>
          <input type="text" class="form-control" name="apematerno" id="apematerno" 
                 value="<?= $persona['apematerno']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="nombres" class="form-label">Nombres</label>
          <input type="text" class="form-control" name="nombres" id="nombres" 
                 value="<?= $persona['nombres']; ?>" required>
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
          <label for="numerodoc" class="form-label">Número Documento</label>
          <input type="text" class="form-control" name="numerodoc" id="numerodoc" 
                 value="<?= $persona['numerodoc']; ?>">
        </div>

        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="text" class="form-control" name="direccion" id="direccion" 
                 value="<?= $persona['direccion']; ?>">
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" class="form-control" name="telefono" id="telefono" 
                 value="<?= $persona['telefono']; ?>">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo</label>
          <input type="email" class="form-control" name="email" id="email" 
                 value="<?= $persona['email']; ?>">
        </div>

        <div class="mb-3">
          <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
          <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" 
                 value="<?= $persona['fecha_nacimiento']; ?>">
        </div>

        <div class="mb-3">
          <label for="sexo" class="form-label">Sexo</label>
          <select class="form-control" name="sexo" id="sexo">
            <option value="M" <?= ($persona['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
            <option value="F" <?= ($persona['sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="imagenperfil" class="form-label">Imagen Perfil</label><br>
          <?php if (!empty($persona['imagenperfil'])): ?>
            <img src="<?= base_url('uploads/'.$persona['imagenperfil']); ?>" 
                 class="img-thumbnail mb-2" width="100">
          <?php endif; ?>
          <input type="file" class="form-control" name="imagenperfil" id="imagenperfil">
        </div>

      </div>
      <div class="card-footer text-end">
        <button type="reset" class="btn btn-sm btn-outline-secondary">Cancelar</button>
        <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
      </div>
    </div>
  </form>
</div>

<?= $footer; ?>
