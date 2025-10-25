<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$type = $_POST['type'] ?? '';
$table = get_table($type);
if (!$table) die("Invalid type");

$id = isset($_POST['id']) ? intval($_POST['id']) : null;

if ($type === 'student') {
    $first = $_POST['first_name'] ?? '';
    $last  = $_POST['last_name'] ?? '';
    $age   = intval($_POST['age'] ?? 0);
    $email = $_POST['email'] ?? '';
    $gender= $_POST['gender'] ?? '';
    $course= $_POST['course'] ?? '';
    $intake= $_POST['intake'] ?? '';
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : '';

    if ($id) {
        $sql = "UPDATE students SET first_name=?, last_name=?, age=?, email=?, gender=?, course=?, intake=?, hobbies=? WHERE s_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssssi", $first, $last, $age, $email, $gender, $course, $intake, $hobbies, $id);
    } else {
        $sql = "INSERT INTO students (first_name,last_name,age,email,gender,course,intake,hobbies) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisssss", $first, $last, $age, $email, $gender, $course, $intake, $hobbies);
    }
}

elseif ($type === 'lecturer') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $dept = $_POST['department'] ?? '';
    $spec = $_POST['specialization'] ?? '';

    if ($id) {
        $sql = "UPDATE lecturers SET name=?, email=?, department=?, specialization=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $dept, $spec, $id);
    } else {
        $sql = "INSERT INTO lecturers (name,email,department,specialization) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $dept, $spec);
    }
}

elseif ($type === 'course') {
    $cname = $_POST['course_name'] ?? '';
    $credit = intval($_POST['credit_score'] ?? 0);
    $duration = $_POST['duration'] ?? '';

    if ($id) {
        $sql = "UPDATE courses SET course_name=?, credit_score=?, duration=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $cname, $credit, $duration, $id);
    } else {
        $sql = "INSERT INTO courses (course_name,credit_score,duration) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $cname, $credit, $duration);
    }
}

else {
    die("Type handler missing");
}

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if ($stmt->execute()) {
    header("Location: list.php?type=" . urlencode($type));
    exit;
} else {
    echo "DB error: " . $stmt->error;
}
