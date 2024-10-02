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
                <li class="inline-flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 font-bold underline">
                        <?php echo e($season->name); ?>

                    </div>
                </li>
            </ol>
        </nav>
     <?php $__env->endSlot(); ?>

    <?php if($season->isMySeason(Auth::id())): ?>
        <div class="py-12 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="<?php echo e(route('round.store', $season->id)); ?>" class="w-full max-w-sm m-1">
                    <?php echo csrf_field(); ?>
                    <div class="flex items-center py-2">
                        <input name="name" type="text" placeholder="Round Name..." required
                               class="appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        <input name="category" type="text" placeholder="Category..." required
                               class="appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        <input name="description" type="text" placeholder="Description..." required
                               class="appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        <input type="submit" value="Submit" class="inline-block shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" />
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4 relative">
            <?php $__currentLoopData = $rounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route("round", [$season->id, $round->id])); ?>" class="block w-full m:w-1/3 lg:w-1/4 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo e($round->name); ?></h5>
                    <p class="font-normal text-gray-700"><?php echo e($round->category); ?></p>
                    <p class="font-normal text-<?php echo e($round->getSubmissionPercentageColor()); ?>-600 font-bold"><?php echo e($round->getSubmissionPercentage()); ?>% Submitted</p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php /**PATH /Users/sgifford/Herd/Playlist-Game/resources/views/season/show.blade.php ENDPATH**/ ?>