# TOPSIS Mathematical Methodology - AInsight

This document explains the mathematical foundations of the **TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)** method used in the evaluation engine of AInsight.

## 1. Overview of TOPSIS
TOPSIS is a multi-criteria decision-making (MCDM) method first developed by Ching-Lai Hwang and Kwangsun Yoon in 1981. 

The core principle is simple: **the chosen alternative should have the shortest geometric distance to the positive ideal solution ($A^+$) and the longest geometric distance from the negative ideal solution ($A^-$).**

---

## 2. Mathematical Steps

Let $m$ be the number of alternatives (options) and $n$ be the number of criteria (parameters).

### Step 1: Establish the Raw Decision Matrix ($X$)
Construct the initial decision matrix $X_{m \times n}$ where $x_{ij}$ represents the rating of alternative $A_i$ ($i = 1, 2, \dots, m$) with respect to criterion $C_j$ ($j = 1, 2, \dots, n$):

$$X = \begin{pmatrix} 
x_{11} & x_{12} & \cdots & x_{1n} \\
x_{21} & x_{22} & \cdots & x_{2n} \\
\vdots & \vdots & \ddots & \vdots \\
x_{m1} & x_{m2} & \cdots & x_{mn} 
\end{pmatrix}$$

### Step 2: Normalize the Decision Matrix ($R$)
Normalize the decision matrix to transform different dimensional units into comparable dimensionless scales. Vector normalization is calculated as:

$$r_{ij} = \frac{x_{ij}}{\sqrt{\sum_{k=1}^m x_{kj}^2}}, \quad i=1,\dots,m; \quad j=1,\dots,n$$

This yields the normalized matrix $R$:

$$R = (r_{ij})_{m \times n}$$

### Step 3: Calculate the Weighted Normalized Decision Matrix ($V$)
Incorporate the importance weights of the criteria $W = (w_1, w_2, \dots, w_n)$ where $\sum_{j=1}^n w_j = 1$:

$$v_{ij} = r_{ij} \cdot w_j$$

This yields the weighted normalized matrix $V$:

$$V = (v_{ij})_{m \times n}$$

### Step 4: Determine the Ideal ($A^+$) and Negative-Ideal ($A^-$) Solutions
Identify the target ideal performance values for each criterion:

- **Positive Ideal Solution ($A^+$)** (maximizing benefits, minimizing costs):
  $$A^+ = (v_1^+, v_2^+, \dots, v_n^+)$$
  Where:
  $$v_j^+ = \begin{cases} 
  \max_i v_{ij} & \text{if } j \text{ is a benefit criterion} \\
  \min_i v_{ij} & \text{if } j \text{ is a cost criterion}
  \end{cases}$$

- **Negative-Ideal Solution ($A^-$)** (minimizing benefits, maximizing costs):
  $$A^- = (v_1^-, v_2^-, \dots, v_n^-)$$
  Where:
  $$v_j^- = \begin{cases} 
  \min_i v_{ij} & \text{if } j \text{ is a benefit criterion} \\
  \max_i v_{ij} & \text{if } j \text{ is a cost criterion}
  \end{cases}$$

### Step 5: Calculate the Separation Measures
Compute the Euclidean distance of each alternative from the positive ideal and negative ideal solutions:

- **Distance from Positive Ideal Solution ($S_i^+$)**:
  $$S_i^+ = \sqrt{\sum_{j=1}^n (v_{ij} - v_j^+)^2}, \quad i=1,\dots,m$$

- **Distance from Negative-Ideal Solution ($S_i^-$)**:
  $$S_i^- = \sqrt{\sum_{j=1}^n (v_{ij} - v_j^-)^2}, \quad i=1,\dots,m$$

### Step 6: Calculate the Relative Closeness to the Ideal Solution ($C_i^*$)
The relative closeness coefficient ($C_i^*$) indicates the closeness rating of alternative $A_i$. It is bounded between $0$ and $1$:

$$C_i^* = \frac{S_i^-}{S_i^+ + S_i^-}, \quad i=1,\dots,m$$

- $C_i^* = 1$ if alternative $A_i$ is at the positive ideal solution.
- $C_i^* = 0$ if alternative $A_i$ is at the negative ideal solution.

### Step 7: Rank the Alternatives
Sort alternatives in **descending order** of $C_i^*$. The option with the largest relative closeness coefficient ($C_i^*$) is the best choice.
