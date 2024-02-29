@extends('layouts.adminNav')
@include('layouts.modal')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')

    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
        table,
        tbody{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="mx-16">
            <div class="flex overflow-hidden">
                <h2 class="text-5xl ml-4 flex text-left text-black font-semibold leadi ">USERS</h2>
                <!-- <form class="whitespace-nowrap mb-8 max-w-full flex-grow text-right mr-8" action="{{ route('admin.home') }}" method="get">
                    <select class="form-control border w-80 border-sePrimary rounded p-1 bg-gray-200 px-2" name="roleFilter" id="roleFilter">
                        <option class="" value="all" {{ $roleFilter = 'all' ? 'selected' : '' }}>All Members</option>
                        <option value="2" {{ $roleFilter = '2' ? 'selected' : '' }}>Chairman</option>
                        <option value="3" {{ $roleFilter = '3' ? 'selected' : '' }}>Dean</option>
                        <option value="4" {{ $roleFilter = '4' ? 'selected' : '' }}>Bayanihan Leader</option>
                        <option value="5" {{ $roleFilter = '5' ? 'selected' : '' }}>Bayanihan Member</option>
                    </select>
                    <button class="bg-blue text-white p-1 mt-3 px-2 hover:drop-shadow-md rounded font-semibold" type="submit">Apply Filter</button>
                </form> -->
            </div>

            <div class="w-full overflow-x-auto">
                <div class="mx-4 mt-4 display-flex whitespace-nowrap content-start">
                    <button class="export_btn flex absolute content-start">
                        <a class="export_text relative p-2 flex display-flex text-right import_btn bg-seThird text-black font-semibold rounded hover:drop-shadow-md" href="{{ route('fileUserExport') }}">Export data</a>
                    </button>
                    <div class="import whitespace-nowrap">
                        <form action="{{ route('fileUserImport') }}" method="POST" enctype="multipart/form-data" class="relative w-full px-4 max-w-full float-right inline-block text-right">
                            @csrf
                            <button type="submit" class="import_btn flex display-flex float-right bg-seThird hover:bg-blue-400 py-1 text-black font-semibold px-2 rounded hover:drop-shadow-md">Import data</button>
                            <button class="custom_file">
                                <input type="file" name="file" class="custom-file-input relative w-full -mr-12" id="customFile">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <livewire:admin-user-table />
        </div>
    </div>

{{-- <script>
    $(document).ready(function() {
    $('.dropdown-menu').hide();

    $('.edit-btn').click(function(e) {
        e.preventDefault();
        $(this).next('.dropdown-menu').toggle();
    });
});
</script> --}}

<script>
    $(document).ready(function() {
        $('.dropdown-menu').hide();

        $('.edit-btn').click(function(e) {
            e.preventDefault();
            $('.dropdown-menu').not($(this).next('.dropdown-menu')).hide();
            $(this).next('.dropdown-menu').toggle();
        });

        // para ma close
        $(document).click(function(e) {
            if (!$(e.target).closest('.edit-btn').length && !$(e.target).closest('.dropdown-menu').length) {
                $('.dropdown-menu').hide();
            }
        });
    });
</script>
</body>

</html>
@endsection