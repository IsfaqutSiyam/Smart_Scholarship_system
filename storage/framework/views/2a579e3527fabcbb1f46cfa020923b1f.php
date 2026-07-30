<?php $__env->startSection('title', 'Scholarships'); ?>
<?php $__env->startSection('page-title', 'Scholarships'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4">

    <form method="GET" class="card p-4 space-y-3">
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="<?php echo e($request->input('search')); ?>"
                       class="form-input pl-9" placeholder="Search scholarships, universities, regions…">
            </div>
            <button type="submit" class="btn-primary">Search</button>
            <a href="<?php echo e(route('student.scholarships.index')); ?>" class="btn-secondary">Reset</a>
        </div>

        <div class="flex flex-wrap gap-2 items-center">
            
            <select name="region" class="form-input w-44 text-sm" onchange="this.form.submit()">
                <option value="">🗺 All Regions</option>
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($region); ?>" <?php echo e($request->input('region') === $region ? 'selected' : ''); ?>>
                    <?php echo e($region); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <select name="funding_type" class="form-input w-44 text-sm" onchange="this.form.submit()">
                <option value="">💰 All Types</option>
                <option value="full"         <?php echo e($request->input('funding_type') === 'full'         ? 'selected' : ''); ?>>Full Scholarship</option>
                <option value="partial"      <?php echo e($request->input('funding_type') === 'partial'      ? 'selected' : ''); ?>>Partial</option>
                <option value="tuition_only" <?php echo e($request->input('funding_type') === 'tuition_only' ? 'selected' : ''); ?>>Tuition Only</option>
            </select>

            
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer px-3 py-2 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                <input type="checkbox" name="upcoming_only" value="1"
                       <?php echo e($request->boolean('upcoming_only') ? 'checked' : ''); ?>

                       class="rounded border-gray-300 text-blue-600" onchange="this.form.submit()">
                Open deadlines only
            </label>

            
            <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isPremium()): ?>
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer px-3 py-2 rounded-lg border border-yellow-300 bg-yellow-50 hover:border-yellow-400 transition-colors">
                <input type="checkbox" name="eligible_only" value="1"
                       <?php echo e($request->boolean('eligible_only') ? 'checked' : ''); ?>

                       class="rounded border-gray-300 text-yellow-500" onchange="this.form.submit()">
                ⭐ Eligible for me
            </label>
            <?php else: ?>
            <a href="<?php echo e(route('student.subscription.index')); ?>"
               class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer px-3 py-2 rounded-lg border border-gray-200 hover:border-yellow-300 hover:text-yellow-600 transition-colors">
                🔒 Eligible-for-me filter <span class="badge bg-yellow-100 text-yellow-700 ml-1">Premium</span>
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </form>

    <p class="text-sm text-gray-500">
        <span class="font-semibold text-gray-800"><?php echo e($scholarships->total()); ?></span>
        <?php echo e(Str::plural('scholarship', $scholarships->total())); ?> found
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $scholarships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('student.scholarships.show', $s)); ?>"
           class="card p-5 hover:shadow-md hover:border-blue-200 transition-all block group">
            <div class="flex items-start justify-between mb-2">
                <span class="badge <?php echo e($s->funding_badge_color); ?>"><?php echo e($s->funding_label); ?></span>
                <?php if($s->days_until_deadline <= 30 && $s->days_until_deadline >= 0): ?>
                <span class="badge bg-red-100 text-red-700"><?php echo e($s->days_until_deadline); ?>d left</span>
                <?php elseif($s->days_until_deadline < 0): ?>
                <span class="badge bg-gray-100 text-gray-500">Closed</span>
                <?php endif; ?>
            </div>

            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 text-sm line-clamp-2 mb-1 transition-colors">
                <?php echo e($s->scholarship_name); ?>

            </h3>
            <p class="text-xs text-gray-500 mb-1"><?php echo e($s->university->university_name); ?></p>
            <p class="text-xs text-gray-400 mb-3">
                📍 <?php echo e($s->university->city); ?> ·
                <span class="badge <?php echo e($s->university->region_badge_color); ?> text-xs"><?php echo e($s->university->region); ?></span>
            </p>

            <?php if($s->annual_amount_cny): ?>
            <p class="text-sm font-bold text-green-600 mb-2"><?php echo e($s->getAmountFormatted()); ?></p>
            <?php endif; ?>

            <div class="flex items-center justify-between text-xs text-gray-400">
                <span><?php echo e($s->min_cgpa ? 'Min CGPA '.$s->min_cgpa : 'No CGPA minimum'); ?></span>
                <span><?php echo e($s->application_deadline->format('d M Y')); ?></span>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 py-16 text-center text-gray-400">
            <p class="text-sm">No scholarships found matching your filters.</p>
            <a href="<?php echo e(route('student.scholarships.index')); ?>" class="text-blue-600 text-sm hover:underline mt-2 block">
                Clear filters
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php echo e($scholarships->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/scholarships/index.blade.php ENDPATH**/ ?>