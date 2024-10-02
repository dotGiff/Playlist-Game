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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Seasons')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if($user->isAdmin()): ?>
        <div class="py-12 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4">
                <div class="flex items-center py-2">
                    <a type="button" href="<?php echo e(route('season.create')); ?>" class="inline-block shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Create
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="py-12 pt-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4 relative">
            <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route("season", $season->id)); ?>" class="block w-full m:w-1/3 lg:w-1/4 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="w-4/5 float-left mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo e($season->name); ?></h5>
                    <?php if($season->isMySeason(Auth::id())): ?>
                        <form class="w-1/5 float-right" action="<?php echo e(route('season.destroy', $season->id)); ?>" method="POST" onsubmit="return confirm('Are you sure? All rounds and submissions will be lost forever.')">
                            <?php echo csrf_field(); ?>
                            <input type="submit" value="X" class="inline-block shadow bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 rounded">
                        </form>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

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
<?php /**PATH /Users/sgifford/Herd/Playlist-Game/resources/views/dashboard.blade.php ENDPATH**/ ?>