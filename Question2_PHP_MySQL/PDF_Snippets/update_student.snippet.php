$stmt->bind_param('ssi', $data['roll_number'], $data['email'], $id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
$errors[] = 'Another student already uses this roll number or email.';
}
$stmt->close();
if ($data['password'] !== '') {
// Password was typed -> update it as well
$hash = hash('sha256', $data['password']);
$stmt = $conn->prepare(
'UPDATE students SET name=?, roll_number=?, email=?, password=?, course=?, mobile=?,
gender=?, address=?, profile_image=? WHERE student_id=?'
);
$stmt->bind_param('sssssssssi', $data['name'], $data['roll_number'], $data['email'],
$hash,
$data['course'], $data['mobile'], $data['gender'], $data['address'], $imagePath, $id);
} else {
// Keep the existing password
$stmt = $conn->prepare(
'UPDATE students SET name=?, roll_number=?, email=?, course=?, mobile=?,
gender=?, address=?, profile_image=? WHERE student_id=?'
);
$stmt->bind_param('ssssssssi', $data['name'], $data['roll_number'], $data['email'],
$data['course'], $data['mobile'], $data['gender'], $data['address'], $imagePath, $id);
}
$stmt->execute();
