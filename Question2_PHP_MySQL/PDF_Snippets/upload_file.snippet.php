$saved = save_upload($_FILES['document'], DOCUMENT_EXTENSIONS);
if (!$saved['ok']) {
$errors[] = $saved['error'];
} else {
try {
// Store file metadata linked to the student (foreign key)
$stmt = $conn->prepare(
'INSERT INTO student_files (student_id, file_name, file_path, file_type) VALUES
(?, ?, ?, ?)'
);
$stmt->bind_param('isss', $selectedId, $saved['name'], $saved['path'],
$saved['type']);
$stmt->execute();
$stmt->close();
set_flash('success', 'File <b>' . e($saved['name']) . '</b> uploaded for ' .
e($owner['name']) . '.');
header('Location: student_details.php?id=' . $selectedId);
exit;
} catch (mysqli_sql_exception $ex) {
// SQL error: remove the saved file so disk and DB stay in sync
remove_file($saved['path']);
$errors[] = 'Could not save file details: ' . $ex->getMessage();
