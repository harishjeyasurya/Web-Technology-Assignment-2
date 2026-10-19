// Conditional logic: search only when text was typed
if (search != null && !search.trim().isEmpty()) {
students = studentDAO.searchStudents(search.trim());
} else {
students = studentDAO.getAllStudents();
}
} catch (SQLException e) {
log("Student list query failed", e);
request.setAttribute("error", "Could not load students: " + e.getMessage());
}
// Send the data to the JSP page
request.setAttribute("students", students);
request.setAttribute("search", search == null ? "" : search.trim());
request.getRequestDispatcher("students.jsp").forward(request, response);
