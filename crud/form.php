<?php
include "db.php";
$type = $_GET['type'] ?? 'student';
$table = get_table($type);
if (!$table) { die("Invalid type."); }

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$editing = false;
$values = [];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE s_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $values = $res->fetch_assoc() ?: [];
    $editing = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= ucfirst($type) ?> Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2><?= $editing ? "Edit" : "Add" ?> <?= ucfirst($type) ?></h2>
    <form action="save.php" method="post">
        <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= (int)$id ?>">
        <?php endif; ?>

        <?php if ($type == 'student'):
            $hobbiesSelected = [];
            if (!empty($values['hobbies'])) $hobbiesSelected = array_map('trim', explode(',', $values['hobbies']));
            $courses = $conn->query("SELECT course_name FROM courses")->fetch_all(MYSQLI_ASSOC);
        ?>
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" name="first_name" required value="<?= htmlspecialchars($values['first_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" name="last_name" required value="<?= htmlspecialchars($values['last_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input class="form-control" name="age" type="number" required value="<?= htmlspecialchars($values['age'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" type="email" required value="<?= htmlspecialchars($values['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Gender</label><br>
                <?php foreach (['Male','Female','Other'] as $g): ?>
                    <label class="mr-2">
                        <input type="radio" name="gender" value="<?= $g ?>" <?= (isset($values['gender']) && $values['gender']==$g) ? 'checked' : '' ?>> <?= $g ?>
                    </label>
                <?php endforeach; ?>
            </div>

             <div class="form-group">
                <label>Course</label>
                <select name="intake" class="form-control">
                    <option value="">-- Select --</option>
                    <?php foreach (['Computer Science','Business Management','	Information Technology'] as $int): ?>
                        <option value="<?= $int ?>" <?= (isset($values['intake']) && $values['intake']==$int) ? 'selected' : '' ?>><?= $int ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Intake</label>
                <select name="intake" class="form-control">
                    <option value="">-- Select --</option>
                    <?php foreach (['Jan 2025','May 2025','Sep 2025'] as $int): ?>
                        <option value="<?= $int ?>" <?= (isset($values['intake']) && $values['intake']==$int) ? 'selected' : '' ?>><?= $int ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Hobbies (choose any)</label><br>
                <?php foreach (['Reading','Sports','Music','Coding'] as $h): ?>
                    <label class="mr-2">
                        <input type="checkbox" name="hobbies[]" value="<?= $h ?>" <?= in_array($h, $hobbiesSelected) ? 'checked' : '' ?>> <?= $h ?>
                    </label>
                <?php endforeach; ?>
            </div>

        <?php elseif ($type == 'lecturer'): ?>
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" required value="<?= htmlspecialchars($values['name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" type="email" required value="<?= htmlspecialchars($values['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Department</label>
                <input class="form-control" name="department" value="<?= htmlspecialchars($values['department'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Specialization</label>
                <input class="form-control" name="specialization" value="<?= htmlspecialchars($values['specialization'] ?? '') ?>">
            </div>

        <?php elseif ($type == 'course'): ?>
            <div class="form-group">
                <label>Course Name</label>
                <input class="form-control" name="course_name" required value="<?= htmlspecialchars($values['course_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Credit Score</label>
                <input class="form-control" name="credit_score" type="number" required value="<?= htmlspecialchars($values['credit_score'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Duration</label>
                <input class="form-control" name="duration" value="<?= htmlspecialchars($values['duration'] ?? '') ?>">
            </div>
        <?php endif; ?>

        <button class="btn btn-success" type="submit"><?= $editing ? 'Update' : 'Save' ?></button>
        <a class="btn btn-secondary" href="list.php?type=<?= $type ?>">Back</a>
    </form>
</div>
</body>
</html>
