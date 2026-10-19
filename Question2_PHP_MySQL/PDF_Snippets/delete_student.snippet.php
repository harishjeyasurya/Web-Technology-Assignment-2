$paths = [$student['profile_image']];
$stmt = $conn->prepare('SELECT file_path FROM student_files WHERE student_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
$paths[] = $row['file_path'];
}
$stmt->close();
// Delete the database row (student_files rows go with it - CASCADE)
$stmt = $conn->prepare('DELETE FROM students WHERE student_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
// Remove the files from disk (array_unique avoids deleting twice)
foreach (array_unique($paths) as $path) {
remove_file($path);
}
