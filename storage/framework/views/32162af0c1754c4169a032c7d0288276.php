<?php $__env->startSection('title', $university->university_name); ?>
<?php $__env->startSection('page-title', $university->university_name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="card p-6">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-xl font-bold text-gray-900"><?php echo e($university->university_name); ?></h2>
                    <span class="badge <?php echo e($university->ranking_badge_color); ?>"><?php echo e($university->ranking_tier); ?></span>
                    <span class="badge <?php echo e($university->language_badge_color); ?>"><?php echo e($university->language_of_instruction); ?></span>
                </div>
                <p class="text-sm text-gray-500 mt-1">📍 <?php echo e($university->city); ?>, <?php echo e($university->province); ?>, China</p>
                <?php if($university->established_year): ?>
                <p class="text-sm text-gray-500">Est. <?php echo e($university->established_year); ?></p>
                <?php endif; ?>
                <?php if($university->website_url): ?>
                <a href="<?php echo e($university->website_url); ?>" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline mt-1">
                    🔗 Official Website
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php if($university->description): ?>
        <p class="mt-4 text-sm text-gray-600 leading-relaxed"><?php echo e($university->description); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Programs (<?php echo e($university->programs->count()); ?>)</h3>
        </div>
        <?php if($university->programs->isEmpty()): ?>
            <p class="px-6 py-8 text-center text-sm text-gray-400">No programs listed yet.</p>
        <?php else: ?>
        <div class="divide-y divide-gray-50">
            <?php $__currentLoopData = $university->programs->groupBy('degree_level'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level => $programs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                    <?php echo e(['bachelor' => "Bachelor's", 'master' => "Master's", 'phd' => 'PhD'][$level] ?? ucfirst($level)); ?>

                </p>
                <div class="space-y-3">
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm"><?php echo e($program->program_name); ?></p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <?php echo e($program->field_of_study); ?> · <?php echo e($program->duration); ?>

                                    <?php if($program->tuition_fee): ?> · <?php echo e($program->tuition_fee); ?> <?php endif; ?>
                                </p>
                                <?php if($program->language_requirement): ?>
                                <p class="text-xs text-gray-500">Language: <?php echo e($program->language_requirement); ?></p>
                                <?php endif; ?>
                                <?php if($program->min_cgpa): ?>
                                <p class="text-xs text-gray-500">Min CGPA: <?php echo e($program->min_cgpa); ?></p>
                                <?php endif; ?>
                                <?php if($program->application_deadline): ?>
                                <p class="text-xs <?php echo e($program->deadline_status === 'closing_soon' ? 'text-red-600 font-medium' : 'text-gray-500'); ?> mt-1">
                                    Deadline: <?php echo e($program->application_deadline->format('d M Y')); ?>

                                    <?php if($program->deadline_status === 'closed'): ?> <span class="badge bg-red-100 text-red-700 ml-1">Closed</span>
                                    <?php elseif($program->deadline_status === 'closing_soon'): ?> <span class="badge bg-orange-100 text-orange-700 ml-1">Closing Soon</span>
                                    <?php endif; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <form method="POST" action="<?php echo e(route('student.applications.store')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="program_id" value="<?php echo e($program->program_id); ?>">
                                <button type="submit" class="btn-secondary text-xs whitespace-nowrap">+ Save</button>
                            </form>
                        </div>
                        <?php if($program->application_guidance): ?>
                        <details class="mt-3">
                            <summary class="text-xs text-blue-600 cursor-pointer hover:underline">View Application Guidance</summary>
                            <div class="mt-2 text-xs text-gray-600 leading-relaxed whitespace-pre-line"><?php echo e($program->application_guidance); ?></div>
                        </details>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($university->scholarships->isNotEmpty()): ?>
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Scholarships (<?php echo e($university->scholarships->count()); ?>)</h3>
        </div>
        <div class="divide-y divide-gray-50">
            <?php $__currentLoopData = $university->scholarships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-6 py-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-medium text-gray-900 text-sm"><?php echo e($s->scholarship_name); ?></p>
                        <span class="badge <?php echo e($s->funding_badge_color); ?> mt-1"><?php echo e($s->funding_label); ?></span>
                        <?php if($s->annual_amount_cny): ?>
                        <span class="text-xs text-gray-500 ml-2"><?php echo e($s->getAmountFormatted()); ?></span>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-1">Deadline: <?php echo e($s->application_deadline->format('d M Y')); ?></p>
                    </div>
                    <a href="<?php echo e(route('student.scholarships.show', $s)); ?>" class="btn-secondary text-xs">Details</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex">
        <a href="<?php echo e(route('student.universities.index')); ?>" class="btn-secondary">← Back to Universities</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/universities/show.blade.php ENDPATH**/ ?>