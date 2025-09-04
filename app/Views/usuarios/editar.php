<?= $header; ?>

<div class="container mt-3">
  <h4>Editar Usuario</h4>
  <form action="<?= base_url('usuarios/actualizar/'.$usuario['idusuario']); ?>" method="post">
    <div class="mb-3">
      <label for="nomuser" class="form-label">Nombre de Usuario</label>
      <input type="text" class="form-control" id="nomuser" name="nomuser" value="<?= $usuario['nomuser']; ?>" required>
    </div>

    <div class="mb-3">
      <label for="passuser" class="form-label">Contraseña (dejar vacío si no desea cambiarla)</label>
      <input type="password" class="form-control" id="passuser" name="passuser">
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-select" id="estado" name="estado">
        <option value="Activo" <?= $usuario['estado'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
        <option value="Inactivo" <?= $usuario['estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="idpersona" class="form-label">Persona asociada</label>
      <select class="form-select" id="idpersona" name="idpersona" required>
        <?php foreach ($personas as $persona): ?>
          <option value="<?= $persona['idpersona']; ?>" 
            <?= $usuario['idpersona'] == $persona['idpersona'] ? 'selected' : ''; ?>>
            <?= $persona['apepaterno'].' '.$persona['apematerno'].' '.$persona['nombres']; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="<?= base_url('usuarios/listar'); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?= $footer; ?>