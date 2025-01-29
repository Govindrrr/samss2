<div class="bg-gradient-to-r from-cyan-500 to-blue-500 top-0 left-0 w-full z-20">
    <!-- Topbar Section -->
    <div class="container text-yellow-200">
        <div class="grid grid-cols-12 p-2">
            <div class="col-span-3"><img class="h-[50px]" src="{{ asset($school->logo) }}" alt=""></div>
            <div class="col-span-7 text-4xl font-bold tracking-tight p-2 text-center">
                <h1>{{ $school->name }}</h1>
            </div>
            <div class="col-span-2 flex font-bold items-end">
                <small>Rapti-2, Lalmatiya, Dang</small>
            </div>
        </div>
    </div>



</div>
<!-- Sticky Navigation Bar -->
<div class="sticky top-0 z-30 bg-yellow-200 border-b-2 border-yellow-200 text-blue-500 shadow-md shadow-yellow-100">
    <div class="container mx-auto">
        <div class="grid grid-cols-12">
            <div class="col-span-9">
                <!-- Navigation Menu -->
                <ul class="flex p-2">
                    <li
                        class="flex items-center font-semibold text-xl px-3 border-y-2 border-blue-500 hover:text-blue-700 hover:border-blue-700">
                        <a href="/">Home</a>
                    </li>
                            <li
                                class="flex items-center font-semibold text-xl px-3 border-y-2 border-blue-500 hover:text-blue-700 hover:border-blue-700">
                                <a href="{{route('notice')}}">{{$bars[0]->nav}}</a>
                            </li>
                            <li
                                class="flex items-center font-semibold text-xl px-3 border-y-2 border-blue-500 hover:text-blue-700 hover:border-blue-700">
                                <a href="{{route('result')}}">{{$bars[3]->nav}}</a>
                            </li>
                            <li
                                class="flex items-center font-semibold text-xl px-3 border-y-2 border-blue-500 hover:text-blue-700 hover:border-blue-700">
                                <a href="{{route('result')}}">Gallery</a>
                            </li>
                            <li
                                class="flex items-center font-semibold text-xl px-3 border-y-2 border-blue-500 hover:text-blue-700 hover:border-blue-700">
                                <a href="{{route('result')}}">Facilies</a>
                            </li>
                </ul>


            </div>

            <!-- Search Bar -->
            <div class="col-span-3 items-center flex">
                <div class="relative w-full max-w-sm">
                    <input type="text" placeholder="Search"
                        class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 bg-yellow-200 text-blue-500" />
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
