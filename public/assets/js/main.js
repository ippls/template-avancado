// assets/js/main.js - Scripts principais

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Template Base MVC carregado com sucesso! DESIGN BRUTAL');
    console.log('🏫 IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos');

    // Adicionar animação suave nas linhas da tabela
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
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