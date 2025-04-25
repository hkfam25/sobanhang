
<li class="nav-item"><a class="nav-link" href="<?php echo e(backpack_url('dashboard')); ?>"><i class="la la-home nav-icon"></i> <?php echo e(trans('backpack::base.dashboard')); ?></a></li>

<?php if (isset($component)) { $__componentOriginalead85e76a923e64d9eae23947232cf9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalead85e76a923e64d9eae23947232cf9a = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuItem::resolve(['title' => 'Products','link' => backpack_url('product')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $attributes = $__attributesOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__attributesOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $component = $__componentOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__componentOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalead85e76a923e64d9eae23947232cf9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalead85e76a923e64d9eae23947232cf9a = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuItem::resolve(['title' => 'Categories','link' => backpack_url('category')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $attributes = $__attributesOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__attributesOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $component = $__componentOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__componentOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalead85e76a923e64d9eae23947232cf9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalead85e76a923e64d9eae23947232cf9a = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuItem::resolve(['title' => 'Users','link' => backpack_url('user')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $attributes = $__attributesOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__attributesOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $component = $__componentOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__componentOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalead85e76a923e64d9eae23947232cf9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalead85e76a923e64d9eae23947232cf9a = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuItem::resolve(['title' => 'Suppliers','link' => backpack_url('supplier')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $attributes = $__attributesOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__attributesOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalead85e76a923e64d9eae23947232cf9a)): ?>
<?php $component = $__componentOriginalead85e76a923e64d9eae23947232cf9a; ?>
<?php unset($__componentOriginalead85e76a923e64d9eae23947232cf9a); ?>
<?php endif; ?>



<?php if (isset($component)) { $__componentOriginal3304fc1ec27516a666a2f68d6da76d86 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3304fc1ec27516a666a2f68d6da76d86 = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuDropdown::resolve(['title' => 'Add-ons','icon' => 'la la-puzzle-piece'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuDropdown::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9 = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuDropdownHeader::resolve(['title' => 'Authentication'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-dropdown-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuDropdownHeader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9)): ?>
<?php $attributes = $__attributesOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9; ?>
<?php unset($__attributesOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9)): ?>
<?php $component = $__componentOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9; ?>
<?php unset($__componentOriginal6a44d5dc6644dfd3b36a457c2d9cc8b9); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuDropdownItem::resolve(['title' => 'Users','icon' => 'la la-user','link' => backpack_url('user')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuDropdownItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $attributes = $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $component = $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuDropdownItem::resolve(['title' => 'Roles','icon' => 'la la-group','link' => backpack_url('role')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuDropdownItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $attributes = $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $component = $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0 = $attributes; } ?>
<?php $component = Backpack\CRUD\app\View\Components\MenuDropdownItem::resolve(['title' => 'Permissions','icon' => 'la la-key','link' => backpack_url('permission')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('backpack::menu-dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Backpack\CRUD\app\View\Components\MenuDropdownItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $attributes = $__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__attributesOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0)): ?>
<?php $component = $__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0; ?>
<?php unset($__componentOriginal4a7c4d33fcbfdc491dc37cabf6bac1f0); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3304fc1ec27516a666a2f68d6da76d86)): ?>
<?php $attributes = $__attributesOriginal3304fc1ec27516a666a2f68d6da76d86; ?>
<?php unset($__attributesOriginal3304fc1ec27516a666a2f68d6da76d86); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3304fc1ec27516a666a2f68d6da76d86)): ?>
<?php $component = $__componentOriginal3304fc1ec27516a666a2f68d6da76d86; ?>
<?php unset($__componentOriginal3304fc1ec27516a666a2f68d6da76d86); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\quanlycuahang\resources\views/vendor/backpack/ui/inc/menu_items.blade.php ENDPATH**/ ?>