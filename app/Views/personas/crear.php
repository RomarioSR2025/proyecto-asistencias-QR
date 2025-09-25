<?= $header; ?>

<!-- Sección de Contenido Principal -->
<div class="container mt-4">
  <!-- Encabezado con información -->
  <div class="my-3">
    <h4>Registro de Persona</h4>
    <a href="<?= base_url("personas/listar"); ?>" class="btn btn-link">Volver al listado</a>
  </div>

  <!-- Mensajes de Error -->
  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Formulario de Registro -->
  <form method="POST" action="<?= base_url('personas/guardar'); ?>" enctype="multipart/form-data" id="registroPersonaForm" novalidate>
    <?= csrf_field(); ?>

    <!-- Card del formulario -->
    <div class="card">
      <div class="card-body">
        
        <!-- Datos Personales -->
        <fieldset>
          <legend>Datos Personales</legend>

          <div class="mb-3">
            <label for="apepaterno" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" name="apepaterno" id="apepaterno" required placeholder="Ingrese su apellido paterno">
            <div class="invalid-feedback">Por favor ingresa tu apellido paterno.</div>
          </div>

          <div class="mb-3">
            <label for="apematerno" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" name="apematerno" id="apematerno" required placeholder="Ingrese su apellido materno">
            <div class="invalid-feedback">Por favor ingresa tu apellido materno.</div>
          </div>

          <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" name="nombres" id="nombres" required placeholder="Ingrese sus nombres completos">
            <div class="invalid-feedback">Por favor ingresa tus nombres completos.</div>
          </div>
        </fieldset>

        <!-- Documento de Identidad -->
        <fieldset>
          <legend>Documento de Identidad</legend>

          <div class="mb-3">
            <label for="tipodoc" class="form-label">Tipo de Documento</label>
            <select class="form-control" name="tipodoc" id="tipodoc" required>
              <option value="DNI">DNI</option>
              <option value="Pasaporte">Pasaporte</option>
              <option value="Carnet">Carnet</option>
            </select>
            <div class="invalid-feedback">Por favor selecciona un tipo de documento.</div>
          </div>

          <div class="mb-3">
            <label for="numerodoc" class="form-label">Número de Documento</label>
            <input type="text" class="form-control" name="numerodoc" id="numerodoc" required placeholder="Ingrese el número de su documento" pattern="\d{8,10}">
            <div class="invalid-feedback">El número de documento debe contener entre 8 y 10 dígitos.</div>
          </div>
        </fieldset>

        <!-- Información Adicional -->
        <fieldset>
          <legend>Información Adicional</legend>

          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingrese su dirección">
            <div class="invalid-feedback">Por favor ingresa tu dirección.</div>
          </div>

          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Ingrese su teléfono" pattern="^\+?\d{10,15}$">
            <div class="invalid-feedback">Formato de teléfono inválido, ejemplo: +1234567890.</div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese su correo electrónico">
            <div class="invalid-feedback">Por favor ingresa un correo electrónico válido.</div>
          </div>

          <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
          </div>

          <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select class="form-control" name="sexo" id="sexo" required>
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
        </fieldset>

        <!-- Imagen de Perfil -->
        <fieldset>
          <legend>Imagen de Perfil</legend>
          <div class="mb-3">
            <label for="imagenperfil" class="form-label">Subir Imagen</label>
            <input type="file" class="form-control" name="imagenperfil" id="imagenperfil" accept="image/*" onchange="previewImage(event)">
            <img id="imagePreview" src="#" alt="Vista previa de la imagen" class="mt-3" style="max-width: 100px; display: none;">
          </div>
        </fieldset>

      </div>

      <!-- Botones de acción -->
      <div class="card-footer text-end">
        <button type="reset" class="btn btn-outline-secondary btn-sm">Cancelar</button>
        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
      </div>
    </div>
  </form>
</div>

<!-- Script para Vista Previa de la Imagen -->
<script>
  function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function() {
      const output = document.getElementById('imagePreview');
      output.src = reader.result;
      output.style.display = 'block';
    };
    if (file) {
      reader.readAsDataURL(file);
    }
  }

  // Validación en el lado del cliente
  document.getElementById('registroPersonaForm').addEventListener('submit', function(event) {
    let isValid = true;
    const form = event.target;
    
    // Validación de campos obligatorios
    form.querySelectorAll('[required]').forEach(function(field) {
      if (!field.value.trim()) {
        isValid = false;
        field.classList.add('is-invalid');
      } else {
        field.classList.remove('is-invalid');
      }
    });

    // Prevención del envío si hay errores
    if (!isValid) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });
</script>

<?= $footer; ?>


