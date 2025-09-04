<?= $header; ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center my-3">
    <h4>Listado de Usuarios</h4>
    <a href="<?= base_url('usuarios/crear'); ?>" class="btn btn-primary btn-sm">Nuevo Usuario</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Persona</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Sexo</th>
        <th>Imagen Perfil</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($usuarios) && is_array($usuarios)) : ?>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?= $usuario['idusuario']; ?></td>
            <td><?= $usuario['nomuser']; ?></td>
            <td><?= $usuario['estado']; ?></td>
            <td><?= $usuario['apepaterno'].' '.$usuario['apematerno'].' '.$usuario['nombres']; ?></td>
            <td><?= $usuario['email']; ?></td>
            <td><?= $usuario['telefono']; ?></td>
            <td><?= $usuario['sexo']; ?></td>
            <td>
              <?php if (!empty($usuario['imagenperfil'])): ?>
                <img src="<?= base_url('uploads/'.$usuario['imagenperfil']); ?>" 
                     alt="Foto de <?= $usuario['nombres']; ?>" 
                     width="60" height="60" style="object-fit:cover; border-radius:50%;">
              <?php else: ?>
                <span class="text-muted">Sin foto</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('usuarios/editar/'.$usuario['idusuario']); ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="<?= base_url('usuarios/borrar/'.$usuario['idusuario']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar este usuario?');">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="9" class="text-center">No hay registros</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>

