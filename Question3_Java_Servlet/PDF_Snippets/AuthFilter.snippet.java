// Is somebody logged in?
HttpSession session = request.getSession(false);
boolean loggedIn = session != null && session.getAttribute("admin") != null;
if (loggedIn || isPublic) {
// Stop the browser from caching protected pages,
// so the Back button after logout does not show old data
if (!isPublic) {
response.setHeader("Cache-Control", "no-cache, no-store, must-revalidate");
response.setHeader("Pragma", "no-cache");
response.setDateHeader("Expires", 0);
}
chain.doFilter(req, res); // continue to the requested page
} else {
// Unauthorized -> redirect to the login page
response.sendRedirect(request.getContextPath() + "/login.jsp?auth=required");
}
