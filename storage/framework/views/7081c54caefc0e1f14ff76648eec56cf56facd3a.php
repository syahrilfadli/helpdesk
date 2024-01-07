<?php $__env->startComponent('mail::message'); ?>
<?php echo e(__('Hello')); ?>, <?php echo e($ticket->name); ?>


<?php echo e(__('Ticket Subject')); ?> : <?php echo e($ticket->subject); ?>


<div>
<?php echo $conversion->description; ?>

</div>

<?php $__env->startComponent('mail::button', ['url' => route('home.view',\Illuminate\Support\Facades\Crypt::encrypt($ticket->ticket_id))]); ?>
    <?php echo e(__('Check Your Ticket Now')); ?>

<?php echo $__env->renderComponent(); ?>

<?php echo e(__('Thanks')); ?>,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\laragon\www\helpdesk\resources\views/email/create_ticket_admin_reply.blade.php ENDPATH**/ ?>