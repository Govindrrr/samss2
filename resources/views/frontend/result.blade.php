<x-frontend-layout>
    <div class="container py-10">
        <div class="grid grid-cols-12">
           
            <div class="col-span-8">
                <h1 class="text-yellow-200 font-medium text-2xl underline p-3">Results</h1>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-yellow-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   SN.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Grade
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Result
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    PDF FILE
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ ++$index}}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$result->level->grade}}.
                                </th>
                                <td class="px-6 py-4">
                                    <a href="{{route('results',$result->id)}}">Click here...</a>
                                </td>
                                <td class="px-6 py-4">
                                   <a href=""> pdf</a>
                                </td>
                                
                            </tr>
                            @endforeach
                          
                            
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</x-frontend-layout>