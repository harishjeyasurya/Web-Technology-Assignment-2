<%-- Conditional messages --%>
<% if (error != null) { %>
<div class="alert alert-error"><%= HtmlUtil.escape(error) %></div>
<% } else if (loggedOut) { %>
<div class="alert alert-success">You have been logged out successfully.</div>
<% } else if (authRequired) { %>
<div class="alert alert-error">Please login first to access the portal.</div>
<% } %>
