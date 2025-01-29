<x-frontend-layout>
    <div class="container py-10">
        <div>
            <h1 class="text-4xl underline text-yellow-200 p-3">Notice</h1>
            <div class="grid grid-cols-12 pt-5">

                <div class="col-span-5  border-yellow-200 p-3 text-white flex-row">
                    <ul class="space-y-2">
                        @foreach ($notices as $index => $notice)
                            <li
                                class="text-slate-700 text-xl font-mono italic border-b-2 border-yellow-200 px-2 bg-yellow-100 rounded-lg">
                                <a href="{{ route('notices', $notice->id) }}">
                                    <div class="">{{ ++$index }}. {{ $notice->topic }}</div>
                                    <small class="text-sm">{{ nepalidate($notice->created_at) }}</small>
                                </a>
                            </li>
                        @endforeach


                    </ul>
                </div>
                <div class="col-span-7 border-l-4 border-yellow-200 p-2">

                    <h1 class="text-2xl text-yellow-200 font-bold">Description</h1>

                    <div class=" p-3 rounded-md bg-yellow-100 italic h-full"></div>

                </div>

            </div>
        </div>
    </div>
</x-frontend-layout>
