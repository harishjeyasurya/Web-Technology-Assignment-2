private static final String URL =
"jdbc:mysql://localhost:3306/student_portal"
+ "?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=Asia/Kolkata";
// Default XAMPP credentials (change if your MySQL has a password)
private static final String USER = "root";
private static final String PASSWORD = "";
// Fully qualified name of the MySQL JDBC driver class
private static final String DRIVER = "com.mysql.cj.jdbc.Driver";
// Static block runs once when the class is first used: loads the driver
static {
try {
Class.forName(DRIVER);
} catch (ClassNotFoundException e) {
// Clear message when the connector jar is missing from WEB-INF/lib
throw new ExceptionInInitializerError(
"MySQL JDBC driver not found. Copy mysql-connector-j.jar into WEB-INF/lib. " +
e);

}
}
// Private constructor: this class only has static methods
private DBConnection() {
}
/**
* Opens a new connection to the student_portal database.
* The caller must close it (we use try-with-resources everywhere).
*
* @return an open JDBC Connection
* @throws SQLException when MySQL is not running or credentials are wrong
*/
public static Connection getConnection() throws SQLException {
return DriverManager.getConnection(URL, USER, PASSWORD);
}
