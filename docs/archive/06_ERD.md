# Entity Relationship Diagram (ERD) - AInsight (PHP Native)

This document describes the relational database structure for AInsight.

## 1. ERD Diagram

```mermaid
erDiagram
    ROLES ||--o{ USERS : "contains"
    USERS ||--o{ HISTORY : "executes"
    AI_TOOLS ||--o{ ASSESSMENTS : "rated in"
    AI_TOOLS ||--o{ TOPSIS_RESULTS : "ranked in"
    CRITERIA ||--o{ CRITERIA_WEIGHTS : "has default weight"
    CRITERIA ||--o{ ASSESSMENT_DETAILS : "has rating score"
    
    ASSESSMENTS ||--|{ ASSESSMENT_DETAILS : "contains"
    HISTORY ||--|{ TOPSIS_RESULTS : "generates"

    ROLES {
        int id PK
        string name "Admin, User"
    }

    USERS {
        int id PK
        string username
        string email
        string password_hash
        int role_id FK
        timestamp created_at
    }

    AI_TOOLS {
        int id PK
        string name
        text description
        string category
        string image_url
        timestamp created_at
    }

    CRITERIA {
        int id PK
        string code "C1, C2, etc."
        string name
        enum type "benefit, cost"
    }

    CRITERIA_WEIGHTS {
        int id PK
        int criterion_id FK
        decimal weight "e.g., 0.2500"
        timestamp updated_at
    }

    ASSESSMENTS {
        int id PK
        int ai_tool_id FK
        timestamp created_at
    }

    ASSESSMENT_DETAILS {
        int id PK
        int assessment_id FK
        int criterion_id FK
        decimal score "e.g., 85.00"
    }

    HISTORY {
        int id PK
        int user_id FK
        string project_name
        string job_category
        timestamp created_at
    }

    TOPSIS_RESULTS {
        int id PK
        int history_id FK
        int ai_tool_id FK
        decimal preference_value "Closeness C_i*"
        int rank
    }
```

---

## 2. Table Schemas & Relational Integrity

### 2.1 USERS & ROLES
- **roles**: Defines permissions. Pre-seeded with `1` (Admin) and `2` (User).
- **users**: Stores accounts. Links to `roles` via `role_id` (FOREIGN KEY constraint with `ON DELETE RESTRICT` to prevent orphan user roles).

### 2.2 AI_TOOLS & CRITERIA
- **ai_tools**: Stores the list of AI tool alternatives being ranked (13 tools seeded initially).
- **criteria**: Defines the evaluation dimensions (Harga/Price, Kemudahan, Kecepatan, Kualitas, Fitur).

### 2.3 CRITERIA_WEIGHTS
- **criteria_weights**: Stores the default weights managed by the Admin. Links to `criteria` via `criterion_id` (FOREIGN KEY constraint with `ON DELETE CASCADE`).

### 2.4 ASSESSMENTS & DETAILS (Decision Matrix)
- **assessments**: Represents an evaluation event of an alternative. Links to `ai_tools` via `ai_tool_id` (FOREIGN KEY constraint with `ON DELETE CASCADE`).
- **assessment_details**: Stores the score of an AI tool against a criterion. Represents cell value $x_{ij}$ in decision matrix $X$. Links to `assessments` via `assessment_id` and `criteria` via `criterion_id` (FOREIGN KEY constraints with `ON DELETE CASCADE`).

### 2.5 HISTORY & TOPSIS_RESULTS
- **history**: Logs the user's assessment query (project name, category, and date).
- **topsis_results**: Stores final ranking scores ($C_i^*$) and rankings for historical lookups. Links to `history` via `history_id` (FOREIGN KEY constraint with `ON DELETE CASCADE`) and `ai_tools` via `ai_tool_id` (FOREIGN KEY constraint with `ON DELETE CASCADE`).
