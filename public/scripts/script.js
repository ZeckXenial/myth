document.addEventListener('DOMContentLoaded', function() {
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
            event.preventDefault(); 

            const maxAttempts = 5;
            const lockoutTime = 300000; 
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

            checkLoginAttempts();

            const attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
            localStorage.setItem('loginAttempts', attempts + 1);
            localStorage.setItem('lastAttemptTime', Date.now());

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

    document.addEventListener('DOMContentLoaded', function() {let timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                alert("Tu sesión ha expirado por inactividad. Por favor, vuelve a iniciar sesión.");
                window.location.href = '/auth/logout'; // Redirigir al logout
            }, 300000); // 5 minutos (300000 milisegundos)
        }
    
        // Inicia el temporizador al cargar la página
        window.onload = resetTimer;
    
        // Reiniciar el temporizador con cualquier interacción del usuario
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;}
    );

document.addEventListener('DOMContentLoaded', function(){document.getElementById('rut').addEventListener('input', function(event) {
    let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier car芍cter que no sea n迆mero
    if (value.length > 8) {
      value = value.slice(0, 8) + '-' + value.slice(8);
    }
    event.target.value = value;
  });})
  document.getElementById('otpForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const rut = document.getElementById('rut').value;
    const otp = document.getElementById('otp').value;
   const now = new Date();
    
    // Convertir la fecha a una cadena en formato ISO con la zona horaria local
   const timestamp = now.getFullYear() + '-' +
   
                      String(now.getMonth() + 1).padStart(2, '0') + '-' +
                      String(now.getDate()).padStart(2, '0') + 'T' +
                      String(now.getHours()).padStart(2, '0') + ':' +
                      String(now.getMinutes()).padStart(2, '0') + ':' +
                      String(now.getSeconds()).padStart(2, '0') +
                      (now.getTimezoneOffset() > 0 ? '-' : '+') +
                      String(Math.abs(now.getTimezoneOffset() / 60)).padStart(2, '0') + ':00';

    const url = `https://college.apingenieros.cl/index.php/api/verify-otp?rut=${rut}&otp=${otp}&DateWithTimeZone=${timestamp}`;
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
         const bodyMessage = data.message;
        alert(bodyMessage);
        $('#otpModal').modal('hide');
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error verificando OTP.');
    });
  })})
