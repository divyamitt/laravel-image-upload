<?php if($message = Session::get('success')): ?>
    <strong><?php echo e($message); ?></strong>
<?php endif; ?>
 
<form action="<?php echo e(url('image')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    Upload Image(s): <input type="file" name="profile_image[]" multiple />
    <p><button type="submit" name="submit">Submit</button></p>
</form><?php /**PATH /Users/abc/project/laravel/resources/views/image.blade.php ENDPATH**/ ?>