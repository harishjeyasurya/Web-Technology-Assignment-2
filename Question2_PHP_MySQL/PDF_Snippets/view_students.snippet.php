$sql = 'SELECT s.student_id, s.name, s.roll_number, s.email, s.course, s.mobile,
s.gender, s.profile_image, s.created_at, COUNT(f.file_id) AS total_files
FROM students s
LEFT JOIN student_files f ON f.student_id = s.student_id';
if ($search !== '') {
// Search in several columns using LIKE with a prepared statement
$sql .= ' WHERE s.name LIKE ? OR s.roll_number LIKE ? OR s.email LIKE ? OR s.course LIKE
?';
}
$sql .= ' GROUP BY s.student_id ORDER BY s.student_id DESC';
$stmt = $conn->prepare($sql);
if ($search !== '') {
$like = '%' . $search . '%'; // % = any characters before / after
$stmt->bind_param('ssss', $like, $like, $like, $like);
}
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC); // all rows as an array
$stmt->close();
<?php foreach ($students as $index => $s): ?>
<tr>
<td><?php echo $index + 1; ?></td>
<td>
<!-- Student image preview (thumbnail) -->

<img class="thumb" src="<?php echo e($s['profile_image']); ?>" alt="<?php echo
e($s['name']); ?>">
</td>
<td><?php echo e($s['name']); ?></td>
<td><?php echo e($s['roll_number']); ?></td>
<td><?php echo e($s['email']); ?></td>
<td><?php echo e($s['course']); ?></td>
<td><?php echo e($s['mobile']); ?></td>
<td class="center"><?php echo (int) $s['total_files']; ?></td>
<td class="actions">
<a class="link-btn view" href="student_details.php?id=<?php echo $s['student_id'];
?>">View</a>
<a class="link-btn edit" href="edit_student.php?id=<?php echo $s['student_id'];
?>">Edit</a>
<a class="link-btn upload" href="upload_file.php?id=<?php echo $s['student_id'];
?>">Upload</a>
<!-- Delete uses POST + confirm box so it cannot happen by accident -->
<form method="post" action="delete_student.php" class="inline-form"
onsubmit="return confirm('Delete <?php echo e(addslashes($s['name'])); ?> and all
uploaded files?');">
<input type="hidden" name="student_id" value="<?php echo $s['student_id']; ?>">
<button type="submit" class="link-btn delete">Delete</button>
</form>
</td>
</tr>
<?php endforeach; ?>
