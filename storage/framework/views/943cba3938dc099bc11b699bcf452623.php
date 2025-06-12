<?php if($crud->hasAccess('create')): ?>
    <a href="<?php echo e(url($crud->route.'/create')); ?>" class="btn btn-primary" bp-button="create" data-style="zoom-in">
        <i class="la la-plus"></i> <span><?php echo e('Thêm'); ?></span>
    </a>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\quanlycuahang\vendor\backpack\crud\src\resources\views\crud/buttons/create.blade.php ENDPATH**/ ?>