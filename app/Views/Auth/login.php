<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include(APPPATH . 'Views/Components/headers.php');?>
    <script src="<?= base_url('public/scripts/script.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('public/css/style.scss') ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="login shadow-drop-2-center" id="loginForm">
                    <div class="text-center mb-4">
                        <h2 class="text-center">Ingreso</h2>
                    </div>
                    <?php echo form_open('auth', ['class' => 'form-floating']); ?>
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="username" placeholder="tucorreo@dominio.com" required>
                            <label for="username">Usuario</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="password" placeholder="******" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="g-recaptcha mb-3" data-sitekey="YOUR_SITE_KEY"></div>
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert"><?php echo esc($error_message); ?></div>
                        <?php endif; ?>
                        <button type="submit" id="loginButton" class="btn btn-primary w-100">Login</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        &copy; <?php echo date('Y'); ?> My School App
    </footer>

</body>
</html>
