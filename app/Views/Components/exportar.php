<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-primary">Exportar Información</h2>

        <!-- Botón de exportación -->
        <div class="text-center mb-3">
            <button value="<?= isset($estudiantes[0]['curso_id']) ? $estudiantes[0]['curso_id'] : 0 ?>" 
                id="exportarTodoCurso"
                class="btn btn-success btn-lg shadow">
                <i class="fas fa-file-export"></i> Exportar Todo el Curso
            </button>
        </div>

        <!-- Acordeón para mostrar información de estudiantes -->
        <div class="accordion shadow-sm" id="accordionExample">
            <?php foreach ($estudiantes as $estudiante): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $estudiante['estudiante_id'] ?>">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?= $estudiante['estudiante_id'] ?>" 
                            aria-expanded="false"
                            aria-controls="collapse<?= $estudiante['estudiante_id'] ?>">
                            <i class="fas fa-user-graduate me-2 text-primary"></i> 
                            <?= esc($estudiante['nombre_estudiante']) ?>
                        </button>
                    </h2>
                    
                    <div id="collapse<?= $estudiante['estudiante_id'] ?>" 
                        class="accordion-collapse collapse"
                        aria-labelledby="heading<?= $estudiante['estudiante_id'] ?>" 
                        data-bs-parent="#accordionExample">
                        
                        <div class="accordion-body bg-white p-4">
                            <div class="d-flex flex-column align-items-center">
                                
                                <!-- Spinner de carga -->
                                <div class="spinner-border text-primary mb-3" role="status"></div>

                                <!-- Tablas de datos -->
                                <div id="dataTableWrapper" class="datatable mx-auto w-100">
                                    <table id="asistenciasContainer<?= $estudiante['estudiante_id'] ?>"  
                                        class="table table-sm table-striped table-hover visually-hidden">
                                    </table>
                                    
                                    <table id="calificacionesContainer<?= $estudiante['estudiante_id'] ?>"  
                                        class="table table-bordered visually-hidden">
                                    </table>
                                    
                                    <table id="anotacionesContainer<?= $estudiante['estudiante_id'] ?>"  
                                        class="table visually-hidden">
                                    </table>
                                </div>

                            </div> 
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script><?php include(APPPATH . 'Views/Components/exportscript.js'); ?></script>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
