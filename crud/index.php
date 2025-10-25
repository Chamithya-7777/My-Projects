<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CRUD App - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
        }
        .crud-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.12);
            padding: 40px 32px;
            max-width: 420px;
            margin: 80px auto;
            text-align: center;
        }
        h1 {
            color: #185a9d;
            margin-bottom: 24px;
            letter-spacing: 2px;
        }
        .btn-group-custom .btn {
            margin: 8px 0;
            width: 80%;
            font-size: 1.1em;
            font-weight: 500;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
            transition: transform 0.15s;
        }
        .btn-group-custom .btn:hover {
            transform: scale(1.04);
        }
    </style>
</head>
<body>
    <div class="crud-card">
        <h1>CRUD Application</h1>
        <p class="mb-4">Choose entity to manage:</p>
        <div class="btn-group-custom d-flex flex-column align-items-center">
            <a class="btn btn-primary" href="list.php?type=student">
                <i class="fas fa-user-graduate"></i> Manage Students
            </a>
            <a class="btn btn-info" href="list.php?type=lecturer">
                <i class="fas fa-chalkboard-teacher"></i> Manage Lecturers
            </a>
            <a class="btn btn-secondary" href="list.php?type=course">
                <i class="fas fa-book"></i> Manage Courses
            </a>
        </div>
    </div>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>