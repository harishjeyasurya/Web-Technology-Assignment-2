// ---- Database settings (default XAMPP values) ----
define('DB_HOST', 'localhost'); // MySQL server address
define('DB_USER', 'root'); // XAMPP default user
define('DB_PASS', ''); // XAMPP default password is empty
define('DB_NAME', 'student_portal'); // database created by student_portal.sql
// Start the session only once (needed for success / error messages)
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
// Make mysqli throw exceptions instead of silent warnings,
// so every SQL error can be caught with try / catch.

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
// Create the connection object
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// utf8mb4 = full Unicode support for names and addresses
$conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $ex) {
// SQL error handling: show a friendly message and stop the script
http_response_code(500);
echo '<div style="font-family:Arial;max-width:600px;margin:40px auto;padding:20px;'
. 'border:1px solid #c62828;background:#fff6f6;color:#c62828;border-radius:6px">'
. '<h3>Database connection failed</h3>'
. '<p>Please make sure MySQL is running in XAMPP and the database '
. '<b>student_portal</b> has been imported.</p>'
. '<p><small>Details: ' . htmlspecialchars($ex->getMessage()) . '</small></p></div>';
exit; // nothing else can work without a database
}
