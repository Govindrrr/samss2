<x-frontend-layout>
    <div class="container pt-16 text-yellow-200 pb-10">
        <div class="grid grid-cols-12">
            <div class="col-span-4 ">
                <div class=" shadow-xl shadow-cyan-700 p-4 h-[300px]">
                    <h1 class="text-4xl font-extralight">Welcome to Adarsha!</h1>
                    <p>This is a brief description.</p>
                </div>
            </div>
            <div class="col-span-8 p-4">

                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    
                        <!-- Item 4 -->
                        @foreach ($slidders as $slidder)
                        <div class=" duration-700 ease-in-out" data-carousel-item>
                            <img class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 border" src="{{ asset(Storage::url($slidder->image)) }}"
                            alt="" />
                    </div>
                        @endforeach
                     
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                      
                        @foreach ($slidders as $slidder)
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                        data-carousel-slide-to="3"></button>
                        @endforeach
                       
                       
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>

            </div>
        </div>
        <div class="grid grid-cols-12 pt-14">
            <div class="col-span-7 p-3">
                <h1 class="text-4xl font-semibold underline">What Principal Says ?</h1>
                <div class="relative p-4">
                    <img class="h-[220px] border" width="200px" src="{{ asset(Storage::url($staff->photo)) }}"
                        alt="" />
                    <p class="shadow-md p-5">
                        "Welcome to our institution, where innovation meets tradition.
                        We are dedicated to fostering excellence, inspiring growth, and shaping a brighter tomorrow for
                        all."
                    </p>
                </div>


            </div>

            <div class="col-span-5 shadow-xl px-10">
                <h1 class="text-2xl font-bold">Organization Structure</h1>
                <div class="grid grid-cols-12 pt-4">
                    <div class="col-span-2">
                        <img class="h-[100px] border" width="100px" src="{{ asset(Storage::url($staff->photo)) }}"
                            alt="" />
                    </div>
                    <div class="col-span-8 p-4">
                        <h1 class="">Name: <span class="text-lg font-bold underline">{{ $staff->name }}</span>
                        </h1>
                        <h1 class="">Role: <span class="text-lg font-bold underline">{{ $staff->role }}</span>
                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-frontend-layout>
