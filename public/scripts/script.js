
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
document.getElementById('otpForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const rut = document.getElementById('rut').value;
    const otp = document.getElementById('otp').value;
    const timestamp = new Date().toISOString();

    const data = JSON.stringify([
        { RUT: rut, OTP: otp, TIMESTAMP: timestamp }
    ]);

    fetch('https://apiede.mineduc.cl/otp/verify-otp', {
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