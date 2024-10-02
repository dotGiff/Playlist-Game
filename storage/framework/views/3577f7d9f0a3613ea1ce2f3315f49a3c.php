<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 

        <nav class="flex pb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="/season/<?php echo e($season->id); ?>" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white"><?php echo e($season->name); ?></a>
                    </div>
                </li>
                <li class="inline-flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 font-bold underline">
                        <?php echo e($round->name); ?>

                    </div>
                </li>
            </ol>
        </nav>
     <?php $__env->endSlot(); ?>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-scroll">
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <?php $__currentLoopData = $round->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-2 w-[100px]"><?php echo e($submission->title); ?>, <?php echo e($submission->artist); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr <?php if($loop->even): ?>  class="bg-white" <?php endif; ?>>
                            <td class="border px-4 py-2 w-[100px] whitespace-nowrap overflow-hidden"><?php echo e($user->name); ?></td>
                            <?php $__currentLoopData = $round->scoresForUser($user->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $score): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="border px-4 py-2 w-[<?php echo e(floor(100/($participants->count()+1))); ?>%] whitespace-nowrap overflow-hidden">
                                    <?php echo e(\App\Models\Score::explainRank($score->rank)); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Totals:</td>
                            <?php
                                $max = max($totalScoresPerSubmission);
                                $min = min($totalScoresPerSubmission);
                                $average = array_sum($totalScoresPerSubmission) / count($totalScoresPerSubmission);
                            ?>

                            <?php $__currentLoopData = $totalScoresPerSubmission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $totalScore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'border px-4 py-2 whitespace-nowrap overflow-hidden text-white text-center',
                                            'bg-green-600' => $totalScore == $max,   // Highlight the max value green
                                            'bg-red-600' => $totalScore == $min,     // Highlight the min value red
                                            'bg-yellow-400' => $totalScore > $average && $totalScore < $max,  // Middle-range numbers yellow
                                            'bg-orange-500' => $totalScore < $average && $totalScore > $min,    // Lower-range numbers blue
                                            'font-bold' => $totalScore == $max || $totalScore == $min,  // Bold the extreme values
                                        ]); ?>">
                                    <?php echo e($totalScore); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 whitespace-nowrap overflow-hidden text-center"></td>
                            <?php $__currentLoopData = $round->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="border px-4 py-2 whitespace-nowrap overflow-hidden text-center">
                                    <?php echo e($submission->user->name); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/sgifford/Herd/Playlist-Game/resources/views/round/scores.blade.php ENDPATH**/ ?>