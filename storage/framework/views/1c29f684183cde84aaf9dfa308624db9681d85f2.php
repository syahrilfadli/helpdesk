<?php
$setting = App\Models\Settings::colorset();
$getSetting = \App\Models\Utility::getSeoSetting();

$color = 'theme-3';
if (!empty($setting['color'])) {
    $color = $setting['color'];
}

$settings = Utility::settings();
// $cust_darklayout = $setting['cust_darklayout'];
$logos = \App\Models\Utility::get_file('uploads/logo/');
$currantLang = \Auth::user()->lang;
$SITE_RTL = !empty($setting['SITE_RTL'] ) ? $setting['SITE_RTL']  : 'off';
?>


<!DOCTYPE html>

<html lang="<?php echo e(Auth::user()->lang); ?>" dir="<?php echo e($settings['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <meta name="title" content="<?php echo e($getSetting['meta_keywords']); ?>">
    <meta name="description" content="<?php echo e($getSetting['meta_description']); ?>">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($getSetting['meta_keywords']); ?>">
    <meta property="og:description" content="<?php echo e($getSetting['meta_description']); ?>">
    <meta property="og:image" content="<?php echo e(asset('uploads/metaevent/'.$getSetting['meta_image'])); ?>">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($getSetting['meta_keywords']); ?>">
    <meta property="twitter:description" content="<?php echo e($getSetting['meta_description']); ?>">
    <meta property="twitter:image" content="<?php echo e(asset('uploads/metaevent/'.$getSetting['meta_image'])); ?>">




    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />



    <title>
        <?php echo $__env->yieldContent('page-title'); ?> - <?php echo e(config('app.name', 'Support Ticket')); ?>

    </title>

    <link rel="shortcut icon" href="<?php echo e($logos.'favicon.png'); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <!-- vendor css -->

    <?php if($settings['SITE_RTL'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <?php if(isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
<?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
<?php endif; ?>


    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

    <!-- switch button -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/libs/select2/dist/css/select2.min.css')); ?>">
    <?php echo $__env->yieldPushContent('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

</head>

<body class="<?php echo e($color); ?>">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <?php echo $__env->make('admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->make('admin.partials.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModal"></h5>
                    <a type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModal"></h5>
                    <a type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>



    <div class="dash-container">
        <div class="dash-content">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="row page-header-title">
                            <div class="col-md-6">
                                <?php if(trim($__env->yieldContent('page-title'))): ?>
                                    <h4 class="m-0"><?php echo $__env->yieldContent('page-title'); ?></h4>
                                <?php endif; ?>
                                <ul class="breadcrumb">
                                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                                </ul>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if(trim($__env->yieldContent('action-button'))): ?>
                                <div class=" " <?php if($SITE_RTL == 'on'): ?>style=" float: left !important;"<?php endif; ?>>
                                    <div class="all-button-box float-end mb-3" style="margin-right: -20px;">
                                        <?php echo $__env->yieldContent('action-button'); ?>
                                    </div>
                                </div>
                                <?php elseif(trim($__env->yieldContent('multiple-action-button'))): ?>
                                <div class=" " <?php if($SITE_RTL == 'on'): ?>style=" float: left !important;"<?php endif; ?>>
                                    <div style="margin-right: -20px;" class="d-flex justify-content-end">
                                        <?php echo $__env->yieldContent('multiple-action-button'); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $__env->yieldContent('content'); ?>

        </div>
    </div>

    <?php echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>



    <script src="<?php echo e(asset('js/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/fire.modal.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>

    <script>
        if($('#pc-dt-simple').length){
            const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
        }

    </script>

<script src="<?php echo e(asset('public/libs/select2/dist/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    <!-- switch button -->
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>

    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure?`,
                    text: "This action can not be undone. Do you want to continue?",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    //   buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

    <script>
        var date_picker_locale = {
            format: 'YYYY-MM-DD',
            daysOfWeek: [
                "<?php echo e(__('Sun')); ?>",
                "<?php echo e(__('Mon')); ?>",
                "<?php echo e(__('Tue')); ?>",
                "<?php echo e(__('Wed')); ?>",
                "<?php echo e(__('Thu')); ?>",
                "<?php echo e(__('Fri')); ?>",
                "<?php echo e(__('Sat')); ?>"
            ],
            monthNames: [
                "<?php echo e(__('January')); ?>",
                "<?php echo e(__('February')); ?>",
                "<?php echo e(__('March')); ?>",
                "<?php echo e(__('April')); ?>",
                "<?php echo e(__('May')); ?>",
                "<?php echo e(__('June')); ?>",
                "<?php echo e(__('July')); ?>",
                "<?php echo e(__('August')); ?>",
                "<?php echo e(__('September')); ?>",
                "<?php echo e(__('October')); ?>",
                "<?php echo e(__('November')); ?>",
                "<?php echo e(__('December')); ?>"
            ],
        };
        var calender_header = {
            today: "<?php echo e(__('today')); ?>",
            month: '<?php echo e(__('month')); ?>',
            week: '<?php echo e(__('week')); ?>',
            day: '<?php echo e(__('day')); ?>',
            list: '<?php echo e(__('list')); ?>'
        };
    </script>

    <script>
        var dataTableLang = {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
            zeroRecords: "<?php echo e(__('No data available in table.')); ?>",
            info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
            infoEmpty: "<?php echo e(__('Showing 0 to 0 of 0 entries')); ?>",
            infoFiltered: "<?php echo e(__('(filtered from _MAX_ total entries)')); ?>",
            search: "<?php echo e(__('Search:')); ?>",
            thousands: ",",
            loadingRecords: "<?php echo e(__('Loading...')); ?>",
            processing: "<?php echo e(__('Processing...')); ?>"
        }
    </script>



    <?php if(APP\Models\Utility::getSettingValByName('gdpr_cookie') == 'on'): ?>
        <script type="text/javascript">
            var defaults = {
                'messageLocales': {
                    /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                    'en': "<?php echo e(APP\Models\Utility::getSettingValByName('cookie_text')); ?>"
                },
                'buttonLocales': {
                    'en': 'Ok'
                },
                'cookieNoticePosition': 'bottom',
                'learnMoreLinkEnabled': false,
                'learnMoreLinkHref': '/cookie-banner-information.html',
                'learnMoreLinkText': {
                    'it': 'Saperne di più',
                    'en': 'Learn more',
                    'de': 'Mehr erfahren',
                    'fr': 'En savoir plus'
                },
                'buttonLocales': {
                    'en': 'Ok'
                },
                'expiresIn': 30,
                'buttonBgColor': '#d35400',
                'buttonTextColor': '#fff',
                'noticeBgColor': '#000000',
                'noticeTextColor': '#fff',
                'linkColor': '#009fdd'
            };
        </script>
        <script src="<?php echo e(asset('js/cookie.notice.js')); ?>"></script>
    <?php endif; ?>

    <script>
        function show_toastr(title, message, type) {
            var o, i;
            var icon = '';
            var cls = '';
            if (type == 'success') {
                icon = 'fas fa-check-circle';
                // cls = 'success';
                cls = 'primary';
            } else {
                icon = 'fas fa-times-circle';
                cls = 'danger';
            }


            $.notify({
                icon: icon,
                title: " " + title,
                message: message,
                url: ""
            }, {
                element: "body",
                type: cls,
                allow_dismiss: !0,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: {
                    x: 15,
                    y: 15
                },
                spacing: 10,
                z_index: 1080,
                delay: 2500,
                timer: 2000,
                url_target: "_blank",
                mouse_over: !1,
                animate: {
                    enter: o,
                    exit: i
                },
                // danger
                template: '<div class="toast text-white bg-' + cls +
                    ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
                    '<div class="d-flex">' +
                    '<div class="toast-body"> ' + message + ' </div>' +
                    '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                    '</div>' +
                    '</div>'
                // template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            });
        }
    </script>

    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }
        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }
        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>


    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php if(Session::has('success')): ?>
        <script>
            show_toastr('<?php echo e(__('Success')); ?>', '<?php echo session('success'); ?>', 'success');
        </script>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <script>
            show_toastr('<?php echo e(__('Error')); ?>', '<?php echo session('error'); ?>', 'error');
        </script>
    <?php endif; ?>
</body>
<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<?php /**PATH D:\laragon\www\helpdesk\resources\views/layouts/admin.blade.php ENDPATH**/ ?>