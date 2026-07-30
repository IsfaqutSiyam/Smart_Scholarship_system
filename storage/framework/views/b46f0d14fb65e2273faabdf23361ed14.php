<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('page-title', 'My Academic Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">

    
    <?php
        $fields = ['full_name','academic_background','preferred_field','cgpa','language_proficiency','degree_seeking'];
        $filled  = collect($fields)->filter(fn($f) => !empty($user->$f))->count();
        $pct     = (int)(($filled / count($fields)) * 100);
    ?>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Profile Completeness</span>
            <span class="text-sm font-bold <?php echo e($pct === 100 ? 'text-green-600' : 'text-blue-600'); ?>"><?php echo e($pct); ?>%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="h-2 rounded-full transition-all <?php echo e($pct === 100 ? 'bg-green-500' : 'bg-blue-600'); ?>"
                 style="width: <?php echo e($pct); ?>%"></div>
        </div>
        <?php if($pct === 100): ?>
        <p class="text-xs text-green-600 mt-2">✓ Your profile is complete. Recommendations are up to date.</p>
        <?php else: ?>
        <p class="text-xs text-gray-500 mt-2">Fill all fields below to get personalized university & scholarship recommendations.</p>
        <?php endif; ?>
    </div>

    <form method="POST" action="<?php echo e(route('student.profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card divide-y divide-gray-100">

            
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Personal Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" value="<?php echo e(old('full_name', $user->full_name)); ?>"
                               class="form-input <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g. Rahima Begum">
                        <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Academic Background</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Academic Background <span class="text-red-500">*</span></label>
                        <input type="text" name="academic_background"
                               value="<?php echo e(old('academic_background', $user->academic_background)); ?>"
                               class="form-input <?php $__errorArgs = ['academic_background'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g. HSC from Dhaka College, 2023">
                        <?php $__errorArgs = ['academic_background'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">CGPA (out of 4.0) <span class="text-red-500">*</span></label>
                            <input type="number" name="cgpa" step="0.01" min="0" max="4"
                                   value="<?php echo e(old('cgpa', $user->cgpa)); ?>"
                                   class="form-input <?php $__errorArgs = ['cgpa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="e.g. 3.50">
                            <?php $__errorArgs = ['cgpa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="form-label">Degree Seeking <span class="text-red-500">*</span></label>
                            <select name="degree_seeking"
                                    class="form-input <?php $__errorArgs = ['degree_seeking'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select...</option>
                                <?php $__currentLoopData = ['bachelor' => "Bachelor's", 'master' => "Master's", 'phd' => 'PhD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('degree_seeking', $user->degree_seeking) === $val ? 'selected' : ''); ?>>
                                    <?php echo e($lbl); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['degree_seeking'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Preferred Field of Study <span class="text-red-500">*</span></label>
                        <select name="preferred_field"
                                class="form-input <?php $__errorArgs = ['preferred_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select field...</option>
                            <?php $__currentLoopData = [
                                'Computer Science','Engineering','Business','Medicine',
                                'Science','Agriculture','Arts & Humanities','Architecture'
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($field); ?>"
                                <?php echo e(old('preferred_field', $user->preferred_field) === $field ? 'selected' : ''); ?>>
                                <?php echo e($field); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['preferred_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Language Proficiency <span class="text-red-500">*</span></h3>
                <p class="text-xs text-gray-500 mb-4">Enter your highest language certificate. Examples: <em>IELTS 6.5</em>, <em>TOEFL 90</em>, <em>HSK 4</em>, <em>English Native</em></p>
                <input type="text" name="language_proficiency"
                       value="<?php echo e(old('language_proficiency', $user->language_proficiency)); ?>"
                       class="form-input <?php $__errorArgs = ['language_proficiency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="e.g. IELTS 6.5">
                <?php $__errorArgs = ['language_proficiency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-800 font-medium mb-1">How this is used:</p>
                    <ul class="text-xs text-blue-700 space-y-0.5 list-disc list-inside">
                        <li>English programs typically require IELTS ≥ 6.0 or TOEFL ≥ 80</li>
                        <li>Mandarin programs typically require HSK 4 or above</li>
                        <li>Bilingual programs may accept either</li>
                    </ul>
                </div>
            </div>

            
            <div class="px-6 py-4 flex justify-end gap-3">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save & Update Recommendations
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\scholarify\resources\views/student/profile/edit.blade.php ENDPATH**/ ?>