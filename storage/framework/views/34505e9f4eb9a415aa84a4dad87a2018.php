<?php
    $dropdownId = 'dropdown-' . Str::random(8);
?>
<?php if($nested): ?>
<div class="dropend">
        <a <?php echo e($attributes->merge([
            'class' => 'dropdown-item dropdown-toggle',
            'href' => $link ?? '#',
            'data-bs-toggle'=> 'dropdown',
            'role' => 'button',
            'aria-expanded' => 'false',
            'data-bs-auto-close' => 'false',
            'id' => $dropdownId, 
            ])); ?>>
            <?php if($icon): ?><i class="nav-icon <?php echo e($icon); ?> d-block d-lg-none d-xl-block"></i><?php endif; ?>
            <?php if($title): ?><span><?php echo e($title); ?></span><?php endif; ?>
        </a>
        <div class="dropdown-menu <?php echo e($open ? 'show' : ''); ?> dropdown-submenu" aria-labelledby="<?php echo e($dropdownId); ?>">
        <?php if(isset($withColumns) && $withColumns): ?>
            <div class="dropdown-menu-columns">
        <?php endif; ?>
            <?php echo $slot; ?>

        <?php if(isset($withColumns) && $withColumns): ?>
            </div>
        <?php endif; ?>
        </div>
</div>
<?php else: ?>
<li class="nav-item dropdown">
    <a <?php echo e($attributes->merge([
        'class' => 'nav-link dropdown-toggle',
        'href' => $link ?? '#',
        'data-bs-toggle'=> 'dropdown',
        'role' => 'button',
        'data-bs-auto-close' => 'false',
        'id' => $dropdownId,
    ])); ?>>

        <?php if($icon): ?><i class="nav-icon <?php echo e($icon); ?> d-block d-lg-none d-xl-block"></i><?php endif; ?>
        <?php if($title): ?><span><?php echo e($title); ?></span><?php endif; ?>
    </a>
    <div class="dropdown-menu <?php echo e($open ? 'show' : ''); ?>" data-bs-popper="static" aria-labelledby="<?php echo e($dropdownId); ?>">
    <?php if(isset($withColumns) && $withColumns): ?>
        <div class="dropdown-menu-columns">
    <?php endif; ?>
        <?php echo $slot; ?>

    <?php if(isset($withColumns) && $withColumns): ?>
        </div>
    <?php endif; ?>
    </div>
</li>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\quanlycuahang\vendor/backpack/theme-tabler/resources/views/components/menu-dropdown.blade.php ENDPATH**/ ?>