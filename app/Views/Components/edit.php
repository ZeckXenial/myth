
<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<h1>Editar Curso</h1>

<form action="<?= site_url('cursos/update/' . $curso['curso_id']) ?>" method="post">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $curso['grado'] ?>" required>
    </div>
   
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
