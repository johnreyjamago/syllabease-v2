@extends('layouts.BLsyllabus')
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
    <x-head.tinymce-config />
    <script src="https://cdn.tiny.cloud/1/ux8hih2n6kvrupg3ywetf1kdoav78vf12hcudnuhz6ftkl0x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        function handleConfirmation() {
            var confirmation = confirm("Are you sure you want to submit?");
            if (confirmation) {
                document.getElementById("submitForm").submit();
            } else {
                alert("Submission canceled.");
            }
        }
    </script>
    <style>
        .crq li {
            list-style-type: disc;
            list-style-position: inside;
            padding-left: 40px;
        }

        .crq tr {
            border: 1px solid #000;
        }

        .crq td,
        .crq th {
            border: 1px solid #000;
            padding: 8px;
        }

        .crq table {
            margin: 0 auto;
        }

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

        .view-feedback-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            width: 500px;
            height: 520px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
        }
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: rgba(128, 128, 128, 0.75);
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            left: 25%;
            margin-left: -60px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
        #ADCO .tooltiptext{
            top: 100%;
        }
        #CO .tooltiptext{
            bottom: 100%;
            
        }
        #Midterm .tooltiptext{
            top: 90%;
        }
        #EditMid .tooltiptext{
            top: 110%;
        }
        #Final .tooltiptext{
            bottom: 110%;
        }
        #EditFinal .tooltiptext{
            bottom: 110%;
        }

    </style>
</head>

