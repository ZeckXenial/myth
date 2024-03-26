<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<body>
    <div class="container">
        <h1 class="text-center">Crear Nueva Asignatura</h1>

        <div class="row justify-content-center">
           
                <div class="form-control">
                 
                        <?= form_open('asignaturas/crear') ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre_asignatura" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-control" id="usuarios" name="user_id" required>
                                <option value="" disabled selected>Selecciona un profesor</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['user_id'] ?>"><?= $usuario['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="usuarios">Usuarios</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-control" id="cursos" name="curso_id" required>
                                <option value="" disabled selected>Selecciona un curso</option>
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?= $curso['curso_id'] ?>"><?= $curso['grado'] ?> - <?= $curso['nombre_nivel'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="cursos">Cursos</label>
                        </div>

                        <input type="submit" class="btn mx-auto btn-primary"></input>
                        <?= form_close() ?>
                
                </div>
         
        </div>
    </div>
    <?php include(APPPATH . 'Views/Components/toast.php'); ?>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
