<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reply Ticket')); ?> - <?php echo e($ticket->ticket_id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.tickets.index')); ?>"><?php echo e(__('Tickets')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Reply')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $logo = \App\Models\Utility::get_file('/');
    $setting = App\Models\Utility::settings();

?>

<?php $__env->startSection('multiple-action-button'); ?>
<div class="row justify-content-end">
    <div class="col-auto">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-tickets')): ?>
        <div class="btn btn-sm btn-primary btn-icon m-1 float-end">
            <a href="#ticket-info" class="" type="button" data-bs-toggle="collapse" data-bs-placement="top"
            title="<?php echo e(__('Edit Ticket')); ?>"><i class="ti ti-edit text-white"></i></a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-tickets')): ?>
<?php echo e(Form::model($ticket, ['route' => ['admin.tickets.update', $ticket->id], 'id' => 'ticket-info', 'class' => 'collapse mt-3', 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                <h6><?php echo e(__('Ticket Information')); ?></h6>
            <?php if(isset($setting['is_enabled']) && $setting['is_enabled'] == 'on'): ?>
                <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['support'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot"> <?php echo e(__('Generate with AI')); ?></i></a>

            <?php endif; ?>
        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Name')); ?></label>
                                    <input class="form-control <?php echo e(!empty($errors->first('name')) ? 'is-invalid' : ''); ?>"
                                        type="text" name="name" required="" value="<?php echo e($ticket->name); ?>"
                                        placeholder="<?php echo e(__('Name')); ?>">
                                    <?php if($errors->has('name')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('name')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Email')); ?></label>
                                    <input class="form-control <?php echo e(!empty($errors->first('email')) ? 'is-invalid' : ''); ?>"
                                        type="email" name="email" required="" value="<?php echo e($ticket->email); ?>"
                                        placeholder="<?php echo e(__('Email')); ?>">
                                    <?php if($errors->has('email')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('email')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Category')); ?></label>
                                    <select class="form-select <?php echo e(!empty($errors->first('category')) ? 'is-invalid' : ''); ?>"
                                        name="category" required="">
                                        <option value=""><?php echo e(__('Select Category')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php if($ticket->category == $category->id): ?> selected <?php endif; ?>>
                                                <?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('category')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('category')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Status')); ?></label>
                                    <select class="form-select <?php echo e(!empty($errors->first('status')) ? 'is-invalid' : ''); ?>"
                                        name="status" required="">
                                        <option value="New Ticket" <?php if($ticket->status == 'New Ticket'): ?> selected <?php endif; ?>>
                                            <?php echo e(__('New Ticket')); ?></option>
                                        <option value="In Progress" <?php if($ticket->status == 'In Progress'): ?> selected <?php endif; ?>>
                                            <?php echo e(__('In Progress')); ?></option>
                                        <option value="On Hold" <?php if($ticket->status == 'On Hold'): ?> selected <?php endif; ?>>
                                            <?php echo e(__('On Hold')); ?></option>
                                        <option value="Closed" <?php if($ticket->status == 'Closed'): ?> selected <?php endif; ?>>
                                            <?php echo e(__('Closed')); ?></option>
                                            <option value="Resolved" <?php if($ticket->status == 'Resolved'): ?> selected <?php endif; ?>>
                                                <?php echo e(__('Resolved')); ?></option>
                                    </select>
                                    <?php if($errors->has('status')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('status')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Subject')); ?></label>
                                    <input class="form-control <?php echo e(!empty($errors->first('subject')) ? 'is-invalid' : ''); ?>"
                                        type="text" name="subject" required="" value="<?php echo e($ticket->subject); ?>"
                                        placeholder="<?php echo e(__('Subject')); ?>">
                                    <?php if($errors->has('subject')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('subject')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Attachments')); ?>

                                        <small>(<?php echo e(__('You can select multiple files')); ?>)</small> </label>
                                    <div class="choose-file form-group">
                                        <label for="file" class="form-label d-block">
                                            

                                            <input type="file" name="attachments[]" id="file" class="form-control mb-2 <?php echo e($errors->has('attachments') ? ' is-invalid' : ''); ?>" multiple=""  data-filename="multiple_file_selection" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                            <img src="" id="blah2" width="20%"/>


                                            <div class="invalid-feedback">
                                                <?php echo e($errors->first('attachments')); ?>

                                            </div>
                                        </label>
                                    </div>
                                    <div class="mx-4">
                                        <p class="multiple_file_selection mb-0"></p>
                                        <ul class="list-group list-group-flush w-100 attachment_list">
                                            <?php $attachments = json_decode($ticket->attachments); ?>
                                            <?php if(!empty($attachments)): ?>
                                                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="list-group-item px-0 me-3 b-0">
                                                        <a download="" href="<?php echo e($logo.'tickets/' . $ticket->ticket_id . '/' . $attachment); ?>" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>">
                                                            <i class="ti ti-arrow-bar-to-down me-2"></i> <?php echo e($attachment); ?>

                                                        </a>
                                                        <a class="bg-danger ms-2 mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('Delete')); ?>" onclick="(confirm('Are You Sure?')?(document.getElementById('user-form-<?php echo e($index); ?>').submit()):'');">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>

                                </div>
                                <div class="form-group col-md-6">

                                    <label class="require form-label"><?php echo e(__('Priority')); ?></label>
                                    <select class="form-control <?php echo e((!empty($errors->first('priority')) ? 'is-invalid' : '')); ?>" name="priority" required="">
                                        <option value=""><?php echo e(__('Select Priority')); ?></option>

                                        <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($priority->id); ?>" <?php if($ticket->priority == $priority->id): ?> selected <?php endif; ?>><?php echo e($priority->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                    <?php if($errors->has('priority')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('priority')); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="require form-label"><?php echo e(__('Description')); ?></label>
                                    <textarea name="description" id="description"
                                        class="form-control ckdescription <?php echo e(!empty($errors->first('description')) ? 'is-invalid' : ''); ?>"><?php echo $ticket->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('description')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if(!$customFields->isEmpty()): ?>
                                    <?php echo $__env->make('admin.customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            </div>

                            <div class="text-end">
                                <a class="btn btn-secondary btn-light mr-2"
                                    href="<?php echo e(route('admin.tickets.index')); ?>"><?php echo e(__('Cancel')); ?></a>
                                <button class="btn btn-primary btn-block btn-submit" type="submit"><?php echo e(__('Update')); ?></button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        <?php echo e(Form::close()); ?>


        <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <form method="post" id="user-form-<?php echo e($index); ?>" action="<?php echo e(route('admin.tickets.attachment.destroy', [$ticket->id, $index])); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <div class="row mt-3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6>
                            <span class="text-left">
                                <?php echo e($ticket->name); ?> <small>(<?php echo e($ticket->created_at->diffForHumans()); ?>)</small>
                                <span class="d-block"><small><?php echo e($ticket->email); ?></small></span>
                            </span>
                        </h6>
                        <small>
                            <span class="text-right">
                                <?php echo e(__('Status')); ?> : <span class="badge rounded <?php if($ticket->status == 'In Progress'): ?> badge bg-warning  <?php elseif($ticket->status == 'On Hold'): ?> badge bg-danger <?php else: ?> badge bg-success <?php endif; ?>"><?php echo e(__($ticket->status)); ?></span>
                            </span>
                            <span class="d-block">
                                <?php echo e(__('Category')); ?> : <span class="badge bg-primary rounded"><?php echo e($ticket->tcategory ? $ticket->tcategory->name : '-'); ?></span>
                            </span>
                        </small>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6">
                                <small>
                                    <span class="text-right">
                                        <?php echo e($field->name); ?> : <?php echo isset($ticket->customField[$field->id]) && !empty($ticket->customField[$field->id]) ? $ticket->customField[$field->id] : '-'; ?>

                                    </span>
                                </small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <p><?php echo $ticket->description; ?></p>
                    </div>
                    <?php $attachments = json_decode($ticket->attachments); ?>
                    <?php if(count($attachments)): ?>
                        <div class="m-1">
                            <h6><?php echo e(__('Attachments')); ?> :</h6>
                            <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item px-0">
                                        
                                        <?php echo e($attachment); ?> <a download="" href="<?php echo e($logo.'tickets/'. $ticket->ticket_id . '/' . $attachment); ?>" class="edit-icon py-1 ml-2" title="<?php echo e(__('Download')); ?>"><i class="fas fa-download ms-2"></i></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php $__currentLoopData = $ticket->conversions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="card-header">
                        <h6><?php echo e($conversion->replyBy()->name); ?>

                            <small>(<?php echo e($conversion->created_at->diffForHumans()); ?>)</small>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div><?php echo $conversion->description; ?></div>
                        <?php $attachments = json_decode($conversion->attachments); ?>
                        <?php if(count($attachments)): ?>
                            <div class="m-1">
                                <h6><?php echo e(__('Attachments')); ?> :</h6>
                                <ul class="list-group list-group-flush">
                                    <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item px-0">
                                            <?php echo e($attachment); ?> <a download="" href="<?php echo e($logo.'reply_tickets/'.$ticket->id. '/' . $attachment); ?>" class="edit-icon py-1 ml-2" title="<?php echo e(__('Download')); ?>"><i class="fa fa-download ms-2"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reply-tickets')): ?>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <?php if($ticket->status != 'Closed'): ?>
                        <div class="card">
                            <div class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                <h6><?php echo e(__('Add Reply')); ?></h6>
                            <?php if(isset($setting['is_enabled']) && $setting['is_enabled'] == 'on'): ?>
                            <div class="col-md-8">
                                <div class="float-end">
                                    <a href="#" data-size="md"
                                        class="btn btn-primary btn-icon btn-sm"
                                        data-ajax-popup-over="true" id="grammarCheck"
                                        data-url="<?php echo e(route('grammar',['grammar'])); ?>"
                                        data-bs-placement="top"
                                        data-title="<?php echo e(__('Grammar check with AI')); ?>">
                                        <i class="ti ti-rotate"></i>
                                        <span><?php echo e(__('Grammar check with AI')); ?></span>
                                    </a>
                                    <a href="#" data-size="md" class="btn btn-sm btn-primary"
                                        data-ajax-popup-over="true" data-size="md"
                                        data-title="<?php echo e(__('Generate content with AI')); ?>"
                                        data-url="<?php echo e(route('generate', ['reply'])); ?>"
                                        data-toggle="tooltip" title="<?php echo e(__('Generate')); ?>">
                                        <i class="fas fa-robot"></span><span
                                                class="robot"><?php echo e(__('Generate With AI')); ?></span></i>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                            <form method="post" action="<?php echo e(route('admin.conversion.store', $ticket->id)); ?>"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="require form-label"><?php echo e(__('Description')); ?></label>
                                        <textarea name="reply_description" id="reply_description" class="form-control ckdescription grammer_textarea" required></textarea>
                                        <div class="invalid-feedback d-block">
                                            <?php echo e($errors->first('reply_description')); ?>

                                        </div>
                                    </div>
                                    <div class="form-group file-group mb-5">
                                        <label class="require form-label"><?php echo e(__('Attachments')); ?></label>
                                        <label class="form-label"><small>(<?php echo e(__('You can select multiple files')); ?>)</small></label>
                                        <div class="choose-file form-group">
                                            <label for="file" class="form-label d-block">
                                                <div><?php echo e(__('Choose File Here')); ?></div>

                                                <input type="file" name="reply_attachments[]" id="file" class="form-control mb-2 <?php echo e($errors->has('reply_attachments') ? ' is-invalid' : ''); ?>" multiple=""  data-filename="multiple_reply_file_selection" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                <img src="" id="blah" width="20%"/>
                                                <div class="invalid-feedback">
                                                    <?php echo e($errors->first('reply_attachments.*')); ?>

                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="multiple_reply_file_selection"></p>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block mt-2 btn-submit" type="submit"><?php echo e(__('Submit')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                <h6><?php echo e(__('Note')); ?></h6>
                            <?php if(isset($setting['is_enabled']) && $setting['is_enabled'] == 'on'): ?>
                                <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['note'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot"> <?php echo e(__('Generate with AI')); ?></i></a>
                            <?php endif; ?>
                        </div>
                            <form method="post" action="<?php echo e(route('admin.note.store', $ticket->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="card-body adjust_card_width">
                                    <div class="form-group ckfix_height">
                                        <textarea name="note" class="form-control ckdescription" id="note"><?php echo e($ticket->note); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('note')); ?>

                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block mt-2 btn-submit" type="submit"><?php echo e(__('Add Note')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="//cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
    <script src="<?php echo e(asset('js/editorplaceholder.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $.each($('.ckdescription'), function(i, editor) {
                CKEDITOR.replace(editor, {
                    extraPlugins: 'editorplaceholder',
                    editorplaceholder: editor.placeholder
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/tickets/edit.blade.php ENDPATH**/ ?>