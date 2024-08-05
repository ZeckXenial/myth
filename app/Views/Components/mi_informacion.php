<?php include(APPPATH . 'Views/Components/headers.php') ;
include(APPPATH . 'Views/Components/Navbar.php') ;?>
<body class="container" >
<div class="container mt-5">
        <div class="card">
            <div class="card-header ">
                <h5>Mi Información</h5>
            </div>
            <div class="card-body ">
                
                <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?></p>
                <p><strong>Email:</strong> <?= $usuario['email'] ?></p>
                <p><strong>Especialidad:</strong> <?= $usuario['especialidad'] ?></p>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal">Editar</button>
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('usuario/actualizar_informacion') ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $usuario['nombre'] ?>" required>
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Especialidad" value="<?= $usuario['especialidad'] ?>">
                        <label for="especialidad">Especialidad</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nueva Contraseña">
                        <label for="password">Nueva Contraseña</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include(APPPATH . 'Views/Components/toast.php'); include(APPPATH . 'Views/Components/footer.php'); ?>