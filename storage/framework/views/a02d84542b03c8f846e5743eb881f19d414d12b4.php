<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage FAQ')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('FAQ')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('multiple-action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-faq')): ?>
        <div class="btn btn-sm btn-primary btn-icon m-1 float-end"  data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Create FAQ')); ?>">
            <a href="<?php echo e(route('admin.faq.create')); ?>" class=""><i class="ti ti-plus text-white"></i></a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pc-dt-simple" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th class="w-25"><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th class="text-end me-3"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td><span class="font-weight-bold white-space"><?php echo e($faq->title); ?></span></td>
                                        <td class="faq_desc"><?php echo $faq->description; ?></td>
                                        <td class="text-end">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-faq')): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="<?php echo e(route('admin.faq.edit',$faq->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip"
                                                        title="<?php echo e(__('Edit')); ?>"><span class="text-white"> <i class="ti ti-edit"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-faq')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <form method="POST" action="<?php echo e(route('admin.faq.destroy',$faq->id)); ?>" id="user-form-<?php echo e($faq->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-toggle="tooltip"
                                                        title="<?php echo e(__('Delete')); ?>">
                                                            <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/faq/index.blade.php ENDPATH**/ ?>