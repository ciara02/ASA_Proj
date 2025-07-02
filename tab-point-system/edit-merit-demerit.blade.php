@extends('layouts.base')
@section('content')
    <link href="{{ asset('assets/tab-activity/newproj.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/tab-point-system/point_system.css') }}" rel="stylesheet">
    <div class="container">


        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="loadingScreen" style="display: none;">
            <p>Please wait, your request is being processed...</p>
            <div class="progress" style="width: 80%;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
            </div>
          </div>

        <form id="editform" action="{{ route('tab-point-system.update') }}" method="POST" enctype="multipart/form-data" data-id="{{ $record->id }}">
            @method('PUT')
            @csrf
         @if(Route::currentRouteName() == 'tab-point-system.edit')   
            <div class="card">
                <div class="card-header custom-background">
                    MERIT AND DEMERIT EDIT FORM
                </div>
                        <input type="hidden" id="pointsystemID" name="pointsystemID" value="{{ $record->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center gap-2">
                                <label for="validateAuthour" class="form-label">Author:</label>
                                <input type="text" class="form-control always-readonly" id="validateAuthour" name="author" readonly
                                value="{{ $record->author }}">
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-4">
                                <label for="validateCreateddate" class="form-label col-md-4">Created On:</label>
                                <input type="text" class="form-control always-readonly" id="validateCreateddate" name="createdDate" readonly
                                    value="{{ $record->created_date }}">
                            </div>

                            <div class="col-md-4 d-flex align-items-center gap-2">


                                <label for="pointSystemDropdown" class="me-2">Type:</label>
                                <select class="form-select" id="pointSystemDropdown" data-bs-toggle="dropdown" required
                                    aria-haspopup="true" aria-expanded="false" style="width: 200px;" required
                                    name="type">
                                    <option value="1" {{ $record->type == 1 ? 'selected' : '' }}>MERIT</option>
                                    <option value="0" {{ $record->type == 0 ? 'selected' : '' }}>DEMERIT</option>
                                </select>

                            </div>

                            <div class="col-md-4 d-flex p-3 align-items-center gap-4">
                                <label for="engineerEdit" class="form-label">Who:</label>
                                <select name="engineer" id="engineerEdit" class="form-control" required>
                                    <!-- Option for existing engineer value -->
                                    @if (isset($record->engineer))
                                        <option value="{{ $record->engineer ?? '' }}" selected>{{ $record->engineer ?? '' }}
                                        </option>
                                    @endif
                                </select>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group d-flex gap-2">
                                        <label for="detailsTextarea"> Details:</label>
                                        <textarea type="text" name="details" class="form-control custom-box-size " id="detailsTextarea" value="">{{ $record->details }} </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body-radio">
                            <label id="severityLabel" for="pointSystemradiobutn" class="pointSystemradiobutn col-md-1">Severity:</label>
                            <div class="card-body-custom">
                                <div class="card-body-custom2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="severity" id="level1radio"
                                            value="1" onclick="updatePoints(1, 50)" required
                                            {{ $record->points == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="level1radio">
                                            Level 1
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="severity" id="level2radio"
                                            value="2" onclick="updatePoints(2, 100)"
                                            {{ $record->points == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="level2radio">
                                            Level 2
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="severity" id="level3radio"
                                            value="3" onclick="updatePoints(3, 150)"
                                            {{ $record->points == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="level3radio">
                                            Level 3
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="severity" id="level4radio"
                                            value="4" onclick="updatePoints(4, 200)"
                                            {{ $record->points == 4 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="level4radio">
                                            Level 4
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body-custom2">
                                    <div class="textradiobtn">
                                        <h1 class="text-style" id="pointsDisplay1">({{ $record->points }}.00) points</h1>
                                        <h1 class="text-style" id="pointsDisplay2">({{ $record->amount }}.00) amount</h1>
                                        <input type="hidden" id="hiddenSeverity" name="points"
                                            value="{{ $record->points }}">
                                        <input type="hidden" id="hiddenPoints" name="amount"
                                            value="{{ $record->amount }}">

                                    </div>
                                </div>
                            </div>


                            <div class="card-body custom-def col-md">
                                <div class="row">
                                    <div class="form-group d-flex gap-2">
                                        <label for="defenseTextarea"> Defense:</label>
                                        <textarea name="defense" class="form-control custom-box-size">{{ $record->defense }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-5">
                            <p class="text" style="color: rgb(0, 0, 0);"><b>Attachments:</b></p>
                            <div id="pointsystem_att_edit_Display" class="mt-3 d-flex flex-wrap gap-3">
                                @if(count($attachments) === 0 || $attachments->every(fn($attachment) => empty($attachment))) 
                                    <p>No attachments found</p>
                                @else
                                    @foreach($attachments as $attachment)
                                        @php
                                            $fileName = basename($attachment); // Extract the file name
                                            $fileExtension = pathinfo($attachment, PATHINFO_EXTENSION); // Get the file extension
                                        @endphp
                                        <div id="file-{{ $loop->index }}" class="attachment-item d-flex flex-column align-items-center">
                                            <span class="file-icon" data-extension="{{ $fileExtension }}"></span>
                                            <a href="/uploads/PointSystem-Attachments/{{ $attachment }}" 
                                               target="_blank" 
                                               download="{{ $fileName }}" 
                                               class="mt-2 text-center file-name" 
                                               title="{{ $fileName }}"> <!-- Tooltip for full file name -->
                                                {{ $fileName }}
                                            </a>
                                            <button class="delete-file-btn btn btn-danger mt-2" data-file="{{ $attachment }}" style="display:none;" type="button">
                                                Delete
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                            
                        <div id="uploadFileEdit">
                            <div class="mb-3">
                                <label for="pointsystem_att_edit" class="form-label">Upload File/s:</label>
                                <input class="form-control" type="file" id="pointsystem_att_edit" name="files[]" multiple>
                            </div>   
                        </div>
                          
                        
                        <div>
                            <div class="col-md-4 d-flex align-items-center gap-2" style="margin-top: 1%;">
                                <label for="statusvalidation" class="form-label">Status:</label>
                                <h1 id="statusValue" style="font-size: 15px; font-weight: bold;">{{ $record->status }}</h1>
                            </div>
                        </div>


                    </div>
              
            </div>
            @endif 
            <!-- Show default buttons -->
            <div class="row mt-3 justify-content-center d-flex gap-5">
                @if(Route::currentRouteName() == 'tab-point-system.edit')
                <a href="{{ route('tab-point-system.index') }}" class="btn btn-danger col-md-1" id="cancel" type="button">Back</a>
                @if($isAllowedToEdit)
                    <button class="btn btn-primary col-md-1" id="edit-merit" type="button">Edit</button>
                @endif
                <button class="btn btn-info col-md-2" id="save-merit" type="submit" disabled name="save-all">Save & Notify</button>
                @endif                              
            </div>
        </form>

            <form id="updateLevelForm" action="{{ route('tab-point-system.updateLevel') }}" method="POST" class="d-inline" enctype="multipart/form-data" data-id="{{ $record->id }}">
                @method('PUT')
                @csrf
                @if(Route::currentRouteName() == 'tab-point-system.edit-approval')
                
                <div class="card">
                    <div class="card-header custom-background">
                        MERIT AND DEMERIT EDIT FORM
                    </div>
                    <input type="hidden" id="approval_pointsystemID" name="approval_pointsystemID" value="{{ $record->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center gap-2">
                                    <label for="validateAuthour" class="form-label">Author:</label>
                                    <input type="text" class="form-control always-readonly" id="validateAuthour" name="author" readonly
                                        value="{{ $record->author }}">
                                </div>
    
                                <div class="col-md-4 d-flex align-items-center gap-4">
                                    <label for="validateCreateddate" class="form-label col-md-4">Created On:</label>
                                    <input type="date" class="form-control always-readonly" id="validateCreateddate" name="createdDate" readonly
                                        value="{{ $record->created_date }}">
                                </div>
    
                                <div class="col-md-4 d-flex align-items-center gap-2">
    
    
                                    <label for="pointSystemDropdown" class="me-2">Type:</label>
                                    <select class="form-select" id="pointSystemDropdown" data-bs-toggle="dropdown" required
                                        aria-haspopup="true" aria-expanded="false" style="width: 200px;" required disabled
                                        name="type">
                                        <option value="1" {{ $record->type == 1 ? 'selected' : '' }}>MERIT</option>
                                        <option value="0" {{ $record->type == 0 ? 'selected' : '' }}>DEMERIT</option>
                                    </select>
    
                                </div>
    
                                <div class="col-md-4 d-flex p-3 align-items-center gap-4">
                                    <label for="engineerEdit" class="form-label">Who:</label>
                                    <select name="engineer" id="engineerEdit" class="form-control" required disabled>
                                        <!-- Option for existing engineer value -->
                                        @if (isset($record->engineer))
                                            <option value="{{ $record->engineer ?? '' }}" selected>{{ $record->engineer ?? '' }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
    
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group d-flex gap-2">
                                            <label for="detailsTextarea"> Details:</label>
                                            <textarea type="text" name="details" class="form-control custom-box-size " id="detailsTextarea" value="" readonly>{{ $record->details }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body-radio">
                                <label id="severityLabel" for="pointSystemradiobutn" class="pointSystemradiobutn col-md-1" disabled>Severity:</label>
                                <div class="card-body-custom">
                                    <div class="card-body-custom2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="severity" id="level1radio"
                                                value="1" onclick="updatePoints(1, 50)" required
                                                {{ $record->points == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="level1radio">
                                                Level 1
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="severity" id="level2radio"
                                                value="2" onclick="updatePoints(2, 100)"
                                                {{ $record->points == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="level2radio">
                                                Level 2
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="severity" id="level3radio"
                                                value="3" onclick="updatePoints(3, 150)"
                                                {{ $record->points == 3 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="level3radio">
                                                Level 3
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="severity" id="level4radio"
                                                value="4" onclick="updatePoints(4, 200)"
                                                {{ $record->points == 4 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="level4radio">
                                                Level 4
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body-custom2">
                                        <div class="textradiobtn">
                                            <h1 class="text-style" id="pointsDisplay1">({{ $record->points }}.00) points</h1>
                                            <h1 class="text-style" id="pointsDisplay2">({{ $record->amount }}.00) amount</h1>
                                            <input type="hidden" id="hiddenSeverity" name="points"
                                                value="{{ $record->points }}">
                                            <input type="hidden" id="hiddenPoints" name="amount"
                                                value="{{ $record->amount }}">
    
                                        </div>
                                    </div>
                                </div>
    
    
                                <div class="card-body custom-def col-md">
                                    <div class="row">
                                        <div class="form-group d-flex gap-2">
                                            <label for="defenseTextarea"> Defense:</label>
                                            <textarea name="defense" class="form-control custom-box-size" readonly>{{ $record->defense }}</textarea>
                                        </div>
                                    </div>
                                </div>
    
                            </div>

                            <div class="mb-5">
                                <p class="text" style="color: rgb(0, 0, 0);"><b>Attachments:</b></p>
                                <div id="pointsystem_att_edit_Display" class="mt-3 d-flex flex-wrap gap-3">
                                    @if(count($attachments) === 0 || $attachments->every(fn($attachment) => empty($attachment))) 
                                        <p>No attachments found</p>
                                    @else
                                        @foreach($attachments as $attachment)
                                            @php
                                                $fileName = basename($attachment); // Extract the file name
                                                $fileExtension = pathinfo($attachment, PATHINFO_EXTENSION); // Get the file extension
                                            @endphp
                                            <div id="file-{{ $loop->index }}" class="attachment-item d-flex flex-column align-items-center">
                                                <!-- Only show the icon if there's a valid file extension -->
                                                @if($fileExtension)
                                                <span class="file-icon" data-extension="{{ $fileExtension }}"></span>
                                                @endif
                        
                                                <!-- Show download link only for allowed users -->
                                                @if($isAllowedToEdit)
                                                    <a href="/uploads/PointSystem-Attachments/{{ $attachment }}" 
                                                      target="_blank" 
                                                      download="{{ $fileName }}" 
                                                      class="mt-2 text-center file-name" 
                                                      title="{{ $fileName }}"> <!-- Tooltip for full file name -->
                                                        {{ $fileName }}
                                                    </a> 
                                                @else
                                                    <span>You do not have access to download the file.</span>
                                                @endif
                        
                                                <button class="delete-file-btn btn btn-danger mt-2" data-file="{{ $attachment }}" style="display:none;" type="button">
                                                    Delete
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        
                            <div>
                                <div class="col-md-4 d-flex align-items-center gap-2"  style="margin-top: 1%;">
                                    <label for="statusvalidation" class="form-label">Status:</label>
                                    <h1 id="statusValue" style="font-size: 15px; font-weight: bold;">{{ $record->status }}</h1>
                                </div>
                            </div>
    
    
                        </div>
                  
                </div>
                 <div class="justify-content-center mt-3" style="margin-left:34%; ">
                    @if(Route::currentRouteName() == 'tab-point-system.edit-approval')
                        @if($isAllowedToEdit)
                            @if($record->status === 'Approved' || $record->status === 'Disapproved')
                                <button class="btn btn-success col-md-4" id="severity-merit" type="button" style="margin-right:10px;">Update Severity Level</button>
                                <button class="btn btn-success col-md-2" id="save-points" type="submit" name="save-points" style="margin-left:10%; margin-right:10px;">Update Points</button>
                                <a href="{{ route('tab-point-system.index') }}" class="btn btn-danger col-md-2" id="cancel" type="button">Cancel</a>
                            @endif
                        @endif  
                    @endif
                 </div>

             @endif
               
            </form>     
            @if(Route::currentRouteName() == 'tab-point-system.edit-approval' && $isAllowedToEdit)
                <div class="col-md-4 justify-content-center mt-3" style="margin-left:40%">
                    <form action="{{ route('tab-point-system.approve', ['id' => $record->id]) }}" method="POST"  id="approve-form">
                        @csrf
                        <button class="btn btn-success" id="approve-merit" type="submit">Approve</button>
                    </form>
                    <form action="{{ route('tab-point-system.disapprove', ['id' => $record->id]) }}" method="POST"  id="disapprove-form">
                        @csrf
                        <button class="btn btn-danger" id="disapprove-merit" type="submit" style="margin-left: 30px;">Disapprove</button>
                    </form>
                    </div>
                </div> 
            @endif
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/tab-point-system/point_system_script.js') }}"></script>

@endsection
