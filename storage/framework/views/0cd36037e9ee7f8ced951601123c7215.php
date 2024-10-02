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
                    <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white underline">
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
                        <a href="/season/<?php echo e($season->id); ?>" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white underline"><?php echo e($season->name); ?></a>
                    </div>
                </li>
                <li class="inline-flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 font-bold">
                        <?php echo e($round->name); ?>

                    </div>
                    <?php if($round->allSubmissionScoresAreIn()): ?>
                        <a href="<?php echo e(route('round.scores', [$season->id, $round->id])); ?>" class="ms-1 text-sm font-medium text-red-700 hover:text-red-600 md:ms-2 dark:text-gray-400 dark:hover:text-white underline">See Scores</a>
                    <?php endif; ?>
                </li>
            </ol>
        </nav>
     <?php $__env->endSlot(); ?>
    <?php if($round->isOpenForSubmissions()): ?>
        <div class="py-8 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <?php if($user->isAdmin()): ?>
                    <form class="py-3" action="<?php echo e(route('round.close', [$round->season_id, $round->id])); ?>" method="POST" <?php if(!$round->allSubmissionsAreIn()): ?> onsubmit="return confirm('Are you sure? There are still players who haven\'t submitted') <?php endif; ?>">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <input type="submit" value="Close Submissions" class="inline-block shadow bg-<?php echo e($round->getSubmissionPercentageColor()); ?>-500 hover:bg-<?php echo e($round->getSubmissionPercentageColor()); ?>-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 rounded">
                    </form>
               <?php endif; ?>
                <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="<?php echo e($round->getSubmissionPercentage()); ?>" aria-valuemin="0" aria-valuemax="100">
                    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-<?php echo e($round->getSubmissionPercentageColor()); ?>-600 text-xs text-white text-center whitespace-nowrap dark:bg-<?php echo e($round->getSubmissionPercentageColor()); ?>-500 transition duration-500" style="width: <?php echo e($round->getSubmissionPercentage()); ?>%">
                        <?php echo e($round->getSubmissionPercentage()); ?>% Submitted
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="<?php echo e(route('submission.store', [$season->id, $round->id])); ?>" class="w-full max-w-sm m-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>"/>
                    <input type="hidden" name="round_id" value="<?php echo e($round->id); ?>"/>
                    <div class="items-center py-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Title
                            <input name="title" type="text" placeholder="Never gonna give you up..." <?php if($submission): ?> value="<?php echo e($submission->title); ?>" <?php endif; ?> required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Artist
                            <input name="artist" type="text" placeholder="Rick Astley..." <?php if($submission): ?> value="<?php echo e($submission->artist); ?>" <?php endif; ?> required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Link
                            <input name="link" type="text" placeholder="https://youtube.com..." <?php if($submission): ?> value="<?php echo e($submission->link); ?>" <?php endif; ?> required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                            <textarea name="description" type="text" placeholder="Ignore the music video..."
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white"
                            ><?php if($submission): ?> <?php echo e($submission->description); ?> <?php endif; ?></textarea>
                        </label>

                        <?php if($submission): ?><p class="text-sm text-red-900">You've submitted but you can update it until the round is closed by an admin.</p><?php endif; ?>
                        <input type="submit" value="Submit" class="inline-block shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" />
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="<?php echo e(route("round.submit-scores", [$round->season_id, $round->id])); ?>" <?php if($user->hasSubmittedScoresForRound($round->id)): ?> onSubmit="return false;" <?php endif; ?>>
                    <?php echo csrf_field(); ?>
                    <?php if($user->hasSubmittedScoresForRound($round->id)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Scores Submitted!</strong>
                            <span class="block sm:inline">Form is now read only.</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            </span>
                        </div>
                    <?php endif; ?>
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Song, Artist</th>
                            <th class="px-4 py-2">Link</th>
                            <th class="px-4 py-2">Best song</th>
                            <th class="px-4 py-2">Second best</th>
                            <th class="px-4 py-2">Third best</th>
                            <th class="px-4 py-2">Heard it!</th>
        
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($user->hasSubmittedScoresForRound($round->id)): ?>
                                <?php $rank = $submission->scoreForUser($user->id)->rank ?>
                                <tr <?php if($loop->even): ?>  class="bg-white" <?php endif; ?>>
                                    <td class="border px-4 py-2"><?php echo e($submission->title); ?>, <?php echo e($submission->artist); ?></td>
                                    <td class="border px-4 py-2"><a href="<?php echo e($submission->link); ?>" class="align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" target="_blank">Link</a></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" <?php if($rank == 1): ?> checked <?php endif; ?> type="radio" name="best" id="best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" <?php if($rank == 2): ?> checked <?php endif; ?> type="radio" name="second_best" id="second_best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" <?php if($rank == 3): ?> checked <?php endif; ?> type="radio" name="third_best" id="third_best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" <?php if($rank == 0): ?> checked <?php endif; ?> type="checkbox" name="heard_it[]" value="<?php echo e($submission->id); ?>"></td>
            
                                </tr>
                            <?php else: ?>
                                <tr <?php if($loop->even): ?>  class="bg-white" <?php endif; ?>>
                                    <td class="border px-4 py-2"><?php echo e($submission->title); ?>, <?php echo e($submission->artist); ?></td>
                                    <td class="border px-4 py-2"><a href="<?php echo e($submission->link); ?>" class="align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" target="_blank">Link</a></td>
                                    <td class="border px-4 py-2"><input type="radio" name="best" id="best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input type="radio" name="second_best" id="second_best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input type="radio" name="third_best" id="third_best" value="<?php echo e($submission->id); ?>"></td>
                                    <td class="border px-4 py-2"><input type="checkbox" name="heard_it[]" value="<?php echo e($submission->id); ?>"></td>
                                    
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <input type="submit" value="Submit" class="float-right inline-block shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 mt-2 rounded">
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php if($user->isAdmin() && $round->allSubmissionScoresAreIn()): ?>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>Scores Status</h2>
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $season->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr <?php if($loop->even): ?> class="bg-white" <?php endif; ?>>
                            <?php if(isset($submissions[$participant->id])): ?>
                                <td class="border px-4 py-2"><?php echo e($participant->name); ?></td>
                                <td class="border px-4 py-2">
                                    <?php if($participant->hasSubmittedScoresForRound($round->id)): ?>
                                        <span class="font-bold text-green-600">Submitted</span>
                                    <?php else: ?>
                                        <span class="font-bold text-yellow-600">...waiting...</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
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

<?php /**PATH /Users/sgifford/Herd/Playlist-Game/resources/views/round/show.blade.php ENDPATH**/ ?>