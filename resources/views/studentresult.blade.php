<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg w-[80%] my-10">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-semibold text-center text-gray-800">Marksheet</h2>
                <p class="text-xl text-center text-gray-600">For the Academic Year 2024-2025</p>
            </div>
            <div class="text-right">
                <p class="text-lg text-gray-800 font-medium">Roll No: {{ $Marks[0]->student->roll_no }}</p>
                <p class="text-lg text-gray-800 font-medium">Class: {{ $Marks[0]->student->level->grade }}</p>
                <p class="text-lg text-gray-800 font-medium">Section: {{ $Marks[0]->student->classroom->name }}</p>
            </div>
        </div>

        <!-- Student Info Section -->
        <div class="mb-6">
            <h3 class="text-2xl font-medium text-gray-800">Student Information</h3>
            <div class="flex gap-6">
                <div class="w-1/2">
                    <p class="text-lg text-gray-600">Name: <span
                            class="font-semibold">{{ $Marks[0]->student->first_name }}
                            {{ $Marks[0]->student->middle_name }} {{ $Marks[0]->student->last_name }}</span></p>
                </div>
            </div>
        </div>
        <div class="flex justify-center">
            <!-- Table for Marks -->
            <table class="w-full table-auto border-collapse">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Subject</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Practical</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Theory</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 " colspan="2">Obtained Mark
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
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->subject->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->full_mark }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pass_mark }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pass_mark }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->pass_mark }}</td>
                            <td
                                class="px-4 py-2 text-sm text-red-600{{ $mark->marks > $mark->pass_mark ? 'text-red-500' : '' }} ">
                                {{ $mark->marks }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mark->marks }}</td>
                        </tr>
                    @endforeach
                    <tr class="border-t">
                        <td class="px-4 py-2 text-sm text-gray-600 ">Total = {{ $total }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600 "> GPA = {{ $gpa }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600 ">result =
                            @if ($result == 1)
                                Pass
                            @else
                                Fail
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600 ">absent = {{ $total }}</td>
                    </tr>

                </tbody>
            </table>



        </div>
</body>

</html> 



