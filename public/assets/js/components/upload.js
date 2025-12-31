document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Arquivo selecionado:', file.name);
                // Preview de imagem (opcional)
                if (file.type.startsWith('image/')) {
                    // Implementar preview
                }
            }
        });
    });
});