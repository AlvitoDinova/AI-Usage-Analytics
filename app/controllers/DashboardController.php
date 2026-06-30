<?php
/**
 * DashboardController
 */
class DashboardController {
    
    /**
     * Renders public landing page
     */
    public function landing() {
        require_once __DIR__ . '/../views/landing.php';
    }

    /**
     * Renders main application dashboard
     *
     * [DEV MODE] Auth guard is temporarily disabled for development.
     * [RESTORE] To re-enable authentication, uncomment the block below:
     *
     * if (!isset($_SESSION['user_id'])) {
     *     header('Location: index.php?page=login');
     *     exit;
     * }
     * if ($_SESSION['role_id'] == 1) {
     *     require_once __DIR__ . '/../views/admin/dashboard.php';
     * } else {
     *     require_once __DIR__ . '/../views/user/dashboard.php';
     * }
     */
    public function index() {
        // [DEV MODE] Auth guard disabled — no login required
        // [RESTORE] Uncomment the session guard block in the docblock above when auth is needed
        require_once __DIR__ . '/../views/dashboard/main.php';
    }
}
