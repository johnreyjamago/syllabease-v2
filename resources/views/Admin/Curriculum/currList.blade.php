
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
    <div class="min-h-screen bg-swhite py-5 ml-16 mr-16 mx-auto m-12">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <h2 class="text-3xl text-black -mb-[30px] font-semibold">Curricula</h2>
                    <a class="whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full float-right" href="{{ route('admin.createCurr') }}">
                        <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Create new Curriculum</a>
                </div>
            </div>
        </div>
        <div class='overflow-x-auto w-full'>
            <table class='w-full border table-auto overflow-scroll w-full p-6 text-left whitespace-nowrap'>
                <thead class="bg-gray-900 border">
                    <tr class="bg-blue text-2xl text-white">
                        <th class="font-bold text-sm uppercase px-6 py-4"> Code </th>
                        <th class="font-bold text-sm uppercase px-6 py-4"> Effectivity </th>
                        <th class="font-bold text-sm uppercase px-6 py-4 text-center"> Department </th>
                        <th class="font-bold text-sm uppercase px-6 py-4 text-center"> </th>
                        <th class="font-bold text-sm uppercase px-6 py-4"> </th>
                    </tr>
                </thead>

                            <tbody class="divide-y divide-[#e5e7eb] bg-[#f9fafb]">
                                @foreach ($curricula as $curriculum)
                                <tr>
                                    <td class="px-6 py-4 font-bold">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <p> {{ $curriculum->curr_code }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class=""> {{ $curriculum->effectivity }}</p>
                                    </td>

                                    <td class="px-6 py-4 text-center"> <span class="">{{ $curriculum->department_code }}</span> </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.editCurr', $curriculum->curr_id) }}" method="GET">
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
                                        <form action="{{ route('admin.destroyCurr',$curriculum->curr_id) }}" method="Post">
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
                                <span class="text-gray-600 text-sm">Page {{ $curricula->currentPage() }} of {{ $curricula->lastPage() }}</span>
                            </div>

                            {{ $curricula->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection








<!-- <body>
    <h1 class="">Curricula</h1>
    <a href="{{ route('admin.createCurr') }}">Create New Curriculum</a>

    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Effectivity</th>
                <th>Department</th>
                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curricula as $curriculum)
            <tr>
                <td>{{ $curriculum->curr_code }}</td>
                <td>{{ $curriculum->effectivity }}</td>
                <td>{{ $curriculum->department_code }}</td>
                <td>


                    <form action="{{ route('admin.editCurr', $curriculum->curr_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyCurr',$curriculum->curr_id) }}" method="Post">
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

 -->