
<form action="<?php echo e(route('admin.priority.store')); ?>" method="post">

    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label"><?php echo e(__('Name')); ?></label>
            <div class="col-sm-12 col-md-12">
                <input type="text" placeholder="<?php echo e(__('Name of the Priority')); ?>" name="name"
                    class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('name')); ?>"
                    required>
                <div class="invalid-feedback">
                    <?php echo e($errors->first('name')); ?>

                </div>
            </div>
        </div>
        <div class="form-group col-md-6">

            <label for="exampleColorInput" class="form-label"><?php echo e(__('Color')); ?></label>
            <div class="col-sm-12 col-md-12">
                <input name="color" type="color"
                    class=" form-control  form-control-color <?php echo e($errors->has('color') ? ' is-invalid' : ''); ?>"
                    value="255ff7" id="exampleColorInput">
                <div class="invalid-feedback">
                    <?php echo e($errors->first('color')); ?>

                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label"></label>
            <div class="col-sm-12 col-md-12 text-end">
                <button class="btn btn-primary btn-block btn-submit"><span><?php echo e(__('Add')); ?></span></button>
            </div>
        </div>
    </div>

</form>


<?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/priority/create.blade.php ENDPATH**/ ?>