// assets/js/main.js - Scripts principais

document.addEventListener('DOMContentLoaded', function() {
  console.log('✅ Mensagens flash carregado com sucesso!');

    // Auto-hide mensagens após 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Validação de formulário em tempo real
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#C1272D';
            } else {
                this.style.borderColor = '#4A8FC4';
            }
        });
    }
});