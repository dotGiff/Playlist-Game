<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seasons') }}
        </h2>
    </x-slot>

    @if($user->isAdmin())
        <div class="py-12 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4">
                <div class="flex items-center py-2">
                    <a type="button" href="{{ route('season.create') }}" class="inline-block shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Create
                    </a>
                </div>
            </div>
        </div>
    @endif
    <div class="py-12 pt-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap mb-4 relative">
            @foreach($seasons as $season)
                <a href="{{ route("season", $season->id) }}" class="block w-full m:w-1/3 lg:w-1/4 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="w-4/5 float-left mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $season->name }}</h5>
                    @if($season->isMySeason(Auth::id()))
                        <form class="w-1/5 float-right" action="{{ route('season.destroy', $season->id) }}" method="POST" onsubmit="return confirm('Are you sure? All rounds and submissions will be lost forever.')">
                            @csrf
                            <input type="submit" value="X" class="inline-block shadow bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 rounded">
                        </form>
                    @endif
                </a>
            @endforeach
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            </div>
        </div>
    </div>
</x-app-layout>
