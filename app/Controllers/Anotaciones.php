public function editar($anotacion_id)
{
    $session = session();
    $user_id = $session->get('user_id'); // Obtener el ID del usuario desde la sesión

    // Obtener el rol del usuario desde la base de datos
    $usuarioModel = new UsuarioModel(); // Asegúrate de tener un modelo para usuarios
    $usuario = $usuarioModel->find($user_id);
    $idrol = $usuario['id_rol']; // Obtener el rol del usuario

    // Verificar si el usuario tiene permiso para editar
    if (!in_array($idrol, [2, 3])) { // Si no es usuario con idrol 2 o 3
        return redirect()->to('unauthorized'); // Redirigir si no tiene permisos
    }

    $anotacionesModel = new AnotacionesModel();
    $data = $this->request->getPost(); // Obtener los datos del formulario

    $anotacionesModel->editarAnotacion($anotacion_id, $data);
    return redirect()->to('anotaciones'); // Redirigir después de editar
}
