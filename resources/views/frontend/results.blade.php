<x-frontend-layout>
    <div class="pt-10">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 ">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-yellow-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                
                                <th scope="col" class="px-6 py-3">
                                    Grade
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Result
                                </th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $index => $result)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$result->level->grade}}
                                </th>
                                <td class="px-6 py-4 text-blue-500 underline">
                                    <a href="{{route('results',$result->id)}}">Click here...</a>
                                </td>
                              
                                
                            </tr>
                            @endforeach
                          
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-8 h-[1000px] rounded-lg">       
                <embed class="md:w-[700px] h-[600px] rounded-md" src="{{asset(Storage::url($resu->pdf))}}" type="application/pdf"> 
            </div>

        </div>
    </div>
</x-frontend-layout>