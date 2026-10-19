<?php foreach ($files as $i => $file): ?>
<?php
// Check the file really exists on disk before linking to it
$exists = is_file(__DIR__ . '/' . $file['file_path']);
$isImage = strpos($file['file_type'], 'image/') === 0;
?>
<tr>
<td><?php echo $i + 1; ?></td>
<td class="center">
<?php if ($exists && $isImage): ?>
<img class="thumb" src="<?php echo e($file['file_path']); ?>" alt="preview">
<?php else: ?>
<span class="file-badge"><?php echo $isImage ? 'IMG' : 'PDF'; ?></span>
<?php endif; ?>
</td>
<td><?php echo e($file['file_name']); ?></td>
<td><?php echo e($file['file_type']); ?></td>

<td><?php echo $exists ? readable_size(filesize(__DIR__ . '/' . $file['file_path'])) : '-
'; ?></td>
<td><?php echo date('d M Y, h:i A', strtotime($file['upload_date'])); ?></td>
<td class="actions">
<?php if ($exists): ?>
<!-- target=_blank opens the file in a new tab -->
<a class="link-btn view" href="<?php echo e($file['file_path']); ?>"
target="_blank">View</a>
<!-- download attribute makes the browser save the file -->
<a class="link-btn upload" href="<?php echo e($file['file_path']); ?>"
download>Download</a>
<?php else: ?>
<span class="muted">File missing</span>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