<body class="font-thin ">
    @if($syll->chair_submitted_at != null && $syll->dean_submitted_at == null && $syll->chair_rejected_at == null)
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has already been submitted, and further edits are no longer permitted.
            </div>
        </div>
        <div class="flex mt-3 mx-auto">
            <div class="">
                <a href="{{ route('bayanihanleader.commentSyllabus', $syll_id) }}" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    View Comments
                </a>
            </div>
            <div class="">
                <a href="{{ route('bayanihanleader.replicateSyllabus', $syll_id) }}" method="post" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    Replicate Syllabus
                </a>
            </div>
        </div>
    </div>
    <!-- Returned by Chair  -->
    @elseif($syll->chair_rejected_at != null && $syll->status == 'Returned by Chair')
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has already been submitted, and further edits are no longer permitted.
            </div>
        </div>
        <div class="flex mt-3 mx-auto">
            <div class="">
                <a href="{{ route('bayanihanleader.viewReviewForm', $syll_id) }}" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    View Syllabus Review Form
                </a>
            </div>
            <div class="">
                <a href="{{ route('bayanihanleader.replicateSyllabus', $syll_id) }}" method="post" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    Replicate Syllabus
                </a>
            </div>
        </div>
    </div>
    <!-- Returned by Dean  -->
    @elseif($syll->dean_rejected_at != null && $syll->status == 'Returned by Dean')
    <div class="flex flex-col border-2 border-blue3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[110px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus has been returned by the dean for further revision.
            </div>
        </div>
        <div class="flex mt-3 mx-auto">
            <div class="">
                <button id="viewFeedback" type="submit" class="p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue">View Feedback</button>
                <a href="{{ route('bayanihanleader.replicateSyllabus', $syll_id) }}" method="post" class="m-2 p-2 items-center rounded shadow hover:text-white hover:bg-blue hover:bg-blue text-blue border border-blue">
                    Replicate Syllabus
                </a>
            </div>
        </div>
    </div>
    <div class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white  rounded-lg shadow-lg view-feedback-modal">
        <div class="mt-5 flex flex-col justify-center items-center">
            <div class="text-lg font-semibold">
                Feedback
            </div>
            <div class="mx-[30px] mt-5 h-[380px] border w-10/12 p-4 border-blue rounded">
                <div>
                    {{$feedback->syll_dean_feedback_text}}
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <button id="closeModalButton2" class="bg-blue px-3 py-2 rounded-lg text-white hover:bg-blue3">Done</button>
            </div>
        </div>
    </div>
    @elseif($syll->chair_submitted_at != null && $syll->dean_submitted_at != null && $syll->status == 'Approved by Chair')
    <div class="flex flex-col border-2 border-green3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[85px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#73d693" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span>This syllabus has already been approved by the chair and is awaiting dean approval; further edits are no longer permitted.
            </div>
        </div>
    </div>
    @elseif($syll->dean_approved_at != null && $syll->status == 'Approved by Dean')
    <div class="flex flex-col border-2 border-green3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[70px] mt-2 mx-auto">
        <div class="flex items-center justify-center">
            <div class="mx-1">
                <svg fill="#73d693" width="40px" height="40px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <title>notice1</title>
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span>This syllabus has already been <span class="font-semibold text-green">approved</span> by the chair and the dean; further edits are no longer permitted.
            </div>
        </div>
    </div>
    @else
    <div class="ml-28 mt-5">
        <div class="flex space-x-4">
            <div class="bg-blue py-2 px-3 text-white rounded shadow-lg hover:scale-105 transition ease-in-out">
                <form action="{{ route('bayanihanleader.editSyllabus', $syll_id) }}" method="GET">
                    @csrf
                    <div class="tooltip">
                    <div class="flex items-center space-x-2 ">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <button type="submit" class="btn btn-primary">Edit Syllabus Header</button>
                        <span class="tooltiptext font-sans text-xs">Edit</span>
                    </div>
                </div>
                </form>
            </div>
            <!-- course outcome -->
            <div class="relative parent hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5H21M3 14.5H21M8 4.5V19.5M6.2 19.5H17.8C18.9201 19.5 19.4802 19.5 19.908 19.282C20.2843 19.0903 20.5903 18.7843 20.782 18.408C21 17.9802 21 17.4201 21 16.3V7.7C21 6.5799 21 6.01984 20.782 5.59202C20.5903 5.21569 20.2843 4.90973 19.908 4.71799C19.4802 4.5 18.9201 4.5 17.8 4.5H6.2C5.0799 4.5 4.51984 4.5 4.09202 4.71799C3.71569 4.90973 3.40973 5.21569 3.21799 5.59202C3 6.01984 3 6.57989 3 7.7V16.3C3 17.4201 3 17.9802 3.21799 18.408C3.40973 18.7843 3.71569 19.0903 4.09202 19.282C4.51984 19.5 5.07989 19.5 6.2 19.5Z" stroke="#1148b1" stroke-width="2" />
                        </svg>
                        <span>Course Outcome</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="shadow-2xl pl-4 pt-1 child transition duration-300 md:absolute top-full right-0 md:w-52 bg-white shadow-2xl md:rounded-b-lg shadow-gray rounded-b-lg">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="ADCO" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Course Outcome</button>
                                        <span class="tooltiptext font-sans text-xs">Define what students will achieve, e.g., "Apply analytical skills to solve complex problems".</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Course Outcome</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 hover:text-sePrimary">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('bayanihanleader.editCoPo', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="CO" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg fill="#1148b1" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                            <path d="M23.2,10.2C18.1,5.1,10,3.5,2.9,5.7C2.6,5.7,2.2,6.2,2.2,7s0,3,0,3.9c0,0.8,0.7,1,1.1,0.9
                                                c5.4-2.2,12-1.2,16.3,3.3l1.1,1.1c0.6,0.6,0.1,1.7-0.7,1.7h-7.8c-0.8,0-1.5,0.6-1.5,1.5v3c0,0.8,0.6,1.5,1.5,1.5l19.2,0.2
                                                c0.8,0,1.5-0.6,1.5-1.5L33,3.5C33,2.7,32.4,2,31.5,2h-3c-0.8,0-1.6,0.6-1.6,1.4l-0.1,7.9c0,0.8-1.1,1.3-1.7,0.7
                                                C25.2,12.1,23.2,10.2,23.2,10.2z" />
                                            <path d="M3.5,27.8h3c0.8,0,1.5,0.7,1.5,1.5v13.2C8,43.3,8.7,44,9.5,44h33c0.8,0,1.5-0.7,1.5-1.5V16.9
                                                c0-0.8-0.7-1.5-1.5-1.5h-4c-0.8,0-1.5-0.7-1.5-1.5v-3c0-0.8,0.7-1.5,1.5-1.5H46c2.2,0,4,1.8,4,4V46c0,2.2-1.8,4-4,4H6
                                                c-2.2,0-4-1.8-4-4V29.3C2,28.5,2.7,27.8,3.5,27.8z" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Assign CO Code</button>
                                        <span class="tooltiptext font-sans text-xs">Determine what course outcomes Code is to be assigned e.g E for Enabling Course</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Course outline -->
            <div class="relative parent hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg fill="#1148b1" width="25px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1801.441 0v1920H219.03v-439.216h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.47 56.515-56.47h56.514V1029.02h-56.514c-31.196 0-56.515-25.3-56.515-56.471 0-31.172 25.319-56.47 56.515-56.47h56.514V577.254h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.471 56.515-56.471h56.514V0h1582.412Zm-113.03 112.941H332.06v351.373h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.3 56.514 56.471 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.471-56.514 56.471H332.06v326.275h1356.353V112.94ZM640.289 425.201H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Zm0 534.845H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Z" fill-rule="evenodd" />
                        </svg>
                        <span>Course Outline</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="shadow-2xl pl-4 pt-1 child transition duration-300 md:absolute top-full right-0 md:w-52 bg-white shadow-2xl md:rounded-b-lg shadow-gray rounded-b-lg">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCot', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="Midterm" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Midterm Course Outline</button>
                                        <span class="tooltiptext font-sans text-xs">Outline the key topics and assessments covered for Midterm, e.g., "4hrs, Week 1-3: Introduction to Programming, Quiz"</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-yellow pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCotRowM', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="EditMid" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Midterm Course Outline Order</button>
                                        <span class="tooltiptext font-sans text-xs">Edit the existing midterm course outline</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCotF', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="Final" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Add Final Course Outline</button>
                                        <span class="tooltiptext font-sans text-xs">Outline the key topics and assessments covered for the Final term, e.g., "4hrs, Week 1-3: Introduction to Programming, Quiz/Exam/"</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li class="text-yellow pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.editCotRowF', $syll_id) }}" method="GET">
                                    @csrf
                                    <div id="EditFinal" class="tooltip">
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Final Course Outline Order</button>
                                        <span class="tooltiptext font-sans text-xs">Edit the existing final course outline</span>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </li>
                        <!-- <li class="text-blue pb-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.viewSyllabus', $syll_id) }}" method="GET">
                                    @csrf
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Course Outline</button>
                                    </div>
                                </form>
                            </div>
                        </li> -->
                    </ul>
                </div>
                <!-- Course Requirements -->
            </div>
            <div class="relative parent hover:bg-blue2 bg-white py-2 px-3 text-white rounded shadow-lg">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9.5H21M3 14.5H21M8 4.5V19.5M6.2 19.5H17.8C18.9201 19.5 19.4802 19.5 19.908 19.282C20.2843 19.0903 20.5903 18.7843 20.782 18.408C21 17.9802 21 17.4201 21 16.3V7.7C21 6.5799 21 6.01984 20.782 5.59202C20.5903 5.21569 20.2843 4.90973 19.908 4.71799C19.4802 4.5 18.9201 4.5 17.8 4.5H6.2C5.0799 4.5 4.51984 4.5 4.09202 4.71799C3.71569 4.90973 3.40973 5.21569 3.21799 5.59202C3 6.01984 3 6.57989 3 7.7V16.3C3 17.4201 3 17.9802 3.21799 18.408C3.40973 18.7843 3.71569 19.0903 4.09202 19.282C4.51984 19.5 5.07989 19.5 6.2 19.5Z" stroke="#1148b1" stroke-width="2" />
                        </svg>
                        <span>Course Requirements</span>
                        <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 15l-4.243-4.243 1.415-1.414L12 12.172l2.828-2.829 1.415 1.414z" stroke="#1148b1" />
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded-b-lg ">
                    <ul class="shadow-2xl pl-4 pt-1 child transition duration-300 md:absolute top-full right-0 md:w-52 bg-white shadow-2xl md:rounded-b-lg shadow-gray rounded-b-lg">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form action="{{ route('bayanihanleader.createCrq', $syll_id) }}" method="GET">
                                    @csrf
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#1148b1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <button type="submit" class="btn btn-primary">Edit Course Requirements</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Submit  -->
            <div class="relative parent hover:bg-green3 hover:scale-105 text-green bg-green2 py-2 px-3 rounded shadow-lg">
                <a class=" space-x-2 ">
                    <form id="submitForm" action="{{ route('bayanihanleader.submitSyllabus', $syll_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-2">
                            <svg width="20px" height="20px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M905.92 237.76a32 32 0 0 0-52.48 36.48A416 416 0 1 1 96 512a418.56 418.56 0 0 1 297.28-398.72 32 32 0 1 0-18.24-61.44A480 480 0 1 0 992 512a477.12 477.12 0 0 0-86.08-274.24z" fill="#31a858" />
                                <path d="M630.72 113.28A413.76 413.76 0 0 1 768 185.28a32 32 0 0 0 39.68-50.24 476.8 476.8 0 0 0-160-83.2 32 32 0 0 0-18.24 61.44zM489.28 86.72a36.8 36.8 0 0 0 10.56 6.72 30.08 30.08 0 0 0 24.32 0 37.12 37.12 0 0 0 10.56-6.72A32 32 0 0 0 544 64a33.6 33.6 0 0 0-9.28-22.72A32 32 0 0 0 505.6 32a20.8 20.8 0 0 0-5.76 1.92 23.68 23.68 0 0 0-5.76 2.88l-4.8 3.84a32 32 0 0 0-6.72 10.56A32 32 0 0 0 480 64a32 32 0 0 0 2.56 12.16 37.12 37.12 0 0 0 6.72 10.56zM230.08 467.84a36.48 36.48 0 0 0 0 51.84L413.12 704a36.48 36.48 0 0 0 51.84 0l328.96-330.56A36.48 36.48 0 0 0 742.08 320l-303.36 303.36-156.8-155.52a36.8 36.8 0 0 0-51.84 0z" fill="#31a858" />
                            </svg>
                            <button type="button" class="btn btn-primary" onclick="handleConfirmation()">Submit</button>
                        </div>
                    </form>
                </a>
            </div>


            <!-- <div class="relative parent py-2 px-3 text-white rounded">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5 4C14.5 5.38071 13.3807 6.5 12 6.5C10.6193 6.5 9.5 5.38071 9.5 4C9.5 2.61929 10.6193 1.5 12 1.5C13.3807 1.5 14.5 2.61929 14.5 4Z" fill="#ffffff" />
                            <path d="M14.5 12C14.5 13.3807 13.3807 14.5 12 14.5C10.6193 14.5 9.5 13.3807 9.5 12C9.5 10.6193 10.6193 9.5 12 9.5C13.3807 9.5 14.5 10.6193 14.5 12Z" fill="#ffffff" />
                            <path d="M12 22.5C13.3807 22.5 14.5 21.3807 14.5 20C14.5 18.6193 13.3807 17.5 12 17.5C10.6193 17.5 9.5 18.6193 9.5 20C9.5 21.3807 10.6193 22.5 12 22.5Z" fill="#ffffff" />
                        </svg>
                    </div>
                </a>
                <div class="rounded">
                    <ul class="shadow-2xl pl-4 pt-1 child transition duration-300 md:absolute top-full md:w-[120px] bg-white shadow-2xl shadow-gray rounded">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div class="">
                                <form id="submitForm" action="{{ route('bayanihanleader.submitSyllabus', $syll_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center space-x-2">
                                        <svg width="20px" height="20px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M905.92 237.76a32 32 0 0 0-52.48 36.48A416 416 0 1 1 96 512a418.56 418.56 0 0 1 297.28-398.72 32 32 0 1 0-18.24-61.44A480 480 0 1 0 992 512a477.12 477.12 0 0 0-86.08-274.24z" fill="#1148b1" />
                                            <path d="M630.72 113.28A413.76 413.76 0 0 1 768 185.28a32 32 0 0 0 39.68-50.24 476.8 476.8 0 0 0-160-83.2 32 32 0 0 0-18.24 61.44zM489.28 86.72a36.8 36.8 0 0 0 10.56 6.72 30.08 30.08 0 0 0 24.32 0 37.12 37.12 0 0 0 10.56-6.72A32 32 0 0 0 544 64a33.6 33.6 0 0 0-9.28-22.72A32 32 0 0 0 505.6 32a20.8 20.8 0 0 0-5.76 1.92 23.68 23.68 0 0 0-5.76 2.88l-4.8 3.84a32 32 0 0 0-6.72 10.56A32 32 0 0 0 480 64a32 32 0 0 0 2.56 12.16 37.12 37.12 0 0 0 6.72 10.56zM230.08 467.84a36.48 36.48 0 0 0 0 51.84L413.12 704a36.48 36.48 0 0 0 51.84 0l328.96-330.56A36.48 36.48 0 0 0 742.08 320l-303.36 303.36-156.8-155.52a36.8 36.8 0 0 0-51.84 0z" fill="#1148b1" />
                                        </svg>
                                        <button type="button" class="btn btn-primary" onclick="handleConfirmation()">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> -->

            <!-- <div class="relative parent py-2 px-3 text-white rounded">
                <a class="text-blue space-x-2 ">
                    <div class="flex items-center space-x-2">
                        <svg width="25px" height="25pxpx" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-99.000000, -520.000000)" fill="#e65a45">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M52.45,371.512 L52.45,364.512 C52.45,363.96 52.9204,363.512 53.5,363.512 C54.0796,363.512 54.55,363.96 54.55,364.512 L54.55,371.512 C54.55,372.064 54.0796,372.512 53.5,372.512 C52.9204,372.512 52.45,372.064 52.45,371.512 L52.45,371.512 Z M54.55,374.512 C54.55,375.064 54.0796,375.512 53.5,375.512 C52.9204,375.512 52.45,375.064 52.45,374.512 C52.45,373.96 52.9204,373.512 53.5,373.512 C54.0796,373.512 54.55,373.96 54.55,374.512 L54.55,374.512 Z M45.1,378 L61.9,378 L61.9,362 L45.1,362 L45.1,378 Z M43,380 L64,380 L64,360 L43,360 L43,380 Z" id="important_message-[#1449]">

                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                </a>
                <div class="rounded">
                    <ul class="shadow-2xl pl-4 pt-1 child transition duration-300 md:absolute top-full md:w-[180px] bg-white shadow-2xl shadow-gray rounded">
                        <li class="text-blue pb-4 pt-4 hover:text-sePrimary">
                            <div>
                                <form id="" action="{{ route('bayanihanleader.viewReviewForm', $syll_id) }}" method="get">
                                    @csrf
                                    <button type="submit" class="mx-5 btn btn-primary">Syllabus Review Form</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                </li>
                </ul>
            </div> -->
        </div>
    </div>
    @endif
    </div>


    </div>

    <table class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white">
        <!-- 1st Header -->
        <tr>
            <th colspan="2" class="font-medium border-2 border-solid px-4">
                <span class="font-bold">{{$syll->college_description}}</span><br>
                {{$syll->department_name}}
            </th>

            <th class="font-medium border-2 border-solid text-left px-4 w-2/6">
                <span class="font-bold underline underline-offset-4">Syllabus<br></span>
                Course Title :<span class="font-bold">{{$syll->course_title}}<br></span>
                Course Code: {{$syll->course_code}}<br>
                Credits: {{$syll->course_credit_unit}} units ({{$syll->course_unit_lec}} hours lecture, {{$syll->course_unit_lab}} hrs Laboratory)<br>
            </th>
        </tr>
        <!-- 2nd Header -->
        <tr class="">
            <td class="border-2 border-solid font-medium  text-sm text-left px-4 text-justify align-top">
                <!-- VISION -->
                <div class="mt-2 mb-8">
                    <span class="font-bold">USTP Vision<br><br></span>
                    <p>The University is a nationally recognized Science and Technology University providing the vital link between education and the economy.</p>
                </div>
                <!-- MISSION -->
                <div class="mb-8">
                    <span class="font-bold">USTP Mission<br><br></span>
                    <ul class="list-disc">
                        <li class="ml-8">
                            Bring the world of work (industry) into the actual higher education and training of students;
                        </li>
                        <li class="ml-8">
                            Offer entrepreneurs the opportunity to maximize their business potentials through a gamut of services from product conceptualization to commercialization;
                        </li>
                        <li class="ml-8">
                            Contribute significantly to the National Development Goals of food security an energy sufficiency through technological solutions.
                        </li>
                    </ul>
                </div>
                <!-- POE -->
                <div class="mb-8">
                    <span class="font-bold">Program Educational Objectives<br><br></span>
                    @foreach($poes as $poe)
                    <div class="mb-2">
                        <p><span class="font-semibold">{{$poe->poe_code}}: </span>{{$poe->poe_description}}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mb-8">
                    <span class="font-bold">Program Outcomes<br><br></span>
                    @foreach($programOutcomes as $po)
                    <div class="mb-5">
                        <p><span class="font-semibold leading-relaxed">{{$po->po_letter}}: </span>{{$po->po_description}}</p>
                    </div>
                    @endforeach
                </div>

                <table class="table-auto border-2 mb-5">
                    <thead class="border-2">
                        <tr>
                            <th class="border-2 text-center py-1">Code</th>
                            <th class="border-2 text-center">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="border-2 text-center py-2">I</td>
                            <td class="border-2 text-center">Introductory Course</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-2">E</td>
                            <td class="border-2 text-center">Enabling Course</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-2">D</td>
                            <td class="border-2 text-center">Demonstrative Course</td>
                        </tr>
                        <tr class="font-semibold">
                            <td class="border-2 text-center py-1">Code</td>
                            <td class="border-2 text-center">Definition</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">I</td>
                            <td class="border-2 text-center">An introductory course to an outcome</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">E</td>
                            <td class="border-2 text-center">A course strengthens an outcome</td>
                        </tr>
                        <tr>
                            <td class="border-2 text-center py-5">D</td>
                            <td class="border-2 text-center">A Course demonstrating an outcome</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td colspan="2" class="w-[10/12] align-top">
                <table class="my-4 mx-2 ">
                    <tr class="">
                        <td class="border-2 border-solid font-medium text-left px-4 w-1/2">
                            Semester/Year: {{$syll->course_semester}} SY{{$syll->bg_school_year}}<br>
                            Class Schedule:{!! nl2br(e($syll->syll_class_schedule)) !!}<br>
                            Bldg./Rm. No. {{$syll->syll_bldg_rm}}
                        </td>
                        <td class="border-2 border-solid font-medium  text-start text-top px-4">
                            Pre-requisite(s): {{$syll->course_pre_req}} <br>
                            Co-requisite(s): {{$syll->course_co_req}}
                        </td>
                    </tr>

                    <tr>
                        <td class="items-start border-2 border-solid font-medium text-left px-4">
                            Instructor:
                            <!-- @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                            <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @endforeach <br> -->
                            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
                            @if ($loop->first)
                            <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @elseif ($loop->last)
                            and <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @else
                            , <span class="font-bold">{{ $instructor->firstname }} {{ $instructor->lastname }}</span>
                            @endif
                            @endforeach
                            <br>
                            Email:
                            @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                            {{ $instructor->email }}
                            @endforeach <br>
                            Phone:
                            @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                            {{ $instructor->phone }}
                            @endforeach <br>
                        </td>
                        <td class="border-2 border-solid font-medium text-left px-4">
                            Consultation Schedule: {!! nl2br(e($syll->syll_ins_consultation)) !!}<br>
                            Bldg rm no: {{$syll->syll_ins_bldg_rm}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 class="items-start border-2 border-solid font-medium text-left px-4 ">
                            <span class="text-left font-bold">
                                I. Course Descripion:</span><br>
                            {{ $syll->syll_course_description }}
                        </td>
                    </tr>
                    <tr class="">
                        <!-- course_outcome table-->
                        <td colspan=2 class=" border-2 border-solid font-medium px-4">
                            <span class="text-left font-bold">
                                II. Course Outcome:</span><br>
                            <table class="m-10 mx-auto border-2 border-solid w-11/12">
                                <tr class="border-2 border-solid">
                                    <th>
                                        Course Outcomes (CO)
                                    </th>
                                    @foreach($programOutcomes as $po)
                                    <th class="border-2 border-solid">
                                        {{$loop->iteration}}
                                    </th>
                                    @endforeach
                                </tr>

                                @foreach($courseOutcomes as $co)
                                <tr class="border-2 border-solid">
                                    <td class="w-64 text-left font-medium px-2"><span class="font-bold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
                                    @foreach($programOutcomes as $po)
                                    <td class="border-2 border-solid font-medium text-center py-1">
                                        @foreach ($copos as $copo)
                                        @if($copo->syll_po_id == $po->po_id)
                                        @if($copo->syll_co_id == $co->syll_co_id)
                                        {{$copo->syll_co_po_code}}
                                        @endif
                                        @endif
                                        @endforeach
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <!-- course outline tr -->
                    <tr>
                        <td colspan=2 class=" border-2 border-solid font-medium px-4">
                            <span class="text-left font-bold">
                                III. Course Outline:</span><br>
                            <table class="m-5 mx-auto border-2 border-solid w-">
                                <tr class="border-2 border-solid">
                                    <th class="border-2 border-solid">
                                        Alloted Time
                                    </th>
                                    <th class="border-2 border-solid">
                                        Course Outcomes (C)
                                    </th>
                                    <th class="border-2 border-solid">
                                        Intended Learning Outcome (ILO)
                                    </th>
                                    <th class="border-2 border-solid">
                                        Topics
                                    </th>
                                    <th class="border-2 border-solid">
                                        Suggested Readings
                                    </th>
                                    <th class="border-2 border-solid">
                                        Teaching Learning Activities
                                    </th>
                                    <th class="border-2 border-solid">
                                        Assessment Tasks/Tools
                                    </th>
                                    <th class="border-2 border-solid">
                                        Grading Criteria
                                    </th>
                                    <th class="border-2 border-solid">
                                        Remarks
                                    </th>
                                </tr>

                                @foreach($courseOutlines as $cot)
                                <tr class="border-2 border-solid">
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_allotted_hour)) !!} hours
                                        <div>
                                            {!! nl2br(e($cot->syll_allotted_time)) !!}
                                        </div>
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        @foreach ($cotCos->get($cot->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_intended_learning)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_topics)) !!}

                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_suggested_readings)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_learning_act)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_asses_tools)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_grading_criteria)) !!}
                                    </td>
                                    <td class="border-2 border-solid p-2">
                                        {!! nl2br(e($cot->syll_remarks)) !!}
                                    </td>
                                    @if($syll->chair_submitted_at == null)
                                    <td class="p-2 flex">
                                        <form action="{{ route('bayanihanleader.editCot', ['syll_co_out_id' => $cot->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="p-1"><svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                                    <path fill="#000000" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                                                </svg></button>
                                        </form>
                                        <form action="{{ route('bayanihanleader.destroyCot', ['syll_co_out_id' => $cot->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=""><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M14 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M4 7H20" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach

                                <tr class="border-2 border-solid p-2">
                                    <th colspan=10 class="border-2 border-solid font-medium px-4">
                                        MIDTERM EXAMINATION
                                    </th>
                                </tr>
                                @foreach($courseOutlinesFinals as $cotf)
                                <tr class="border-2 border-solid p-2">
                                    <td class="border-2 border-solid p-2">
                                        <!-- {{$cotf->syll_allotted_time}} -->
                                        {!! nl2br(e($cotf->syll_allotted_hour)) !!} hours
                                        <div>
                                            {!! nl2br(e($cotf->syll_allotted_time)) !!}
                                        </div>
                                    </td>
                                    <td class="border-2 border-solid">
                                        <!-- @foreach ($cotCosF->get($cotf->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach -->
                                        @foreach ($cotCosF->get($cotf->syll_co_out_id, []) as $index => $coo)
                                        {{ $coo->syll_co_code }}@unless($loop->last),@endunless
                                        @endforeach
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_intended_learning)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_topics)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_suggested_readings)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_learning_act)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_asses_tools)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_grading_criteria)) !!}
                                    </td>
                                    <td class="border-2 border-solid">
                                        {!! nl2br(e($cotf->syll_remarks)) !!}
                                    </td>
                                    @if($syll->chair_submitted_at == null)
                                    <td class="border-solid p-1 flex">
                                        <form action="{{ route('bayanihanleader.editCotF', ['syll_co_out_id' => $cotf->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="p-1"> <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                                    <path fill="#000000" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                                                </svg></button>
                                        </form>
                                        <form action="{{ route('bayanihanleader.destroyCotF', ['syll_co_out_id' => $cotf->syll_co_out_id, 'syll_id' => $syll_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=""><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M14 11V17" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M4 7H20" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan=10 class="border-2 border-solid font-medium px-4">
                                        FINAL EXAMINATION
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- course Requirements -->
                    <tr class="crq border-2">
                        <td colspan="2" class="border-2 border-solid font-medium">
                            <span class="text-left font-bold">
                                IV. Course Requirements:
                            </span><br>
                            <div class="crq">
                                {!! $syll->syll_course_requirements !!}
                            </div>
                        </td>
                    </tr>
        </tr>
    </table>
    <div class="grid grid-cols-3 m-3">
        <div class="">
            <div class="flex justify-center">
                Prepared By:
            </div>
            @foreach ($instructors[$syll->syll_id] ?? [] as $key => $instructor)
            <div>
                @if($syll->chair_submitted_at != null)
                <div class="flex justify-center mt-20">
                    sgd
                </div>
                @else
                <div class="flex justify-center mt-20">

                </div>
                @endif
                <div class="flex justify-center font-semibold underline">
                    {{ strtoupper($instructor->prefix) }} {{ strtoupper($instructor->firstname) }} {{ strtoupper($instructor->lastname) }} {{ strtoupper($instructor->suffix) }}
                </div>
                <div class="flex justify-center">
                    Instructor
                </div>
            </div>
            @endforeach
        </div>
        <div>
            <div class="flex justify-center">
                Checked and Recommended for Approval:
            </div>
            @if($syll->dean_submitted_at != null)
            <div class="flex justify-center mt-20">
                sgd
            </div>
            @else
            <div class="flex justify-center mt-20">

            </div>
            @endif
            <div class="flex justify-center font-semibold underline">
                {{ strtoupper($syll->syll_chair) }}
            </div>
            <div class="flex justify-center">
                Chairperson, {{$syll->department_name}}
            </div>
        </div>
        <div>
            <div class="flex justify-center">
                Approved by:
            </div>
            @if($syll->dean_approved_at != null)
            <div class="flex justify-center mt-20">
                sgd
            </div>
            @else
            <div class="flex justify-center mt-20">

            </div>
            @endif
            <div class="flex justify-center font-semibold underline">
                {{ strtoupper($syll->syll_dean) }}
            </div>
            <div class="flex justify-center">
                Dean, {{$syll->college_code}}
            </div>
        </div>
    </div>
    </td>
    </table>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rejectButton = document.getElementById("viewFeedback");
            var feedbackModal = document.querySelector(".view-feedback-modal");
            var overlay = document.getElementById("overlay");

            rejectButton.addEventListener("click", function() {
                feedbackModal.style.display = "block";
                overlay.style.display = "block";
            });

            // Close modal functionality
            var closeModalButton2 = document.getElementById("closeModalButton2");

            closeModalButton2.addEventListener("click", function() {
                feedbackModal.style.display = "none";
                overlay.style.display = "none";
            });
            var closeModalButton2 = document.getElementById("closeModalButton2");

            closeModalButton.addEventListener("click", function() {
                feedbackModal.style.display = "none";
                overlay.style.display = "none";
            });
        });
    </script>
</body>

</html>
@endsection