$stmt = $conn->prepare('SELECT * FROM students WHERE student_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc(); // null when not found
$stmt->close();
<!-- data-mode="edit" tells script.js that password / image are optional -->
<form id="registrationForm" action="update_student.php" method="post"
enctype="multipart/form-data" novalidate data-mode="edit">
<!-- Hidden field carries the id of the student being edited -->
<input type="hidden" name="student_id" value="<?php echo (int) $student['student_id']; ?>">
