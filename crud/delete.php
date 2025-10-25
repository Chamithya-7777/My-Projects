<?php
include "db.php";
$type = $_GET['type'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$table = get_table($type);
if (!$table || !$id) { die("Invalid request."); }

$stmt = $conn->prepare("DELETE FROM $table WHERE s_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: list.php?type=" . urlencode($type));
    exit;
} else {
    echo "Delete failed: " . $stmt->error;
}
?>
