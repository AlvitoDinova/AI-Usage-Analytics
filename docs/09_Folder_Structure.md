# Project Folder Structure - AInsight (PHP Native)

This document describes the directory organization and file structure of the AInsight web application, complying with standard custom MVC conventions.

---

## 1. Project Directory Layout

The application is structured as follows:

```
AInsight/
├── app/                        # Application Core Logic (MVC)
│   ├── controllers/            # Request handlers
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── AIController.php
│   │   ├── CriteriaController.php
│   │   ├── AssessmentController.php
│   │   └── ProfileController.php
│   ├── models/                 # Database Query Logic
│   │   ├── User.php
│   │   ├── AITool.php
│   │   ├── Criterion.php
│   │   ├── Weight.php
│   │   ├── Assessment.php
│   │   ├── History.php
│   │   └── Topsis.php          # Mathematical TOPSIS Service Engine
│   └── views/                  # UI Layout & View templates
│       ├── layouts/            # Shared headers, footers, sidebars
│       │   ├── header.php
│       │   ├── footer.php
│       │   └── sidebar.php
│       ├── auth/               # Access views
│       │   ├── login.php
│       │   └── register.php
│       ├── admin/              # Administrator-only views
│       │   ├── dashboard.php
│       │   ├── ai.php
│       │   ├── criteria.php
│       │   ├── matrix.php
│       │   └── users.php
│       ├── user/               # Standard user views
│       │   ├── dashboard.php
│       │   ├── assess.php
│       │   ├── result.php
│       │   ├── history.php
│       │   └── profile.php
│       └── landing.php         # Public Landing Page
├── config/                     # Configuration files
│   └── Database.php            # PDO Database Connection Singleton class
├── database/                   # Database schemas
│   └── Database.sql            # Complete MySQL Schema DDL & Seeds script
├── public/                     # Public Document Root (Web Server Target)
│   ├── assets/                 # Client assets
│   │   ├── css/
│   │   │   └── style.css       # Custom palette definitions and tweaks
│   │   ├── js/
│   │   │   └── main.js         # AJAX request logic & validations
│   │   └── images/             # Uploaded icons and illustrations
│   └── index.php               # Front Controller (Entry point & Routing)
├── README.md                   # Installation & methodology manual
└── TOPSIS_GUIDE.md             # Detailed guide explaining TOPSIS steps
```

---

## 2. Dynamic Routing Flow (index.php Front Controller)

Since this is a PHP Native application, we use a single entry point: `public/index.php`. 
- Every web request (e.g. `http://localhost/AInsight/public/index.php?page=assess` or URL rewritten structures) is received by `index.php`.
- `index.php` loads the database configurations, registers the session, sets up security validation (CSRF & login state), and routes the request to the matching controller method.
- The controller instantiates the required models, fetches parameters, triggers logical actions (like executing TOPSIS), sets view variables, and includes the appropriate file inside `app/views/`.
