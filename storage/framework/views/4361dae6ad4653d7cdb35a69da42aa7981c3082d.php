

<form method="post" class="needs-validation" action="<?php echo e(route('admin.groups.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-6 form-group">
            <label class="col-form-label" for="name"><?php echo e(__('Group Name')); ?></label>
            <input type="text" class="form-control" id="name" name="name" required />
        </div>
        <div class="col-6 form-group">
            <label class="require form-label"><?php echo e(__('Description')); ?></label>
            <textarea name="description"
                class="form-control ckdescription <?php echo e(!empty($errors->first('description')) ? 'is-invalid' : ''); ?>"></textarea>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('operating_hours', __('Operating Hours'),['class'=>'col-form-label'])); ?>

            <?php echo e(Form::select('operating_hours', $opeatings,null, array('class' => 'form-control select','required'=>'required'))); ?>


        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('users', __('Agent'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('users[]', $users, null, ['class' => 'form-control multi-select ', 'id' => 'choices-multiple1', 'multiple' => '' ,'required'=>'required'])); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('leader', __('Group leader'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('leader[]', $leader, null, ['class' => 'form-control multi-select ', 'id' => 'choices-multiple2', 'multiple' => '','required'=>'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label" for="email"><?php echo e(__('E-Mail Address')); ?></label>
            <input type="email" class="form-control" id="email" name="email" />
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-end text-end">
            <a class="btn btn-secondary btn-light btn-submit" href="<?php echo e(route('admin.group')); ?>"><?php echo e(__('Cancel')); ?></a>
            <button class="btn btn-primary btn-submit ms-2" type="submit"><?php echo e(__('Add')); ?></button>
        </div>
    </div>
</form>

<script src="<?php echo e(asset('public/libs/select2/dist/js/select2.min.js')); ?>"></script>

<script>
    if ($(".multi-select").length > 0) {
    $( $(".multi-select") ).each(function( index,element ) {
        var id = $(element).attr('id');
           var multipleCancelButton = new Choices(
                '#'+id, {
                    removeItemButton: true,
                }
            );
    });

}


if ($(".select2").length) {
        $('.select2').select2({
            "language": {
                "noResults": function () {
                    return "No result found";
                }
            },
        });
    }

</script>

<?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/groups/create.blade.php ENDPATH**/ ?>