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
    // Evento al hacer clic en "Editar"
    const editButtons = document.querySelectorAll('.editar-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const anotacionId = this.getAttribute('data-anotacion-id');
            document.getElementById('editable-glosa-' + anotacionId).style.display = 'block';
            document.getElementById('glosaAnotacion' + anotacionId).focus();
            this.style.display = 'none'; // Ocultar el botón de editar
        });
    });

    // Evento al hacer clic en "Guardar"
    const saveButtons = document.querySelectorAll('.guardar-btn');
    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const anotacionId = this.getAttribute('data-anotacion-id');
            const nuevaGlosa = document.getElementById('glosaAnotacion' + anotacionId).value;

            // Validar que el campo no esté vacío
            if (!nuevaGlosa.trim()) {
                alert('El campo no puede estar vacío.');
                return;
            }

            // Enviar la nueva glosa con AJAX
            fetch('https://college.apingenieros.cl/index.php/anotaciones/editar/' + anotacionId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Para evitar que la petición sea bloqueada
                },
                body: JSON.stringify({ glosa_anot: nuevaGlosa })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el texto mostrado
                    alert('Anotación guardada con éxito.');
                    document.getElementById('editable-glosa-' + anotacionId).style.display = 'none';
                    const glosaElement = document.querySelector(`#verAnotacionesModal .alert[data-anotacion-id='${anotacionId}'] span`);
                    glosaElement.textContent = nuevaGlosa;
                } else {
                    alert('Hubo un error al guardar la anotación.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error inesperado.');
            });
        });
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
        console.log('Success:', data.body);
         const bodyMessage = data.body;
        alert(bodyMessage);
        $('#otpModal').modal('hide');
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error verificando OTP.');
    });
  })})
