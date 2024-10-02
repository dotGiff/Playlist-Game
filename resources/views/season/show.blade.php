<x-app-layout>
    <x-slot name="header">
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
                        {{ $season->name }}
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    @if($season->isMySeason(Auth::id()))
        <div class="py-12 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="{{ route('round.store', $season->id) }}" class="w-full max-w-sm m-1">
                    @csrf
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
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4 relative">
            @foreach($rounds as $round)
                <a href="{{ route("round", [$season->id, $round->id]) }}" class="block w-full m:w-1/3 lg:w-1/4 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $round->name }}</h5>
                    <p class="font-normal text-gray-700">{{ $round->category }}</p>
                    <p class="font-normal text-{{ $round->getSubmissionPercentageColor() }}-600 font-bold">{{ $round->getSubmissionPercentage() }}% Submitted</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>

