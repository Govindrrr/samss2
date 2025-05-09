<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .div1{
            width: 100%;
            height: 100vh;
            /* Full viewport height */
            background-color: #c6b5b5;
            padding: 60px 50px;
            box-sizing: border-box;
            /* Ensure padding doesn’t affect width */
            color: black;
        }

        .page-break {
            page-break-after: always;
        }

        /* Flexbox for Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f1f1f1;
        }

        /* Student Information */
        .student-info {
            margin-bottom: 24px;
            font-size: 18px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-red {
            color: red;
        }

        @page {
            size: A4;
            margin: 0;
            /* Remove margins */
        }

        .page-break {
            page-break-after: always;
        }

       
        body {
            background: #c6b5b5;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="div1">
        <!-- Header Section -->
        @foreach ($stds as $student)
            @php
                $Marks = App\Models\Mark::where('student_id', $student->id)->where('exam_id', session('exam'))->get();
                $total = 0;
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

                            $gpa = ($total/$totalMark * 100)/25;
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
    </div>
</body>

</html>
