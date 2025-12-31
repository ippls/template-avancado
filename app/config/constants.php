<?php
/**
 * Constantes Globais - Template Avançado
 */

// ============================================
// CAMINHOS BASE
// ============================================
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('VIEWS_PATH', BASE_PATH . '/views');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('CONFIG_PATH', APP_PATH . '/config');
define('CONTROLLERS_PATH', APP_PATH . '/Http/Controllers');
define('MIDDLEWARE_PATH', APP_PATH . '/Http/Middleware');
define('MODELS_PATH', APP_PATH . '/Models');
define('ROUTES_PATH', BASE_PATH . '/routes');
define('VENDOR_PATH', BASE_PATH . '/vendor');

// ============================================
// CAMINHOS DE VIEWS
// ============================================
define('LAYOUTS_PATH', VIEWS_PATH . '/layouts');
define('PAGES_PATH', VIEWS_PATH . '/pages');
define('COMPONENTS_PATH', VIEWS_PATH . '/components');
define('ERRORS_PATH', VIEWS_PATH . '/errors');

// ============================================
// CAMINHOS DE ASSETS
// ============================================
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// ============================================
// CAMINHOS DE STORAGE
// ============================================
define('LOGS_PATH', STORAGE_PATH . '/logs');
define('CACHE_PATH', STORAGE_PATH . '/cache');
define('SESSIONS_PATH', STORAGE_PATH . '/sessions');

// ============================================
// AMBIENTE
// ============================================
define('IS_DEVELOPMENT', APP_ENV === 'development');
define('IS_PRODUCTION', APP_ENV === 'production');

// ============================================
// PAGINAÇÃO
// ============================================
define('ITEMS_PER_PAGE', 10);

// ============================================
// UPLOAD
// ============================================
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_DOCUMENT_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);