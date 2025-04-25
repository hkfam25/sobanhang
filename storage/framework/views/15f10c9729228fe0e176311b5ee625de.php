<?php
	// preserve backwards compatibility with Widgets in Backpack 4.0
	if (isset($widget['wrapperClass'])) {
		$widget['wrapper']['class'] = $widget['wrapperClass'];
	}
?>

<?php echo $__env->renderWhen(!empty($widget['wrapper']), backpack_view('widgets.inc.wrapper_start'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
	<div class="jumbotron mb-2 ">

	  <?php if(isset($widget['heading'])): ?>
	  <h1 class="<?php echo e($widget['heading_class'] ?? 'display-3'); ?>"><?php echo $widget['heading']; ?></h1>
	  <?php endif; ?>

	  <?php if(isset($widget['content'])): ?>
	  <p class="<?php echo e($widget['content_class'] ?? ''); ?>"><?php echo $widget['content']; ?></p>
	  <?php endif; ?>

	  <?php if(isset($widget['button_link'])): ?>
	  <p class="lead">
	    <a class="btn btn-primary" href="<?php echo e($widget['button_link']); ?>" role="button"><?php echo e($widget['button_text']); ?></a>
	  </p>
	  <?php endif; ?>
	</div>
<?php echo $__env->renderWhen(!empty($widget['wrapper']), backpack_view('widgets.inc.wrapper_end'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?><?php /**PATH C:\xampp\htdocs\quanlycuahang\vendor\backpack\crud\src\resources\views\ui/widgets/jumbotron.blade.php ENDPATH**/ ?>