/**
 * DOCS.JS - Sistema de Documentação Responsivo
 * Template Padrão IPPLS
 */

(function() {
    'use strict';

    // Elementos
    const elements = {
        sidebar: document.getElementById('docsSidebar'),
        sidebarClose: document.getElementById('sidebarClose'),
        menuToggle: document.getElementById('menuToggle'),
        sidebarNav: document.getElementById('sidebarNav'),
        docsSearch: document.getElementById('docsSearch'),
        themeToggle: document.getElementById('themeToggle'),
        docsContent: document.getElementById('docsContent'),
        overlay: document.getElementById('docsOverlay'),
    };

    // Estado
    const state = {
        currentTheme: localStorage.getItem('docs-theme') || 'light',
        sidebarOpen: false,
        searchIndex: [],
    };

    // ========================================
    // INICIALIZAÇÃO
    // ========================================
    function init() {
        applyTheme();
        buildSearchIndex();
        setupEventListeners();
        setupScrollSpy();
        setupSmoothScroll();
        highlightActiveNav();
        setupCodeCopy();
    }

    // ========================================
    // TEMA
    // ========================================
    function applyTheme() {
        if (state.currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            if (elements.themeToggle) {
                elements.themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
        } else {
            document.body.classList.remove('dark-theme');
            if (elements.themeToggle) {
                elements.themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
    }

    function toggleTheme() {
        state.currentTheme = state.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('docs-theme', state.currentTheme);
        applyTheme();
    }

    // ========================================
    // SIDEBAR MOBILE
    // ========================================
    function openSidebar() {
        if (elements.sidebar && elements.overlay) {
            elements.sidebar.classList.add('active');
            elements.overlay.classList.add('active');
            state.sidebarOpen = true;
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSidebar() {
        if (elements.sidebar && elements.overlay) {
            elements.sidebar.classList.remove('active');
            elements.overlay.classList.remove('active');
            state.sidebarOpen = false;
            document.body.style.overflow = '';
        }
    }

    // ========================================
    // SCROLL SPY
    // ========================================
    function setupScrollSpy() {
        if (!elements.docsContent) return;

        const headings = elements.docsContent.querySelectorAll('h1[id], h2[id], h3[id]');
        const navItems = elements.sidebarNav?.querySelectorAll('.docs-nav-item');

        if (headings.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;

                    navItems?.forEach(item => {
                        const href = item.getAttribute('href');
                        if (href === `#${id}`) {
                            navItems.forEach(n => n.classList.remove('active'));
                            item.classList.add('active');

                            // Scroll item into view in sidebar
                            item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                        }
                    });
                }
            });
        }, {
            rootMargin: '-80px 0px -66%',
            threshold: 0
        });

        headings.forEach(heading => observer.observe(heading));
    }

    // ========================================
    // SMOOTH SCROLL
    // ========================================
    function setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#') {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    closeSidebar();
                    return;
                }

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    closeSidebar();

                    if (history.pushState) {
                        history.pushState(null, null, href);
                    }
                }
            });
        });
    }

    // ========================================
    // NAVEGAÇÃO ATIVA
    // ========================================
    function highlightActiveNav() {
        if (!elements.sidebarNav) return;

        const hash = window.location.hash;

        if (hash) {
            const navItems = elements.sidebarNav.querySelectorAll('.docs-nav-item');
            navItems.forEach(item => {
                if (item.getAttribute('href') === hash) {
                    item.classList.add('active');
                    item.scrollIntoView({ block: 'nearest' });
                }
            });
        }
    }

    // ========================================
    // SISTEMA DE PESQUISA
    // ========================================
    function buildSearchIndex() {
        if (!elements.docsContent) return;

        const headings = elements.docsContent.querySelectorAll('h1, h2, h3');
        const paragraphs = elements.docsContent.querySelectorAll('p');

        headings.forEach(heading => {
            if (heading.id) {
                state.searchIndex.push({
                    type: 'heading',
                    title: heading.textContent,
                    content: heading.textContent,
                    id: heading.id
                });
            }
        });

        paragraphs.forEach((p, index) => {
            const prevHeading = getPreviousHeading(p);
            if (prevHeading) {
                state.searchIndex.push({
                    type: 'content',
                    title: prevHeading.textContent,
                    content: p.textContent,
                    id: prevHeading.id || `content-${index}`
                });
            }
        });
    }

    function getPreviousHeading(element) {
        let prev = element.previousElementSibling;

        while (prev) {
            if (prev.tagName && /^H[1-3]$/.test(prev.tagName)) {
                return prev;
            }
            prev = prev.previousElementSibling;
        }

        return null;
    }

    // ========================================
    // EVENT LISTENERS
    // ========================================
    function setupEventListeners() {
        // Tema
        if (elements.themeToggle) {
            elements.themeToggle.addEventListener('click', toggleTheme);
        }

        // Sidebar mobile
        if (elements.menuToggle) {
            elements.menuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                openSidebar();
            });
        }

        if (elements.sidebarClose) {
            elements.sidebarClose.addEventListener('click', (e) => {
                e.stopPropagation();
                closeSidebar();
            });
        }

        // Overlay
        if (elements.overlay) {
            elements.overlay.addEventListener('click', closeSidebar);
        }

        // Impedir propagação de cliques dentro da sidebar
        if (elements.sidebar) {
            elements.sidebar.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }

        // Pesquisa na sidebar
        if (elements.docsSearch) {
            let searchTimeout;
            elements.docsSearch.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();

                searchTimeout = setTimeout(() => {
                    const navItems = elements.sidebarNav?.querySelectorAll('.docs-nav-item');

                    if (query.length >= 2) {
                        navItems?.forEach(item => {
                            const text = item.textContent.toLowerCase();
                            const isMatch = text.includes(query.toLowerCase());
                            item.style.display = isMatch ? 'block' : 'none';

                            // Highlight match
                            if (isMatch) {
                                item.style.backgroundColor = 'var(--docs-sidebar-active)';
                            } else {
                                item.style.backgroundColor = '';
                            }
                        });
                    } else {
                        navItems?.forEach(item => {
                            item.style.display = 'block';
                            item.style.backgroundColor = '';
                        });
                    }
                }, 300);
            });
        }

        // Hash change
        window.addEventListener('hashchange', highlightActiveNav);

        // Resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (window.innerWidth > 768 && state.sidebarOpen) {
                    closeSidebar();
                }
            }, 150);
        });

        // Fechar sidebar com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && state.sidebarOpen) {
                closeSidebar();
            }
        });
    }

    // ========================================
    // CÓDIGO - BOTÃO COPIAR
    // ========================================
    function setupCodeCopy() {
        const codeBlocks = document.querySelectorAll('pre code');

        codeBlocks.forEach(block => {
            const pre = block.parentElement;

            // Verifica se já tem botão
            if (pre.querySelector('.code-copy-btn')) return;

            const button = document.createElement('button');
            button.className = 'code-copy-btn';
            button.innerHTML = '<i class="fas fa-copy"></i>';
            button.title = 'Copiar código';
            button.setAttribute('aria-label', 'Copiar código');

            button.addEventListener('click', async () => {
                const code = block.textContent;

                try {
                    await navigator.clipboard.writeText(code);
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.style.color = '#10b981';

                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy"></i>';
                        button.style.color = '';
                    }, 2000);
                } catch (err) {
                    console.error('Erro ao copiar:', err);

                    // Fallback
                    const textarea = document.createElement('textarea');
                    textarea.value = code;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);

                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.style.color = '#10b981';
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy"></i>';
                        button.style.color = '';
                    }, 2000);
                }
            });

            pre.style.position = 'relative';
            pre.appendChild(button);
        });
    }

    // ========================================
    // INICIAR
    // ========================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();

// ========================================
// ESTILOS DO BOTÃO COPIAR
// ========================================
const style = document.createElement('style');
style.textContent = `
    .code-copy-btn {
        position: absolute;
        top: 0.875rem;
        right: 0.875rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.375rem;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        backdrop-filter: blur(4px);
        z-index: 10;
    }

    .code-copy-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: scale(1.05);
    }

    .code-copy-btn:active {
        transform: scale(0.95);
    }

    @media (max-width: 768px) {
        .code-copy-btn {
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
        }
    }
`;
document.head.appendChild(style);