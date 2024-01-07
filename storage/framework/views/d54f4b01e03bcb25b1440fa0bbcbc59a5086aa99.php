<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('FAQ')); ?>

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

                        <img src="<?php echo e($logos.'logo-light.png'.'?'.time()); ?>" alt="logo" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo e(route('login')); ?>"><?php echo e(__('Agent Login')); ?></a>
                            </li>
                            
                            <li class="nav-item">
                                <?php if($setting['Knowlwdge_Base'] == 'on'): ?>
                                    <a class="nav-link" href="<?php echo e(route('knowledge')); ?>"><?php echo e(__('Knowledge')); ?></a>
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
                        <h2 class="mb-3 text-white f-w-600"><?php echo e(__('FAQ')); ?></h2>
                    </div>

                    <div class="text-start faq">
                        <?php if($faqs->count()): ?>
                            <div class="accordion accordion-flush" id="faq-accordion">
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="heading-<?php echo e($index); ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($index); ?>" aria-expanded="<?php echo e($index == 0 ? 'true' : 'false'); ?>" aria-controls="collapse-<?php echo e($index); ?>">
                                                <span class="d-flex align-items-center">
                                                    <i class="ti ti-info-circle text-primary"></i> <?php echo e($faq->title); ?>

                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?php echo e($index); ?>"
                                            class="accordion-collapse collapse <?php if($index == 0): ?> show <?php endif; ?>" aria-labelledby="heading-<?php echo e($index); ?>" data-bs-parent="#faq-accordion">
                                            <div class="accordion-body">
                                                <p class="mb-0"><?php echo $faq->description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0 text-center"><?php echo e(__('No Faqs found.')); ?></h6>
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

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/faq.blade.php ENDPATH**/ ?>