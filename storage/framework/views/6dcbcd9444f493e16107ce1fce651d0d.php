<?php $__env->startSection('title', $scholarship->scholarship_name); ?>
<?php $__env->startSection('page-title', $scholarship->scholarship_name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl space-y-5">

    <div class="card p-6">
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="badge <?php echo e($scholarship->funding_badge_color); ?> text-sm px-3 py-1"><?php echo e($scholarship->funding_label); ?></span>
            <?php if($scholarship->days_until_deadline >= 0): ?>
                <?php if($scholarship->days_until_deadline <= 30): ?>
                <span class="badge bg-red-100 text-red-700 text-sm px-3 py-1">⚠ Closes in <?php echo e($scholarship->days_until_deadline); ?> days</span>
                <?php else: ?>
                <span class="badge bg-green-100 text-green-700 text-sm px-3 py-1">Open</span>
                <?php endif; ?>
            <?php else: ?>
            <span class="badge bg-gray-100 text-gray-600 text-sm px-3 py-1">Deadline Passed</span>
            <?php endif; ?>
        </div>

        <h2 class="text-xl font-bold text-gray-900"><?php echo e($scholarship->scholarship_name); ?></h2>
        <a href="<?php echo e(route('student.universities.show', $scholarship->university)); ?>"
           class="text-sm text-blue-600 hover:underline">
            🏛 <?php echo e($scholarship->university->university_name); ?>

        </a>

        <dl class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Annual Award</dt>
                <dd class="text-lg font-bold text-green-600 mt-1"><?php echo e($scholarship->getAmountFormatted()); ?></dd>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Application Deadline</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1"><?php echo e($scholarship->application_deadline->format('d F Y')); ?></dd>
            </div>
            <?php if($scholarship->min_cgpa): ?>
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Minimum CGPA</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1"><?php echo e($scholarship->min_cgpa); ?> / 4.00</dd>
            </div>
            <?php endif; ?>
            <?php if($scholarship->eligible_degree_levels): ?>
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Eligible Degrees</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1">
                    <?php echo e(implode(', ', array_map('ucfirst', $scholarship->eligible_degree_levels_array))); ?>

                </dd>
            </div>
            <?php endif; ?>
        </dl>
    </div>

    <?php if($scholarship->coverage_details): ?>
    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-3">What's Covered</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?php echo e($scholarship->coverage_details); ?></p>
    </div>
    <?php endif; ?>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-3">Eligibility Criteria</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?php echo e($scholarship->eligibility_criteria); ?></p>
    </div>

    <div class="flex gap-3">
        <a href="<?php echo e(route('student.scholarships.index')); ?>" class="btn-secondary">← Back</a>
        <a href="<?php echo e(route('student.universities.show', $scholarship->university)); ?>" class="btn-primary">
            View University Programs
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/scholarships/show.blade.php ENDPATH**/ ?>