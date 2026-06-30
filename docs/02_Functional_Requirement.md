# Functional Requirement Document (FRD) - AInsight (PHP Native)

This document details the functional specifications for the AInsight system built using PHP Native.

## 1. System Feature List & Requirements

### 1.1 Authentication & Authorization
- **FR-1.1.1**: The system must provide **Login** and **Register** pages.
- **FR-1.1.2**: User accounts must have role permissions: **Admin** or **User**.
- **FR-1.1.3**: Passwords must be encrypted using `password_hash()` (bcrypt) in PHP.
- **FR-1.1.4**: Session-based login must be used to check user authorization on restricted pages.

### 1.2 User Dashboard
- **FR-1.2.1 (Admin Dashboard)**:
  - Display summary cards: Total AI tools, Total Users, Total Assessments.
  - Display a bar or pie chart using Chart.js representing the popularity of recommended AI tools.
  - Display a log of recent user assessment activities.
- **FR-1.2.2 (User Dashboard)**:
  - Display summary cards: Personal assessments completed, favorite recommended AI tool, active date.
  - Quick action to start a new AI selection assessment.
  - Display user's recent assessment logs.

### 1.3 Master Data Management (Admin Only)
- **FR-1.3.1 (CRUD AI Tools)**:
  - Admin can add, edit, and delete AI alternatives.
  - Core fields: Name, Description, Category, Image/Logo.
  - Pre-seeded AI tools: ChatGPT, Gemini, Claude, Copilot, Perplexity, DeepSeek, Grok, Meta AI, Midjourney, Leonardo AI, Canva AI, Gamma, NotebookLM.
- **FR-1.3.2 (CRUD Criteria)**:
  - Admin can manage evaluation criteria.
  - Core fields: Criterion Code (e.g., C1, C2), Name (e.g., Harga, Kualitas), Type (Benefit or Cost).
- **FR-1.3.3 (CRUD Default Weights)**:
  - Admin can set default weights for each criterion.
  - Weights must sum to 1.0 (or be normalized programmatically).
- **FR-1.3.4 (CRUD Assessments Matrix)**:
  - Admin can set the performance score of each AI tool against each criterion.
  - Grid matrix containing input cells for all AI tool alternatives and criteria codes (values from 1 to 10 or 1 to 100).
- **FR-1.3.5 (CRUD Users)**:
  - Admin can manage user accounts (CRUD, change roles).

### 1.4 Selection Assessment (Penilaian User)
- **FR-1.4.1**: Standard users can create a new assessment.
- **FR-1.4.2**: The user enters:
  - Project/Job Name (e.g., "Menulis Artikel Blog B2B")
  - Job Category (e.g., Copywriting, Desain Grafis, Coding, Presentasi, Riset)
- **FR-1.4.3**: The user can adjust the relative importance weights of each criterion for their specific task (e.g., using select inputs or sliders).
- **FR-1.4.4**: On submission, the system triggers the TOPSIS calculation using:
  - The predefined scores of all AI alternatives (from the Admin assessments matrix).
  - The user's custom criteria weights.

### 1.5 TOPSIS Calculation & Step-by-Step View
- **FR-1.5.1**: The system must implement the complete TOPSIS algorithm:
  1. **Decision Matrix ($X$)**: Raw evaluation scores.
  2. **Normalized Matrix ($R$)**: $r_{ij} = x_{ij} / \sqrt{\sum x_{kj}^2}$.
  3. **Weighted Normalized Matrix ($V$)**: $v_{ij} = r_{ij} \cdot w_j$.
  4. **Positive Ideal Solution ($A^+$)** and **Negative Ideal Solution ($A^-$)**: Benefit vs. Cost definitions.
  5. **Euclidean Distances ($S_i^+$ and $S_i^-$)**: Separation measures.
  6. **Preference Closeness Coefficient ($C_i^*$)**: $C_i^* = S_i^- / (S_i^+ + S_i^-)$.
  7. **Ranking**: Descending order of $C_i^*$.
- **FR-1.5.2**: The application must provide a dedicated calculation details page that displays each mathematical step using Bootstrap tables, enabling users to verify calculations for academic purposes.
- **FR-1.5.3**: The results page must display:
  - The top recommended AI tool.
  - A summary chart ranking all alternatives.
  - Narrative explanation of the calculation result.

### 1.6 History & Profile
- **FR-1.6.1**: The system must log all user assessment queries in the `history` and `topsis_results` tables.
- **FR-1.6.2**: Users must be able to view their assessment history log, delete historical logs, and click "View Details" to re-render the mathematical matrices and recommendations of any past calculation.
- **FR-1.6.3**: Users must be able to edit their profile (Username, Email) and change password.

---

## 2. Page Map (Sitemap)
- **Public**:
  - Landing Page (`views/landing.php`)
  - Login Page (`views/auth/login.php`)
  - Register Page (`views/auth/register.php`)
- **Admin Section**:
  - Dashboard (`views/admin/dashboard.php`)
  - CRUD AI Tools (`views/admin/ai/index.php`)
  - CRUD Criteria (`views/admin/criteria/index.php`)
  - CRUD Weights & Matrix (`views/admin/matrix/index.php`)
  - CRUD Users (`views/admin/users/index.php`)
  - History & Calculations Log (`views/admin/history.php`)
- **User Section**:
  - Dashboard (`views/user/dashboard.php`)
  - Assessment Input (`views/user/assess.php`)
  - Calculation Details & Result (`views/user/result.php`)
  - Personal History Logs (`views/user/history.php`)
  - Profile Page (`views/user/profile.php`)
