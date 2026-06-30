# Business Requirement Document (BRD) - AInsight (PHP Native)

## 1. Executive Summary
**AInsight** is a web-based Decision Support System (DSS / Sistem Pendukung Keputusan) designed to help creative teams at **Notch Creative Agency, Tangerang Selatan** choose the most appropriate Artificial Intelligence (AI) tools for specific tasks and projects. 

Using the **TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)** method, the system calculates and ranks AI tool alternatives based on pre-evaluated criteria scores and dynamic user preferences. The application aims to bring objectivity, efficiency, and clarity to the selection of AI tools in creative workflows.

## 2. Business Background & Problem Statement
Notch Creative Agency incorporates a wide range of AI tools into daily operations. These tools support diverse categories such as Copywriting, Graphic Design, Social Media Content, Video Editing, Motion Graphics, Brainstorming, Coding, Presentations, Research, and Image Generation.

However, the agency faces several challenges:
1. **Inefficient Tool Selection**: Employees often spend excessive time testing different AI platforms to find one suited for their specific task requirements.
2. **Subjective Preferences**: Decisions regarding which AI to use are based on personal preference rather than objective task demands (such as cost, output quality, ease of use, response speed, or feature completeness).
3. **Underutilization of Paid Tools**: The agency subscribes to premium platforms (e.g., Midjourney, Claude, ChatGPT, Cursor), but employees are not always aware of which tool delivers the best performance for their specific task context.

AInsight addresses these challenges by serving as an objective selection system. It matches the user's task requirements against expert ratings of registered AI tools to recommend the optimal tool.

## 3. Project Objectives
- **Centralized AI Directory**: Build a managed repository of active AI tools used within the creative agency.
- **Objective Mathematical Ranking**: Implement the complete TOPSIS algorithm to rank AI tools based on custom criteria values and weights.
- **Interactive Evaluation**: Allow creative workers to input their task requirements (criteria importance weights) and instantly receive ranked suggestions with explanation.
- **Academic Transparency**: Display all mathematical steps of the TOPSIS calculation to serve as empirical material for the thesis.

## 4. Scope of the System
### In Scope:
- **User Authentication & Role Management**: Secure access for Admin and standard Users.
- **AI Tool Alternative Management**: CRUD interface for Admin to manage the list of AI tools (ChatGPT, Gemini, Claude, Copilot, Perplexity, DeepSeek, Grok, Meta AI, Midjourney, Leonardo AI, Canva AI, Gamma, NotebookLM).
- **Criteria & Weight Settings**: CRUD interface for Admin to define the decision criteria (e.g., Harga, Kemudahan, Kecepatan, Kualitas, Fitur) and default weights.
- **Assessment Matrix (Pre-Evaluations)**: Admin interface to evaluate each AI tool against all criteria.
- **Selection Assessment Flow**: Interactive form where users input their project needs, setting weights for each criterion.
- **TOPSIS Engine**: Calculation and visualization of intermediate steps (raw matrix, normalized matrix, weighted normalized matrix, positive/negative ideal solutions, separation distance, preference value, and ranking).
- **History Logs**: Detailed log of past assessments and recommendations.
- **Statistical Dashboard**: Summary charts displaying tool popularity, user activity, and calculation trends.

### Out of Scope:
- Automated web scraping of pricing structures.
- Direct integration with AI APIs for content generation.

## 5. Stakeholders & User Personas
| Role | Responsibility | Main Goal in System |
|---|---|---|
| **Admin** | System Parameter Control | Manages users, AI list, criteria, default weights, and pre-rated tool scores. |
| **User (Creative Staff)** | AI Tool Selection | Inputs task requirements, views TOPSIS recommendations, looks at calculation steps, and reviews history. |

## 6. Key Success Metrics (KPIs)
- **Mathematical Accuracy**: 100% agreement between system calculations and manual TOPSIS calculations.
- **Onboarding Speed**: Creative employees can configure project needs and get AI rankings in under 30 seconds.
- **Traceability**: All 9 steps of the TOPSIS process are clearly displayed on the calculation review page.
