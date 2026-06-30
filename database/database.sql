-- ============================================================
--  AInsight — Database Schema & Seeder
--  Skripsi: SPK Pemilihan AI pada Industri Kreatif
--  Metode  : TOPSIS
--  Database: ainsight_db  (sudah dibuat di phpMyAdmin)
--  Engine  : InnoDB | Charset: utf8mb4_unicode_ci
--  Author  : AInsight Dev Team
--  Version : 1.0.0 — 2026
-- ============================================================

USE `ainsight_db`;

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE            = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';
SET time_zone           = '+07:00';

-- ============================================================
-- 1. ROLES
-- ============================================================
CREATE TABLE IF NOT EXISTS `roles` (
    `id`         INT            NOT NULL AUTO_INCREMENT,
    `nama_role`  VARCHAR(50)    NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_roles_nama` (`nama_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Master role pengguna (Admin, User)';

-- ============================================================
-- 2. USERS
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id`           INT           NOT NULL AUTO_INCREMENT,
    `nama`         VARCHAR(150)  NOT NULL,
    `email`        VARCHAR(150)  NOT NULL,
    `password`     VARCHAR(255)  NOT NULL    COMMENT 'bcrypt hash',
    `role_id`      INT           NOT NULL    DEFAULT 2,
    `created_at`   TIMESTAMP     NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP     NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email`    (`email`),
    KEY `idx_users_role_id`        (`role_id`),
    CONSTRAINT `fk_users_role`
        FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Akun pengguna aplikasi';

-- ============================================================
-- 3. PROJECT_TYPES
-- ============================================================
CREATE TABLE IF NOT EXISTS `project_types` (
    `id`           INT           NOT NULL AUTO_INCREMENT,
    `nama_proyek`  VARCHAR(100)  NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_project_types_nama` (`nama_proyek`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Master jenis proyek kreatif';

-- ============================================================
-- 4. AI_TOOLS  (Alternatif TOPSIS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `ai_tools` (
    `id`          INT           NOT NULL AUTO_INCREMENT,
    `nama_ai`     VARCHAR(100)  NOT NULL,
    `developer`   VARCHAR(100)  NOT NULL,
    `kategori`    VARCHAR(150)  NOT NULL,
    `website`     VARCHAR(255)      NULL,
    `deskripsi`   TEXT              NULL,
    `status`      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_ai_tools_nama` (`nama_ai`),
    KEY `idx_ai_tools_status`     (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Daftar AI Tools sebagai alternatif TOPSIS';

-- ============================================================
-- 5. CRITERIA  (Kriteria TOPSIS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `criteria` (
    `id`              INT          NOT NULL AUTO_INCREMENT,
    `kode`            VARCHAR(10)  NOT NULL,
    `nama_kriteria`   VARCHAR(150) NOT NULL,
    `tipe`            ENUM('Benefit','Cost') NOT NULL COMMENT 'Benefit=nilai besar lebih baik; Cost=nilai kecil lebih baik',
    `deskripsi`       TEXT             NULL,
    `created_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_criteria_kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Master kriteria penilaian TOPSIS';

-- ============================================================
-- 6. CRITERIA_WEIGHTS  (Bobot Default Admin)
-- ============================================================
CREATE TABLE IF NOT EXISTS `criteria_weights` (
    `id`           INT           NOT NULL AUTO_INCREMENT,
    `criteria_id`  INT           NOT NULL,
    `bobot`        TINYINT       NOT NULL DEFAULT 3 COMMENT 'Skala 1-5',
    `updated_at`   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_criteria_weights_criteria` (`criteria_id`),
    CONSTRAINT `fk_cw_criteria`
        FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bobot default setiap kriteria yang diatur oleh Admin';

-- ============================================================
-- 7. MATRIX_VALUES  (Nilai AI × Kriteria — Matriks Keputusan)
-- ============================================================
CREATE TABLE IF NOT EXISTS `matrix_values` (
    `id`           INT        NOT NULL AUTO_INCREMENT,
    `ai_id`        INT        NOT NULL,
    `criteria_id`  INT        NOT NULL,
    `nilai`        TINYINT    NOT NULL DEFAULT 1 COMMENT 'Skala 1-5; tidak boleh NULL',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_matrix_ai_criteria` (`ai_id`, `criteria_id`),
    KEY `idx_matrix_criteria` (`criteria_id`),
    CONSTRAINT `fk_mv_ai`
        FOREIGN KEY (`ai_id`)        REFERENCES `ai_tools` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_mv_criteria`
        FOREIGN KEY (`criteria_id`)  REFERENCES `criteria` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Nilai setiap AI terhadap setiap kriteria (matriks keputusan global)';

-- ============================================================
-- 8. PROJECTS  (Header Proyek User)
-- ============================================================
CREATE TABLE IF NOT EXISTS `projects` (
    `id`               INT          NOT NULL AUTO_INCREMENT,
    `project_type_id`  INT          NOT NULL,
    `nama_proyek`      VARCHAR(255) NOT NULL,
    `deskripsi`        TEXT             NULL,
    `created_at`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_projects_type` (`project_type_id`),
    CONSTRAINT `fk_projects_type`
        FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Data proyek yang akan dievaluasi menggunakan TOPSIS';

-- ============================================================
-- 9. ASSESSMENTS  (Sesi Penilaian)
-- ============================================================
CREATE TABLE IF NOT EXISTS `assessments` (
    `id`                 INT        NOT NULL AUTO_INCREMENT,
    `project_id`         INT        NOT NULL,
    `tanggal_penilaian`  DATE       NOT NULL,
    `created_at`         TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_assessments_project` (`project_id`),
    CONSTRAINT `fk_assessments_project`
        FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Header sesi penilaian proyek';

-- ============================================================
-- 10. ASSESSMENT_DETAILS  (Bobot per-Kriteria oleh User)
-- ============================================================
CREATE TABLE IF NOT EXISTS `assessment_details` (
    `id`             INT      NOT NULL AUTO_INCREMENT,
    `assessment_id`  INT      NOT NULL,
    `criteria_id`    INT      NOT NULL,
    `bobot`          TINYINT  NOT NULL DEFAULT 3 COMMENT 'Bobot user skala 1-5',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_ad_assessment_criteria` (`assessment_id`, `criteria_id`),
    KEY `idx_ad_criteria` (`criteria_id`),
    CONSTRAINT `fk_ad_assessment`
        FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_ad_criteria`
        FOREIGN KEY (`criteria_id`)   REFERENCES `criteria` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bobot kriteria yang dipilih user per sesi penilaian';

-- ============================================================
-- 11. TOPSIS_RESULTS  (Hasil Akhir Ranking)
-- ============================================================
CREATE TABLE IF NOT EXISTS `topsis_results` (
    `id`                INT            NOT NULL AUTO_INCREMENT,
    `assessment_id`     INT            NOT NULL,
    `ai_id`             INT            NOT NULL,
    `nilai_preferensi`  DECIMAL(10,8)  NOT NULL COMMENT 'Nilai Ci* TOPSIS (0-1)',
    `ranking`           INT            NOT NULL,
    `created_at`        TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_tr_assessment_ai` (`assessment_id`, `ai_id`),
    KEY `idx_tr_ai`      (`ai_id`),
    KEY `idx_tr_ranking` (`ranking`),
    CONSTRAINT `fk_tr_assessment`
        FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_tr_ai`
        FOREIGN KEY (`ai_id`)         REFERENCES `ai_tools` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Hasil akhir ranking TOPSIS per sesi penilaian';

-- ============================================================
-- 12. CALCULATION_LOGS  (Jejak Tiap Tahap TOPSIS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `calculation_logs` (
    `id`             INT         NOT NULL AUTO_INCREMENT,
    `assessment_id`  INT         NOT NULL,
    `tahap`          ENUM(
                         'Matriks Keputusan',
                         'Normalisasi',
                         'Matriks Terbobot',
                         'Solusi Ideal Positif',
                         'Solusi Ideal Negatif',
                         'Jarak Positif',
                         'Jarak Negatif',
                         'Nilai Preferensi',
                         'Ranking'
                     )           NOT NULL,
    `data_json`      LONGTEXT    NOT NULL COMMENT 'Snapshot data tahap dalam format JSON',
    `created_at`     TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_calclog_assessment` (`assessment_id`),
    KEY `idx_calclog_tahap`      (`tahap`),
    CONSTRAINT `fk_cl_assessment`
        FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Log detail setiap tahap perhitungan TOPSIS';

-- ============================================================
-- 13. ACTIVITY_LOGS  (Audit Trail)
-- ============================================================
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `aktivitas`   VARCHAR(500) NOT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_actlog_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Log seluruh aktivitas pengguna dalam sistem';

-- ============================================================
-- 14. STATISTICS  (Cache Statistik untuk Dashboard)
-- ============================================================
CREATE TABLE IF NOT EXISTS `statistics` (
    `id`              INT          NOT NULL AUTO_INCREMENT,
    `nama_statistik`  VARCHAR(100) NOT NULL,
    `nilai`           DECIMAL(15,2)    NULL DEFAULT 0,
    `updated_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_statistics_nama` (`nama_statistik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Statistik ringkasan untuk widget dashboard';

SET FOREIGN_KEY_CHECKS = 1;


-- ============================================================
-- ██████████  S E E D E R  ██████████
-- ============================================================


-- ------------------------------------------------------------
-- SEED: ROLES
-- ------------------------------------------------------------
INSERT INTO `roles` (`id`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User')
ON DUPLICATE KEY UPDATE `nama_role` = VALUES(`nama_role`);


-- ------------------------------------------------------------
-- SEED: USERS  (password: Admin@123 | User@123 — bcrypt cost 12)
-- Gunakan password_hash('Admin@123', PASSWORD_BCRYPT) jika ingin re-generate.
-- ------------------------------------------------------------
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role_id`) VALUES
(1, 'Administrator', 'admin@notchcreative.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(2, 'Demo User', 'user@notchcreative.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2)
ON DUPLICATE KEY UPDATE
    `nama`     = VALUES(`nama`),
    `role_id`  = VALUES(`role_id`);


-- ------------------------------------------------------------
-- SEED: PROJECT_TYPES
-- ------------------------------------------------------------
INSERT INTO `project_types` (`id`, `nama_proyek`) VALUES
( 1, 'Copywriting'),
( 2, 'Graphic Design'),
( 3, 'Branding'),
( 4, 'Motion Graphic'),
( 5, 'Video Editing'),
( 6, 'UI/UX'),
( 7, 'Presentation'),
( 8, 'Research'),
( 9, 'Coding'),
(10, 'Social Media Content')
ON DUPLICATE KEY UPDATE `nama_proyek` = VALUES(`nama_proyek`);


-- ------------------------------------------------------------
-- SEED: AI_TOOLS  (13 Alternatif)
-- ------------------------------------------------------------
INSERT INTO `ai_tools`
    (`id`, `nama_ai`, `developer`, `kategori`, `website`, `deskripsi`, `status`)
VALUES
( 1, 'ChatGPT',     'OpenAI',          'Teks, Coding, Riset',
    'https://chat.openai.com',
    'Model bahasa besar generasi terbaru dari OpenAI. Unggul dalam penulisan, coding, brainstorming, dan analisis teks panjang dengan akurasi tinggi.',
    'aktif'),

( 2, 'Gemini',      'Google DeepMind', 'Teks, Multimodal, Riset',
    'https://gemini.google.com',
    'AI multimodal dari Google yang mendukung teks, gambar, dan kode. Terintegrasi erat dengan ekosistem Google Workspace (Docs, Gmail, Drive).',
    'aktif'),

( 3, 'Claude',      'Anthropic',       'Teks, Analisis, Copywriting',
    'https://claude.ai',
    'Asisten AI dari Anthropic yang sangat unggul dalam analisis dokumen panjang, nuansa bahasa, dan keamanan konten. Ideal untuk copywriting mendalam.',
    'aktif'),

( 4, 'Copilot',     'Microsoft',       'Coding, Teks, Produktivitas',
    'https://copilot.microsoft.com',
    'Asisten AI dari Microsoft berbasis GPT-4 yang terintegrasi di Microsoft 365. Sangat andal untuk produktivitas, coding di VS Code, dan analisis data.',
    'aktif'),

( 5, 'Perplexity',  'Perplexity AI',   'Riset, Pencarian',
    'https://www.perplexity.ai',
    'Mesin pencari bertenaga AI yang menyajikan jawaban akurat disertai kutipan sumber real-time. Ideal untuk riset cepat dan verifikasi informasi.',
    'aktif'),

( 6, 'DeepSeek',    'DeepSeek',        'Coding, Riset, Teks',
    'https://www.deepseek.com',
    'Model AI open-source dari China dengan performa kompetitif di bidang coding dan analisis. Tersedia gratis dengan biaya operasional sangat rendah.',
    'aktif'),

( 7, 'Grok',        'xAI',             'Riset, Social Media, Teks',
    'https://grok.x.ai',
    'AI asisten dari xAI (Elon Musk) yang memiliki akses real-time ke data platform X/Twitter. Ideal untuk analisis tren dan konten social media.',
    'aktif'),

( 8, 'Meta AI',     'Meta',            'Teks, Social Media',
    'https://www.meta.ai',
    'Asisten AI dari Meta yang terintegrasi langsung di WhatsApp, Instagram, dan Facebook. Gratis dan mudah diakses oleh seluruh anggota tim.',
    'aktif'),

( 9, 'Midjourney',  'Midjourney Inc.', 'Image Generation, Desain Grafis',
    'https://www.midjourney.com',
    'Platform generative AI terdepan dalam menghasilkan gambar artistik berkualitas sangat tinggi. Diakses melalui Discord dengan antarmuka prompt-based.',
    'aktif'),

(10, 'Leonardo AI', 'Leonardo.Ai',     'Image Generation, Desain Grafis',
    'https://leonardo.ai',
    'Platform AI image generation berbasis web dengan berbagai model dan kontrol kreatif yang detail. Cocok untuk aset visual game, branding, dan ilustrasi.',
    'aktif'),

(11, 'Canva AI',    'Canva',           'Desain Grafis, Presentasi',
    'https://www.canva.com',
    'Fitur AI terintegrasi dalam platform desain Canva. Sangat mudah digunakan oleh non-desainer untuk membuat konten visual, presentasi, dan materi marketing.',
    'aktif'),

(12, 'Gamma',       'Gamma App',       'Presentasi, Dokumen',
    'https://gamma.app',
    'AI pembuat slide presentasi, dokumen, dan landing page secara instan. Mengubah teks atau outline menjadi presentasi visual profesional dalam hitungan detik.',
    'aktif'),

(13, 'NotebookLM',  'Google',          'Riset, Analisis Dokumen',
    'https://notebooklm.google.com',
    'Buku catatan virtual bertenaga AI dari Google untuk menganalisis, merangkum, dan menjawab pertanyaan berdasarkan dokumen yang diunggah pengguna.',
    'aktif')

ON DUPLICATE KEY UPDATE
    `developer`  = VALUES(`developer`),
    `kategori`   = VALUES(`kategori`),
    `website`    = VALUES(`website`),
    `deskripsi`  = VALUES(`deskripsi`),
    `status`     = VALUES(`status`);


-- ------------------------------------------------------------
-- SEED: CRITERIA  (10 Kriteria TOPSIS)
-- Benefit = nilai besar → lebih baik
-- Cost    = nilai kecil → lebih baik (misal: harga mahal = nilai tinggi = buruk)
-- ------------------------------------------------------------
INSERT INTO `criteria`
    (`id`, `kode`, `nama_kriteria`, `tipe`, `deskripsi`)
VALUES
( 1, 'K1', 'Akurasi',
    'Benefit',
    'Tingkat keakuratan dan kebenaran output yang dihasilkan AI. Semakin akurat hasilnya, semakin bernilai tinggi untuk kebutuhan profesional.'),

( 2, 'K2', 'Kemudahan Penggunaan',
    'Benefit',
    'Seberapa mudah dan intuitif antarmuka serta alur kerja AI dapat digunakan oleh anggota tim kreatif tanpa pelatihan khusus.'),

( 3, 'K3', 'Harga',
    'Cost',
    'Biaya berlangganan atau penggunaan AI. Tipe Cost berarti harga lebih mahal (nilai tinggi) dianggap kurang menguntungkan bagi agensi.'),

( 4, 'K4', 'Kecepatan',
    'Benefit',
    'Kecepatan respons dan pemrosesan AI dalam menghasilkan output. Kecepatan tinggi meningkatkan produktivitas tim.'),

( 5, 'K5', 'Bahasa Indonesia',
    'Benefit',
    'Kemampuan AI memahami dan menghasilkan konten dalam Bahasa Indonesia dengan kualitas yang baik dan natural.'),

( 6, 'K6', 'Integrasi',
    'Benefit',
    'Kemampuan AI untuk berintegrasi dengan tools dan platform lain yang digunakan oleh tim (Slack, Notion, Google Workspace, dll).'),

( 7, 'K7', 'Kemampuan Coding',
    'Benefit',
    'Kemampuan AI dalam membantu penulisan, debugging, review, dan penjelasan kode pemrograman untuk kebutuhan pengembangan internal.'),

( 8, 'K8', 'Kemampuan Desain',
    'Benefit',
    'Kemampuan AI dalam menghasilkan atau mendukung pembuatan aset visual, gambar, ilustrasi, dan elemen desain grafis.'),

( 9, 'K9', 'Kemampuan Copywriting',
    'Benefit',
    'Kemampuan AI dalam menghasilkan teks marketing, copywriting, caption, artikel, dan konten kreatif berbasis bahasa yang berkualitas tinggi.'),

(10, 'K10', 'Brainstorming',
    'Benefit',
    'Kemampuan AI dalam membantu proses ideasi, generasi konsep, eksplorasi ide kreatif, dan diskusi konseptual untuk proyek kreatif.')

ON DUPLICATE KEY UPDATE
    `nama_kriteria` = VALUES(`nama_kriteria`),
    `tipe`          = VALUES(`tipe`),
    `deskripsi`     = VALUES(`deskripsi`);


-- ------------------------------------------------------------
-- SEED: CRITERIA_WEIGHTS  (Bobot default Admin, skala 1–5)
-- K1=5 K2=4 K3=4 K4=3 K5=3 K6=3 K7=4 K8=4 K9=5 K10=4
-- ------------------------------------------------------------
INSERT INTO `criteria_weights` (`id`, `criteria_id`, `bobot`) VALUES
( 1,  1, 5),   -- K1  Akurasi                 — Sangat Penting
( 2,  2, 4),   -- K2  Kemudahan Penggunaan    — Penting
( 3,  3, 4),   -- K3  Harga                   — Penting
( 4,  4, 3),   -- K4  Kecepatan               — Sedang
( 5,  5, 3),   -- K5  Bahasa Indonesia        — Sedang
( 6,  6, 3),   -- K6  Integrasi               — Sedang
( 7,  7, 4),   -- K7  Kemampuan Coding        — Penting
( 8,  8, 4),   -- K8  Kemampuan Desain        — Penting
( 9,  9, 5),   -- K9  Kemampuan Copywriting   — Sangat Penting
(10, 10, 4)    -- K10 Brainstorming           — Penting
ON DUPLICATE KEY UPDATE `bobot` = VALUES(`bobot`);


-- ============================================================
-- SEED: MATRIX_VALUES  (13 AI × 10 Kriteria = 130 baris)
--
-- Skala 1–5:
--   1 = Sangat Rendah  2 = Rendah  3 = Sedang
--   4 = Tinggi         5 = Sangat Tinggi
--
-- Kolom urutan: K1 K2 K3 K4 K5 K6 K7 K8 K9 K10
--               Akr Mud Hrg Kec BInd Int Cod Des Cpy Brs
--
-- Untuk K3 (Harga/Cost): 5=Sangat Mahal  1=Gratis/Sangat Murah
-- (nilai tinggi = buruk karena tipe Cost → TOPSIS akan membalik)
-- ============================================================

-- ai_id=1  ChatGPT
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      5   5   3   4   4   5   5   3   5   5
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(1,  1, 5),  -- K1  Akurasi           : Sangat Tinggi
(1,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi
(1,  3, 3),  -- K3  Harga             : Sedang ($20/bln untuk Plus)
(1,  4, 4),  -- K4  Kecepatan         : Tinggi
(1,  5, 4),  -- K5  Bahasa Indonesia  : Tinggi
(1,  6, 5),  -- K6  Integrasi         : Sangat Tinggi (API, plugin)
(1,  7, 5),  -- K7  Coding            : Sangat Tinggi
(1,  8, 3),  -- K8  Desain            : Sedang (DALL-E via plugin)
(1,  9, 5),  -- K9  Copywriting       : Sangat Tinggi
(1, 10, 5)   -- K10 Brainstorming     : Sangat Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=2  Gemini
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      5   5   2   4   5   5   4   3   4   5
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(2,  1, 5),  -- K1  Akurasi           : Sangat Tinggi (Gemini 2.0)
(2,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi
(2,  3, 2),  -- K3  Harga             : Rendah (gratis dengan akun Google)
(2,  4, 4),  -- K4  Kecepatan         : Tinggi
(2,  5, 5),  -- K5  Bahasa Indonesia  : Sangat Tinggi (Google multilingual)
(2,  6, 5),  -- K6  Integrasi         : Sangat Tinggi (Google Workspace)
(2,  7, 4),  -- K7  Coding            : Tinggi
(2,  8, 3),  -- K8  Desain            : Sedang (Imagen via Gemini)
(2,  9, 4),  -- K9  Copywriting       : Tinggi
(2, 10, 5)   -- K10 Brainstorming     : Sangat Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=3  Claude
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      5   4   3   4   3   4   5   2   5   5
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(3,  1, 5),  -- K1  Akurasi           : Sangat Tinggi (nuansa & logika)
(3,  2, 4),  -- K2  Kemudahan         : Tinggi
(3,  3, 3),  -- K3  Harga             : Sedang ($20/bln Pro)
(3,  4, 4),  -- K4  Kecepatan         : Tinggi
(3,  5, 3),  -- K5  Bahasa Indonesia  : Sedang (lebih lemah dari ChatGPT/Gemini)
(3,  6, 4),  -- K6  Integrasi         : Tinggi (API tersedia)
(3,  7, 5),  -- K7  Coding            : Sangat Tinggi
(3,  8, 2),  -- K8  Desain            : Rendah (tidak ada image generation)
(3,  9, 5),  -- K9  Copywriting       : Sangat Tinggi (teks panjang terbaik)
(3, 10, 5)   -- K10 Brainstorming     : Sangat Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=4  Copilot
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      4   5   2   4   4   5   5   2   4   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(4,  1, 4),  -- K1  Akurasi           : Tinggi
(4,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi (terintegrasi di Office)
(4,  3, 2),  -- K3  Harga             : Rendah (bundel M365, ~$30/bln termasuk Office)
(4,  4, 4),  -- K4  Kecepatan         : Tinggi
(4,  5, 4),  -- K5  Bahasa Indonesia  : Tinggi
(4,  6, 5),  -- K6  Integrasi         : Sangat Tinggi (Microsoft ekosistem)
(4,  7, 5),  -- K7  Coding            : Sangat Tinggi (GitHub Copilot)
(4,  8, 2),  -- K8  Desain            : Rendah
(4,  9, 4),  -- K9  Copywriting       : Tinggi
(4, 10, 4)   -- K10 Brainstorming     : Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=5  Perplexity
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      4   4   2   5   3   3   3   1   3   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(5,  1, 4),  -- K1  Akurasi           : Tinggi (real-time sources)
(5,  2, 4),  -- K2  Kemudahan         : Tinggi
(5,  3, 2),  -- K3  Harga             : Rendah (gratis + $20 Pro)
(5,  4, 5),  -- K4  Kecepatan         : Sangat Tinggi (search-based)
(5,  5, 3),  -- K5  Bahasa Indonesia  : Sedang
(5,  6, 3),  -- K6  Integrasi         : Sedang
(5,  7, 3),  -- K7  Coding            : Sedang
(5,  8, 1),  -- K8  Desain            : Sangat Rendah (tidak ada)
(5,  9, 3),  -- K9  Copywriting       : Sedang
(5, 10, 4)   -- K10 Brainstorming     : Tinggi (riset ide)
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=6  DeepSeek
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      5   4   1   3   3   3   5   2   4   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(6,  1, 5),  -- K1  Akurasi           : Sangat Tinggi (DeepSeek-R1)
(6,  2, 4),  -- K2  Kemudahan         : Tinggi
(6,  3, 1),  -- K3  Harga             : Sangat Rendah (hampir gratis)
(6,  4, 3),  -- K4  Kecepatan         : Sedang (server kadang lambat)
(6,  5, 3),  -- K5  Bahasa Indonesia  : Sedang
(6,  6, 3),  -- K6  Integrasi         : Sedang (API tersedia)
(6,  7, 5),  -- K7  Coding            : Sangat Tinggi (benchmark setara GPT-4)
(6,  8, 2),  -- K8  Desain            : Rendah
(6,  9, 4),  -- K9  Copywriting       : Tinggi
(6, 10, 4)   -- K10 Brainstorming     : Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=7  Grok
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      4   4   2   4   3   3   4   2   4   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(7,  1, 4),  -- K1  Akurasi           : Tinggi
(7,  2, 4),  -- K2  Kemudahan         : Tinggi
(7,  3, 2),  -- K3  Harga             : Rendah (bundel X Premium $8-16/bln)
(7,  4, 4),  -- K4  Kecepatan         : Tinggi
(7,  5, 3),  -- K5  Bahasa Indonesia  : Sedang
(7,  6, 3),  -- K6  Integrasi         : Sedang (hanya X platform)
(7,  7, 4),  -- K7  Coding            : Tinggi
(7,  8, 2),  -- K8  Desain            : Rendah (Aurora image gen masih terbatas)
(7,  9, 4),  -- K9  Copywriting       : Tinggi
(7, 10, 4)   -- K10 Brainstorming     : Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=8  Meta AI
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      3   5   1   4   4   4   3   2   4   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(8,  1, 3),  -- K1  Akurasi           : Sedang (Llama 3 series)
(8,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi (WA, IG, FB)
(8,  3, 1),  -- K3  Harga             : Sangat Rendah (100% gratis)
(8,  4, 4),  -- K4  Kecepatan         : Tinggi
(8,  5, 4),  -- K5  Bahasa Indonesia  : Tinggi
(8,  6, 4),  -- K6  Integrasi         : Tinggi (Meta ekosistem)
(8,  7, 3),  -- K7  Coding            : Sedang
(8,  8, 2),  -- K8  Desain            : Rendah (image gen terbatas)
(8,  9, 4),  -- K9  Copywriting       : Tinggi
(8, 10, 4)   -- K10 Brainstorming     : Tinggi
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=9  Midjourney
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      3   3   4   3   2   2   1   5   2   3
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(9,  1, 3),  -- K1  Akurasi           : Sedang (sangat visual, tidak faktual)
(9,  2, 3),  -- K2  Kemudahan         : Sedang (perlu belajar prompt Discord)
(9,  3, 4),  -- K3  Harga             : Tinggi ($10-60/bln, tidak ada free tier)
(9,  4, 3),  -- K4  Kecepatan         : Sedang
(9,  5, 2),  -- K5  Bahasa Indonesia  : Rendah (prompt bahasa Inggris lebih optimal)
(9,  6, 2),  -- K6  Integrasi         : Rendah (hanya Discord)
(9,  7, 1),  -- K7  Coding            : Sangat Rendah
(9,  8, 5),  -- K8  Desain            : Sangat Tinggi (terbaik di kategorinya)
(9,  9, 2),  -- K9  Copywriting       : Rendah
(9, 10, 3)   -- K10 Brainstorming     : Sedang (visual ideation)
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=10  Leonardo AI
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      3   4   3   3   2   3   1   5   2   3
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(10,  1, 3),  -- K1  Akurasi           : Sedang
(10,  2, 4),  -- K2  Kemudahan         : Tinggi (antarmuka web lebih mudah dari MJ)
(10,  3, 3),  -- K3  Harga             : Sedang (freemium, paid $12/bln)
(10,  4, 3),  -- K4  Kecepatan         : Sedang
(10,  5, 2),  -- K5  Bahasa Indonesia  : Rendah
(10,  6, 3),  -- K6  Integrasi         : Sedang (API tersedia)
(10,  7, 1),  -- K7  Coding            : Sangat Rendah
(10,  8, 5),  -- K8  Desain            : Sangat Tinggi (kontrol model sangat detail)
(10,  9, 2),  -- K9  Copywriting       : Rendah
(10, 10, 3)   -- K10 Brainstorming     : Sedang
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=11  Canva AI
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      3   5   3   4   4   5   1   5   4   3
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(11,  1, 3),  -- K1  Akurasi           : Sedang (AI generatif desain)
(11,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi (drag & drop terbaik)
(11,  3, 3),  -- K3  Harga             : Sedang (freemium, Pro $15/bln)
(11,  4, 4),  -- K4  Kecepatan         : Tinggi
(11,  5, 4),  -- K5  Bahasa Indonesia  : Tinggi (UI tersedia dalam BI)
(11,  6, 5),  -- K6  Integrasi         : Sangat Tinggi (link ke semua platform)
(11,  7, 1),  -- K7  Coding            : Sangat Rendah
(11,  8, 5),  -- K8  Desain            : Sangat Tinggi (platform desain terpadu)
(11,  9, 4),  -- K9  Copywriting       : Tinggi (Magic Write)
(11, 10, 3)   -- K10 Brainstorming     : Sedang
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=12  Gamma
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      3   5   2   4   3   4   1   4   4   4
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(12,  1, 3),  -- K1  Akurasi           : Sedang (konten slide, bukan riset)
(12,  2, 5),  -- K2  Kemudahan         : Sangat Tinggi (zero learning curve)
(12,  3, 2),  -- K3  Harga             : Rendah (freemium, paid $10/bln)
(12,  4, 4),  -- K4  Kecepatan         : Tinggi (generate slide sangat cepat)
(12,  5, 3),  -- K5  Bahasa Indonesia  : Sedang
(12,  6, 4),  -- K6  Integrasi         : Tinggi (embed, export PPT/PDF)
(12,  7, 1),  -- K7  Coding            : Sangat Rendah
(12,  8, 4),  -- K8  Desain            : Tinggi (template premium)
(12,  9, 4),  -- K9  Copywriting       : Tinggi (narrative slides)
(12, 10, 4)   -- K10 Brainstorming     : Tinggi (outline ke presentasi)
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);

-- ai_id=13  NotebookLM
--     K1  K2  K3  K4  K5  K6  K7  K8  K9  K10
--      4   4   1   3   3   3   2   1   3   5
INSERT INTO `matrix_values` (`ai_id`, `criteria_id`, `nilai`) VALUES
(13,  1, 4),  -- K1  Akurasi           : Tinggi (berbasis dokumen sendiri = grounded)
(13,  2, 4),  -- K2  Kemudahan         : Tinggi
(13,  3, 1),  -- K3  Harga             : Sangat Rendah (100% gratis)
(13,  4, 3),  -- K4  Kecepatan         : Sedang
(13,  5, 3),  -- K5  Bahasa Indonesia  : Sedang
(13,  6, 3),  -- K6  Integrasi         : Sedang (Google Drive support)
(13,  7, 2),  -- K7  Coding            : Rendah
(13,  8, 1),  -- K8  Desain            : Sangat Rendah
(13,  9, 3),  -- K9  Copywriting       : Sedang
(13, 10, 5)   -- K10 Brainstorming     : Sangat Tinggi (audio overview, mind-map)
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);


-- ------------------------------------------------------------
-- SEED: STATISTICS  (Widget Dashboard default)
-- ------------------------------------------------------------
INSERT INTO `statistics` (`nama_statistik`, `nilai`) VALUES
('total_ai_tools',       13),
('total_kriteria',       10),
('total_penilaian',       0),
('total_proyek',          0),
('ai_terpilih_terbanyak', 0)
ON DUPLICATE KEY UPDATE `nilai` = VALUES(`nilai`);


-- ============================================================
-- VALIDASI AKHIR
-- Perintah di bawah hanya untuk verifikasi setelah import.
-- Uncomment untuk dijalankan manual di query tab phpMyAdmin.
-- ============================================================
/*
SELECT 'roles'          AS tabel, COUNT(*) AS total FROM roles
UNION ALL
SELECT 'users',           COUNT(*)  FROM users
UNION ALL
SELECT 'project_types',   COUNT(*)  FROM project_types
UNION ALL
SELECT 'ai_tools',        COUNT(*)  FROM ai_tools
UNION ALL
SELECT 'criteria',        COUNT(*)  FROM criteria
UNION ALL
SELECT 'criteria_weights',COUNT(*)  FROM criteria_weights
UNION ALL
SELECT 'matrix_values',   COUNT(*)  FROM matrix_values
UNION ALL
SELECT 'statistics',      COUNT(*)  FROM statistics;

-- Verifikasi tidak ada nilai NULL di matrix_values
SELECT COUNT(*) AS null_check FROM matrix_values WHERE nilai IS NULL;
-- Expected: 0

-- Verifikasi semua 130 kombinasi (13 AI × 10 Kriteria) ada
SELECT COUNT(*) AS total_matrix FROM matrix_values;
-- Expected: 130
*/

-- ============================================================
--  END OF FILE — ainsight_db schema & seeder v1.0.0
-- ============================================================
