
<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="<?php echo e(route('admin.category')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.category' ) ? ' active' : ''); ?>"><?php echo e(__('Category')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('admin.group')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.group' ) ? 'active' : ''); ?>"><?php echo e(__('Group')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('admin.operating_hours.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.operating_hours.index' ) ? 'active' : ''); ?>"><?php echo e(__('Operating Hours')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('admin.priority.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.priority.index' ) ? 'active' : ''); ?>"><?php echo e(__('Priority')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('admin.policiy.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.policiy.index' ) ? 'active' : ''); ?>"><?php echo e(__('SLA Policy Setting')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <a href="<?php echo e(route('admin.province.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'admin.province.index' ) ? 'active' : ''); ?>"><?php echo e(__('Province')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>

<?php /**PATH D:\laragon\www\helpdesk\resources\views/layouts/setup.blade.php ENDPATH**/ ?>