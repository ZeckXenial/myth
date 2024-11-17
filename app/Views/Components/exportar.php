<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<body>
    

<div class="container">
    <h2 class="text-center" style="margin-top: 20px;">Exportar Informacion</h2>
    <div class="text-center">
        <button id="exportarTodoCurso" value="<?= $estudiantes[0]['curso_id'] ?>" class="btn btn-primary">Exportar Todo el Curso</button>
        
    </div>
    <div class="accordion" id="accordionExample">
    <?php foreach ($estudiantes as $estudiante): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $estudiante['estudiante_id'] ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $estudiante['estudiante_id'] ?>" aria-expanded="true" aria-controls="collapse<?= $estudiante['estudiante_id'] ?>">
                    <?= $estudiante['nombre_estudiante'] ?>
                </button>
            </h2>
            <div id="collapse<?= $estudiante['estudiante_id'] ?>" class="accordion-collapse mx-auto collapse" aria-labelledby="heading<?= $estudiante['estudiante_id'] ?>" data-bs-parent="#accordion">
                <div class="accordion-body">
                <div class="d-flex justify-content-center align-items-center">
                 <div class="spinner-border text-primary" role="status">
                     </div>
                     <div id="dataTableWrapper" class="datatable mx-auto"  style="display: inline-block;" >
                         <table id="asistenciasContainer<?= $estudiante['estudiante_id'] ?>"  class="visually-hidden " ></table>
                         <table id="calificacionesContainer<?= $estudiante['estudiante_id'] ?>"  class="visually-hidden table-bordered" ></table>
                         <table id="anotacionesContainer<?= $estudiante['estudiante_id'] ?>" class="visually-hidden" ></table>
                </div>
          </div> 
                    
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script class="mx-auto"><?php include(APPPATH . 'Views/Components/exportscript.js'); ?></script>


</body>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
