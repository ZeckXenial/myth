<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body class="container">

    <div class="container mt-5">
        <h1 class="text-center">Estadísticas Generales</h1>

        <div class=" row">
            <!-- Estadísticas de Asistencias -->
            <div class=" col-lg-6 mb-4">
                <div class="shadow-drop-2-center card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5>Asistencias</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartAsistencias"></canvas>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de Matrículas -->
            <div class="col-lg-6 mb-4">
                <div class="shadow-drop-2-center card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5>Matrículas</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartMatriculas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Estadísticas de Anotaciones -->
            <div class="col-lg-6 mb-4">
                <div class="shadow-drop-2-center card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5>Anotaciones</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartAnotaciones"></canvas>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de Calificaciones -->
            <div class="col-lg-6 mb-4">
                <div class="shadow-drop-2-center card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5>Calificaciones</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartCalificaciones"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
        <button id="exportarasistencia"  data-url="<?= site_url('cursos/exportarasistencias') ?>" class="btn  btn-primary">Exportar Asistencias</button>
        
    </div>
        <!-- DataTable -->
        
            <div class=" form-control ">
                <table id="validacionestable" class="table table-hover table-striped table-bordered">
            
                <h3 class="text-center">Registros Recientes</h3>
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($validaciones)): ?>
                    <?php foreach ($validaciones as $validacion): ?>
                        <tr>
                            <td><?= htmlspecialchars($validacion['val_id']) ?></td>
                            <td><?= htmlspecialchars($validacion['usuario_nombre']) ?></td>
                            <td><?= htmlspecialchars($validacion['status']) ?></td>
                            <td><?= htmlspecialchars($validacion['fecha_val']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay registros recientes</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    </div>

    <script src="<?= base_url('public/scripts/datatable-script.js') ?>"></script>
    <script src="<?= base_url('public/scripts/script.js') ?>"></script>

    <script>
        // Configuración de los gráficos de Chart.js con animaciones
        var ctxAsistencias = document.getElementById('chartAsistencias').getContext('2d');
        var chartAsistencias = new Chart(ctxAsistencias, {
            type: 'bar',
            data: {
                labels: <?= json_encode($asistencias['labels']) ?>, // Etiquetas de los cursos
                datasets: [{
                    label: 'Asistencias',
                    data: <?= json_encode($asistencias['data']) ?>, // Cantidad de asistencias
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2000,  // Duración de la animación en milisegundos
                    easing: 'easeOutBounce'  // Efecto de la animación
                }
            }
        });

        var ctxMatriculas = document.getElementById('chartMatriculas').getContext('2d');
        var chartMatriculas = new Chart(ctxMatriculas, {
            type: 'line',
            data: {
                labels: <?= json_encode($matriculas['labels']) ?>, // IDs de cursos o identificadores
                datasets: [{
                    label: 'Matrículas',
                    data: <?= json_encode($matriculas['data']) ?>, // Total de matriculados
                    fill: false,
                    borderColor: 'rgba(40, 167, 69, 1)',
                    tension: 0.1
                }]
            },
            options: {
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuad'
                }
            }
        });

        var ctxAnotaciones = document.getElementById('chartAnotaciones').getContext('2d');
        var chartAnotaciones = new Chart(ctxAnotaciones, {
            type: 'line',
            data: {
                labels: <?= json_encode($anotaciones['labels']) ?>, // Meses
                datasets: [{
                    label: 'Anotaciones',
                    data: <?= json_encode($anotaciones['data']) ?>, // Total de anotaciones por mes
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 1800,
                    easing: 'easeOutElastic'
                }
            }
        });

        var ctxCalificaciones = document.getElementById('chartCalificaciones').getContext('2d');
        var chartCalificaciones = new Chart(ctxCalificaciones, {
            type: 'bar',
            data: {
                labels: <?= json_encode($calificaciones['labels']) ?>, // Cursos
                datasets: [{
                    label: 'Promedio de Calificaciones',
                    data: <?= json_encode($calificaciones['data']) ?>, // Promedio de calificaciones
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2500,
                    easing: 'easeInOutExpo'
                }
            }
        });
    </script>

</body>
<?php include(APPPATH . 'Views/Components/toast.php'); include(APPPATH . 'Views/Components/footer.php'); ?>

</html>
