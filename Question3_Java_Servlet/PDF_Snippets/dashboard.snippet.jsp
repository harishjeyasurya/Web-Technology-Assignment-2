<% for (Student s : recent) { %>
<tr>
<!-- Image streamed by FileServlet using the student id -->
<td><img class="thumb" src="FileServlet?photo=<%= s.getStudentId() %>" alt="photo"></td>
<td><%= HtmlUtil.escape(s.getName()) %></td>
<td><%= HtmlUtil.escape(s.getRollNumber()) %></td>
<td><%= HtmlUtil.escape(s.getCourse()) %></td>
<td><%= s.getCreatedAt() != null ? fmt.format(s.getCreatedAt()) : "-" %></td>
<td><a class="link-btn" href="StudentProfileServlet?id=<%= s.getStudentId()
%>">View</a></td>
</tr>
<% } %>
