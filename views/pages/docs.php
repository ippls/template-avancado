<?php
/**
 * Página de Documentação - Template Padrão IPPLS
 * Design moderno e totalmente responsivo
 */

// Caminho para o README.md
$readmePath = __DIR__ . '/../../README.md';
$readmeExists = file_exists($readmePath);

// Processa o README se existir
if ($readmeExists) {
    $readmeContent = file_get_contents($readmePath);
    $html = convertMarkdownToHtml($readmeContent);
    list($html, $navigation) = generateNavigationAndIds($html);
    $html = sanitizeHtml($html);
    // Substitui emojis por ícones Font Awesome apenas na renderização
    if (!function_exists('replaceEmojisWithFA')) {
        // função definida mais abaixo
    }
    $html = replaceEmojisWithFA($html);
}

/**
 * Converte Markdown para HTML
 */
function convertMarkdownToHtml($text) {
    $text = str_replace(["\r\n", "\r"], "\n", $text);

    // Blocos de código
    $text = preg_replace_callback('/```(\w+)?\n(.*?)\n```/s', function($m) {
        $lang = $m[1] ?? 'plaintext';
        $code = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
        return '<pre><code class="language-' . $lang . '">' . $code . '</code></pre>';
    }, $text);

    // Headings
    for ($i = 6; $i >= 1; $i--) {
        $text = preg_replace('/^' . str_repeat('#', $i) . '\s+(.+)$/m', '<h' . $i . '>$1</h' . $i . '>', $text);
    }

    // Badges
    $text = preg_replace('/!\[([^\]]*)\]\((https:\/\/img\.shields\.io[^\)]+)\)/', '<img src="$2" alt="$1" class="badge-img">', $text);

    // Imagens
    $text = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1" class="content-img">', $text);

    // Links
    $text = preg_replace_callback('/\[([^\]]+)\]\(([^\)]+)\)/', function($m) {
        $text = $m[1];
        $url = trim($m[2]);
        $isExternal = strpos($url, 'http') === 0;
        $target = $isExternal ? ' target="_blank" rel="noopener"' : '';
        return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"' . $target . '>' . $text . '</a>';
    }, $text);

    // Linha horizontal
    $text = preg_replace('/^-{3,}\s*$/m', '<hr class="docs-divider">', $text);

    // Bold e Italic
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $text);

    // Inline code
    $text = preg_replace('/`([^`]+)`/', '<code class="inline-code">$1</code>', $text);

    // Task lists
    $text = preg_replace('/^\s*-\s+\[x\]\s+(.+)$/m', '<li class="task-item checked"><i class="fas fa-check-square"></i> $1</li>', $text);
    $text = preg_replace('/^\s*-\s+\[\s\]\s+(.+)$/m', '<li class="task-item"><i class="far fa-square"></i> $1</li>', $text);

    // Listas
    $text = preg_replace('/^\s*[-\*]\s+(.+)$/m', '<li>$1</li>', $text);
    $text = preg_replace_callback('/((?:<li(?:\s+class="[^"]*")?>.*?<\/li>\s*)+)/s', function($m) {
        if (strpos($m[0], 'task-item') !== false) {
            return '<ul class="task-list">' . $m[0] . '</ul>';
        }
        return '<ul>' . $m[0] . '</ul>';
    }, $text);

    // Tabelas
    $text = preg_replace_callback('/(\|.+\|[\r\n]+)+/s', function($m) {
        $table = trim($m[0]);
        $rows = array_filter(explode("\n", $table));

        if (count($rows) < 2) return $m[0];

        $html = '<div class="table-container"><table class="docs-table">';
        $isHeader = true;

        foreach ($rows as $i => $row) {
            if ($i === 1 && preg_match('/^\|[\s:-]+\|/', $row)) continue;

            $cells = array_map('trim', explode('|', trim($row, '|')));
            $tag = $isHeader ? 'th' : 'td';

            $html .= '<tr>';
            foreach ($cells as $cell) {
                $html .= "<$tag>" . trim($cell) . "</$tag>";
            }
            $html .= '</tr>';

            if ($isHeader) $isHeader = false;
        }

        $html .= '</table></div>';
        return $html;
    }, $text);

    // Blockquotes
    $text = preg_replace('/^>\s+(.+)$/m', '<blockquote class="docs-quote">$1</blockquote>', $text);

    // Parágrafos
    $blocks = preg_split('/\n\s*\n/', trim($text));
    $result = [];
    foreach ($blocks as $block) {
        $block = trim($block);
        if (preg_match('/^<(h[1-6]|ul|ol|pre|blockquote|hr|table|div)/i', $block)) {
            $result[] = $block;
        } else if (!empty($block)) {
            $result[] = '<p>' . $block . '</p>';
        }
    }

    return implode("\n\n", $result);
}

