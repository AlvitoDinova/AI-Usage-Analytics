<?php
/**
 * AInsight - Decision Support System
 * Front Controller & Routing
 */

// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simple PSR-4 like autoloader for PHP Native MVC
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../';
    
    // Class-to-path mappings
    $folders = [
        'app/controllers/',
        'app/models/',
        'config/'
    ];
    
    foreach ($folders as $folder) {
        $file = $baseDir . $folder . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load routing configurations
// [DEV MODE] Default route changed to 'dashboard' — bypass landing page during development
// [RESTORE] Change 'dashboard' back to 'landing' to re-enable the landing page as the entry point
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Routing handler map
switch ($page) {
    case 'landing':
        $controller = new DashboardController();
        $controller->landing();
        break;
        
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;
        
    case 'profile':
        $controller = new ProfileController();
        $controller->index();
        break;
        
    case 'ai-tools':
        $controller = new AIController();
        $controller->index();
        break;
        
    case 'criteria':
        $controller = new CriteriaController();
        $controller->index();
        break;
        
    case 'matrix':
        $controller = new AssessmentController();
        $controller->matrix();
        break;
        
    case 'assess':
        $controller = new AssessmentController();
        $controller->assess();
        break;
        
    case 'result':
        $controller = new AssessmentController();
        $controller->result();
        break;
        
    case 'history':
        $controller = new AssessmentController();
        $controller->history();
        break;
        
    default:
        // Render 404 page
        http_response_code(404);
        echo "404 Not Found";
        break;
}
