<div id="flashMessage" class="alert alert-info"<?= !empty($hidden) ? ' style="display: none;"' : '' ?>>
	<button class="close" data-dismiss="alert">×</button>
	<strong>Notice</strong> 
	<?php if (!empty($message)): ?>
		<?= $message ?>
	<?php endif ?>
</div>