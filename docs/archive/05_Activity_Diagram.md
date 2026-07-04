# Activity Diagram - AInsight (PHP Native)

This document details the activity workflows for core system processes in AInsight using Mermaid flowcharts.

---

## 1. User Authentication Workflow

This activity describes the login process for users entering the system and role-based direction.

```mermaid
stateDiagram-v2
    [*] --> NavigateToLogin
    NavigateToLogin --> InputCredentials : Enter Email/Username & Password
    InputCredentials --> ValidateCredentials
    state ValidateCredentials <<choice>>
    ValidateCredentials --> DisplayError : Credentials Invalid
    DisplayError --> NavigateToLogin
    ValidateCredentials --> StartSession : Credentials Valid
    StartSession --> CheckRole
    state CheckRole <<choice>>
    CheckRole --> RedirectAdminDashboard : Role is Admin
    CheckRole --> RedirectUserDashboard : Role is User
    RedirectAdminDashboard --> [*]
    RedirectUserDashboard --> [*]
```

---

## 2. Assessment & TOPSIS Calculation Workflow

This activity describes how a user performs an evaluation, how the TOPSIS engine computes rankings, and how the results are stored.

```mermaid
stateDiagram-v2
    [*] --> NavigateToAssessPage
    NavigateToAssessPage --> InputProjectDetails : Enter Project Name & Select Job Category
    InputProjectDetails --> AdjustWeights : Move sliders/select weights for C1-C5
    AdjustWeights --> SubmitForm
    SubmitForm --> FetchPredefinedScores : Query assessments & details from DB for C1-C5
    FetchPredefinedScores --> ExecuteTOPSIS
    
    state ExecuteTOPSIS {
        [*] --> VectorNormalization : Normalize decision matrix
        VectorNormalization --> WeightMultiplication : Multiply normalized values by weights
        WeightMultiplication --> IdentifyIdeals : Find Positive (A+) and Negative (A-) Solutions
        IdentifyIdeals --> CalculateDistances : Measure Euclidean distances (S+ and S-)
        CalculateDistances --> CalculateCloseness : Compute preference index (C*)
        CalculateCloseness --> SortAndRank : Sort alternatives in descending order of C*
    }

    ExecuteTOPSIS --> RenderResultPage : Show ranking list & highlight top AI tool
    RenderResultPage --> SaveHistory : Save query & ranks in database
    SaveHistory --> [*]
```

---

## 3. Admin Matrix Assessment Workflow

This activity describes how the Admin inputs performance ratings for each AI tool under the criteria.

```mermaid
stateDiagram-v2
    [*] --> NavigateToMatrixPage
    NavigateToMatrixPage --> LoadMatrixGrid : Load all active AI Tools & Criteria Codes
    LoadMatrixGrid --> EditCellValues : Enter score (1-10 or 1-100) for AI x Criterion
    EditCellValues --> ClickSave
    ClickSave --> ValidateInputs : Verify scores are numeric and within bounds
    state ValidateInputs <<choice>>
    ValidateInputs --> ShowValidationError : Invalid score entered
    ShowValidationError --> EditCellValues
    ValidateInputs --> UpdateDatabase : Valid scores
    UpdateDatabase --> ShowSuccessNotification
    ShowSuccessNotification --> [*]
```
