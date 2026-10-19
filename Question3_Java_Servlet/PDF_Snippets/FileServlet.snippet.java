// Build the full path and make sure it stays INSIDE the base folder
// (blocks path traversal such as ../../windows/system.ini)
Path file = baseDir.resolve(relativePath).normalize();
if (!file.startsWith(baseDir) || !Files.isRegularFile(file)) {
response.sendError(HttpServletResponse.SC_NOT_FOUND, "File missing on server");
return;
}
// Conditional: only images and PDFs are streamed
if (contentType == null
|| !(contentType.startsWith("image/") || contentType.equals("application/pdf"))) {
response.sendError(HttpServletResponse.SC_FORBIDDEN, "File type not allowed");
return;
}
// ---- HTTP headers ----
response.setContentType(contentType);
response.setContentLengthLong(Files.size(file));
response.setHeader("X-Content-Type-Options", "nosniff");
// inline = show in browser, attachment = download dialog
String disposition = "1".equals(request.getParameter("download")) ? "attachment" :
"inline";
response.setHeader("Content-Disposition",
disposition + "; filename=\"" + downloadName.replace("\"", "") + "\"");
// ---- Stream the bytes in small chunks ----
try (InputStream in = Files.newInputStream(file);

OutputStream out = response.getOutputStream()) {
byte[] buffer = new byte[BUFFER_SIZE];
int bytesRead;
while ((bytesRead = in.read(buffer)) != -1) {
out.write(buffer, 0, bytesRead);
}
}
}
