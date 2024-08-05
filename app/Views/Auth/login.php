<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="<?= base_url('public/scripts/script.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('public/css/style.scss') ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!--     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 --></head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="">
                <div class="text-center mb-4">
                    <h2>Login</h2>
                </div>
                <div class="login" id="loginForm">
                    <?php echo form_open('auth', ['class' => 'form-floating']); ?>
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="tucorreo@dominio.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="******" required>
                        </div>
                        <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
                        <?php if (isset($error_message)): ?>
                            <div class="error-message"><?php echo esc($error_message); ?></div>
                        <?php endif; ?>
                        <button type="submit" id="loginButton" class="btn btn-primary">Login</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        &copy; <?php echo date('Y'); ?> My School App
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
