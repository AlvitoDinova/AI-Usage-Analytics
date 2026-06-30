<?php
/**
 * Database — PDO Singleton Connection
 * AInsight | ainsight_db | XAMPP MySQL
 */
class Database {

    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=127.0.0.1;port=3306;dbname=ainsight_db;charset=utf8mb4',
                    'root',   // XAMPP default username
                    '',       // XAMPP default password (empty)
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                http_response_code(500);
                die('
                <div style="font-family:monospace;padding:24px;max-width:700px;margin:40px auto;
                            background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;color:#991b1b;">
                    <strong style="font-size:1.1rem;">&#9888; Database Connection Error</strong><br><br>
                    ' . htmlspecialchars($e->getMessage()) . '<br><br>
                    <small>Pastikan MySQL XAMPP sudah berjalan dan database <code>ainsight_db</code> sudah diimport.</small>
                </div>');
            }
        }
        return self::$instance;
    }
}
