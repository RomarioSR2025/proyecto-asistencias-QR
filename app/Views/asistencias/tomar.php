<?= $header; ?>

<div class="container mt-4">
  <h4>Tomar Asistencia - <?= esc($grupo['grado'].' '.$grupo['seccion'].' - '.$grupo['nivel'].' ('.$grupo['alectivo'].')'); ?></h4>
  <p><strong>Fecha:</strong> <?= esc($fecha); ?></p>

  <form action="<?= base_url('asistencias/guardar/'.$grupo['idgrupo']); ?>" method="post">
    <input type="hidden" name="fecha" value="<?= esc($fecha); ?>">

    <table class="table table-bordered table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Alumno</th>
          <th>Estado</th>
          <th>Entrada</th>
          <th>Salida</th>
          <th>Método</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($alumnos) && is_array($alumnos)): ?>
          <?php foreach ($alumnos as $i => $a): ?>
            <tr>
              <td><?= $i+1; ?></td>
              <td><?= esc($a['nombres'].' '.$a['apepaterno'].' '.$a['apematerno']); ?></td>
              <td>
                <select name="estado[<?= $a['idmatricula']; ?>]" class="form-select">
                  <option value="Asistió">Asistió</option>
                  <option value="Falta">Falta</option>
                  <option value="Tardanza">Tardanza</option>
                  <option value="Justificado">Justificado</option>
                </select>
              </td>
              <td>
                <input type="time" name="hentrada[<?= $a['idmatricula']; ?>]" class="form-control">
              </td>
              <td>
                <input type="time" name="hsalida[<?= $a['idmatricula']; ?>]" class="form-control">
              </td>
              <td>
                <select name="metodo[<?= $a['idmatricula']; ?>]" class="form-select">
                  <option value="QR">QR</option>
                  <option value="Manual">Manual</option>
                </select>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">No hay alumnos en este grupo</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-3">
      <button type="submit" class="btn btn-success">💾 Guardar Asistencia</button>
      <a href="<?= base_url('asistencias/listar?fecha='.$fecha.'&idgrupo='.$grupo['idgrupo']); ?>" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>

<?= $footer; ?>
