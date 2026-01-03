document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Arquivo selecionado:', file.name);
                // Preview de imagem (opcional)
                const elementForImagePreview = document.getElementById('container-preview');
                const imagePreview = document.createElement('img');
                imagePreview.setAttribute('alt', 'Visualizar a imagem do produto.');
                imagePreview.setAttribute('src', file.name);
                imagePreview.className = 'image-preview';
                imagePreview.id = 'imagePreview';
                // Adicionar ao contêiner
                elementForImagePreview.appendChild(imagePreview);
                if (file.type.startsWith('image/')) {
                    // Implementar preview
                    imagePreview.classList.add('show');
                }else{
                    imagePreview.classList.remove('show');
                }
            }
        });
    });
});