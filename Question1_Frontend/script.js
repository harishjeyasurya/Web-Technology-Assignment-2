/* ==================================================================
File : script.js
Purpose : Client-side validation for the Student Registration Form.
Checks : required fields, name, roll number format, e-mail format,
password strength, course, 10-digit mobile, gender,
address, file type (jpg/jpeg/png/pdf) and file size (2 MB).
Reuse : The PHP "Add" and "Edit" pages load this same file.
When the form has data-mode="edit", password and files
become optional (the old values are kept).
================================================================== */
// Get the form and the overall message paragraph
const form = document.getElementById("registrationForm");
const formMessage = document.getElementById("formMessage");
// "edit" mode is used by edit_student.php, "add" is the default
const isEditMode = form.dataset.mode === "edit";
// ---------- Constants used for validation ----------
const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB in bytes
const IMAGE_EXTENSIONS = ["jpg", "jpeg", "png"]; // allowed for profile picture
const DOCUMENT_EXTENSIONS = ["jpg", "jpeg", "png", "pdf"]; // allowed for certificate
// ---------- Regular expressions ----------
const namePattern = /^[A-Za-z][A-Za-z .]{2,99}$/; // letters, space, dot; min 3 chars
const rollPattern = /^[0-9]{2}[A-Z]{2,3}[0-9]{3}$/; // e.g. 24CS077 or 24ECE012
const emailPattern = /^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/; // something@something.domain
const mobilePattern = /^[0-9]{10}$/; // exactly 10 digits
const upperPattern = /[A-Z]/; // at least one uppercase
const lowerPattern = /[a-z]/; // at least one lowercase
const digitPattern = /[0-9]/; // at least one number
// ---------- Helper functions ----------
// Shows an error under a field and paints its border red
function showError(fieldId, message) {
const errorBox = document.getElementById(fieldId + "Error");
const field = document.getElementById(fieldId);
if (errorBox) errorBox.textContent = message;
if (field) {

field.classList.add("input-error");
field.classList.remove("input-success");
}
}
// Clears the error of a field and paints its border green
function showSuccess(fieldId) {
const errorBox = document.getElementById(fieldId + "Error");
const field = document.getElementById(fieldId);
if (errorBox) errorBox.textContent = "";
if (field) {
field.classList.remove("input-error");
field.classList.add("input-success");
}
}
// Removes every error / success style (used by Reset button)
function clearAll() {
document.querySelectorAll(".error").forEach(function (box) {
box.textContent = "";
});
document.querySelectorAll(".input-error, .input-success").forEach(function (el) {
el.classList.remove("input-error", "input-success");
});
formMessage.textContent = "";
formMessage.className = "form-message";
const strength = document.getElementById("passwordStrength");
if (strength) {
strength.textContent = "";
strength.className = "strength";
}
const preview = document.getElementById("imagePreview");
if (preview && !isEditMode) preview.style.display = "none";
}
// Returns the lower-case extension of a file name, e.g. "photo.JPG" -> "jpg"
function getExtension(fileName) {
return fileName.split(".").pop().toLowerCase();
}
// Common file check: required?, allowed extension, maximum size
function validateFile(fieldId, allowedExtensions, required) {
const input = document.getElementById(fieldId);
if (!input) return true; // field not on this page
// No file chosen
if (input.files.length === 0) {
if (required) {
showError(fieldId, "Please choose a file.");
return false;
}
showSuccess(fieldId); // optional and empty -> OK
return true;
}
const file = input.files[0];
const ext = getExtension(file.name);
// File type validation
if (!allowedExtensions.includes(ext)) {
showError(fieldId, "Invalid file type. Allowed: " + allowedExtensions.join(", ").toUpperCase());
return false;
}
// File size validation
if (file.size > MAX_FILE_SIZE) {

showError(fieldId, "File is too large (" + (file.size / 1048576).toFixed(2) + " MB). Maximum is 2 MB.");
return false;
}
showSuccess(fieldId);
return true;
}
// ---------- Individual field validators ----------
// Each returns true when the field is valid.
function validateName() {
const value = document.getElementById("name").value.trim();
if (value === "") { showError("name", "Student name is required."); return false; }
if (!namePattern.test(value)) {
showError("name", "Name must have at least 3 letters (only letters, spaces and dots).");
return false;
}
showSuccess("name");
return true;
}
function validateRoll() {
const field = document.getElementById("roll_number");
field.value = field.value.trim().toUpperCase(); // 24cs077 -> 24CS077
if (field.value === "") { showError("roll_number", "Roll number is required."); return
false; }
if (!rollPattern.test(field.value)) {
showError("roll_number", "Format: 2 digits + 2-3 letters + 3 digits (e.g. 24CS077).");
return false;
}
showSuccess("roll_number");
return true;
}
function validateEmail() {
const value = document.getElementById("email").value.trim();
if (value === "") { showError("email", "Email is required."); return false; }
if (!emailPattern.test(value)) {
showError("email", "Enter a valid email address (e.g. name@example.com).");
return false;
}
showSuccess("email");
return true;
}
function validatePassword() {
const field = document.getElementById("password");
if (!field) return true;
const value = field.value;
// In edit mode an empty password means "keep the old password"
if (value === "" && isEditMode) { showSuccess("password"); return true; }
if (value === "") { showError("password", "Password is required."); return false; }
// Build a list of the rules that are not satisfied
const missing = [];
if (value.length < 8) missing.push("8 characters");
if (!upperPattern.test(value)) missing.push("one uppercase letter");
if (!lowerPattern.test(value)) missing.push("one lowercase letter");
if (!digitPattern.test(value)) missing.push("one number");
if (missing.length > 0) {
showError("password", "Password needs at least " + missing.join(", ") + ".");
return false;

}
showSuccess("password");
return true;
}
function validateCourse() {
if (document.getElementById("course").value === "") {
showError("course", "Please select a course.");
return false;
}
showSuccess("course");
return true;
}
function validateMobile() {
const value = document.getElementById("mobile").value.trim();
if (value === "") { showError("mobile", "Mobile number is required."); return false; }
if (!mobilePattern.test(value)) {
showError("mobile", "Mobile number must contain exactly 10 digits.");
return false;
}
showSuccess("mobile");
return true;
}
function validateGender() {
// querySelector returns null when no radio button is checked
const checked = document.querySelector('input[name="gender"]:checked');
const errorBox = document.getElementById("genderError");
if (!checked) {
errorBox.textContent = "Please select a gender.";
return false;
}
errorBox.textContent = "";
return true;
}
function validateAddress() {
const value = document.getElementById("address").value.trim();
if (value === "") { showError("address", "Address is required."); return false; }
if (value.length < 10) {
showError("address", "Address must be at least 10 characters long.");
return false;
}
showSuccess("address");
return true;
}
// ---------- Password strength indicator (live) ----------
function updateStrength() {
const field = document.getElementById("password");
const label = document.getElementById("passwordStrength");
if (!field || !label) return;
const value = field.value;
// One point for every rule satisfied
let score = 0;
if (value.length >= 8) score++;
if (upperPattern.test(value)) score++;
if (lowerPattern.test(value)) score++;
if (digitPattern.test(value)) score++;
if (value === "") {
label.textContent = "";
label.className = "strength";
} else if (score <= 2) {
label.textContent = "Strength: Weak";

label.className = "strength weak";
} else if (score === 3) {
label.textContent = "Strength: Medium";
label.className = "strength medium";
} else {
label.textContent = "Strength: Strong";
label.className = "strength strong";
}
}
// ---------- Live validation while the user types ----------
document.getElementById("name").addEventListener("blur", validateName);
document.getElementById("roll_number").addEventListener("blur", validateRoll);
document.getElementById("email").addEventListener("blur", validateEmail);
document.getElementById("course").addEventListener("change", validateCourse);
document.getElementById("address").addEventListener("blur", validateAddress);
// Allow only digits in the mobile field
document.getElementById("mobile").addEventListener("input", function () {
this.value = this.value.replace(/[^0-9]/g, "");
});
document.getElementById("mobile").addEventListener("blur", validateMobile);
if (document.getElementById("password")) {
document.getElementById("password").addEventListener("input", updateStrength);
document.getElementById("password").addEventListener("blur", validatePassword);
}
document.querySelectorAll('input[name="gender"]').forEach(function (radio) {
radio.addEventListener("change", validateGender);
});
// Profile image: validate and show a preview of the chosen picture
const profileInput = document.getElementById("profile_image");
if (profileInput) {
profileInput.addEventListener("change", function () {
const ok = validateFile("profile_image", IMAGE_EXTENSIONS, !isEditMode);
const preview = document.getElementById("imagePreview");
if (ok && this.files.length > 0 && preview) {
// URL.createObjectURL makes a temporary link to the local file
preview.src = URL.createObjectURL(this.files[0]);
preview.style.display = "block";
}
});
}
const certificateInput = document.getElementById("certificate");
if (certificateInput) {
certificateInput.addEventListener("change", function () {
validateFile("certificate", DOCUMENT_EXTENSIONS, !isEditMode);
});
}
// ---------- Submit handler ----------
form.addEventListener("submit", function (event) {
// Run every validator (no short-circuit, so ALL errors are shown together)
const results = [
validateName(),
validateRoll(),
validateEmail(),
validatePassword(),
validateCourse(),
validateMobile(),
validateGender(),
validateAddress(),
validateFile("profile_image", IMAGE_EXTENSIONS, !isEditMode),
validateFile("certificate", DOCUMENT_EXTENSIONS, !isEditMode)

];
// If any validator returned false, stop the form from being sent
if (results.includes(false)) {
event.preventDefault();
formMessage.textContent = "Please correct the highlighted errors and try again.";
formMessage.className = "form-message failure";
return;
}
formMessage.textContent = "All details are valid. Submitting...";
formMessage.className = "form-message success";
// When the page is opened directly from disk (file://) there is no PHP
// server, so we only show the success message instead of submitting.
if (window.location.protocol === "file:") {
event.preventDefault();
const name = document.getElementById("name").value.trim();
const roll = document.getElementById("roll_number").value;
alert("Registration details are valid!\n\nName: " + name + "\nRoll Number: " + roll +
"\n\n(Run the project through XAMPP to save it in MySQL.)");
formMessage.textContent = "Validation successful for " + name + " (" + roll + ").";
}
// Otherwise the browser continues and posts the form to insert_student.php
});
// Reset button: clear messages and styles as well as the values
form.addEventListener("reset", function () {
// setTimeout lets the browser clear the values first
setTimeout(clearAll, 0);
});
