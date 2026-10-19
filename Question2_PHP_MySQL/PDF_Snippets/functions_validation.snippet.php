// Roll number format: 2 digits + 2-3 capital letters + 3 digits (24CS077)
if (!preg_match('/^[0-9]{2}[A-Z]{2,3}[0-9]{3}$/', $data['roll_number'])) {
$errors[] = 'Roll number format is invalid (example: 24CS077).';
}
// E-mail format using PHP's built-in filter
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
$errors[] = 'Email address is not valid.';
}
// Password strength (only when a password was typed)
if ($data['password'] !== '') {
if (strlen($data['password']) < 8
|| !preg_match('/[A-Z]/', $data['password'])
|| !preg_match('/[a-z]/', $data['password'])
|| !preg_match('/[0-9]/', $data['password'])) {
$errors[] = 'Password must have at least 8 characters with one uppercase, one
lowercase and one number.';
