# 🛠️ PHP Habit Tracker Toolkit Document

## 1. Title & Objective

**Title:** PHP Habit Tracker

**Objective:** Create a simple habit tracker using plain PHP.

* Technology: PHP
* Reason: Lightweight, easy to run locally, simple file-based storage.
* End goal: Render a web UI that tracks habits with weekly progress.

## 2. Quick Summary of the Technology

**PHP:** Server-side scripting language used for web development.

* Used for: Building dynamic web pages, handling forms, storing and retrieving data.
* Real-world example: WordPress, which runs millions of websites.

## 3. System Requirements

* OS: Linux/Mac/Windows
* Tools: VS Code or any code editor
* PHP CLI installed (version 8.x recommended)
* Web browser

## 4. Installation & Setup Instructions

1. Ensure PHP is installed: `php -v`
2. Navigate to project folder: `cd habit-tracker/app`
3. Run built-in PHP server: `php -S localhost:8000`
4. Open browser at `http://localhost:8000`

## 5. Minimal Working Example

* The main working code is located in `index.php`.
* This handles adding, toggling, and deleting habits.
* Uses JSON file `data.json` for data persistence.
* Renders UI with weekly habit tracking and completion percentage.

## 6. AI Prompt Journal

# AI Prompt Journal – PHP Habit Tracker

### Prompt 1 – Setting up PHP project structure

**Prompt:**
I’m new to PHP. How do I set up a simple project structure for a habit tracker? How should I organize folders and name the files?

**Summary:**
Guidance suggested creating a main project folder (`habit-tracker`) with an `app/` subfolder for core files, a `data.json` file for storing habits, and optionally a `css/` folder for styles. Recommended using `index.php` as the main entry point.

**Evaluation:**
Very helpful for understanding the project skeleton and where each file should go.

---

### Prompt 2 – Naming conventions and best practices

**Prompt:**
What’s a good way to name my PHP files and organize CSS/JS for a small project?

**Summary:**
Recommended keeping `index.php` as the entry point, `style.css` inside a `css/` folder, and any helper PHP files if needed in `includes/`. Encouraged readable names, lowercase with hyphens.

**Evaluation:**
Clear guidance; I renamed my style file to `style.css` and structured folders cleanly.

---

### Prompt 3 – Running PHP built-in server

**Prompt:**
How can I run my PHP habit tracker locally without installing Apache or Nginx?

**Summary:**
Explained using `php -S localhost:8000 -t app` to serve files from the `app/` folder.

**Evaluation:**
Essential; I could view the project in the browser immediately.

---

### Prompt 4 – Setting up JSON data file

**Prompt:**
How do I store and read data in a simple PHP project without a database?

**Summary:**
Suggested using a `data.json` file in the project root and reading/writing via `file_get_contents` and `file_put_contents`.

**Evaluation:**
Perfect; I now understand simple persistent storage without a database.

---

### Prompt 5 – Folder structure visualization

**Prompt:**
Can you show an example of the folder structure for a PHP habit tracker project?

**Summary:**
Example recommended:

```
habit-tracker/
│
├─ app/
│   ├─ index.php
│   └─ data.json
│
├─ css/
│   └─ style.css
└─ README.md
```

**Evaluation:**
Extremely helpful; I now have a mental map of where everything lives.

---

### Prompt 6 – Handling POST requests in PHP

**Prompt:**
How do I add a new habit using a form and handle the POST request in PHP?

**Summary:**
Suggested using `$_SERVER['REQUEST_METHOD'] === 'POST'` and checking `isset($_POST['add'])`. Form data can be retrieved via `$_POST['name']` and added to the JSON file.

**Evaluation:**
Helpful; I now know how to capture user input and persist it.

---

### Prompt 7 – Toggling habit completion

**Prompt:**
How can I mark a habit as done/undone for specific days using PHP?

**Summary:**
Recommended storing each day as a boolean in the JSON object and using a toggle function that flips true/false.

**Evaluation:**
Useful; my weekly habit buttons now work as expected.

---

### Prompt 8 – Displaying progress

**Prompt:**
How do I calculate and display habit completion percentages in PHP?

**Summary:**
Suggested counting completed days and dividing by total days to get a percentage, which can then be displayed in a circular or linear progress bar.

**Evaluation:**
Great; my habit tracker now shows visual progress for each habit.

---

### Prompt 9 – Deleting a habit

**Prompt:**
How can I remove a habit from the tracker in PHP?

**Summary:**
Explained using a `delete` POST action with the habit ID, then filtering it out from the habits array and saving back to JSON.

**Evaluation:**
Very helpful; delete buttons now work without errors.

---

### Prompt 10 – Styling habit tracker

**Prompt:**
What’s the best way to style my habit tracker table, buttons, and progress bars with CSS?

**Summary:**
Recommended creating a separate `style.css` file, using classes for buttons (`completed`/`incomplete`) and progress bars, and using media queries for responsiveness.

**Evaluation:**
Useful; now my habit tracker looks clean, responsive, and interactive.


## 7. Common Issues & Fixes

* **Issue:** PHP parse error from misplaced multi-line comments.

  * **Fix:** Remove or properly format `/* ... */` comments.
* **Issue:** CSS inline in PHP causing messy code.

  * **Fix:** Move all CSS to `style.css` and link it.
* **Issue:** PHP built-in server not starting.

  * **Fix:** Install `php-cli` and ensure `php` command works.
* **Issue:** JSON file not writable.

  * **Fix:** Ensure `data.json` exists and has write permissions.
* **Issue:** Progress bar percentages not displaying correctly.

  * **Fix:** Use integer values for `--progress` in conic-gradient.

## 8. References

* [PHP Official Docs](https://www.php.net/docs.php)
* [CSS Conic Gradient](https://developer.mozilla.org/en-US/docs/Web/CSS/conic-gradient)
* [JSON in PHP](https://www.php.net/manual/en/book.json.php)
* Helpful Blogs: PHP file-based data tutorials
