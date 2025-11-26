<?php

define('DATA_FILE', __DIR__ . '/data.json');
define('DAYS_OF_WEEK', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);


 
function loadHabits(): array {
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    $json = file_get_contents(DATA_FILE);
    return json_decode($json, true) ?: [];
}

/**
 * Save habits to JSON file
 */
function saveHabits(array $habits): void {
    file_put_contents(DATA_FILE, json_encode(array_values($habits), JSON_PRETTY_PRINT));
}


function generateId(array $habits): int {
    if (empty($habits)) {
        return 1;
    }
    $lastHabit = end($habits);
    return $lastHabit['id'] + 1;
}

/**
 * Create initial days array for new habit
 */
function createDaysArray(): array {
    return array_fill_keys(DAYS_OF_WEEK, false);
}

/**
 * Add a new habit
 */
function addHabit(array &$habits, string $name): void {
    $name = trim($name);
    if ($name === '') {
        return;
    }
    
    $habits[] = [
        'id' => generateId($habits),
        'name' => $name,
        'days' => createDaysArray(),
        'created_at' => date('Y-m-d H:i:s')
    ];
}

/**
 * Toggle a specific day for a habit
 */
function toggleDay(array &$habits, int $id, string $day): void {
    foreach ($habits as &$habit) {
        if ($habit['id'] === $id && isset($habit['days'][$day])) {
            $habit['days'][$day] = !$habit['days'][$day];
            break;
        }
    }
}

/**
 * Delete a habit by ID
 */
function deleteHabit(array &$habits, int $id): void {
    $habits = array_filter($habits, fn($h) => $h['id'] !== $id);
}

/**
 * Calculate completion percentage for a habit
 */
function getCompletionPercentage(array $days): int {
    $completed = count(array_filter($days));
    $total = count($days);
    return $total > 0 ? round(($completed / $total) * 100) : 0;
}


$habits = loadHabits();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new habit
    if (isset($_POST['add']) && isset($_POST['name'])) {
        addHabit($habits, $_POST['name']);
        saveHabits($habits);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Toggle day completion
    if (isset($_POST['toggle']) && isset($_POST['id']) && isset($_POST['day'])) {
        toggleDay($habits, (int)$_POST['id'], $_POST['day']);
        saveHabits($habits);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Delete habit
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        deleteHabit($habits, (int)$_POST['id']);
        saveHabits($habits);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Tracker - PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
        
        h1 {
            color: #667eea;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2.5em;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        
        .add-form {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .add-form input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .add-form input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .habit-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .habit-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
        
        .habit-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        
        .habit-name {
            text-align: left;
            font-weight: 500;
            color: #212529;
        }
        
        .day-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
        }
        
        .day-btn.completed {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }
        
        .day-btn.incomplete {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #adb5bd;
        }
        
        .day-btn:hover {
            transform: scale(1.1);
        }
        
        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .progress-bar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: conic-gradient(#667eea var(--progress), #e9ecef 0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #495057;
            position: relative;
        }
        
        .progress-bar::before {
            content: '';
            position: absolute;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: white;
        }
        
        .progress-bar span {
            position: relative;
            z-index: 1;
            font-size: 14px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            .habit-table th,
            .habit-table td {
                padding: 8px 4px;
                font-size: 12px;
            }
            
            .day-btn {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 Habit Tracker</h1>
        <p class="subtitle">Build better habits, one day at a time</p>
        
        <!-- Add Habit Form -->
        <form method="POST" class="add-form">
            <input 
                type="text" 
                name="name" 
                placeholder="Enter a new habit (e.g., Morning workout, Read 30 minutes)" 
                required
                autofocus
            >
            <button type="submit" name="add" class="btn btn-primary">Add Habit</button>
        </form>

        <?php if (empty($habits)): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <h3>No habits yet!</h3>
                <p>Start by adding your first habit above.</p>
            </div>
        <?php else: ?>
            <!-- Habits Table -->
            <table class="habit-table">
                <thead>
                    <tr>
                        <th>Habit</th>
                        <?php foreach(DAYS_OF_WEEK as $day): ?>
                            <th><?= substr($day, 0, 3) ?></th>
                        <?php endforeach; ?>
                        <th>Progress</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($habits as $habit): ?>
                        <?php $completion = getCompletionPercentage($habit['days']); ?>
                        <tr>
                            <td class="habit-name"><?= htmlspecialchars($habit['name']) ?></td>
                            
                            <?php foreach(DAYS_OF_WEEK as $day): ?>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $habit['id'] ?>">
                                        <input type="hidden" name="day" value="<?= $day ?>">
                                        <button 
                                            type="submit" 
                                            name="toggle" 
                                            class="day-btn <?= $habit['days'][$day] ? 'completed' : 'incomplete' ?>"
                                            title="Toggle <?= $day ?>"
                                        >
                                            <?= $habit['days'][$day] ? '✓' : '○' ?>
                                        </button>
                                    </form>
                                </td>
                            <?php endforeach; ?>
                            
                            <td>
                                <div class="progress-bar" style="--progress: <?= $completion ?>%">
                                    <span><?= $completion ?>%</span>
                                </div>
                            </td>
                            
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $habit['id'] ?>">
                                    <button type="submit" name="delete" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>