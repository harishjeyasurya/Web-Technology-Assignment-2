// Columns of the students table
private int studentId;
private String name;
private String rollNumber;
private String email;
private String course;
private String mobile;
private String gender;
private String address;
private String profileImage; // relative path, e.g. uploads/images/x.png
private Timestamp createdAt;
// Extra values (not columns) used by the JSP pages
private int fileCount; // number of uploaded files
private List<StudentFile> files = new ArrayList<>(); // uploaded documents
public boolean isImage() {
return fileType != null && fileType.startsWith("image/");
}
/**
* true when the file is a PDF document.
*/
public boolean isPdf() {
return "application/pdf".equals(fileType);
}
