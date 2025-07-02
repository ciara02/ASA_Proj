@extends('layouts.base')
@section('content')
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tab-point-system/point_system.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div id="loadingScreen" style="display: none;">
        <p>Please wait, your request is being processed...</p>
        <div class="progress" style="width: 80%;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
        </div>
      </div>
      
    <div class="container" style="margin-top: 1%;">

        <div class="card">

            <div class="card-header custom-background">
                MERIT AND DEMERIT CREATE NEW FORM
            </div>

            <form id="create-form" method="POST" action="{{ route('tab-point-system.store') }}" required class="custom-style">

                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-center gap-2">
                            <label for="validateAuthour" class="form-label">Author:</label>
                            <input type="text" class="form-control" id="validateAuthour" name="author"
                            value="{{ $ldapEngineer && $ldapEngineer->fullName ? $ldapEngineer->fullName : '' }}" readonly>
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label for="validateCreateddate" class="form-label col-md-4">Created On:</label>
                            <input type="date" class="form-control" id="validateCreateddate" name="createdDate"
                                value="{{ now()->format('Y-m-d') }}" required readonly>
                        </div>

                        <div class="col-md-4 d-flex align-items-center gap-2">

                            <label for="pointSystemDropdown" class="me-2">Type:</label>
                            <select class="form-control" id="pointSystemDropdown" name="type" aria-haspopup="true"
                                required aria-expanded="false" style="width: 200px;">
                                <option value="" selected>--Select Type--</option>
                                <option value="1">MERIT</option>
                                <option value="0">DEMERIT</option>
                            </select>

                        </div>

                        <div class="col-md-4 d-flex p-3 align-items-center gap-4">
                            <label for="engineers" class="form-label">Who:</label>
                            <select class="form-control" id="engineers" name="engineer[]" multiple required></select>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group d-flex gap-2">
                                    <label for="detailsTextarea"> Details:</label>
                                    <textarea class="form-control custom-box-size" name="details" id="detailsTextarea" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-radio">
                        <label id="severityLabel" for="pointSystemradiobutn" class="pointSystemradiobutn col-md-1 ">Severity:</label>
                        <div class="card-body-custom">
                            <div class="card-body-custom2 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="severity" id="level1radio" required
                                        value="1" onclick="updatePoints(1, 50)">
                                    <label class="form-check-label" for="level1radio">
                                        Level 1
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="severity" id="level2radio"
                                        value="2" onclick="updatePoints(2, 100)">
                                    <label class="form-check-label" for="level2radio">
                                        Level 2
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="severity" id="level3radio"
                                        value="3" onclick="updatePoints(3, 150)">
                                    <label class="form-check-label" for="level3radio">
                                        Level 3
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="severity" id="level4radio"
                                        value="4" onclick="updatePoints(4, 200)">
                                    <label class="form-check-label" for="level4radio">
                                        Level 4
                                    </label>
                                </div>
                            </div>
                            <div class="card-body-custom2">
                                <div class="textradiobtn">
                                    <h1 class="text-style" id="pointsDisplay1">(0.00) points</h1>
                                    <h1 class="text-style" id="pointsDisplay2">(00.00) amount</h1>
                                    <input type="hidden" id="hiddenSeverity" name="points" value="">
                                    <input type="hidden" id="hiddenPoints" name="amount" value="">
                                </div>
                            </div>
                        </div>
                        <div class="card-body custom-def col-md">
                            <div class="row">
                                <div class="form-group d-flex gap-2">
                                    <label for="defenseTextArea"> Defense:</label>
                                    <textarea class="form-control custom-box-size" name="defense" id="defenseTextArea" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        {{-- <div class="align-items-center gap-4" style="margin-top: 2%;">
                            <label for="statusvalidation" class="form-label">Status:</label>
                            <h1 style="font-size: 15px; font-weight: bold;"></h1>
                        </div> --}}
                    </div>

                    <div class="mb-3">
                        <label for="pointsystem_att" class="form-label">Upload File/s:</label>
                        <input class="form-control" type="file" id="pointsystem_att" name="files[]" multiple>
                    </div>

                </div>



        </div>

    </div>
    <div class="row mt-3 justify-content-center d-flex gap-5">

        <a href="{{ route('tab-point-system.index') }}" class="btn btn-danger col-md-1" type="button">Cancel</a>

        <button class="btn btn-info col-md-2" id="saveData" type="submit">Save & Notify
        </button>

    </div>
    </div>
    </form>


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/tab-point-system/point_system_script.js') }}"></script>
@endsection
