<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Users')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Users')); ?></li>
<?php $__env->stopSection(); ?>
<?php

    $logos = \App\Models\Utility::get_file('public/');

?>
<?php $__env->startSection('multiple-action-button'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-users')): ?>
<a href="<?php echo e(route('admin.users.create')); ?>"  class="mx-1" >
    <div class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
        title="<?php echo e(__('Create User')); ?>">
        <i class="ti ti-plus text-white"></i>
    </div>
</a>
<?php endif; ?>
<?php if(\Auth::user()->parent == 0): ?>
<a href="<?php echo e(route('userlog')); ?>" class="btn btn-sm btn-primary btn-icon" title="<?php echo e(__('User Login History')); ?>" data-bs-toggle="tooltip" data-bs-placement="top">
<i class="ti ti-user-check"></i>
</a>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table id="pc-dt-simple" class="table">
                            <thead class="thead-light">
                            <tr>
                                
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo e(__('Picture')); ?></th>
                                    <th scope="col"><?php echo e(__('Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Email')); ?></th>
                                    <th scope="col"><?php echo e(__('Category')); ?></th>
                                    <th scope="col"><?php echo e(__('Role')); ?></th>
                                    <th scope="col" class="text-end me-3"><?php echo e(__('Action')); ?></th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td>
                                            <a href="<?php echo e((!empty($user->avatar))? ($logos.$user->avatar): $logos.'avatar.png'); ?>" target="_blank">
                                                <img src="<?php echo e((!empty($user->avatar))? ($logos.$user->avatar): $logos.'avatar.png'); ?>" class="img-fluid rounded-circle card-avatar" width="35" id="blah3">
                                            </a>
                                        </td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $user->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-white p-2 px-3 rounded fix_badge" style="background: <?php echo e($category->color); ?>"><?php echo e($category->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           </td>
                                        <td>
                                            <span class="badge bg-primary p-2 px-3 rounded rounded">
                                                <?php echo e((!empty($user->parent) && $user->parent == 1) ? 'Agent' : 'Admin'); ?>

                                            </span>
                                        </td>
                                        <td class="text-end me-3">
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-size="md" data-url="<?php echo e(route('user.reset',\Crypt::encrypt($user->id))); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Reset Password')); ?>" data-toggle="tooltip" title="<?php echo e(__('Reset Password')); ?>">
                                                    <span class="text-white">  <i class="ti ti-key"></i> </span>
                                                </a>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-users')): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip"
                                                        title="<?php echo e(__('Edit')); ?>"> <span class="text-white"> <i class="ti ti-edit"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-users')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <form method="POST" action="<?php echo e(route('admin.users.destroy',$user->id)); ?>" id="delete-form-<?php echo e($user->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-toggle="tooltip"
                                                        title="<?php echo e(__('Delete')); ?>">
                                                        <span class="text-white"> <i
                                                            class="ti ti-trash"></i></span>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/users/index.blade.php ENDPATH**/ ?>