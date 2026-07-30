<?php $__env->startSection('title', 'My Applications'); ?>
<?php $__env->startSection('page-title', 'My Applications'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <?php if($applications->isEmpty()): ?>
    <div class="card py-16 text-center text-gray-400">
        <p class="text-sm">You haven't saved any programs yet.</p>
        <a href="<?php echo e(route('student.universities.index')); ?>" class="btn-primary mt-4 inline-flex">Browse Universities</a>
    </div>
    <?php else: ?>
    <div class="card divide-y divide-gray-100">
        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="px-6 py-4 flex items-start gap-4">
            <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-900"><?php echo e($app->program->program_name); ?></p>
                <p class="text-sm text-gray-500"><?php echo e($app->program->university->university_name); ?> · <?php echo e($app->program->degree_label); ?></p>
                <?php if($app->scholarship): ?>
                <p class="text-xs text-green-600 mt-0.5">🎓 Linked scholarship: <?php echo e($app->scholarship->scholarship_name); ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-400 mt-0.5">Saved <?php echo e($app->created_at->diffForHumans()); ?></p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge <?php echo e($app->status_badge_color); ?>"><?php echo e($app->status_label); ?></span>
                <a href="<?php echo e(route('student.applications.show', $app)); ?>" class="btn-secondary text-xs">View</a>
                <form method="POST" action="<?php echo e(route('student.applications.destroy', $app)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700"
                            onclick="return confirm('Remove this application?')">Remove</button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/applications/index.blade.php ENDPATH**/ ?>