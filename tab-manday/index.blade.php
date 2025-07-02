@extends('layouts.base')
@section('content')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Include DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Select2 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include your custom CSS -->
    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">


    <form id="searchMethod" method="get" enctype="multipart/form-data" action="{{ route('search.get') }}" style="margin-top: 20px; ">

        <div class="row d-flex flex-row justify-content-center align-items-center">
   
            <div class="col-3 d-flex p-2 align-items-center">     
                <label class="pe-2"><b>Engineer</b></label>
                <select class="form-control flex-grow-1" id="engineername" name="engineers[]" style="min-width: 0;">
                </select>
            </div>
    
            <div class="col-1 p-2">
                <input type="submit" value="Filter" name="search" class="btn btn-primary" />
            </div>
    
        </div>
    </form>

    <div class="row d-flex flex-row justify-content-center align-items-center mt-2 ps-3 pe-3">
        <div class="table-responsive">
            <table id="manday-table" class="table table-striped" style="width:100%">

                <thead>
                    <tr>
                        <th>Project Name</th> 
                        <th>Engineer Name</th>
                        <th>Time Exited</th>
                        <th>Time Reported</th>
                        <th>Manday</th>
                    </tr>
                </thead>
                
                <tbody>

                    @if (isset($GetEngineerManday))
                        @foreach ($GetEngineerManday as $totalManday)
                            <tr>
                                <td>{{ $totalManday->proj_name  ?? 'No Project Name' }}</td>
                                <td>{{$totalManday->engr_names }}</td>
                                <td>{{ $totalManday->exited_key_time }}</td>
                                <td>{{ $totalManday->reported_key_time }}</td>
                                <td>{{number_format($totalManday->manday , 3)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    {{-- Include Select2 script cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Include your script.js file -->
    <script src="{{ asset('assets/tab-manday/manday_script.js') }}"></script>
@endsection
