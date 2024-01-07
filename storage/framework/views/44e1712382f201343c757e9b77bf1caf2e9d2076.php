<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit FAQ')); ?> (<?php echo e($faq->title); ?>)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.faq')); ?>"><?php echo e(__('FAQ')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php

$setting = App\Models\Utility::settings();

?>



<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                    <?php if(isset($setting['is_enabled']) && $setting['is_enabled'] == 'on'): ?>
                    <div class="float-end" style="margin-top: 18px;margin-left: -24px;">
                        <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['faq'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot"> <?php echo e(__('Generate with AI')); ?></i></a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo e(route('admin.faq.update',$faq->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Title')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" placeholder="<?php echo e(__('Title of the Faq')); ?>" name="title" class="form-control <?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>" value="<?php echo e($faq->title); ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('title')); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Description')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <textarea name="description" class="form-control <?php echo e($errors->has('description') ? ' is-invalid' : ''); ?>"><?php echo e($faq->description); ?></textarea>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('description')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label"></label>
                                <div class="col-sm-12 col-md-12 text-end">
                                    <button class="btn btn-primary btn-block btn-submit"><span><?php echo e(__('Update')); ?></span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="//cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
    <script src="<?php echo e(asset('js/editorplaceholder.js')); ?>"></script>
    <script>
        CKEDITOR.replace('description', {
            // contentsLangDirection: 'rtl',
            extraPlugins: 'editorplaceholder',
            editorplaceholder: '<?php echo e(__('Start Text here..')); ?>'
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/faq/edit.blade.php ENDPATH**/ ?>