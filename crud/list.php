<?php
include "db.php";
$type = $_GET['type'] ?? 'student';
$table = get_table($type);
if (!$table) die("Invalid type");

$res = $conn->query("SELECT * FROM $table");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= ucfirst($type) ?> List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
        }
        .table-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(44,62,80,0.10);
            padding: 32px 24px;
            margin-top: 40px;
        }
        .table th {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            font-size: 1em;
        }
        .action-btn {
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: 1.1em;
        }
        .action-btn.edit {
            background: #ffc107;
            color: #fff;
            border: none;
        }
        .action-btn.edit:hover {
            background: #ff9800;
            color: #fff;
        }
        .action-btn.delete {
            background: #dc3545;
            color: #fff;
            border: none;
        }
        .action-btn.delete:hover {
            background: #b71c1c;
            color: #fff;
        }
    </style>
</head>
<body class="p-4">
<div class="container table-container">
    <h2 class="mb-4 text-center"><?= ucfirst($type) ?> List</h2>
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-primary" href="form.php?type=<?= $type ?>">
            <i class="fas fa-plus"></i> Add New <?= ucfirst($type) ?>
        </a>
        <a class="btn btn-link" href="index.php">Back to Home</a>
    </div>

    <?php if (!$res || $res->num_rows == 0): ?>
        <div class="alert alert-info">No records found.</div>
    <?php else: ?>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <?php foreach ($res->fetch_fields() as $f): ?>
                        <th><?= htmlspecialchars($f->name) ?></th>
                    <?php endforeach; ?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <?php foreach ($row as $val): ?>
                            <td><?= htmlspecialchars($val) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a class="btn btn-sm btn-warning" href="form.php?type=<?= $type ?>&id=<?= $row['s_id'] ?>">Edit</a>
                            <a class="btn btn-sm btn-danger" href="delete.php?type=<?= $type ?>&id=<?= $row['s_id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>

                            

                            


                            
                        </td>
                       
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>




