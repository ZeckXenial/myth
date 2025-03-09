<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<h1 class="text-center my-4">Agregar Curso</h1>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= site_url('cursos/guardar') ?>" method="post">
                
                <!-- Grado Input -->
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="grado" name="grado" placeholder="Ingrese el grado" required>
                    <label for="grado" class="form-label">Grado <i class="bi bi-pencil-fill"></i></label>
                </div>
                
                <!-- Nivel Select -->
                <div class="mb-3 form-floating">
                    <select class="form-select" name="nivel_id" id="nivel_id" required>
                        <?php foreach ($niveles as $nivel): ?>
                            <option value="<?= $nivel['nivel_id'] ?>"><?= $nivel['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nivel_id" class="form-label">Nivel <i class="bi bi-archive"></i></label>
                </div>

                <!-- Profesor Designado Select -->
                <div class="mb-3 form-floating">
                    <select class="form-select" name="user_id" id="user_id" required>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['user_id'] ?>"><?= $usuario['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="user_id" class="form-label">Profesor Designado <i class="bi bi-person-check-fill"></i></label>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle-fill"></i> Agregar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
