public Admin validateLogin(String username, String password) throws SQLException {
String sql = "SELECT admin_id, username, full_name FROM admin "
+ "WHERE username = ? AND password = SHA2(?, 256)";
// try-with-resources closes the connection, statement and result set automatically
try (Connection con = DBConnection.getConnection();
PreparedStatement ps = con.prepareStatement(sql)) {
// PreparedStatement parameters prevent SQL injection
ps.setString(1, username);
ps.setString(2, password);
try (ResultSet rs = ps.executeQuery()) {
if (rs.next()) { // a matching row means valid login
return new Admin(
rs.getInt("admin_id"),
rs.getString("username"),
rs.getString("full_name"));
}
}
}
return null; // wrong username or password
