<?php if ($flash): ?>
<!-- Flash message: class "alert-success" or "alert-error" -->
<div class="alert alert-<?php echo e($flash['type']); ?>">
<?php echo $flash['text']; /* already escaped when created */ ?>
</div>
<?php endif; ?>
