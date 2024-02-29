<!-- @-extends('layouts.blNav') -->
@extends('layouts.blSidebar')
@section('content')
@include('layouts.modal')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
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
        table
        {
            border: 1px solid;
            border-collapse: collapse;
            padding: 4px;
            border-color: black;
        }
    </style>
</head>

<body>
    <div class="mt-[6%] ml-[4px]">
        <div class="mb-5 ml-11 mt-2 pt-2 w-[10%] hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded px-2 hover:bg-blue">
            <form action="{{ route('bayanihanleader.createSyllabus') }}" method="GET">
                @csrf
                <button type="submit" class="flex m-auto text-ml">
                    <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                        <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                    <div class="flex m-auto ml-2">
                        Create Syllabus
                    </div>
                </button>
            </form>
        </div>
    </div>
    <div class="m-auto p-8 bg-slate-100 mt-[10px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe]  w-11/12">
    <h1 class="font-bold text-4xl text-[#201B50] mb-8 text-center">List of Syllabus</h1>
        <!-- <div class="ml-12 mt-2 text-blue text-2xl font-semibold">
            Syllabi
        </div> -->

        <livewire:b-l-syllabus-table />

        <!-- Syllabus Cards                                 -->
        <!-- <div class="ml-10 mr-5 mt-5">
            <div class="grid grid-cols-5 gap-4 mt-2">
                @forelse ($syllabus as $key => $syll)
                <div class="bg-white w-58 h-72 h-auto min-h-fit bg- rounded-xl shadow-lg hover:scale-105 transition ease-in-out">
                    <div class="ml-[155px] flex justify-end">
                        <div class="bg-beige2 text-gray rounded-full w-max px-3 absolute mt-2 mr-2 bg-opacity-75">
                            {{$syll->status}}
                        </div>
                    </div>
                    <div class="w-fit">
                        @php
                        $imageIndex = $key % 10 + 1; // Cycle through images 1-10
                        @endphp
                        <img class="rounded-t-xl h-40" src="/assets/bg/{{ $imageIndex }}.png" alt="{{ $syll->course_title }}">
                    </div>
                    <div class="text-xl font-semibold mx-3 text-neutral-900 mt-1">
                        {{ $syll->course_title }}
                    </div>
                    <div class="text-neutral-900 font-semibold text-lg mx-3 mb-2">
                        {{ $syll->course_code }}
                    </div>
                    <div class="text-neutral-900 font-medium mx-3">
                        {{ $syll->bg_school_year }}
                    </div>
                    <div class="text-neutral-900 font-medium mx-3">
                        {{ $syll->course_semester }}
                    </div>
                    <div class="text-neutral-900 mx-3 text-sm">
                        Due by : {{ $syll-> dl_syll}}
                    </div>
                    <div class="text-neutral-900 mx-3 text-sm" id="remaining-time">
                        Remaining : Calculating...
                    </div>
                    <div class="flex flex-row justify-center">
                        <div class="mr-3 justify-end flex">
                            <form action="{{ route('bayanihanleader.destroySyllabus', $syll->syll_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this syllabus entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="shadow-lg rounded-full bg-blue text-white py-1 px-3 my-4">Delete</button>
                            </form>
                        </div>
                        <div class="flex">
                            <form action="{{ route('bayanihanleader.viewSyllabus', $syll->syll_id) }}" method="GET">
                                @csrf
                                <button type="submit" class="shadow-lg rounded-full bg-blue text-white py-1 px-3 my-4">View</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p>No Syllabus found</p>
                @endforelse
            </div>
        </div> -->


    </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var syll = <?php echo json_encode($syll ?? null); ?>;
            var dueDate = syll && syll.dl_syll ? new Date(syll.dl_syll) : null;

            if (dueDate) {
                function updateRemainingTime() {
                    var now = new Date();
                    var timeDifference = dueDate - now;
                    var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                    var remainingTimeElement = document.getElementById('remaining-time');
                    remainingTimeElement.innerText = 'Remaining: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                }

                updateRemainingTime();
                setInterval(updateRemainingTime, 1000);
            }
        });
    </script>
</body>

</html>
@endsection