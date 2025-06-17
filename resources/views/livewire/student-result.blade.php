
<div class="container m-10">
        @foreach ($stds as $student)
            @php
                $Marks = App\Models\Mark::where('student_id', $student->id)->where('exam_id', session('exam'))->get();
                $total = 0;
                $gpa = 0;
                $result = "pass";
                $totalMark = 0;
            @endphp
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-3xl font-semibold text-center text-gray-800">Marksheet</h2>
                    <p class="text-xl text-center text-gray-600">For the Academic Year 2024-2025</p>
                </div>
                <div class="text-right">
                    <p class="text-lg text-gray-800 font-medium">Roll No: {{ $student->roll_no }}</p>
                    <p class="text-lg text-gray-800 font-medium">Class: {{ $student->level->grade }}</p>
                    <p class="text-lg text-gray-800 font-medium">Section: {{ $student->classroom->name }}</p>
                </div>
            </div>

            <!-- Student Info Section -->
            <div class="mb-6">
                <h3 class="text-2xl font-medium text-gray-800">Student Information</h3>
                <div class="flex gap-6">
                    <p class="text-lg text-gray-600">Name: <span class="font-semibold">{{ $student->first_name }}
                            {{ $student->middle_name }} {{ $student->last_name }}</span></p>

                </div>
            </div>
            <div class="flex justify-center">
                <!-- Table for Marks -->
                <table class="w-full table-auto border-collapse border">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Subject</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Practical
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Theory
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Obtained
                                Mark
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm text-gray-600"></td>
                            <td class="px-4 py-2 text-sm text-gray-600">FM</td>
                            <td class="px-4 py-2 text-sm text-gray-600">PM</td>
                            <td class="px-4 py-2 text-sm text-gray-600">FM</td>
                            <td class="px-4 py-2 text-sm text-gray-600">PM</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Pr</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Th</td>
                        </tr>
                        @foreach ($Marks as $mark)
                        @php
                           
                            $totalMark += $mark->full_mark;
                            $total += $mark->marks;
                            if($mark->marks < $mark->pass_mark){
                                $result = "fail";
                            }
                           
                            
                        @endphp
                            <tr class="border-t">
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->subject->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pr_full_mark }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pr_pass_mark }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pass_mark }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pass_mark }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pr_marks }}</td>
                                <td
                                    class="px-4 py-2 text-sm {{ $mark->marks < $mark->pass_mark ? 'text-red' : '' }} ">
                                    {{ $mark->marks }}
                                    <span class="text-red">{{ $mark->marks < $mark->pass_mark ? '*' : ''}} </span>
                                    </td>
                            </tr>
                        @endforeach
                        @php
                            
                            if($total != 0){

                                $gpa = ($total/$totalMark * 100)/25;
                            }
                        @endphp
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm text-gray-600 ">Total = {{ $total }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600 "> GPA = {{ $gpa }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600 ">result = {{$result}}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600 ">absent = {{ $total }}</td>
                        </tr>

                    </tbody>
                </table>



            </div>
            <div class="page-break"></div>
        @endforeach
    
    <button wire:click='Pdf' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download</button>
</div>