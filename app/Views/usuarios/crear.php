<?= $header; ?>

<div class="container mt-3">
  <h4>Nuevo Usuario</h4>
  <form action="<?= base_url('usuarios/guardar'); ?>" method="post">
    <div class="mb-3">
      <label for="nomuser" class="form-label">Nombre de Usuario</label>
      <input type="text" class="form-control" id="nomuser" name="nomuser" required>
    </div>

    <div class="mb-3">
      <label for="passuser" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="passuser" name="passuser" required>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-select" id="estado" name="estado">
        <option value="Activo">Activo</option>
        <option value="Inactivo">Inactivo</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="idpersona" class="form-label">Persona asociada</label>
      <select class="form-select" id="idpersona" name="idpersona" required>
        <option value="">Seleccione una persona...</option>
        <?php foreach ($personas as $persona): ?>
          <option value="<?= $persona['idpersona']; ?>">
            <?= $persona['apepaterno'].' '.$persona['apematerno'].' '.$persona['nombres']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="<?= base_url('usuarios/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>