/**
 * Gera navegação e adiciona IDs
 */
function generateNavigationAndIds($html) {
    $navigation = [];

    if (preg_match_all('/<h([1-3])>(.*?)<\/h\1>/i', $html, $matches, PREG_SET_ORDER)) {
        $ids = [];

        foreach ($matches as $m) {
            $level = (int)$m[1];
            $text = strip_tags($m[2]);
            $id = slugify($text);

            $originalId = $id;
            $counter = 1;
            while (in_array($id, $ids)) {
                $id = $originalId . '-' . $counter++;
            }
            $ids[] = $id;

            $navigation[] = [
                'id' => $id,
                'text' => $text,
                'level' => $level
            ];

            $html = preg_replace(
                '/<h' . $level . '>' . preg_quote($m[2], '/') . '<\/h' . $level . '>/i',
                '<h' . $level . ' id="' . $id . '">' . $m[2] . '</h' . $level . '>',
                $html,
                1
            );
        }
    }

    return [$html, $navigation];
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-') ?: 'section';
}

function sanitizeHtml($html) {
    $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/', '', $html);
    $html = preg_replace('/(href|src)\s*=\s*["\']javascript:[^"\']*["\']/', '$1="#"', $html);
    return $html;
}

/**
 * Mapeamento de emojis para classes do Font Awesome
 */
function emojiToFaClassMap(): array {
    return [
        '📚' => 'fa-book-open',
        '📖' => 'fa-book',
        '🚀' => 'fa-rocket',
        '🔍' => 'fa-search',
        '🔎' => 'fa-search',
        '🐛' => 'fa-bug',
        '🏗️' => 'fa-project-diagram',
        '✅' => 'fa-check-circle',
        '⚠️' => 'fa-exclamation-triangle',
        '📁' => 'fa-folder',
        '✨' => 'fa-star',
        '💡' => 'fa-lightbulb',
    ];
}

/**
 * Substitui emojis por elementos <i class="fas fa-..."> apenas em text nodes
 * Ignora nodes dentro de <code>, <pre>, <a>, <img>, <script>, <style>, <textarea>
 */
function replaceEmojisWithFA(string $html): string {
    $map = emojiToFaClassMap();
    if (empty($map) || trim($html) === '') return $html;

    libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'UTF-8');
    // wrapper para trabalhar com fragmento
    $ok = $dom->loadHTML('<?xml encoding="utf-8" ?><div id="__root__">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if (!$ok) return $html;

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//text()[not(ancestor::code) and not(ancestor::pre) and not(ancestor::a) and not(ancestor::img) and not(ancestor::script) and not(ancestor::style) and not(ancestor::textarea)]');

    foreach ($nodes as $textNode) {
        $text = $textNode->nodeValue;
        if ($text === null || $text === '') continue;

        // verificar presença de qualquer emoji do mapa
        $found = false;
        foreach ($map as $emoji => $_) {
            if (mb_strpos($text, $emoji) !== false) { $found = true; break; }
        }
        if (!$found) continue;

        $parent = $textNode->parentNode;

        // reconstruir: dividir por cada emoji encontrado (iterativo)
        $working = $text;
        // iremos processar a cada emoji do mapa substituindo por sequência de nós
        // para evitar múltiplos passes complexos, faremos uma varredura por emoji usando explode
        $fragmentParts = [$working];
        foreach ($map as $emoji => $faClass) {
            $newParts = [];
            foreach ($fragmentParts as $part) {
                if (strpos($part, $emoji) === false) {
                    $newParts[] = $part;
                    continue;
                }
                $pieces = explode($emoji, $part);
                $count = count($pieces);
                for ($i = 0; $i < $count; $i++) {
                    $newParts[] = $pieces[$i];
                    if ($i !== $count - 1) {
                        // marker para emoji
                        $newParts[] = $emoji; // vamos usar o emoji literal como placeholder
                    }
                }
            }
            $fragmentParts = $newParts;
        }

        // inserir nós antes do textNode
        foreach ($fragmentParts as $part) {
            if ($part === '') continue;
            if (array_key_exists($part, $map)) {
                $i = $dom->createElement('i');
                $i->setAttribute('class', 'fas ' . $map[$part]);
                $i->setAttribute('aria-hidden', 'true');
                $parent->insertBefore($i, $textNode);
            } else {
                $parent->insertBefore($dom->createTextNode($part), $textNode);
            }
        }

        // remover o text node original
        $parent->removeChild($textNode);
    }

    // recuperar innerHTML do wrapper
    $root = $dom->getElementById('__root__');
    if (!$root) return $html;

    $inner = '';
    foreach ($root->childNodes as $n) {
        $inner .= $dom->saveHTML($n);
    }

    return $inner;
}
?>

