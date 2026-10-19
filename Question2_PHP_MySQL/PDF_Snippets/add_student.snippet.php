<form id="registrationForm" action="insert_student.php" method="post"
enctype="multipart/form-data" novalidate data-mode="add">
<!-- Hidden MAX_FILE_SIZE lets PHP reject huge files early (2 MB) -->
<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
<div class="form-group">
<label for="name">Student Name <span class="req">*</span></label>
<input type="text" id="name" name="name" maxlength="100" placeholder="Enter full name"
value="<?php echo e(old('name', $old)); ?>">
<small class="error" id="nameError"></small>
</div>
<div class="form-row">
<div class="form-group">
<label for="roll_number">Roll Number <span class="req">*</span></label>
<input type="text" id="roll_number" name="roll_number" maxlength="10" placeholder="e.g.
24CS077"
value="<?php echo e(old('roll_number', $old)); ?>">
<small class="error" id="roll_numberError"></small>
</div>
<div class="form-group">
<label for="email">Email <span class="req">*</span></label>

<input type="email" id="email" name="email" maxlength="100"
placeholder="student@example.com"
value="<?php echo e(old('email', $old)); ?>">
<small class="error" id="emailError"></small>
</div>
</div>
<div class="form-group">
<label for="password">Password <span class="req">*</span></label>
<!-- Password is never re-filled for security -->
<input type="password" id="password" name="password" placeholder="Minimum 8 characters">
<small class="hint">At least 8 characters, one uppercase, one lowercase and one
number.</small>
<small class="strength" id="passwordStrength"></small>
<small class="error" id="passwordError"></small>
</div>
<div class="form-row">
<div class="form-group">
<label for="course">Course <span class="req">*</span></label>
<select id="course" name="course">
<option value="">-- Select Course --</option>
<?php foreach (COURSES as $course): ?>
<!-- Loop prints every course; the old choice stays selected -->
<option value="<?php echo e($course); ?>" <?php echo old('course', $old) === $course
? 'selected' : ''; ?>>
<?php echo e($course); ?>
</option>
<?php endforeach; ?>
</select>
<small class="error" id="courseError"></small>
