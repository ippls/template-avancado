/**
 * Navbar - Controlador de Menu Mobile
 * Gerencia o toggle do menu hamburger e interações
 */

document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    // Garantir que os elementos existem
    if (!navbarToggle || !navbarMenu) {
        console.warn('⚠️ Navbar elements not found');
        return;
    }

    // Event: Clicar no botão hamburger
    navbarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const isActive = navbarMenu.classList.toggle('active');
        navbarToggle.classList.toggle('active', isActive);

        // Accessibility
        navbarToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
    });

    // Event: Fechar menu ao clicar em um link
    const navLinks = navbarMenu.querySelectorAll('.navbar-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navbarMenu.classList.remove('active');
            navbarToggle.classList.remove('active');
        });
    });

    // Event: Fechar menu ao clicar fora (mobile)
    // Prevent closing when clicking inside the navbar/menu
    if (navbarMenu) {
        navbarMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    document.addEventListener('click', function(e) {
        // Only act when menu is open
        if (navbarMenu.classList.contains('active') && !e.target.closest('.navbar')) {
            navbarMenu.classList.remove('active');
            navbarToggle.classList.remove('active');
            navbarToggle.setAttribute('aria-expanded', 'false');
        }
    });
});