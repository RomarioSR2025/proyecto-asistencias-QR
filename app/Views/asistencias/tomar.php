<?= $header; ?>

<div class="container mt-4">
    <h4>📝 Tomar Asistencia - <?= esc($grupo['nivel'] . ' ' . $grupo['grado'] . '-' . $grupo['seccion']); ?></h4>
    <p>📅 Fecha: <?= esc($fecha); ?></p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session('success'); ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session('error'); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('asistencias/guardar'); ?>" method="post">
        <input type="hidden" name="fecha" value="<?= esc($fecha); ?>">
        <input type="hidden" name="idgrupo" value="<?= esc($grupo['idgrupo']); ?>">

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Alumno</th>
                        <th>Asistencia</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                            <td><?= esc($alumno['nombres'] . ' ' . $alumno['apepaterno'] . ' ' . $alumno['apematerno']); ?></td>
                            <td>
                                <select name="estado[<?= $alumno['idmatricula']; ?>]" class="form-select">
                                    <option value="Asistió">Asistió</option>
                                    <option value="Tardanza">Tardanza</option>
                                    <option value="Falta">Falta</option>
                                </select>
                            </td>
                            <td>
                                <input type="time" name="hentrada[<?= $alumno['idmatricula']; ?>]" class="form-control">
                            </td>
                            <td>
                                <input type="time" name="hsalida[<?= $alumno['idmatricula']; ?>]" class="form-control">
                            </td>
                            <input type="hidden" name="mintardanza[<?= $alumno['idmatricula']; ?>]" value="0" class="mintardanza">
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-success mt-3">💾 Guardar Asistencia</button>
    </form>

    <hr class="my-5">

    <div>
        <h5>📷 Registro con Código QR</h5>
        <p>Escanea el código QR del alumno para registrar su asistencia.</p>

        <div id="reader" style="width:300px;"></div>

        <button class="btn btn-outline-secondary mt-3" onclick="restartScanner()">🔄 Reiniciar escáner</button>

        <p id="resultado" class="mt-3 fw-bold"></p>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
let scanner;

function onScanSuccess(qrCodeMessage) {
    const idgrupo = "<?= $grupo['idgrupo']; ?>";
    const url = "<?= base_url('asistencias/registrarPorQR/'); ?>" + encodeURIComponent(qrCodeMessage) + "?idgrupo=" + idgrupo;

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('QR inválido o fuera del grupo.');
            return response.text();
        })
        .then(data => {
            document.getElementById("resultado").innerText = data;
            document.getElementById("resultado").className = "mt-3 fw-bold text-success";
        })
        .catch(err => {
            document.getElementById("resultado").innerText = "❌ " + err.message;
            document.getElementById("resultado").className = "mt-3 fw-bold text-danger";
        });
}

function restartScanner() {
    if (scanner) {
        scanner.clear().then(() => {
            scanner.render(onScanSuccess);
        }).catch(err => {
            console.error("Error reiniciando el escáner:", err);
        });
    }
}

scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250,
    rememberLastUsedCamera: true,
    showTorchButtonIfSupported: true
});
scanner.render(onScanSuccess);

// ===== CÁLCULO AUTOMÁTICO DE TARDANZA =====
document.querySelectorAll('input[name^="hentrada"]').forEach(input => {
    input.addEventListener('change', function() {
        const horaEntrada = this.value;
        const idmatricula = this.name.match(/\d+/)[0]; // extraer idmatricula
        const horaLimite = '08:00';

        if (!horaEntrada) {
            setTardanza(idmatricula, 0);
            return;
        }

        const entradaDate = new Date(`1970-01-01T${horaEntrada}:00`);
        const limiteDate = new Date(`1970-01-01T${horaLimite}:00`);

        let tardanza = 0;
        if (entradaDate > limiteDate) {
            tardanza = Math.round((entradaDate - limiteDate) / 60000); // diferencia en minutos
        }

        setTardanza(idmatricula, tardanza);
        actualizarEstado(idmatricula, tardanza);
    });
});

function setTardanza(idmatricula, tardanza) {
    const inputTardanza = document.querySelector(`input[name="mintardanza[${idmatricula}]"]`);
    if (inputTardanza) {
        inputTardanza.value = tardanza;
    }
}

function actualizarEstado(idmatricula, tardanza) {
    const selectEstado = document.querySelector(`select[name="estado[${idmatricula}]"]`);
    if (selectEstado) {
        if (tardanza > 0 && selectEstado.value === 'Asistió') {
            selectEstado.value = 'Tardanza';
        } else if (tardanza === 0 && selectEstado.value === 'Tardanza') {
            selectEstado.value = 'Asistió';
        }
    }
}
</script>

<?= $footer; ?>

