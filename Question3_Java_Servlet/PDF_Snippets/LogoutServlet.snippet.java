session.invalidate(); // removes "admin" and every other attribute
}
// Message is shown by login.jsp
response.sendRedirect("login.jsp?logout=1");
