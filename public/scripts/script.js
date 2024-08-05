document.addEventListener('DOMContentLoaded', function() {
    // Revelar Contraseña
    document.querySelectorAll('.reveal-password').forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.parentNode.querySelector('input[type="password"]');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    });

   document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe

            // Resto de la lógica para manejar el envío del formulario y conteo de intentos
            const maxAttempts = 5;
            const lockoutTime = 300000; // 5 minutos en milisegundos
            const loginButton = document.getElementById('loginButton');

            function checkLoginAttempts() {
                const attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
                const lastAttemptTime = parseInt(localStorage.getItem('lastAttemptTime')) || 0;
                const currentTime = Date.now();

                if (attempts >= maxAttempts && (currentTime - lastAttemptTime) < lockoutTime) {
                    loginButton.disabled = true;
                    loginButton.classList.add('disabled');
                    loginButton.innerText = 'Demasiados intentos. Intente más tarde.';
                    return true;
                } else if (attempts >= maxAttempts && (currentTime - lastAttemptTime) >= lockoutTime) {
                    localStorage.setItem('loginAttempts', 0);
                    localStorage.removeItem('lastAttemptTime');
                    loginButton.disabled = false;
                    loginButton.classList.remove('disabled');
                    loginButton.innerText = 'Login';
                }
                return false;
            }

            // Llamar a la función para verificar al cargar la página
            checkLoginAttempts();

            // Incrementar el contador de intentos y guardar la hora del último intento
            const attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
            localStorage.setItem('loginAttempts', attempts + 1);
            localStorage.setItem('lastAttemptTime', Date.now());

            // Manejar el bloqueo del botón de login si se supera el límite de intentos
            if (attempts + 1 >= maxAttempts) {
                loginButton.disabled = true;
                loginButton.classList.add('disabled');
                loginButton.innerText = 'Demasiados intentos. Intente más tarde.';
            }
        });
    } else {
        console.error('Elemento con ID "loginForm" no encontrado.');
    }
});


    // Menú de Usuario
    $(document).ready(function() {
        $('.menu-user .nav-link').on('click', function(e) {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).next('.dropdown-menu').toggleClass('show');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.menu-user').length) {
                $('.menu-user').removeClass('show');
                $('.menu-user .dropdown-menu').removeClass('show');
            }
        });
    });

    // Verificación de OTP
document.getElementById('otpForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const rut = document.getElementById('rut').value;
    const otp = document.getElementById('otp').value;
    const timestamp = new Date().toISOString();
     console.log(rut);
    console.log(otp);
    console.log(timestamp);
    const data = JSON.stringify([
        { RUT: rut, OTP: otp, TIMESTAMP: timestamp }
    ]);
    console.log(data);
    fetch('https://college.apingenieros.cl/index.php/api/verify-otp', {  // Cambia la URL a tu endpoint
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        alert('OTP verificado correctamente.');
        $('#otpModal').modal('hide');
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error verificando OTP.');
    });
});
});
