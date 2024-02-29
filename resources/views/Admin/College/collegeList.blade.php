@extends('layouts.adminNav')
@include('layouts.modal')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')

    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
        </style>
</head>

<body>
    <div class="min-h-screen bg-swhite py-5 ml-16 mr-16 mx-auto">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <h2 class="text-3xl text-black -mb-[30px] font-semibold">Colleges</h2>
                    <a class="whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full float-right" href="{{ route('admin.createCollege') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Create College</a>
                </div>
            </div>
        </div>
                    <div class='overflow-x-auto w-full'>
                        <table class='w-full border table-auto overflow-scroll w-full p-6 text-left whitespace-nowrap'>
                            <thead class="border">
                                <tr class="bg-blue text-2xl text-white">
                                    <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Code </th>
                                    <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Description </th>
                                    <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"></th>
                                    <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#e5e7eb] bg-[#f9fafb]">
                                @foreach ($colleges as $college)
                                <tr>
                                    <td class="px-6 py-4 font-bold">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <p>{{ $college->college_code }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="">{{ $college->college_description }}</p>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.editCollege', $college->college_id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="hover:scale-105">
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
                                        <form action="{{ route('admin.destroyCollege',$college->college_id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:scale-105">
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
                        <div class="mt-9">
                            <div class="flex justify-center">
                                <span class="text-gray-600 text-sm">Page {{ $colleges->currentPage() }} of {{ $colleges->lastPage() }}</span>
                            </div>

                            {{ $colleges->links() }} <!-- Pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="min-h-screen bg-swhite py-5 ml-16 -mt-[10%] mr-16 mx-auto m-12">
            <div class="flex justify-center align-items-center">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <h2 class="text-3xl text-black font-semibold -mb-[35px]">Dean</h2>
                        <a class="whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full float-right" href="{{ route('createDean') }}">
                            <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Assign Dean</a>
                    </div>
                </div>
            </div>
                <div class='overflow-x-auto w-full'>
                    <table class='w-full border table-auto overflow-scroll w-full p-6 text-left whitespace-nowrap'>
                        <thead class="bg-[#e2e8f0] border">
                            <tr class="bg-blue text-2xl text-white">
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Code </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Name </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Start Validity </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> End Validity </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#e5e7eb] bg-[#f9fafb]">
                        @foreach ($deans as $dean)
                            <tr>
                                <td class="px-6 py-4 font-bold">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <p>{{ $dean->college_code }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="">{{ $dean->firstname }} {{ $dean->lastname }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="">{{ $dean->start_validity }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="">{{ $dean->end_validity }}</p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('editDean', $dean->dean_id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="hover:scale-105">
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
                                <form action="{{ route('destroyDean',$dean->dean_id) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:scale-105">
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
                <div class="mt-4">
                    <div class="flex justify-center">
                        <span class="text-gray-600 text-sm">Page {{ $deans->currentPage() }} of {{ $deans->lastPage() }}</span>
                    </div>
                        {{ $deans->links() }} <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

@endsection








<!-- <body>
    <h1 class="">Colleges</h1>
    <a href="{{ route('admin.createCollege') }}">Create New College</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Descripion</th>
                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
            <tr>
                <td>{{ $college->college_code }}</td>
                <td>{{ $college->college_description }}</td>
                <td>

                    <form action="{{ route('admin.editCollege', $college->college_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyCollege',$college->college_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h1 class="">Dean</h1>
    <a href="{{ route('createDean') }}">Assign Dean</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Start Validity</th>
                <th>End Validity</th>

                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deans as $dean)
            <tr>
                <td>{{ $dean->college_code }}</td>
                <td>{{ $dean->firstname }} {{ $dean->lastname }}</td>
                <td>{{ $dean->start_validity }}</td>
                <td>{{ $dean->end_validity }}</td>
                <td>

                    <form action="{{ route('editDean', $dean->dean_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('destroyDean',$dean->dean_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html> -->