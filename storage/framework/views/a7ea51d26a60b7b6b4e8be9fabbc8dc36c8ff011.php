<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logo = Utility::get_superadmin_logo();
    $logos=\App\Models\Utility::get_file('uploads/logo/');
    $setting = \App\Models\Utility::settings();
?>
<?php $__env->startSection('content'); ?>

    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="<?php echo e('http://localhost:8000/assets/images/logo-new.png?'.time()); ?>" alt="logo" style="width:70px;">
                        
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            
                            <li class="nav-item">
                                <?php if($setting['FAQ'] == 'on'): ?>
                                    <a class="nav-link" href="<?php echo e(route('faq')); ?>"><?php echo e(__('FAQ')); ?></a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <?php if($setting['Knowlwdge_Base'] == 'on'): ?>
                                    <a href="<?php echo e(route('knowledge')); ?>" class="nav-link"><?php echo e(__('Knowledge')); ?></a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('search')); ?>"><?php echo e(__('Search Ticket')); ?></a>
                            </li>
                            <li class="nav-item">

                                <select name="language" id="language" class="btn btn-primary my-1 me-2  language_option_bg" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code  => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($code == $lang): ?> selected <?php endif; ?> value="<?php echo e(route('login',$code)); ?>"><?php echo e(Str::ucfirst($language)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">

                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <div class="card-body">
                            <div class="d-flex">
                                <h2 class="mb-3 f-w-600"><?php echo e(__('Login')); ?></h2>
                            </div>
                            <form method="POST" action="<?php echo e(route('login')); ?>" id="form_data">
                                <?php echo csrf_field(); ?>
                                <?php if(session()->has('info')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session()->get('info')); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(session()->has('status')): ?>
                                    <div class="alert alert-info">
                                        <?php echo e(session()->get('status')); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label d-flex"><?php echo e(__('Email')); ?></label>

                                        <input type="email" class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                                            id="email" name="email" placeholder="<?php echo e(__('Email address')); ?>" required="">
                                        <div class="invalid-feedback d-block">
                                            <?php echo e($errors->first('email')); ?>

                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex" ><?php echo e(__('Password')); ?></label>
                                        <input type="password" class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" id="password" name="password" placeholder="<?php echo e(__('Enter Password')); ?>" required="">
                                        <div class="invalid-feedback d-block">
                                            <?php echo e($errors->first('password')); ?>

                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <a href="<?php echo e(route('password.request')); ?>" class="d-block mt-2"><small><?php echo e(__('Forgot password?')); ?></small>
                                        </a>
                                    </div>
                                    <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
                                    <div class="form-group mb-3 mt-3 ">
                                        <?php echo NoCaptcha::display(); ?>

                                        <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="small text-danger" role="alert" >
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endif; ?>
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-block mt-2" id="login_button"><?php echo e(__('Login')); ?></button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="<?php echo e(asset('assets/images/auth/img-auth-3.svg')); ?>" alt="" class="img-fluid">
                            <h3 class="text-white mb-4 mt-5"><?php echo e(__('“Perhatian Anda adalah nilai yang kami hargai di aplikasi dukungan kami.”')); ?></h3>
                            <p class="text-white">
                                <?php echo e(__('Ketika kami membuat segalanya terlihat mudah, itu karena kami berusaha sebaik mungkin untuk memudahkan pengalaman Anda. Kami di sini untuk membantu dengan sepenuh hati.')); ?>

                            </p>
                        </div>
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

<?php $__env->startPush('scripts'); ?>
<?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
<?php echo NoCaptcha::renderJs(); ?>

<?php endif; ?>
    <script>
    $(document).ready(function () {
        $("#form_data").submit(function (e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/auth/login.blade.php ENDPATH**/ ?>