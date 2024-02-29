@extends('layouts.deanSidebar')
{{-- @extends('layouts.deanNav') --}}

@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Home</title>
    @vite('resources/css/app.css')
    

    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }

        /* body {
            background-color: #e8e9e9;
        } */

        /* table, */
        /* tbody {
            border: 1px solid;
            border-collapse: collapse;
            padding: 4px;
            border-color: black;
        } */

        /* th {
            background-color: #2468d2;
            color: white;
        } */
    </style>
    <script>
        //JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
</head>

<body>
    <div class="p-4 pb-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <h2 class="font-bold text-4xl text-[#201B50] mb-4">Colleges</h2>
                    <a class="whitespace-nowrap absolute w-50 mr-1.5 hover:scale-105 w-max transition ease-in-out px-4 py-2 font-semibold flex max-w-full float-left bg-blue5 mb-2 text-white rounded-lg hover:bg-blue" href="{{ route('dean.createDepartment') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Add new Department</a>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto w-full bg-white shadow-lg pt-6"> 
            <table class='w-full text-sm mt-12 text-left rtl:text-right text-gray-500 dark:text-gray-400'>
                <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-sm text-white">
                        <th class="bg-blue5 rounded-tl-lg px-6 py-3"> Code </th>
                        <th class="bg-blue5 px-6 py-3"> Name</th>
                        <th class="bg-blue5 px-6 py-3"> Status</th>
                        <th class="bg-blue5 px-6 py-3"></th>
                        <th class="bg-blue5 rounded-tr-lg px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($departments as $department)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                        <td class="px-3 text-lg font-medium dark:text-gray-400">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p>{{ $department->department_code }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-6">
                            <p class="">{{ $department->department_name }}</p>
                        </td>

                        {{-- <td class="px-6 py-6">
                            <p>{{ $department->department_status }}</p>
                        </td> --}}

                        <td class="px-6 py-6 flex">
                            @if($department->department_status == 'Active')
                                <p class="bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg text-center flex justify-center px-12 py-[1px]">Active</p>
                            @else
                                <p class="bg-[#fca5a5] text-[#b91c1c] border-2 border-[#ef4444] rounded-lg text-center flex justify-center px-11 py-[1px]">Inactive</p>
                            @endif
                        </td>
                        
                        <td>
                            <form action="{{ route('dean.editDepartment', $department->department_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="mt-3 hover:scale-105">
                                    <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>Edit</title>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Edit">
                                                <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">
                                                </rect>
                                                <line x1="20" y1="20" x2="4" y2="20" id="Path" stroke="#58dd67" stroke-width="2" stroke-linecap="round">
                                                </line>
                                                <path d="M14.5858,4.41421 C15.3668,3.63316 16.6332,3.63316 17.4142,4.41421 L17.4142,4.41421 C18.1953,5.19526 18.1953,6.46159 17.4142,7.24264 L9.13096,15.5259 L6.10051,15.7279 L6.30254,12.6975 L14.5858,4.41421 Z" id="Path" stroke="#58dd67" stroke-width="2" stroke-linecap="round">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dean.destroyDepartment',$department->department_id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mt-3 hover:scale-105">
                                    <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>Trash</title>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Trash">
                                                <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">
                                                </rect>
                                                <path d="M6,6 L6.96683,19.5356 C6.98552,19.7973 7.20324,20 7.46556,20 L16.5344,20 C16.7968,20 17.0145,19.7973 17.0332,19.5356 L18,6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                                </path>
                                                <line x1="4" y1="6" x2="20" y2="6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                                </line>
                                                <line x1="10" y1="10" x2="10" y2="16" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">

                                                </line>
                                                <line x1="14" y1="10" x2="14" y2="16" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                                </line>
                                                <path d="M15,6 C15,4.34315 13.6569,3 12,3 C10.3431,3 9,4.34315 9,6" id="Path" stroke="#ff3813" stroke-width="2" stroke-linecap="round">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="pagination mt-6">
            <div class="flex justify-center">
                <span class="text-gray-600 text-sm">Page {{ $departments->currentPage() }} of {{ $departments->lastPage() }}</span>
            </div>
            {{ $departments->links() }}
        </div>
    </div>
    
</body>

</html>
@endsection