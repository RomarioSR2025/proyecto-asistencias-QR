<?php $baseUrl = base_url(); ?>

<?= $header; ?>

<div class="container mt-4">
  <!-- Título y botón de nueva persona -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 text-primary">Listado de Estudiantes</h4>
    <a href="<?= esc($baseUrl . 'personas/crear'); ?>" class="btn btn-success btn-sm" aria-label="Crear un nuevo estudiante">
      <i class="fas fa-plus"></i> Nuevo Estudiante
    </a>
  </div>

  <!-- Barra de búsqueda avanzada -->
  <div class="mb-3">
    <form class="d-flex" method="GET" action="<?= esc($baseUrl . 'personas'); ?>" role="search">
      <label for="searchInput" class="sr-only">Buscar Estudiantes</label>
      <input type="text" id="searchInput" name="buscar" class="form-control form-control-sm" 
             placeholder="Buscar por nombre, documento..." 
             value="<?= esc($buscar ?? ''); ?>" 
             aria-label="Buscar estudiantes por nombre o documento">
      <button type="submit" class="btn btn-outline-secondary btn-sm ml-2" aria-label="Iniciar búsqueda">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>

  <!-- Mostrar número de registros y paginación -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted">
      Mostrando <?= esc(count($personas)); ?> de <?= esc($total_personas); ?> registros
    </div>
    <div class="d-flex justify-content-center">
      <?= $pagination; ?> <!-- Paginación de los registros -->
    </div>
  </div>

  <!-- Tabla de estudiantes -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Apellido Paterno</th>
          <th scope="col">Apellido Materno</th>
          <th scope="col">Nombres</th>
          <th scope="col">Tipo Doc</th>
          <th scope="col">Número Doc</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Email</th>
          <th scope="col">Sexo</th>
          <th scope="col">Imagen Perfil</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($personas) && is_array($personas)) : ?>
          <?php foreach ($personas as $persona): ?>
            <tr>
              <td><?= esc($persona['idpersona']); ?></td>
              <td><?= esc($persona['apepaterno']); ?></td>
              <td><?= esc($persona['apematerno']); ?></td>
              <td><?= esc($persona['nombres']); ?></td>
              <td><?= esc($persona['tipodoc']); ?></td>
              <td><?= esc($persona['numerodoc']); ?></td>
              <td><?= esc($persona['telefono']); ?></td>
              <td>
                <a href="mailto:<?= esc($persona['email']); ?>" 
                   class="text-truncate" 
                   style="max-width: 150px;" 
                   title="Enviar correo a <?= esc($persona['email']); ?>">
                  <?= esc($persona['email']); ?>
                </a>
              </td>
              <td><?= esc($persona['sexo']); ?></td>
              <td>
                <?php
                  $imageUrl = !empty($persona['imagenperfil']) ? esc(base_url('uploads/'.$persona['imagenperfil'])) : esc(base_url('images/default-profile.jpg'));
                ?>
                <img src="<?= $imageUrl; ?>" 
                     alt="Foto de <?= esc($persona['nombres']); ?>" 
                     class="img-fluid rounded-circle" 
                     style="max-width: 60px; height: 60px; object-fit: cover;" 
                     title="Foto de <?= esc($persona['nombres']); ?>">
              </td>
              <td>
                <a href="<?= esc($baseUrl . 'personas/editar/' . $persona['idpersona']); ?>" 
                   class="btn btn-warning btn-sm" 
                   aria-label="Editar persona <?= esc($persona['nombres']); ?>">
                  <i class="fas fa-edit"></i> Editar
                </a>
                <button class="btn btn-danger btn-sm" 
                        data-toggle="modal" 
                        data-target="#confirmDeleteModal" 
                        data-id="<?= esc($persona['idpersona']); ?>" 
                        aria-label="Eliminar persona <?= esc($persona['nombres']); ?>">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="11" class="text-center">No hay registros disponibles</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal de Confirmación de Eliminación -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de eliminación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar ventana modal de confirmación">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de eliminar a este estudiante? Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <a id="deleteConfirmBtn" href="#" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $footer; ?>

<script>
  $('#confirmDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var personaId = button.data('id'); // Extrae el ID de la persona
    var url = '<?= esc($baseUrl . 'personas/borrar/'); ?>' + personaId; // Crea la URL de eliminación
    var modal = $(this);
    modal.find('#deleteConfirmBtn').attr('href', url); // Asigna la URL al botón de confirmación
  });
</script>


