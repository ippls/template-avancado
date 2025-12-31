/**
 * Back to Top Button
 * Botão para voltar ao topo da página com scroll suave
 */

document.addEventListener('DOMContentLoaded', function() {
    // Criar o botão dinamicamente
    const backToTopBtn = document.createElement('button');
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.id = 'backToTop';
    backToTopBtn.setAttribute('aria-label', 'Voltar ao topo');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';

    // Adicionar ao body
    document.body.appendChild(backToTopBtn);

    // Mostrar/Ocultar botão baseado no scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    // Scroll suave ao clicar
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    console.log('✅ Back to Top button inicializado');
});