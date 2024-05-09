@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();

    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>

    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>
    <script>
        function addAuditAgenda(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='date'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='time'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='date'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='time'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                // '<select name="auditor"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                // '<select name="auditee"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'>";
            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#internalaudit-table').click(function(e) {

                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="audit[]"></td>' +
                        // '<td><input type="date" name="scheduled_start_date[]"></td>'
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' +
                        serialNumber +
                        '_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' +
                    serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                    '_checkdate`,`scheduled_end_date' + serialNumber +
                    '_checkdate`)" /></div></div></div></td>' +
                        '<td><input type="time" name="scheduled_start_time[]"></td>' +
                        // '<td><input type="date" name="scheduled_end_date[]"></td>'
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date' +
                        serialNumber +
                        '_checkdate"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' +
                    serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                    '_checkdate`,`scheduled_end_date' + serialNumber +
                    '_checkdate`)" /></div></div></div></td>' +
                        '<td><input type="time" name="scheduled_end_time[]"></td>' +
                        '<td><select name="auditor[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        '<td><select name="auditee[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
                    html += '</select></td>' +
                        '<td><input type="text" name="remarks[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#internalaudit tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="observation_id[]"></td>' +
                        // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date[]" class="hide-input" oninput="handleDateInput(this, `date' + serialNumber +'`)" /></div></div></div></td>' +
                        // '<td><select name="auditorG[]">' 
                        +'<option value="">Select a value</option>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    html += '</select></td>' +
                        //     '<td><select name="auditeeG[]">' +
                        //     '<option value="">Select a value</option>';

                        // for (var i = 0; i < users.length; i++) {
                        //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                        // }
                        // html += '</select></td>' 
                        '<td><input type="text" name="observation_description[]"></td>' +
                        // '<td><input type="text" name="severity_level[]"></td>' +
                        '<td><input type="text" name="area[]"></td>' +
                        // '<td><input type="text" name="observation_category[]"></td>' +
                        //'<td><select name="observation_category[]"><option value="">Select A Value</option><option value="Major">Major</option><option value="Minor">Minor</option><option value="Critical">Critical</option><option value="Recommendation">Recommendation</option></select></td>'
                        // + '<td><select name="capa_required[]"><option value="">Select A Value</option><option value="Yes">Yes</option><option value="No">No</option></select></td>' +
                        '<td><input type="text" name="auditee_response[]"></td>'
                    // '<td><input type="text" name="auditor_review_on_response[]"></td>' +
                    //'<td><input type="text" name="qa_comment[]"></td>' +

                    // '//<td><input type="text" name="capa_details[]"></td>' +
                    // '<td><input type="date" name="capa_due_date[]"></td>'
                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="capa_due_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="capa_due_date[]" class="hide-input" oninput="handleDateInput(this, `capa_due_date' + serialNumber +'`)" /></div></div></div></td>' +
                    // '<td><select name="capa_owner[]">' +
                    '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        //  '<td><input type="text" name="action_taken[]"></td>' +
                        // '<td><input type="date" name="capa_completion_date[]"></td>'
                        // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="capa_completion_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="capa_completion_date[]" class="hide-input" oninput="handleDateInput(this, `capa_completion_date' + serialNumber +'`)" /></div></div></div></td>'
                        +
                        //'<td><input type="text" name="status_Observation[]"></td>' +
                        //'<td><input type="text" name="remark_observation[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#onservation-field-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <style>
        .calenderauditee {
            position: relative;
        }

        .new-date-data-field input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }
    </style>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Internal Audit
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




    <div id="change-control-fields">
        <div class="container-fluid">


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Audit Planning</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Audit Preparation</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Audit Execution</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Audit Response & Closure</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Checklist - Tablet Dispensing &
                    Granulation</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <form id="auditform" action="{{ route('createInternalAudit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/IA/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code </b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">QMS-North America</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('m-d-Y') }}" value="" name="intiation_date"> --}}
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div>
                                            <small class="text-primary">Please mention expected date of completion</small>
                                        </div>
                                        {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('m-d-Y') }}" value="" name="due_date"> --}}
                                {{-- <div class="calenderauditee">
                                            <input type="text"  id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div> --}}

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Due Date</label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="initiator_Group" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA" @if (old('initiator_Group') == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if (old('initiator_Group') == 'QAB') selected @endif>Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC" @if (old('initiator_Group') == 'CQA') selected @endif>Central
                                                Quality Control</option>
                                            <option value="MANU" @if (old('initiator_Group') == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if (old('initiator_Group') == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if (old('initiator_Group') == 'CS') selected @endif>
                                                Central
                                                Stores</option>
                                            <option value="ITG" @if (old('initiator_Group') == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if (old('initiator_Group') == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if (old('initiator_Group') == 'CL') selected @endif>
                                                Central Laboratory</option>

                                            <option value="TT" @if (old('initiator_Group') == 'TT') selected @endif>Tech
                                                team</option>
                                            <option value="QA" @if (old('initiator_Group') == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if (old('initiator_Group') == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if (old('initiator_Group') == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if (old('initiator_Group') == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if (old('initiator_Group') == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if (old('initiator_Group') == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if (old('initiator_Group') == 'BA') selected @endif>
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" readonly>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                        <textarea name="short_description"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                            required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Severity Level</label>
                                        <span class="text-primary">Severity levels in a QMS record gauge issue seriousness,
                                            guiding priority for corrective actions. Ranging from low to high, they ensure
                                            quality standards and mitigate critical risks.</span>
                                        <select name="severity_level_form">
                                            <option value="0">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Initiated Through</label>
                                        <div><small class="text-primary">Please select related information</small></div>
                                        <select name="initiated_through"
                                            onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                            <option value="">-- select --</option>
                                            <option value="recall">Recall</option>
                                            <option value="return">Return</option>
                                            <option value="deviation">Deviation</option>
                                            <option value="complaint">Complaint</option>
                                            <option value="regulatory">Regulatory</option>
                                            <option value="lab-incident">Lab Incident</option>
                                            <option value="improvement">Improvement</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="initiated_through_req">
                                        <label for="If Other">Others<span class="text-danger d-none">*</span></label>
                                        <textarea name="initiated_if_other"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Type of Audit</label>
                                        <select name="audit_type"
                                            onchange="otherController(this.value, 'others', 'type_of_audit_req')">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="R&D">R&D</option>
                                            <option value="GLP">GLP</option>
                                            <option value="GCP">GCP</option>
                                            <option value="GDP">GDP</option>
                                            <option value="GEP">GEP</option>
                                            <option value="ISO 17025">ISO 17025</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="type_of_audit_req">
                                        <label for="If Other">If Others<span class="text-danger d-none">*</span></label>
                                        <textarea name="if_other"></textarea>
                                        @error('if_other')
                                            <p class="text-danger">this field is required</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="external_agencies">External Agencies</label>
                                        <select name="external_agencies"
                                            onchange="otherController(this.value, 'others', 'external_agencies_req')">
                                            <option value="">-- Select --</option>
                                            <option value="jordan_fda">Jordan FDA</option>
                                            <option value="us_fda">USFDA</option>
                                            <option value="mhra">MHRA</option>
                                            <option value="anvisa">ANVISA</option>
                                            <option value="iso">ISO</option>
                                            <option value="who">WHO</option>
                                            <option value="local_fda">Local FDA</option>
                                            <option value="tga">TGA</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input" id="external_agencies_req">
                                        <label for="others">Others<span class="text-danger d-none">*</span></label>
                                        <textarea name="Others"></textarea>
                                        @error('others')
                                            <p class="text-danger">this field is required</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Initial Comments">Description</label>
                                        <textarea name="initial_comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <input type="file" id="myfile" name="inv_attachment[]" multiple> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="audit_file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="inv_attachment[]"
                                                    oninput="addMultipleFiles(this, 'audit_file_attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Planning content -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit Schedule Start Date">Audit Schedule Start Date</label>
                                        {{-- <input type="date" name="start_date"> --}}
                                        <div class="calenderauditee">
                                            <input type="text" id="audit_schedule_start_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="audit_schedule_start_date_checkdate"
                                                name="audit_schedule_start_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'audit_schedule_start_date');checkDate('audit_schedule_start_date_checkdate','audit_schedule_end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_schedule_start_date"><b>Audit Schedule Start Date
                                        </b></label>
                                        <input type="text" value="{{ date('d-M-Y') }}" name="audit_schedule_start_date"
                                            disabled>
                                        <input type="hidden" value="{{ date('d-M-Y') }}" name="audit_schedule_start_date">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit Schedule End Date">Audit Schedule End Date</label>
                                        {{-- <input type="date" name="end_date"> --}}
                                        <div class="calenderauditee">
                                            <input type="text" id="audit_schedule_end_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="audit_schedule_end_date_checkdate"
                                                name="audit_schedule_end_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'audit_schedule_end_date');checkDate('audit_schedule_start_date_checkdate','audit_schedule_end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Audit Agenda<button type="button" name="audit-agenda-grid"
                                                id="internalaudit-table">+</button>
                                        </label>
                                        <table class="table table-bordered" id="internalaudit">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Area of Audit</th>
                                                    <th>Scheduled Start Date</th>
                                                    <th>Scheduled Start Time</th>
                                                    <th>Scheduled End Date</th>
                                                    <th>Scheduled End Time</th>
                                                    <th>Auditor</th>
                                                    <th>Auditee</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="audit[]"></td>
                                                {{-- <td><input type="date" name="scheduled_start_date[]"></td> --}}
                                                <td>
                                                    <div class="group-input new-date-data-field mb-0">
                                                        <div class="input-date ">
                                                            <div class="calenderauditee">
                                                                <input type="text" class="test"
                                                                    id="scheduled_start_date1" readonly
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date" id="scheduled_start_date1_checkdate"
                                                                    name="scheduled_start_date[]"
                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                    class="hide-input"
                                                                    oninput="handleDateInput(this, `scheduled_start_date1`);checkDate('scheduled_start_date1_checkdate','scheduled_end_date1_checkdate')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="time" name="scheduled_start_time[]"></td>
                                                {{-- <td><input type="date" name="scheduled_end_date[]"></td> --}}
                                                <td>
                                                    <div class="group-input new-date-data-field mb-0">
                                                        <div class="input-date ">
                                                            <div class="calenderauditee">
                                                                <input type="text" class="test"
                                                                    id="scheduled_end_date1" readonly
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date" id="scheduled_end_date1_checkdate"
                                                                    name="scheduled_end_date[]"
                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                    class="hide-input"
                                                                    oninput="handleDateInput(this, `scheduled_end_date1`);checkDate('scheduled_start_date1_checkdate','scheduled_end_date1_checkdate')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td><input type="time" name="scheduled_end_time[]"></td>
                                                <td> <select id="select-state" placeholder="Select..." name="auditor[]">
                                                        <option value="">Select a value</option>
                                                        @foreach ($users as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select></td>
                                                <td><select id="select-state" placeholder="Select..." name="auditee[]">
                                                        <option value="">Select a value</option>
                                                        @foreach ($users as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="text" name="remarks[]"></td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    {{-- <div class="group-input">
                                        <label for="Facility Name">Facility Name</label>
                                        <select multiple name="Facility[]" placeholder="Select Facility Name"
                                            data-search="false" data-silent-initial-value-set="true" id="Facility">
                                            <option value="Plant 1">Plant 1</option>
                                            <option value="QA">QA</option>
                                            <option value="QC">QC</option>
                                            <option value="MFG">MFG</option>
                                            <option value="Corporate">Corporate</option>
                                            <option value="Microbiology">Microbiology</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-lg-6">
                                    {{-- <div class="group-input">
                                        <label for="Group Name">Function Name</label>
                                        <select multiple name="Group[]" placeholder="Select Function Name"
                                            data-search="false" data-silent-initial-value-set="true" id="Group">
                                            <option value="QA">QA</option>
                                            <option value="QC">QC</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="RA">RA</option>
                                            <option value="R&D">R&D</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product/Material Name">Product/Material Name</label>
                                        <input type="text" name="material_name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments(If Any)">Comments(If Any)</label>
                                        <textarea name="if_comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Preparation content -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Lead Auditor">Lead Auditor</label>
                                        <select name="lead_auditor">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="File Attachments">File Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <div class="file-attachment-field">
                                            <div id="file_attachment"></div>
                                            <input type="file" id="myfile" name="file_attachment[]"
                                            oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                        </div> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Observation Details
                                            <button type="button" name="audit-agenda-grid"
                                                id="ObservationAdd">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="onservation-field-table"
                                                style="width: 150%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row#</th>
                                                        <th>Observation ID</th>
                                                        <th>Date</th>
                                                        <th>Auditor</th>
                                                        <th>Auditee</th>
                                                        <th>Observation Description</th>
                                                        {{-- <th>Severity Level</th> --}}
                                {{-- <th>Area/process</th>
                                                        <th>Observation Category</th>
                                                        <th>CAPA Required</th>
                                                        <th>Auditee Response</th>
                                                        <th>Auditor Review on Response</th>
                                                        <th>QA Comments</th>
                                                        <th>CAPA Details</th>
                                                        <th>CAPA Due Date</th>
                                                        <th>CAPA Owner</th>
                                                        <th>Action Taken</th>
                                                        <th>CAPA Completion Date</th>
                                                        <th>Status</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="observationDetail">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> --}}

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Audit Team">Audit Team</label>
                                        <select multiple name="Audit_team[]" placeholder="Select Audit Team"
                                            data-search="false" data-silent-initial-value-set="true" id="Audit">
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Auditee">Auditee</label>
                                        <select multiple name="Auditee[]" placeholder="Select Auditee"
                                            data-search="false" data-silent-initial-value-set="true" id="Auditee">
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Auditor Details">External Auditor Details</label>
                                        <textarea name="Auditor_Details"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Auditing Agency">External Auditing Agency</label>
                                        <textarea name="External_Auditing_Agency"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Relevant Guidelines / Industry Standards">Relevant Guidelines /
                                            Industry Standards</label>
                                        <textarea name="Relevant_Guideline"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Comments">QA Comments</label>
                                        <textarea name="QA_Comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Guideline Attachment">Guideline Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment_guideline"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment_guideline[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment_guideline')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Category">Audit Category</label>
                                        <select name="Audit_Category">
                                            <option value="0">-- Select --</option>
                                            <option value="1">Internal Audit/Self Inspection</option>
                                            <option value="2">Supplier Audit</option>
                                            <option value="3">Regulatory Audit</option>
                                            <option value="4">Consultant Audit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier/Vendor/Manufacturer Details">Supplier/Vendor/Manufacturer
                                            Details</label>
                                        <input type="text" name="Supplier_Details">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier/Vendor/Manufacturer Site">Supplier/Vendor/Manufacturer
                                            Site</label>
                                        <input type="text" name="Supplier_Site">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea name="Comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Execution content -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text"
                                            value="{{ Helpers::getdateFormat($due_date) }}">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit Start Date">Audit Start Date</label>
                                        {{-- <input type="date" name="audit_start_date"> --}}
                                        <div class="calenderauditee">
                                            <input type="text" id="audit_start_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="audit_start_date" id="audit_start_date_checkdate"
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'audit_start_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit End Date">Audit End Date</label>
                                        {{-- <input type="date" name="audit_end_date"> --}}
                                        <div class="calenderauditee">
                                            <input type="text" id="audit_end_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="audit_end_date_checkdate" name="audit_end_date"
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'audit_end_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Observation Details
                                            <button type="button" name="audit-agenda-grid"
                                                id="ObservationAdd">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="onservation-field-table"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row#</th>
                                                        <th>Observation Details</th>
                                                        {{-- <th>Date</th> --}}
                                                        {{-- <th>Auditor</th> --}}
                                                        {{-- <th>Auditee</th> --}}
                                                        <th>Pre Comments</th>
                                                        {{-- <th>Severity Level</th> --}}
                                                        <th>CAPA Details if any</th>
                                                        {{-- <th>Observation Category</th> --}}
                                                        {{-- <th>CAPA Required</th> --}}
                                                        <th>Post Comments</th>
                                                        {{-- <th>Auditor Review on Response</th> --}}
                                                        {{-- <th>QA Comments</th> --}}
                                                        {{-- <th>CAPA Details</th> --}}
                                                        {{-- <th>CAPA Due Date</th> --}}
                                                        {{-- <th>CAPA Owner</th> --}}
                                                        {{-- <th>Action Taken</th> --}}
                                                        {{-- <th>CAPA Completion Date</th> --}}
                                                        {{-- <th>Status</th> --}}
                                                        {{-- <th>Remarks</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="observationDetail">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Audit Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Audit_file[]" multiple> --}}
                                        {{-- <div class="file-attachment-field">
                                            <div id="audit_attachment"></div>
                                            <input type="file" id="myfile" name="Audit_file[]"
                                            oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                        </div> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="audit_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Audit_file[]"
                                                    oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Comments">Audit Comments</label>
                                        <textarea name="Audit_Comments1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Response & Closure content -->
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Audit Response
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Remarks">Remarks</label>
                                        <textarea name="Remarks"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reference Recores">Reference Record</label>
                                        <select multiple id="reference_record" name="refrence_record[]" id="">
                                            <option value="">--Select---</option>
                                            @foreach ($old_record as $new)
                                                <option value="{{ $new->id }}">
                                                    {{ Helpers::getDivisionName($new->division_id) }}/IA/{{ date('Y') }}/{{ Helpers::recordFormat($new->record) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Report Attachments">Report Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="report_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="report_file[]"
                                                    oninput="addMultipleFiles(this, 'report_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Audit Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <input type="file" id="myfile" name="myfile[]" multiple> --}}
                                        {{-- <div class="file-attachment-field">
                                            <div id="myfile_attachment"></div>
                                            <input type="file" id="myfile" name="myfile[]"
                                            oninput="addMultipleFiles(this, 'myfile_attachment')" multiple>
                                        </div> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="myfile_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="myfile[]"
                                                    oninput="addMultipleFiles(this, 'myfile_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Comments">Audit Comments</label>
                                        <textarea name="Audit_Comments2"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="due_date_extension">Due Date Extension Justification</label>
                                        <div><small class="text-primary">Please Mention justification if due date is
                                                crossed</small></div>
                                        <textarea name="due_date_extension"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- Audit Response & Closure content -->
                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Checklist for Tablet Dispensing
                                </div>

                                <div class="col-12">
                                    {{-- <label for="Audit Attachments">PHASE- I B INVESTIGATION REPORT</label> --}}
                                    <div class="group-input">
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">Sr.No.</th>
                                                        <th style="width: 40%;">Question</th>
                                                        <th style="width: 20%;">Response</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="flex text-center">1.1</td>
                                                        <td>Is access to the facility restricted?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="what_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.2</td>
                                                        <td>Is the dispensing area cleaned as per SOP?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="where_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.3</td>
                                                        <td> Check the status label of area and equipment.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="when_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.4</td>
                                                        <td>Are all raw materials carry proper label? </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="coverage_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.5</td>
                                                        <td>
                                                            {" "}
                                                            Standard operating procedure for dispensing of raw material is
                                                            displayed?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.6</td>
                                                        <td>
                                                            {" "}
                                                            All the person involve in dispensing having proper gowning?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.7</td>
                                                        <td>Where you keep the materials after dispensing? </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.8</td>
                                                        <td>Is there any log book for keeping the record of dispensing?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.9</td>
                                                        <td>
                                                            Have you any standard practice to cross check the approved
                                                            status of raw materials before dispensing?{" "}
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.10</td>
                                                        <td>
                                                            Are all balances calibrated which are to be use for dispensing?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.11</td>
                                                        <td>
                                                            Is the pressure differential of RLAF is within acceptance limit?
                                                            What is the limit? _______
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.12</td>
                                                        <td>
                                                            Is the pressure differential of the area is within acceptance
                                                            limit? Check the pressure differential__________
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        {{--    <td>
                                                            <textarea name="who_will_not_be"></textarea> --}} <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.13</td>
                                                        <td>
                                                            Is there any record for room temperature & relative humidity?
                                                            Check the temperature _____°C & RH _____%
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>;

                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Checklist for Tablet Granulation
                                </div>
                                <div class="col-12">
                                    {{-- <label for="Audit Attachments">PHASE- I B INVESTIGATION REPORT</label> --}}
                                    <div class="group-input">
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">Sr.No.</th>
                                                        <th style="width: 40%;">Question</th>
                                                        <th style="width: 20%;">Response</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="flex text-center">2.1</td>
                                                        <td>Is status labels displayed on all equipments? </td>
                                                        <td>

                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>


                                                        </td>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.2</td>
                                                        <td>Is the dispensing area cleaned as per SOP?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                      

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.3</td>
                                                        <td> Check the status label of area and equipment.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                      
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>


                                                       

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.4</td>
                                                        <td>Are there data to show that cleaning procedures for
                                                            non-dedicated equipment are adequate to remove the previous
                                                            materials? For active ingredients, have these procedures been
                                                            validated? </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                      

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.5</td>
                                                        <td> Do you have written procedures for the safe and correct use of
                                                            cleaning and sanitizing agents? What are the sanitizing agents
                                                            used in this plant?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                       

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.6</td>
                                                        <td> Are there data to show that the residues left by the cleaning
                                                            and/or sanitizing agent are within acceptable limits when
                                                            cleaning is performed in accordance with the approved method?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                      
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.7</td>
                                                        <td>Do you have written procedures that describe the sufficient
                                                            details of the cleaning schedule, methods, equipment and
                                                            material? Check for procedure compliance </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                    

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.8</td>
                                                        <td>Are there written instructions describing how to use in-process
                                                            data to control the process?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                       

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.9</td>
                                                        <td>Are all piece of equipment clearly identified with easily
                                                            visible markings? Check the equipment nos. corresponds to an
                                                            entry in a log book.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                       
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.10</td>
                                                        <td>Is equipment inspected immediately prior to use?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                       
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                  

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.11</td>
                                                        <td>Do cleaning instructions include disassembly and drainage
                                                            procedure, if required to ensure that no cleaning solutions or
                                                            rinse remains in the equipment?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                      
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                     

                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.12</td>
                                                        <td>Has a written schedule been established and is it followed for
                                                            cleaning of equipment?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>


                                                        {{-- <textarea name="who_will_not_be"></textarea> --}}
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.13</td>
                                                        <td>Are seams on product-contact surfaces smooth and properly
                                                            maintained to minimize accumulation of product, dirt, and
                                                            organic matter and to avoid growth of microorganisms?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>

                                                    </tr>



                                                    <tr>
                                                        <td class="flex text-center">2.14</td>
                                                        <td>Is clean equipment clearly identified as “cleaned” with a
                                                            cleaning date shown on the equipment tag? Check for few
                                                            equipments.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.15</td>
                                                        <td>Is equipment cleaned promptly after use?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.16</td>
                                                        <td>Is there proper storage of cleaned equipment so as to prevent
                                                            contamination?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.17</td>
                                                        <td>Is there adequate system to assure that unclean equipment and
                                                            utensils are not used (e.g., labeling with clean status)?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.18</td>
                                                        <td>Is sewage, trash and other reuse disposed off in a safe and
                                                            sanitary manner ( and with sufficient frequency)</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.19</td>
                                                        <td>Are written records maintained on equipment cleaning, sanitizing
                                                            and maintenance on or near each piece of equipment? Check 2
                                                            equipment records.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.20</td>
                                                        <td>Are all weighing and measuring performed by one qualified person
                                                            and checked by a second person
                                                            Check the weighing balance record.
                                                        </td>

                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.21</td>
                                                        <td>Are the sieves & screen kept in proper place with proper label?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.22</td>
                                                        <td>Is the pressure differential of every particular area are within
                                                            limit?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.23</td>
                                                        <td>All the person working in granulation area having proper
                                                            gowning?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.24</td>
                                                        <td>Is Inventory record of sieve, screen, rubber sleeve, FBD bag,
                                                            etc. maintained?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.25</td>
                                                        <td>Check the FBD bags for three products, and their utilization
                                                            records.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.26</td>
                                                        <td>Have you any SOP regarding Hold time of material during staging?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.27</td>
                                                        <td>Is there a written procedure specifying the frequency of
                                                            inspection and replacement for air filters?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.28</td>
                                                        <td>Are written operating procedures available for each equipment
                                                            used in the manufacturing, processing? Check for SOP compliance.
                                                            Check the list of equipment and equipment details.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.29</td>
                                                        <td>Does each equipment have written instructions for maintenance
                                                            that includes a schedule for maintenance?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.30</td>
                                                        <td>Does the process control address all issues to ensure identity,
                                                            strength, quality and purity of product?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.31</td>
                                                        <td>Check the calibration labels for instrument calibration status.
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.32</td>
                                                        <td>Temperature & RH record log book is available for each staging
                                                            area.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.33</td>
                                                        <td>Check for area activity record.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.34</td>
                                                        <td>Check for equipment usage record.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.35</td>
                                                        <td>Check for general equipment details and accessory details.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.36</td>
                                                        <td>Check for man & material movement in the area.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.37</td>
                                                        <td>Air handling system qualification, cleaning details and PAO test
                                                            reports.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.38</td>
                                                        <td>Check for purified water hose pipe status and water hold up.
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.39</td>
                                                        <td>Check for the status labeling in the area and material randomly.
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.40</td>
                                                        <td>Check the in-process equipments cleaning status & records.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.41</td>
                                                        <td>Are any unplanned process changes (process excursions)
                                                            documented in the batch record?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.42</td>
                                                        <td>If the product is blended, are there blending parameters and/or
                                                            homogeneity specifications?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.43</td>
                                                        <td>Are materials and equipment clearly labeled as to identity and,
                                                            if appropriate, stage of manufacture?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">2.44</td>
                                                        <td>Is there is an preventive maintenance program for all equipment
                                                            and status of it.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Checklist for Tablet Documentation
                                </div>

                                <div class="col-12">
                                    {{-- <label for="Audit Attachments">PHASE- I B INVESTIGATION REPORT</label> --}}
                                    <div class="group-input">
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">Sr.No.</th>
                                                        <th style="width: 40%;">Question</th>
                                                        <th style="width: 20%;">Response</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="flex text-center">3.1</td>
                                                        <td>Do records have doer & checker signatures? Check the timings,
                                                            date and yield etc. in the batch manufacturing record.</td>
                                                        <td>

                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>


                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">3.2</td>
                                                        <td>Is each batch assigned a distinctive code, so that material can
                                                            be traced through manufacturing and distribution? Check for In
                                                            process analytical reports.</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">3.3</td>
                                                        <td>Is the batch record is on line up to the current stage of a
                                                            process?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">3.4</td>
                                                        <td>In process carried out as per the written instruction describe
                                                            in batch record? </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">3.5</td>
                                                        <td>Is there any area cleaning record available?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">3.6</td>
                                                        <td> Current version of SOP’s is available in respective areas?
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <select name="response" id="response"
                                                                    style="padding: 2px; width:90%; border: 1px solid black;  background-color: #f0f0f0;">
                                                                    <option value="Yes">Select an Option</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td style="vertical-align: middle;">
                                                            <div
                                                                style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="what_will_not_be" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>



                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- Activity Log content -->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Audit Schedule By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Audit Schedule On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancelled By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancelled On">Cancelled On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Preparation Completed On">Audit Preparation Completed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Preparation Completed On">Audit Preparation Completed On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Mgr.more Info Reqd By">Audit Mgr.more Info Reqd By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Mgr.more Info Reqd On">Audit Mgr.more Info Reqd On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Observation Submitted By">Audit Observation Submitted By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Observation Submitted On">Audit Observation Submitted On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Lead More Info Reqd By">Audit Lead More Info Reqd By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Lead More Info Reqd On">Audit Lead More Info Reqd On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Response Completed By">Audit Response Completed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Response Completed On">Audit Response Completed On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Response Feedback Verified By">Response Feedback Verified By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Response Feedback Verified On">Response Feedback Verified On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for=" Rejected By">Rejected By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Rejected On">Rejected On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit">Submit</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>
    <script>
        document.getElementById('myfile').addEventListener('change', function() {
            var fileListDiv = document.querySelector('.file-list');
            fileListDiv.innerHTML = ''; // Clear previous entries

            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                var listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileListDiv.appendChild(listItem);
            }
        });
    </script>


    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }



        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('type_of_audit').addEventListener('change', function() {
        //         var typeOfAuditReqInput = document.getElementById('type_of_audit_req');
        //         if (typeOfAuditReqInput) {
        //             var selectedValue = this.value;
        //             if (selectedValue == 'others') {
        //                 typeOfAuditReqInput.setAttribute('required', 'required');
        //             } else {
        //                 typeOfAuditReqInput.removeAttribute('required');
        //             }
        //         } else {
        //             console.error("Element with id 'type_of_audit_req' not found");
        //         }
        //     });
        // });
    </script>
    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
@endsection