<!-- Container Principal -->
<div class="docs-wrapper">

    <!-- Sidebar -->
    <aside class="docs-sidebar" id="docsSidebar">
        <div class="docs-sidebar-header">
            <h3><i class="fas fa-book-open"></i> Navegação</h3>
            <button class="docs-sidebar-close" id="sidebarClose" aria-label="Fechar menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="docs-sidebar-search">
            <i class="fas fa-search"></i>
            <input type="text" id="docsSearch" placeholder="Pesquisar..." autocomplete="off">
        </div>

        <nav class="docs-sidebar-nav" id="sidebarNav">
            <?php if ($readmeExists && !empty($navigation)): ?>
                <?php foreach ($navigation as $item): ?>
                    <a href="#<?= $item['id'] ?>"
                       class="docs-nav-item docs-nav-level-<?= $item['level'] ?>"
                       data-section="<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>

        <div class="docs-sidebar-footer">
            <a href="https://github.com/ippls/template-padrao" target="_blank" class="docs-github-link">
                <i class="fab fa-github"></i> GitHub
            </a>
        </div>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="docs-content-wrapper">

        <!-- Header -->
        <header class="docs-header">
            <button class="docs-menu-toggle" id="menuToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="docs-header-content">
                <div class="docs-header-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="docs-header-text">
                    <h1 class="docs-header-title">Documentação</h1>
                    <p class="docs-header-subtitle">Template Padrão MVC - IPPLS</p>
                </div>
            </div>

            <div class="docs-header-actions">
                <button class="docs-theme-toggle" id="themeToggle" title="Alternar tema">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </header>

        <!-- Breadcrumb -->
        <nav class="docs-breadcrumb">
            <a href="?page=home"><i class="fas fa-home"></i> Início</a>
            <i class="fas fa-chevron-right"></i>
            <span>Documentação</span>
        </nav>

        <!-- Conteúdo -->
        <article class="docs-content" id="docsContent">
            <?php if ($readmeExists): ?>
                <?= $html ?>
                <footer class="docs-content-footer">
                    <div class="docs-footer-section">
                        <h4><i class="fas fa-question-circle"></i> Encontrou um problema?</h4>
                        <p>Ajude-nos a melhorar esta documentação.</p>
                        <div class="docs-footer-links">
                            <a href="https://github.com/ippls/template-avançado/issues" target="_blank">
                                <i class="fab fa-github"></i> Reportar
                            </a>
                        </div>
                    </div>

                    <div class="docs-footer-section">
                        <h4><i class="fas fa-heart"></i> Precisa de ajuda?</h4>
                        <p>Entre em contato com a equipe IPPLS.</p>
                        <div class="docs-footer-links">
                            <a href="mailto:paigrandengola@gmail.com">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                        </div>
                    </div>
                </footer>
            <?php else: ?>
                <div class="docs-empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h2>Documentação não disponível</h2>
                    <p>Crie um arquivo README.md na raiz do projeto.</p>
                </div>
            <?php endif; ?>
        </article>
    </main>
</div>

<!-- Overlay para mobile -->
<div class="docs-overlay" id="docsOverlay"></div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="<?= asset('js/components/docs.js') ?>"></script>

<script>
// Highlight.js
document.addEventListener('DOMContentLoaded', function() {
    if (window.hljs) {
        document.querySelectorAll('pre code').forEach(block => {
            hljs.highlightElement(block);
        });
    }
});
</script>