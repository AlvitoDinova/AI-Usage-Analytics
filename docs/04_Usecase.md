# Use Case Document - AInsight (PHP Native)

This document describes the actors and use cases for the AInsight Decision Support System.

## 1. Use Case Diagram

The system has two primary actors: **Admin** and **User (Creative Staff)**.

```mermaid
left_to_right_direction
actor Admin as "Admin"
actor User as "User"

rectangle AInsight_System {
    usecase UC1 as "Register / Create Account"
    usecase UC2 as "Login & Authentication"
    usecase UC3 as "Manage Personal Profile"
    
    usecase UC4 as "View Dashboard & Usage Charts"
    usecase UC5 as "Input Assessment Details"
    usecase UC6 as "Execute TOPSIS & View Recommendations"
    usecase UC7 as "Inspect Step-by-Step Calculations"
    usecase UC8 as "View Personal History & Past Results"
    
    usecase UC9 as "Manage User Accounts (CRUD)"
    usecase UC10 as "Manage AI Alternatives (CRUD)"
    usecase UC11 as "Manage Criteria (CRUD)"
    usecase UC12 as "Manage Criteria Weights (CRUD)"
    usecase UC13 as "Manage Matrix Assessments (CRUD)"
    usecase UC14 as "View Overall Activity Logs"
}

User --> UC1
User --> UC2
User --> UC3
User --> UC4
User --> UC5
User --> UC6
User --> UC7
User --> UC8

Admin --> UC2
Admin --> UC4
Admin --> UC9
Admin --> UC10
Admin --> UC11
Admin --> UC12
Admin --> UC13
Admin --> UC14
```

---

## 2. Use Case Descriptions

### UC-1: Register / Create Account
- **Actor**: User
- **Preconditions**: User does not have an account.
- **Flow**:
  1. User navigates to the Register page.
  2. User fills in Username, Email, and Password.
  3. System validates inputs (unique email/username, strong password).
  4. System registers the user with the default role of 'User'.
  5. System redirects the user to the Login page.

### UC-2: Login & Authentication
- **Actors**: User, Admin
- **Preconditions**: User has registered.
- **Flow**:
  1. User navigates to the Login page.
  2. User enters Email/Username and Password.
  3. System verifies credentials against the database.
  4. System establishes a session and saves the user's role.
  5. System redirects the user to their respective Dashboard based on role (Admin dashboard vs User dashboard).

### UC-5: Input Assessment Details
- **Actor**: User
- **Preconditions**: User is authenticated.
- **Flow**:
  1. User clicks "Mulai Penilaian" (Start Assessment).
  2. User enters project name (e.g., campaign name) and selects the job category.
  3. User adjusts the importance level (weight) for each criterion (Harga, Kemudahan, Kecepatan, Kualitas, Fitur) based on the project's specific requirements.
  4. User submits the assessment form.

### UC-6: Execute TOPSIS & View Recommendations
- **Actor**: User
- **Preconditions**: User has submitted an assessment query.
- **Flow**:
  1. System pulls the dynamic weights selected by the user.
  2. System pulls the pre-rated performance scores of all registered AI tools.
  3. System executes the mathematical steps of the TOPSIS algorithm.
  4. System displays the ranked list of AI tools with their Closeness Coefficient values ($C_i^*$) and highlights the best tool.
  5. System saves the calculation parameters and rankings in the history table.

### UC-7: Inspect Step-by-Step Calculations
- **Actor**: User, Admin
- **Preconditions**: A TOPSIS calculation has just been executed or is loaded from history.
- **Flow**:
  1. User clicks "Lihat Detail Perhitungan" (View Calculation Details).
  2. System renders the step-by-step tables:
     - Raw decision matrix ($X$)
     - Normalized matrix ($R$)
     - Weighted normalized matrix ($V$)
     - Positive ideal ($A^+$) and Negative ideal ($A^-$) solutions
     - Separation measures ($S_i^+$ and $S_i^-$)
     - Closeness coefficient ($C_i^*$) and ranks
  3. System provides explanation notes for each step to support thesis defense.

### UC-10: Manage AI Alternatives (CRUD)
- **Actor**: Admin
- **Preconditions**: Admin is authenticated.
- **Flow**:
  1. Admin navigates to the AI Management page.
  2. Admin can create, read, update, or delete AI alternatives.
  3. Admin enters name, description, category, and uploads an icon.
  4. Database is updated.
