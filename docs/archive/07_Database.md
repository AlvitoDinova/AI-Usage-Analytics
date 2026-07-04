# Database Design & Schema DDL - AInsight (PHP Native)

This document details the SQL DDL commands to construct the MySQL database schema for AInsight and includes default seed data to populate the alternatives, criteria, and roles.

## 1. Database Creation & Schema DDL (MySQL)

```sql
-- Create Database
CREATE DATABASE IF NOT EXISTS ainsight_db;
USE ainsight_db;

-- 1. Roles Table
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. AI Tools (Alternatives) Table
CREATE TABLE IF NOT EXISTS ai_tools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    category VARCHAR(100) NOT NULL,
    image_url VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Criteria Table
CREATE TABLE IF NOT EXISTS criteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    type ENUM('benefit', 'cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Criteria Weights Table
CREATE TABLE IF NOT EXISTS criteria_weights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    criterion_id INT NOT NULL UNIQUE,
    weight DECIMAL(5,4) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (criterion_id) REFERENCES criteria(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Assessments Table (Alternative Decision Matrix Headers)
CREATE TABLE IF NOT EXISTS assessments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ai_tool_id INT NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ai_tool_id) REFERENCES ai_tools(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Assessment Details Table (Alternative Performance Scores)
CREATE TABLE IF NOT EXISTS assessment_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assessment_id INT NOT NULL,
    criterion_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
    FOREIGN KEY (criterion_id) REFERENCES criteria(id) ON DELETE CASCADE,
    UNIQUE KEY uq_assessment_criterion (assessment_id, criterion_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. History (User Assessment Requests) Table
CREATE TABLE IF NOT EXISTS history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    job_category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. TOPSIS Results Table
CREATE TABLE IF NOT EXISTS topsis_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    history_id INT NOT NULL,
    ai_tool_id INT NOT NULL,
    preference_value DECIMAL(7,6) NOT NULL,
    `rank` INT NOT NULL,
    FOREIGN KEY (history_id) REFERENCES history(id) ON DELETE CASCADE,
    FOREIGN KEY (ai_tool_id) REFERENCES ai_tools(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 2. Seed Data Script

The following insert commands populate default data so that AInsight is fully functional immediately after database creation.

```sql
-- Seed Roles
INSERT INTO roles (id, name) VALUES 
(1, 'Admin'),
(2, 'User')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Seed Default Admin Account (password: 'admin123')
INSERT INTO users (username, email, password_hash, role_id) VALUES
('admin', 'admin@notchcreative.com', '$2y$10$7Z25Xk6i1Q9rY96V2WfT7u9gq.b3H2xVlV95Y6Kk8uV4v1w5t0N6G', 1)
ON DUPLICATE KEY UPDATE username=VALUES(username);

-- Seed Criteria
INSERT INTO criteria (id, code, name, type) VALUES 
(1, 'C1', 'Harga Langganan (Cost)', 'cost'),
(2, 'C2', 'Kemudahan Penggunaan (Benefit)', 'benefit'),
(3, 'C3', 'Kecepatan Respon (Benefit)', 'benefit'),
(4, 'C4', 'Kualitas Output (Benefit)', 'benefit'),
(5, 'C5', 'Kelengkapan Fitur (Benefit)', 'benefit')
ON DUPLICATE KEY UPDATE name=VALUES(name), type=VALUES(type);

-- Seed Criteria Weights (Equally distributed default weights)
INSERT INTO criteria_weights (criterion_id, weight) VALUES 
(1, 0.2000),
(2, 0.2000),
(3, 0.2000),
(4, 0.2000),
(5, 0.2000)
ON DUPLICATE KEY UPDATE weight=VALUES(weight);

-- Seed AI Tools (Alternatives)
INSERT INTO ai_tools (id, name, description, category, image_url) VALUES 
(1, 'ChatGPT', 'Model bahasa besar dari OpenAI untuk teks, brainstorming, dan coding.', 'Copywriting, Coding, Riset', 'chatgpt.png'),
(2, 'Gemini', 'AI multimodal dari Google dengan integrasi ekosistem Google Workspace.', 'Brainstorming, Riset', 'gemini.png'),
(3, 'Claude', 'AI asisten dari Anthropic, unggul dalam analisis teks panjang dan logika.', 'Copywriting, Riset', 'claude.png'),
(4, 'Copilot', 'AI asisten coding berbasis OpenAI Codex dari Microsoft.', 'Coding', 'copilot.png'),
(5, 'Perplexity', 'AI mesin pencari conversational yang memberikan kutipan sumber.', 'Riset', 'perplexity.png'),
(6, 'DeepSeek', 'AI model open-source berkinerja tinggi untuk analisis dan coding.', 'Coding, Riset', 'deepseek.png'),
(7, 'Grok', 'AI asisten real-time dari xAI terintegrasi dengan platform X.', 'Riset, Social Media Content', 'grok.png'),
(8, 'Meta AI', 'Asisten cerdas terintegrasi dari Meta di WhatsApp, Instagram, dan FB.', 'Social Media Content', 'metaai.png'),
(9, 'Midjourney', 'Generative AI penghasil desain visual berkualitas tinggi via Discord.', 'Desain Grafis, Image Generation', 'midjourney.png'),
(10, 'Leonardo AI', 'Platform pembuatan aset gambar dengan kontrol filter kreatif.', 'Desain Grafis, Image Generation', 'leonardo.png'),
(11, 'Canva AI', 'AI pembantu desain terintegrasi dengan platform Canva.', 'Desain Grafis, Presentasi', 'canva.png'),
(12, 'Gamma', 'AI pembantu pembuat slide presentasi dan landing page instan.', 'Presentasi', 'gamma.png'),
(13, 'NotebookLM', 'Buku catatan virtual bertenaga AI dari Google untuk analisis dokumen.', 'Riset', 'notebooklm.png')
ON DUPLICATE KEY UPDATE name=VALUES(name), category=VALUES(category);

