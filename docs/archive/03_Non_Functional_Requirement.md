# Non-Functional Requirement Document (NFRD) - AInsight (PHP Native)

This document details the performance, security, scalability, usability, and technical constraints for the AInsight system.

## 1. Performance & Responsiveness
- **NFR-1.1**: The TOPSIS algorithm calculations for 13 AI alternatives against 5 criteria must run in under 50 milliseconds in a standard local server environment (XAMPP / PHP 8.x).
- **NFR-1.2**: All pages must load in under 1 second when running locally.
- **NFR-1.3**: AJAX operations, if utilized for dynamic criteria weight loading, must respond in under 100 milliseconds.

## 2. Security & Compliance
- **NFR-2.1 (Data Access & PDO)**:
  - Database access must be constructed using **PDO (PHP Data Objects)**.
  - All database queries involving user input must use **PDO Prepared Statements** to eliminate SQL injection risks.
- **NFR-2.2 (Password Encryption)**:
  - User passwords must be stored using PHP's native `password_hash()` with `PASSWORD_BCRYPT` and validated via `password_verify()`.
- **NFR-2.3 (Session & Authentication)**:
  - Session security must use `session_start()`, call `session_regenerate_id(true)` upon login, and restrict access through secure middleware-like session validation patterns.
- **NFR-2.4 (XSS Protection)**:
  - All dynamic data rendered inside HTML must be escaped using `htmlspecialchars()` or a custom helper function to prevent Cross-Site Scripting (XSS).
- **NFR-2.5 (CSRF Protection)**:
  - Forms submitting state modifications (POST requests) must contain a CSRF token stored in the user's session and validated upon request handling.

## 3. Scalability & DB Limits
- **NFR-3.1**: The MySQL database schema must contain indexes on foreign key relationships (e.g., `user_id` on `history`, `history_id` on `topsis_results`) to ensure fast history fetching.
- **NFR-3.2**: The application must be able to support up to 50 active criteria and 100 AI tools without database scaling or calculation performance issues.

## 4. UI/UX Design & Usability
- **NFR-4.1**: The application layout must be clean and modern, styled predominantly with a palette of **White, Blue, and Light Gray** to suit Notch Creative Agency's professional creative vibe.
- **NFR-4.2**: The frontend design must be fully responsive using **Bootstrap 5** grid utilities, working on screens of all sizes (mobiles, tablets, and desktops).
- **NFR-4.3**: TOPSIS calculation steps must be rendered as responsive tables using standard Bootstrap table classes, ensuring math steps are highly legible during thesis defense/sessions.
- **NFR-4.4**: Chart.js must be integrated to render the ranking coefficients and statistics visually.

## 5. Technical Stack Requirements
- **Server Environment**: Apache web server running PHP 8.0+ (compatible with standard XAMPP/Laragon setups on Windows).
- **Programming Language**: PHP Native (no framework).
- **Database**: MySQL (configured with InnoDB engine and foreign keys).
- **Frontend Stack**: Bootstrap 5 (CSS/JS files linked locally or via CDN), vanilla Javascript, and Chart.js.
- **Architecture**: A simple MVC structure using directory layout organization and a single front-controller router `public/index.php`.
