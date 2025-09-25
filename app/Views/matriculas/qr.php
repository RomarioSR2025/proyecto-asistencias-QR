<?= $header; ?>

<div class="container mt-4 text-center">
  <h4>Matrícula Registrada ✅</h4>

  <p><strong>Se generó el código QR con los datos del estudiante:</strong></p>

  <img 
    src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= urlencode($matricula['codigo_qr']); ?>" 
    alt="Código QR" 
    style="width:300px; height:300px;"
  >

  <div class="mt-3">
    <pre class="text-start border p-3 bg-light"><?= esc($matricula['codigo_qr']); ?></pre>
  </div>

  <div class="mt-4">
    <a href="<?= base_url('matriculas/listar'); ?>" class="btn btn-primary">📋 Ver Matrículas</a>
    <a href="<?= base_url('matriculas/crear'); ?>" class="btn btn-success">➕ Nueva Matrícula</a>
  </div>
</div>

<?= $footer; ?>
