<%-- Loop over every file of the student --%>
<% for (StudentFile f : student.getFiles()) { %>
<div class="file-card">
<%-- Conditional logic: image preview OR PDF icon --%>

<% if (f.isImage()) { %>
<img src="FileServlet?id=<%= f.getFileId() %>" alt="<%= HtmlUtil.escape(f.getFileName())
%>">
<% } else if (f.isPdf()) { %>
<div class="pdf-icon">PDF</div>
<% } else { %>
<div class="pdf-icon">FILE</div>
<% } %>
<p class="file-name"><%= HtmlUtil.escape(f.getFileName()) %></p>
<p class="muted"><%= HtmlUtil.escape(f.getFileType()) %></p>
<p class="muted">Uploaded: <%= f.getUploadDate() != null ? fmt.format(f.getUploadDate()) :
"-" %></p>
<div class="file-actions">
<!-- inline view in a new tab, or force download -->
<a href="FileServlet?id=<%= f.getFileId() %>" target="_blank" class="link-btn">View</a>
<a href="FileServlet?id=<%= f.getFileId() %>&amp;download=1" class="link-btn link-
gray">Download</a>
