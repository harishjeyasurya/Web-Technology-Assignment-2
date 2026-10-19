if (admin != null) {
// Remove any old session (prevents session-fixation attacks)
HttpSession oldSession = request.getSession(false);
if (oldSession != null) {
oldSession.invalidate();
}
// ---- Session creation ----
HttpSession session = request.getSession(true);
session.setAttribute("admin", admin); // marks the user as logged in
session.setMaxInactiveInterval(30 * 60); // auto logout after 30 minutes idle
// Redirect (not forward) so refreshing the page does not re-submit the form
response.sendRedirect("DashboardServlet");
} else {
// Wrong credentials -> back to login page with a message
request.setAttribute("error", "Invalid username or password.");
request.setAttribute("username", username);
request.getRequestDispatcher("login.jsp").forward(request, response);
