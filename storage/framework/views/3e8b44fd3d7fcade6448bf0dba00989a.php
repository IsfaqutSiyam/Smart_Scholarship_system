<?php $__env->startSection('title', 'My Recommendations'); ?>
<?php $__env->startSection('page-title', 'Personalized Recommendations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">

    
    <div class="flex items-start justify-between flex-wrap gap-3">
        <div>
            <p class="text-sm text-gray-500">
                Profile: <strong><?php echo e($user->preferred_field); ?></strong> ·
                CGPA <strong><?php echo e($user->cgpa); ?></strong> ·
                <strong><?php echo e(['bachelor'=>"Bachelor's",'master'=>"Master's",'phd'=>'PhD'][$user->degree_seeking] ?? ''); ?></strong> ·
                <strong><?php echo e($user->language_proficiency); ?></strong>
            </p>
            <?php if(!$isPremium): ?>
            <p class="text-xs text-yellow-700 bg-yellow-50 border border-yellow-200 px-3 py-1.5 rounded-lg mt-2 inline-flex items-center gap-2">
                🔒 Free plan: showing top <?php echo e(\App\Models\User::FREE_REC_LIMIT); ?> of many matches.
                <a href="<?php echo e(route('student.subscription.index')); ?>" class="font-semibold underline">Unlock all with Premium →</a>
            </p>
            <?php endif; ?>
        </div>
        <form method="POST" action="<?php echo e(route('student.recommendations.refresh')); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
        </form>
    </div>

    
    <div class="card p-4 bg-blue-50 border-blue-200">
        <p class="text-xs font-semibold text-blue-800 mb-2">How scores are calculated (rule-based · fully explainable):</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-blue-700">
            <span>📚 Field Match — 40 pts</span>
            <span>🎓 CGPA Score — 25 pts</span>
            <span>🌐 Language — 20 pts</span>
            <span>🏛 Tier Ranking — 15 pts</span>
        </div>
    </div>

    
    <?php if($recommendations->isEmpty()): ?>
    <div class="card py-16 text-center text-gray-400">
        <p class="text-sm">No recommendations yet.
            <a href="<?php echo e(route('student.profile.edit')); ?>" class="text-blue-600 hover:underline">Update your profile</a>
            to generate them.
        </p>
    </div>
    <?php else: ?>
    <div class="space-y-3">
        <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
                    <?php echo e($rec->match_score >= 80 ? 'bg-green-100 text-green-700' :
                       ($rec->match_score >= 60 ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')); ?>">
                    #<?php echo e($i + 1); ?>

                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <div>
                            <p class="font-semibold text-gray-900"><?php echo e($rec->program->program_name); ?></p>
                            <a href="<?php echo e(route('student.universities.show', $rec->university)); ?>"
                               class="text-sm text-blue-600 hover:underline">
                                <?php echo e($rec->university->university_name); ?>

                            </a>
                            <span class="text-xs text-gray-400"> · <?php echo e($rec->university->city); ?> · </span>
                            <span class="badge <?php echo e($rec->university->region_badge_color); ?> text-xs">
                                <?php echo e($rec->university->region); ?>

                            </span>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-2xl font-bold <?php echo e($rec->match_color); ?>"><?php echo e($rec->match_percent); ?>%</p>
                            <p class="text-xs text-gray-400"><?php echo e($rec->match_level); ?></p>
                        </div>
                    </div>

                    
                    <?php if($rec->score_breakdown): ?>
                    <div class="mt-3 space-y-1.5">
                        <?php
                            $bd = $rec->score_breakdown;
                            $bars = [
                                ['label'=>'Field Match',  'score'=>$bd['field_score']    ?? 0, 'max'=>40, 'color'=>'bg-blue-500'],
                                ['label'=>'CGPA',         'score'=>$bd['cgpa_score']     ?? 0, 'max'=>25, 'color'=>'bg-green-500'],
                                ['label'=>'Language',     'score'=>$bd['language_score'] ?? 0, 'max'=>20, 'color'=>'bg-yellow-500'],
                                ['label'=>'Tier Ranking', 'score'=>$bd['ranking_score']  ?? 0, 'max'=>15, 'color'=>'bg-purple-500'],
                            ];
                        ?>
                        <?php $__currentLoopData = $bars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-24 text-gray-500 flex-shrink-0"><?php echo e($bar['label']); ?></span>
                            <div class="flex-1 bg-gray-100 rounded-full h-1.5">
                                <div class="<?php echo e($bar['color']); ?> h-1.5 rounded-full"
                                     style="width:<?php echo e($bar['max']>0 ? min(100,($bar['score']/$bar['max'])*100) : 0); ?>%"></div>
                            </div>
                            <span class="w-14 text-right text-gray-400"><?php echo e($bar['score']); ?>/<?php echo e($bar['max']); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>

                    <div class="flex items-center gap-3 mt-3 flex-wrap">
                        <span class="badge <?php echo e($rec->university->ranking_badge_color); ?>"><?php echo e($rec->university->ranking_tier); ?></span>
                        <span class="badge <?php echo e($rec->university->language_badge_color); ?>"><?php echo e($rec->university->language_of_instruction); ?></span>
                        <?php if($rec->program->min_cgpa): ?>
                        <span class="text-xs text-gray-400">Min CGPA: <?php echo e($rec->program->min_cgpa); ?></span>
                        <?php endif; ?>
                        <?php if($rec->program->application_deadline): ?>
                        <span class="text-xs text-gray-400">Deadline: <?php echo e($rec->program->application_deadline->format('d M Y')); ?></span>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('student.applications.store')); ?>" class="ml-auto">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="program_id" value="<?php echo e($rec->program->program_id); ?>">
                            <button type="submit" class="btn-secondary text-xs">+ Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    
    <?php if(!$isPremium && $locked > 0): ?>
    <div class="card p-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-300 text-center">
        <p class="text-2xl mb-2">⭐</p>
        <p class="font-bold text-gray-900 text-lg"><?php echo e($locked); ?> more matches found!</p>
        <p class="text-sm text-gray-600 mt-1 mb-4">
            Upgrade to Premium to see all <?php echo e($locked + \App\Models\User::FREE_REC_LIMIT); ?> recommendations
            with full score breakdowns.
        </p>
        <a href="<?php echo e(route('student.subscription.index')); ?>"
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-yellow-400 text-gray-900 font-bold rounded-xl hover:bg-yellow-300 transition-colors">
            Upgrade — from ৳299/month
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/recommendations/index.blade.php ENDPATH**/ ?>