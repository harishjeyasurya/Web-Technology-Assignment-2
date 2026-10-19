<%-- Loop: one card for every student --%>
<% for (Student s : students) { %>
<div class="student-card">
<!-- <img> tag points to the Servlet, which streams the photo -->
<img src="FileServlet?photo=<%= s.getStudentId() %>" alt="<%= HtmlUtil.escape(s.getName())
%>">
<h3><%= HtmlUtil.escape(s.getName()) %></h3>
<p class="roll"><%= HtmlUtil.escape(s.getRollNumber()) %></p>
<p><%= HtmlUtil.escape(s.getCourse()) %></p>
<p class="muted"><%= HtmlUtil.escape(s.getEmail()) %></p>
<%-- Different badge text depending on the number of files --%>
<% if (s.getFileCount() == 0) { %>
<span class="badge badge-gray">No documents</span>
<% } else if (s.getFileCount() == 1) { %>
<span class="badge">1 document</span>
<% } else { %>
<span class="badge"><%= s.getFileCount() %> documents</span>
<% } %>
<a href="StudentProfileServlet?id=<%= s.getStudentId() %>" class="btn btn-primary btn-
block">View Profile</a>
