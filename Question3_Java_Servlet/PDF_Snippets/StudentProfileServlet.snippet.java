// id missing or not a number -> back to the list
response.sendRedirect("StudentListServlet");
return;
}
try {
Student student = studentDAO.getStudentById(id);
if (student == null) {
request.setAttribute("error", "No student found with id " + id + ".");
} else {
// Attach the uploaded files to the student object
student.setFiles(fileDAO.getFilesByStudent(id));
request.setAttribute("student", student);
}
} catch (SQLException e) {
log("Profile query failed", e);
request.setAttribute("error", "Could not load the profile: " + e.getMessage());
}
request.getRequestDispatcher("profile.jsp").forward(request, response);
