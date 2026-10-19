public List<Student> getAllStudents() throws SQLException {
String sql = BASE_SELECT + "GROUP BY s.student_id ORDER BY s.student_id DESC";
List<Student> list = new ArrayList<>();
try (Connection con = DBConnection.getConnection();
PreparedStatement ps = con.prepareStatement(sql);
ResultSet rs = ps.executeQuery()) {
// Loop through every row and convert it into a Student object
while (rs.next()) {
list.add(mapRow(rs));
}
}
return list;
private Student mapRow(ResultSet rs) throws SQLException {
Student s = new Student();
s.setStudentId(rs.getInt("student_id"));
s.setName(rs.getString("name"));
s.setRollNumber(rs.getString("roll_number"));
s.setEmail(rs.getString("email"));
s.setCourse(rs.getString("course"));
s.setMobile(rs.getString("mobile"));
s.setGender(rs.getString("gender"));
s.setAddress(rs.getString("address"));
s.setProfileImage(rs.getString("profile_image"));
s.setCreatedAt(rs.getTimestamp("created_at"));
s.setFileCount(rs.getInt("file_count"));
return s;
