<?= $header ?>

<div class="container mt-4">
    <h2 class="mb-4">📊 Panel de Control - Sistema de Asistencia</h2>

    <!-- Cards con conteos -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">👥 Personas</h5>
                    <h2><?= $totalPersonas ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">🧑‍💻 Usuarios</h5>
                    <h2><?= $totalUsuarios ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">📅 Calendarizaciones</h5>
                    <h2><?= $totalCalendarizaciones ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">🏫 Grupos</h5>
                    <h2><?= $totalGrupos ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Otra fila -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow text-center bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">📋 Matrículas</h5>
                    <h2><?= $totalMatriculas ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica de matrículas por año escolar -->
    <div class="card shadow mt-4">
        <div class="card-body">
            <h5 class="card-title">📈 Matrículas por Año Escolar</h5>
            <canvas id="graficoMatriculas"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoMatriculas').getContext('2d');
    const grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($matriculasPorAnio, 'anio_escolar')) ?>,
            datasets: [{
                label: 'Total de Matrículas',
                data: <?= json_encode(array_column($matriculasPorAnio, 'total')) ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<?= $footer ?>
