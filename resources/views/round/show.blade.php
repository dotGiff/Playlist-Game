<x-app-layout>
    <x-slot name="header">

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
                        <a href="/season/{{ $season->id }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white underline">{{ $season->name }}</a>
                    </div>
                </li>
                <li class="inline-flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 font-bold">
                        {{ $round->name }}
                    </div>
                    @if($round->allSubmissionScoresAreIn())
                        <a href="{{ route('round.scores', [$season->id, $round->id]) }}" class="ms-1 text-sm font-medium text-red-700 hover:text-red-600 md:ms-2 dark:text-gray-400 dark:hover:text-white underline">See Scores</a>
                    @endif
                </li>
            </ol>
        </nav>
    </x-slot>
    @if($round->isOpenForSubmissions())
        <div class="py-8 pb-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if($user->isAdmin())
                    <form class="py-3" action="{{ route('round.close', [$round->season_id, $round->id]) }}" method="POST" @if(!$round->allSubmissionsAreIn()) onsubmit="return confirm('Are you sure? There are still players who haven\'t submitted') @endif">
                        @method('PUT')
                        @csrf
                        <input type="submit" value="Close Submissions" class="inline-block shadow bg-{{ $round->getSubmissionPercentageColor() }}-500 hover:bg-{{ $round->getSubmissionPercentageColor() }}-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 rounded">
                    </form>
               @endif
                <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="{{ $round->getSubmissionPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-{{ $round->getSubmissionPercentageColor() }}-600 text-xs text-white text-center whitespace-nowrap dark:bg-{{ $round->getSubmissionPercentageColor() }}-500 transition duration-500" style="width: {{ $round->getSubmissionPercentage() }}%">
                        {{ $round->getSubmissionPercentage() }}% Submitted
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="{{ route('submission.store', [$season->id, $round->id]) }}" class="w-full max-w-sm m-1">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                    <input type="hidden" name="round_id" value="{{ $round->id }}"/>
                    <div class="items-center py-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Title
                            <input name="title" type="text" placeholder="Never gonna give you up..." @if($submission) value="{{ $submission->title }}" @endif required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Artist
                            <input name="artist" type="text" placeholder="Rick Astley..." @if($submission) value="{{ $submission->artist }}" @endif required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Link
                            <input name="link" type="text" placeholder="https://youtube.com..." @if($submission) value="{{ $submission->link }}" @endif required
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white">
                        </label>

                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                            <textarea name="description" type="text" placeholder="Ignore the music video..."
                                   class="w-full appearance-none block bg-gray-200 text-gray-700 border rounded py-2 px-4 mr-3 leading-tight focus:outline-none focus:bg-white"
                            >@if($submission) {{ $submission->description }} @endif</textarea>
                        </label>

                        @if($submission)<p class="text-sm text-red-900">You've submitted but you can update it until the round is closed by an admin.</p>@endif
                        <input type="submit" value="Submit" class="inline-block shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" />
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="POST" action="{{ route("round.submit-scores", [$round->season_id, $round->id]) }}" @if($user->hasSubmittedScoresForRound($round->id)) onSubmit="return false;" @endif>
                    @csrf
                    @if($user->hasSubmittedScoresForRound($round->id))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Scores Submitted!</strong>
                            <span class="block sm:inline">Form is now read only.</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            </span>
                        </div>
                    @endif
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Song, Artist</th>
                            <th class="px-4 py-2">Link</th>
                            <th class="px-4 py-2">Best song</th>
                            <th class="px-4 py-2">Second best</th>
                            <th class="px-4 py-2">Third best</th>
                            <th class="px-4 py-2">Heard it!</th>
        {{--                    <th class="px-4 py-2">Description</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($submissions as $submission)
                            @if($user->hasSubmittedScoresForRound($round->id))
                                @php $rank = $submission->scoreForUser($user->id)->rank @endphp
                                <tr @if($loop->even)  class="bg-white" @endif>
                                    <td class="border px-4 py-2">{{ $submission->title }}, {{ $submission->artist }}</td>
                                    <td class="border px-4 py-2"><a href="{{ $submission->link }}" class="align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" target="_blank">Link</a></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" @if($rank == 1) checked @endif type="radio" name="best" id="best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" @if($rank == 2) checked @endif type="radio" name="second_best" id="second_best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" @if($rank == 3) checked @endif type="radio" name="third_best" id="third_best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input onclick="return false;" @if($rank == 0) checked @endif type="checkbox" name="heard_it[]" value="{{ $submission->id }}"></td>
            {{--                        <td class="border px-4 py-2">{{ $submission->description }}</td>--}}
                                </tr>
                            @else
                                <tr @if($loop->even)  class="bg-white" @endif>
                                    <td class="border px-4 py-2">{{ $submission->title }}, {{ $submission->artist }}</td>
                                    <td class="border px-4 py-2"><a href="{{ $submission->link }}" class="align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" target="_blank">Link</a></td>
                                    <td class="border px-4 py-2"><input type="radio" name="best" id="best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input type="radio" name="second_best" id="second_best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input type="radio" name="third_best" id="third_best" value="{{ $submission->id }}"></td>
                                    <td class="border px-4 py-2"><input type="checkbox" name="heard_it[]" value="{{ $submission->id }}"></td>
                                    {{--                        <td class="border px-4 py-2">{{ $submission->description }}</td>--}}
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <input type="submit" value="Submit" class="float-right inline-block shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-1 px-4 mt-2 rounded">
                </form>
            </div>
        </div>
    @endif
    @if($user->isAdmin() && $round->allSubmissionScoresAreIn())
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
                    @foreach($season->participants as $participant)
                        <tr @if($loop->even) class="bg-white" @endif>
                            @if(isset($submissions[$participant->id]))
                                <td class="border px-4 py-2">{{ $participant->name }}</td>
                                <td class="border px-4 py-2">
                                    @if($participant->hasSubmittedScoresForRound($round->id))
                                        <span class="font-bold text-green-600">Submitted</span>
                                    @else
                                        <span class="font-bold text-yellow-600">...waiting...</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>

