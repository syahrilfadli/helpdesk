<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Knowledge')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logos=\App\Models\Utility::get_file('uploads/logo/');
?>

<?php $__env->startSection('content'); ?>
    <div class="auth-wrapper auth-v1">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">

            <nav class="navbar navbar-expand-md navbar-dark default dark_background_color">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="<?php echo e($logos.'logo-light.png' .'?'.time()); ?>" alt="logo" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Agent Login')); ?></a>
                            </li>
                            
                            <li class="nav-item">
                                <?php if($setting['FAQ'] == 'on'): ?>
                                    <a class="nav-link" href="<?php echo e(route('faq')); ?>"><?php echo e(__('FAQ')); ?></a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('search')); ?>"><?php echo e(__('Search Ticket')); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row align-items-center justify-content-center text-start">
                <div class="col-xl-12 text-center">
                    <div class="mx-3 mx-md-5">
                        <h2 class="mb-3 text-white f-w-600"><?php echo e(__('Knowledge')); ?></h2>
                    </div>

                    <div class="text-start">
                        <?php if($knowledges->count()): ?>
                            <div class="row">
                                <?php $__currentLoopData = $knowledges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $knowledge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        <div class="card" style="min-height: 200px;">
                                            <div class="card-header py-3 mb-3" id="heading-<?php echo e($index); ?>"role="button"
                                            aria-expanded="<?php echo e($index == 0 ? 'true' : 'false'); ?>">
                                                <div class="row m-auto">
                                                    <h6 class="mr-3"><?php echo e(App\Models\Knowledge::knowlege_details($knowledge->category)); ?>  ( <?php echo e(App\Models\Knowledge::category_count($knowledge->category)); ?> ) </h6>
                                                </div>
                                            </div>
                                            <ul class="knowledge_ul">
                                                <?php $__currentLoopData = $knowledges_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($knowledge->category == $details->category): ?>
                                                        <li style="list-style: none;" class="child">
                                                            <a href="<?php echo e(route('knowledgedesc',['id'=>$details->id])); ?>">
                                                                <i class="far fa-file-alt ms-3"></i>  <?php echo e(!empty($details->title) ? $details->title : '-'); ?>

                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0 text-center"><?php echo e(__('No Knowledges found.')); ?></h6>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">

                            <p class="text-muted"><?php echo e(env('FOOTER_TEXT')); ?></p>
                        </div>
                        <div class="col-6 text-end">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/knowledge.blade.php ENDPATH**/ ?>