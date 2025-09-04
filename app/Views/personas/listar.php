<?= $header; ?>

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center my-3">
    <h4>Listado de Personas</h4>
    <a href="<?= base_url('personas/crear'); ?>" class="btn btn-primary btn-sm">Nueva Persona</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Nombres</th>
        <th>Tipo Doc</th>
        <th>Número Doc</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Sexo</th>
        <th>Imagen Perfil</th> 
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($personas) && is_array($personas)) : ?>
        <?php foreach ($personas as $persona): ?>
          <tr>
            <td><?= $persona['idpersona']; ?></td>
            <td><?= $persona['apepaterno']; ?></td>
            <td><?= $persona['apematerno']; ?></td>
            <td><?= $persona['nombres']; ?></td>
            <td><?= $persona['tipodoc']; ?></td>
            <td><?= $persona['numerodoc']; ?></td>
            <td><?= $persona['telefono']; ?></td>
            <td><?= $persona['email']; ?></td>
            <td><?= $persona['sexo']; ?></td>
            <td>
              <?php if (!empty($persona['imagenperfil'])): ?>
                <img src="<?= base_url('uploads/'.$persona['imagenperfil']); ?>" 
                     alt="Foto de <?= $persona['nombres']; ?>" 
                     width="60" height="60" style="object-fit:cover; border-radius:50%;">
              <?php else: ?>
                <span class="text-muted">Sin foto</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('personas/editar/'.$persona['idpersona']); ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="<?= base_url('personas/borrar/'.$persona['idpersona']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar?');">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="11" class="text-center">No hay registros</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $footer; ?>