-- Seed Decision Matrix Scores (Assessments & Details)
-- Evaluation scale: 1 to 100

-- ChatGPT
INSERT INTO assessments (id, ai_tool_id) VALUES (1, 1) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(1, 1, 60.00), -- Harga (Cost: lower score is actually cheaper, but we put raw cost index, e.g. 60 out of 100 relative price)
(1, 2, 90.00), -- Kemudahan
(1, 3, 85.00), -- Kecepatan
(1, 4, 88.00), -- Kualitas
(1, 5, 92.00)  -- Fitur
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Gemini
INSERT INTO assessments (id, ai_tool_id) VALUES (2, 2) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(2, 1, 50.00),
(2, 2, 88.00),
(2, 3, 80.00),
(2, 4, 82.00),
(2, 5, 85.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Claude
INSERT INTO assessments (id, ai_tool_id) VALUES (3, 3) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(3, 1, 60.00),
(3, 2, 85.00),
(3, 3, 82.00),
(3, 4, 92.00),
(3, 5, 88.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Copilot
INSERT INTO assessments (id, ai_tool_id) VALUES (4, 4) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(4, 1, 60.00),
(4, 2, 80.00),
(4, 3, 85.00),
(4, 4, 85.00),
(4, 5, 80.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Perplexity
INSERT INTO assessments (id, ai_tool_id) VALUES (5, 5) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(5, 1, 60.00),
(5, 2, 88.00),
(5, 3, 85.00),
(5, 4, 88.00),
(5, 5, 85.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- DeepSeek
INSERT INTO assessments (id, ai_tool_id) VALUES (6, 6) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(6, 1, 10.00), -- Sangat murah / free
(6, 2, 75.00),
(6, 3, 70.00),
(6, 4, 85.00),
(6, 5, 80.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Grok
INSERT INTO assessments (id, ai_tool_id) VALUES (7, 7) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(7, 1, 50.00),
(7, 2, 80.00),
(7, 3, 75.00),
(7, 4, 78.00),
(7, 5, 75.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Meta AI
INSERT INTO assessments (id, ai_tool_id) VALUES (8, 8) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(8, 1, 0.00), -- Gratis total
(8, 2, 90.00),
(8, 3, 88.00),
(8, 4, 75.00),
(8, 5, 70.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Midjourney
INSERT INTO assessments (id, ai_tool_id) VALUES (9, 9) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(9, 1, 70.00), -- Cukup mahal
(9, 2, 60.00), -- Lebih sulit (via Discord)
(9, 3, 80.00),
(9, 4, 95.00), -- Kualitas gambar sangat tinggi
(9, 5, 85.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Leonardo AI
INSERT INTO assessments (id, ai_tool_id) VALUES (10, 10) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(10, 1, 50.00),
(10, 2, 82.00),
(10, 3, 82.00),
(10, 4, 90.00),
(10, 5, 88.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Canva AI
INSERT INTO assessments (id, ai_tool_id) VALUES (11, 11) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(11, 1, 40.00),
(11, 2, 92.00), -- Sangat mudah
(11, 3, 80.00),
(11, 4, 80.00),
(11, 5, 85.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- Gamma
INSERT INTO assessments (id, ai_tool_id) VALUES (12, 12) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(12, 1, 50.00),
(12, 2, 85.00),
(12, 3, 82.00),
(12, 4, 85.00),
(12, 5, 80.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);

-- NotebookLM
INSERT INTO assessments (id, ai_tool_id) VALUES (13, 13) ON DUPLICATE KEY UPDATE ai_tool_id=VALUES(ai_tool_id);
INSERT INTO assessment_details (assessment_id, criterion_id, score) VALUES 
(13, 1, 0.00), -- Gratis saat ini
(13, 2, 85.00),
(13, 3, 80.00),
(13, 4, 88.00),
(13, 5, 82.00)
ON DUPLICATE KEY UPDATE score=VALUES(score);
```
