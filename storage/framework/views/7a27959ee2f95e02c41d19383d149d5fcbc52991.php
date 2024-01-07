

<?php

$settings = App\Models\Utility::settings();
$logo = \App\Models\Utility::get_file('public/');
$Lang = \App\Models\Languages::where('code',$currantLang)->first();

?>

<?php if($settings['cust_theme_bg'] == 'on' ): ?>
    <header class="dash-header transprent-bg">
<?php else: ?>
    <header class="dash-header">
<?php endif; ?>
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

                        <span class="theme-avtar">
                            <img src="<?php echo e((!empty(\Auth::user()->avatar))? ($logo.\Auth::user()->avatar): $logo."/avatar.png"); ?>" class="header-avtar" width="50">
                        </span>
                        <span class="hide-mob ms-2"><?php echo e(__('Hi')); ?>, <?php echo e(Auth::user()->name); ?></span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">

                        <a href="<?php echo e(Auth::user()->profilelink); ?>" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span><?php echo e(__('Profile')); ?></span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="ti ti-power"></i>
                            <span><?php echo e(__('Logout')); ?></span>
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <?php
            $unseenCounter = App\Models\FloatingChatMessage::where('id', Auth::user()->id)
                ->where('is_read', 0)
                ->count();
        ?>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <?php if(\Auth::user()->type != 'Super Admin' && \Auth::user()->type != 'Agent'): ?>
                <?php if(Utility::settings()['CHAT_MODULE'] == 'yes'): ?>
                    <li class="dash-h-item">
                        <a class="dash-head-link me-0" href="<?php echo e(route('admin.chats')); ?>">
                            <i class="ti ti-message-circle"></i>
                            <span class="bg-danger px-1 mb-1 dash-h-badge message-counter custom_messanger_counter"><?php echo e($unseenCounter); ?><span class="sr-only"></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php endif; ?>
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-world nocolor"></i>
                        <span class="drp-text hide-mob"><?php echo e(ucFirst($Lang->fullName)); ?></span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                       <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <a href="<?php echo e(route('admin.lang.update', $code)); ?>"
                           class="dropdown-item <?php echo e($currantLang == $code ? 'text-primary' : ''); ?>">
                           <span><?php echo e(ucFirst($lang)); ?></span>
                       </a>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if(\Auth::user()->parent == 0): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lang-create')): ?>
                                <a href="#" data-url="<?php echo e(route('admin.lang.create')); ?>" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Create New Language')); ?>" class="dropdown-item border-top py-1 text-primary"
                                ><?php echo e(__('Create Language')); ?></a>
                            </a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lang-manage')): ?>
                                <a href="<?php echo e(route('admin.lang.index', [$currantLang])); ?>"
                                class="dropdown-item border-top py-1 text-primary"><?php echo e(__('Manage Languages')); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>




<?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/partials/topnav.blade.php ENDPATH**/ ?>