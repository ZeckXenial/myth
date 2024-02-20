
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