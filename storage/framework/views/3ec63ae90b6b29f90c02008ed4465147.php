
<?php
  $key_attribute = (new $field['model'])->getKeyName();
  $field['attribute'] ??= (new $field['model'])->identifiableAttribute();
  $field['number_of_columns'] ??= 3;
  $field['show_select_all'] ??= false;

  // calculate the checklist options
  if (!isset($field['options'])) {
      $field['options'] = $field['model']::all()->pluck($field['attribute'], $key_attribute)->toArray();
  } else {
      $field['options'] = call_user_func($field['options'], $field['model']::query());

      if(is_a($field['options'], \Illuminate\Contracts\Database\Query\Builder::class, true)) {
          $field['options'] = $field['options']->pluck($field['attribute'], $key_attribute)->toArray();
      }
  }

  // calculate the value of the hidden input
  $field['value'] = old_empty_or_null($field['name'], []) ??  $field['value'] ?? $field['default'] ?? [];
  if(!empty($field['value'])) {
      if (is_a($field['value'], \Illuminate\Support\Collection::class)) {
          $field['value'] = ($field['value'])->pluck($key_attribute)->toArray();
      } elseif (is_string($field['value'])){
        $field['value'] = json_decode($field['value']);
      }
  }

  // define the init-function on the wrapper
  $field['wrapper']['data-init-function'] ??= 'bpFieldInitChecklist';
?>

<?php echo $__env->make('crud::fields.inc.wrapper_start', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <label><?php echo $field['label']; ?>


    <?php if($field['show_select_all'] ?? false): ?>
    <span class="fs-6 small checklist-select-all-inputs">
        <a href="javascript:void(0)" href="#" class="select-all-inputs"><?php echo e(trans('backpack::crud.select_all')); ?></a>
        <a href="javascript:void(0)" href="#" class="unselect-all-inputs d-none"><?php echo e(trans('backpack::crud.unselect_all')); ?></a> 
    </span>
    <?php endif; ?>
    </label>
    
    <?php echo $__env->make('crud::fields.inc.translatable_icon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <input type="hidden" data-show-select-all="<?php echo e(var_export($field['show_select_all'])); ?>" value='<?php echo json_encode($field['value'], 15, 512) ?>' name="<?php echo e($field['name']); ?>">

    <div class="row checklist-options-container">
        <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-<?php echo e(intval(12/$field['number_of_columns'])); ?>">
                <div class="checkbox">
                  <label class="font-weight-normal">
                    <input type="checkbox" value="<?php echo e($key); ?>"> <?php echo e($option); ?>

                  </label>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>
<?php echo $__env->make('crud::fields.inc.wrapper_end', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>





    
    <?php $__env->startPush('crud_fields_scripts'); ?>
        <?php $bassetBlock = 'backpack/crud/fields/checklist-field.js'; ob_start(); ?>
        <script>
            function bpFieldInitChecklist(element) {
                let hidden_input = element.find('input[type=hidden]');
                let selected_options = JSON.parse(hidden_input.val() || '[]');
                let container = element.find('.row.checklist-options-container');
                let checkboxes = container.find(':input[type=checkbox]');                
                let showSelectAll = hidden_input.data('show-select-all');
                let selectAllAnchor = element.find('.checklist-select-all-inputs').find('a.select-all-inputs');
                let unselectAllAnchor = element.find('.checklist-select-all-inputs').find('a.unselect-all-inputs');

                // set the default checked/unchecked states on checklist options
                checkboxes.each(function(key, option) {
                  var id = $(this).val();

                  if (selected_options.map(String).includes(id)) {
                    $(this).prop('checked', 'checked');
                  } else {
                    $(this).prop('checked', false);
                  }
                });

                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.click(function() {
                  var newValue = [];

                  checkboxes.each(function() {
                    if ($(this).is(':checked')) {
                      var id = $(this).val();
                      newValue.push(id);
                    }
                  });

                  hidden_input.val(JSON.stringify(newValue)).trigger('change');

                  toggleAllSelectAnchor();
                });
                  
                let selectAll = function() {
                  checkboxes.prop('checked', 'checked');
                  hidden_input.val(JSON.stringify(checkboxes.map(function() { return $(this).val(); }).get())).trigger('change');
                  selectAllAnchor.toggleClass('d-none');
                  unselectAllAnchor.toggleClass('d-none');
                };

                let unselectAll = function() {
                  checkboxes.prop('checked', false);
                  hidden_input.val(JSON.stringify([])).trigger('change');
                  selectAllAnchor.toggleClass('d-none');
                  unselectAllAnchor.toggleClass('d-none');
                };

                let toggleAllSelectAnchor = function() {
                  if(showSelectAll === false) {
                    return;
                  }

                  if (checkboxes.length === selected_options.length) {
                    selectAllAnchor.toggleClass('d-none');
                    unselectAllAnchor.toggleClass('d-none');
                  }
                };

                if(showSelectAll) {
                  selectAllAnchor.click(selectAll);
                  unselectAllAnchor.click(unselectAll);

                  toggleAllSelectAnchor();
                }

                hidden_input.on('CrudField:disable', function(e) {
                      checkboxes.attr('disabled', 'disabled');
                  });

                hidden_input.on('CrudField:enable', function(e) {
                    checkboxes.removeAttr('disabled');
                });

            }
        </script>
        <?php Basset::bassetBlock($bassetBlock, ob_get_clean()); ?>
    <?php $__env->stopPush(); ?>


<?php /**PATH C:\xampp\htdocs\quanlycuahang\vendor\backpack\crud\src\resources\views\crud/fields/checklist.blade.php ENDPATH**/ ?>