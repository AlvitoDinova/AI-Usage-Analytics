<?php
/**
 * Global Helper Functions — AInsight
 */

/** Set a session flash message */
function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/** Redirect to a URL and exit */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/** Safely output HTML-escaped value */
function e(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/** Return only allowed keys from POST data */
function only(array $keys): array {
    $result = [];
    foreach ($keys as $key) {
        $result[$key] = $_POST[$key] ?? '';
    }
    return $result;
}

/** Simple CSRF token generation (stored in session) */
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Validate CSRF token from POST */
function verifyCsrf(): bool {
    return isset($_POST['csrf_token']) && hash_equals(csrfToken(), $_POST['csrf_token']);
}

/** Render hidden CSRF input field */
function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/** Format a float to N decimal places */
function fmt(float $value, int $decimals = 6): string {
    return number_format($value, $decimals, '.', '');
}

/** Pagination helper: returns [total_pages, offset] */
function paginate(int $total, int $perPage, int $currentPage): array {
    $totalPages  = (int)ceil($total / $perPage);
    $currentPage = max(1, min($currentPage, $totalPages ?: 1));
    $offset      = ($currentPage - 1) * $perPage;
    return [$totalPages, $offset, $currentPage];
}
