
document.addEventListener("DOMContentLoaded", function(){
    window.addEventListener('scroll', function() {
       
        if (window.scrollY > 150) {
            document.getElementById('navbar').classList.add('fixed-top');
            navbar_height = document.querySelector('.navbar').offsetHeight;
    document.body.style.paddingTop = navbar_height + 'px';
            
        } else {
             document.getElementById('navbar').classList.remove('fixed-top');
            document.body.style.paddingTop = '0';
        } 
    });
}); 
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