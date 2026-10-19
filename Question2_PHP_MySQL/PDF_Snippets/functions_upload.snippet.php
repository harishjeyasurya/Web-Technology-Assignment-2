// 2. File size validation
if ($file['size'] > MAX_FILE_SIZE) {
return ['ok' => false, 'error' => 'File "' . $file['name'] . '" exceeds the 2 MB limit.'];
}
if ($file['size'] === 0) {
return ['ok' => false, 'error' => 'File "' . $file['name'] . '" is empty.'];
}
// 3. Extension validation
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowedExt, true)) {
return ['ok' => false, 'error' => 'Invalid file type ".' . $ext . '". Allowed: ' .
strtoupper(implode(', ', $allowedExt)) . '.'];
}
// 4. Real content type check (a .exe renamed to .jpg is rejected)
$mime = '';
if (function_exists('finfo_open')) {
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);
} elseif (function_exists('mime_content_type')) {
$mime = mime_content_type($file['tmp_name']);
}
if ($mime !== '' && !in_array($mime, ALLOWED_MIME[$ext], true)) {
return ['ok' => false, 'error' => 'File "' . $file['name'] . '" content does not match its
extension.'];
}
if ($mime === '') {
$mime = ALLOWED_MIME[$ext][0]; // fallback when fileinfo is disabled
}
// 5. Images go to uploads/images, PDFs go to uploads/documents
$folder = ($ext === 'pdf') ? 'uploads/documents/' : 'uploads/images/';
if (!is_dir(__DIR__ . '/' . $folder)) {
mkdir(__DIR__ . '/' . $folder, 0755, true); // create folder if missing
}
// Clean the original name: keep only letters, numbers, dot, dash, underscore
$baseName = pathinfo($file['name'], PATHINFO_FILENAME);
$baseName = preg_replace('/[^A-Za-z0-9_-]/', '_', $baseName);
$baseName = substr($baseName, 0, 50);
// Timestamp prefix -> unique name -> files are never overwritten
$newName = time() . '_' . $baseName . '.' . $ext;
$counter = 1;
while (file_exists(__DIR__ . '/' . $folder . $newName)) {
$newName = time() . '_' . $baseName . '_' . $counter . '.' . $ext;
$counter++;
}
// 6. Move the temporary file to its permanent place
if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/' . $folder . $newName)) {
return ['ok' => false, 'error' => 'Could not save "' . $file['name'] . '". Check folder
permissions.'];
}
return [
'ok' => true,
'name' => $newName, // stored file name
'path' => $folder . $newName, // relative path saved in MySQL
'type' => $mime, // MIME type saved in MySQL
