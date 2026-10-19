public List<StudentFile> getFilesByStudent(int studentId) throws SQLException {
String sql = "SELECT * FROM student_files WHERE student_id = ? "
+ "ORDER BY upload_date DESC, file_id DESC";
List<StudentFile> list = new ArrayList<>();
try (Connection con = DBConnection.getConnection();
PreparedStatement ps = con.prepareStatement(sql)) {
ps.setInt(1, studentId);
try (ResultSet rs = ps.executeQuery()) {
while (rs.next()) {
list.add(mapRow(rs));
}
}
}
return list;
