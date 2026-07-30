<?php $__env->startSection('title', 'Universities'); ?>
<?php $__env->startSection('page-title', 'Chinese Universities'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4">

    
    <form method="GET" class="card p-4 space-y-3">
        
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="<?php echo e($request->input('search')); ?>"
                       class="form-input pl-9" placeholder="Search by name, city, region, field…">
            </div>
            <button type="submit" class="btn-primary">Search</button>
            <a href="<?php echo e(route('student.universities.index')); ?>" class="btn-secondary">Reset</a>
        </div>

        
        <div class="flex flex-wrap gap-2">
            
            <select name="region" class="form-input w-44 text-sm"
                    onchange="this.form.submit()">
                <option value="">🗺 All Regions</option>
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($region); ?>" <?php echo e($request->input('region') === $region ? 'selected' : ''); ?>>
                    <?php echo e($region); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <select name="city" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="">🏙 All Cities</option>
                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($city); ?>" <?php echo e($request->input('city') === $city ? 'selected' : ''); ?>><?php echo e($city); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <select name="language" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="">🌐 Any Language</option>
                <?php $__currentLoopData = ['English','Mandarin','Bilingual']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($lang); ?>" <?php echo e($request->input('language') === $lang ? 'selected' : ''); ?>><?php echo e($lang); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <select name="tier" class="form-input w-44 text-sm"
                    onchange="this.form.submit()">
                <option value="">🏛 Any Tier</option>
                <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tier); ?>" <?php echo e($request->input('tier') === $tier ? 'selected' : ''); ?>><?php echo e($tier); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <select name="sort" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="name" <?php echo e($request->input('sort','name') === 'name' ? 'selected' : ''); ?>>Sort: A–Z</option>
                <option value="tier" <?php echo e($request->input('sort') === 'tier' ? 'selected' : ''); ?>>Sort: Top Tier</option>
                <option value="city" <?php echo e($request->input('sort') === 'city' ? 'selected' : ''); ?>>Sort: City</option>
                <option value="new"  <?php echo e($request->input('sort') === 'new'  ? 'selected' : ''); ?>>Sort: Newest</option>
            </select>
        </div>

        
        <?php
            $activeFilters = array_filter([
                'region'   => $request->input('region'),
                'city'     => $request->input('city'),
                'language' => $request->input('language'),
                'tier'     => $request->input('tier'),
                'search'   => $request->input('search'),
            ]);
        ?>
        <?php if($activeFilters): ?>
        <div class="flex flex-wrap gap-2 pt-1">
            <?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                <?php echo e(ucfirst($key)); ?>: <?php echo e($val); ?>

                <a href="<?php echo e(request()->fullUrlWithQuery([$key => null])); ?>" class="ml-0.5 hover:text-red-600">✕</a>
            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </form>

    
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            <span class="font-semibold text-gray-800"><?php echo e($universities->total()); ?></span>
            <?php echo e(Str::plural('university', $universities->total())); ?> found
        </p>
        
        <div class="hidden md:flex gap-1 flex-wrap justify-end">
            <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(request()->fullUrlWithQuery(['region' => $r, 'page' => null])); ?>"
               class="text-xs px-2.5 py-1 rounded-full transition-colors
                      <?php echo e($request->input('region') === $r
                         ? 'bg-blue-700 text-white'
                         : 'bg-white border border-gray-200 text-gray-600 hover:border-blue-300 hover:text-blue-700'); ?>">
                <?php echo e($r); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $universities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uni): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('student.universities.show', $uni)); ?>"
           class="card p-5 hover:shadow-md hover:border-blue-200 transition-all block group">

            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="badge <?php echo e($uni->ranking_badge_color); ?>"><?php echo e($uni->ranking_tier); ?></span>
            </div>

            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors line-clamp-2 mb-1 text-sm leading-snug">
                <?php echo e($uni->university_name); ?>

            </h3>

            <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-3">
                <span>📍 <?php echo e($uni->city); ?></span>
                <span>·</span>
                <span class="badge <?php echo e($uni->region_badge_color); ?> text-xs"><?php echo e($uni->region); ?></span>
            </div>

            <div class="flex items-center justify-between text-xs">
                <span class="badge <?php echo e($uni->language_badge_color); ?>"><?php echo e($uni->language_of_instruction); ?></span>
                <span class="text-gray-400">
                    <?php echo e($uni->programs_count); ?> prog · <?php echo e($uni->scholarships_count); ?> schol
                </span>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
            <p class="text-sm font-medium">No universities match your filters.</p>
            <a href="<?php echo e(route('student.universities.index')); ?>"
               class="text-blue-600 text-sm hover:underline mt-2 inline-block">Clear all filters</a>
        </div>
        <?php endif; ?>
    </div>

    <?php echo e($universities->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/universities/index.blade.php ENDPATH**/ ?>