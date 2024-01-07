<?php $__env->startComponent('mail::message'); ?>
<?php echo e(__('Hello')); ?>, <?php echo e($ticket->name); ?><br>

<?php echo e(__('A request for support has been closed')); ?> #<?php echo e($ticket->ticket_id); ?><br><br>

<b style="font-size:15px"><?php echo e($ticket->name); ?></b>&nbsp;&nbsp;<small><?php echo e($ticket->created_at->diffForHumans()); ?></small>
<p><?php echo $ticket->description; ?></p>

<?php $__currentLoopData = $ticket->conversions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<b style="font-size:15px"><?php echo e($conversion->replyBy()->name); ?></b>&nbsp;&nbsp;<small><?php echo e($conversion->created_at->diffForHumans()); ?></small>
<p><?php echo $conversion->description; ?></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<br>
<b style="font-size: 15px">Notes</b>
<p><?php echo $ticket->note; ?></p>
<br>





<?php echo e(__('Thanks')); ?>,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH D:\laragon\www\helpdesk\resources\views/email/close_ticket.blade.php ENDPATH**/ ?>