@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        #change-control-fields > div.container-fluid > div.inner-block.state-block > div.status > div.progress-bars.d-flex > div.bg-danger{
            border-radius: 0px 20px 20px 0px;
        }
    </style>
    @php
        $users = DB::table('users')->get();
    @endphp
    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }}/ Market Complaint
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#Monitor_Information').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="date" name="date[]"></td>' +
                        ' <td><input type="text" name="Responsible[]"></td>' +
                        '<td><input type="text" name="ItemDescription[]"></td>' +
                        '<td><input type="date" name="SentDate[]"></td>' +
                        '<td><input type="date" name="ReturnDate[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#Monitor_Information_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Product_Material').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="ProductName[]"></td>' +
                        '<td><input type="number" name="ReBatchNumber[]"></td>' +
                        '<td><input type="date" name="ExpiryDate[]"></td>' +
                        '<td><input type="date" name="ManufacturedDate[]"></td>' +
                        '<td><input type="text" name="Disposition[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#Equipment').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="ProductName[]"></td>' +
                        '<td><input type="number" name="BatchNumber[]"></td>' +
                        '<td><input type="date" name="ExpiryDate[]"></td>' +
                        '<td><input type="date" name="ManufacturedDate[]"></td>' +
                        '<td><input type="number" name="NumberOfItemsNeeded[]"></td>' +
                        '<td><input type="text" name="Exist[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#Equipment_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>



    <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
        }

        .state-block {
            padding: 20px;
            margin-bottom: 20px;
        }

        .progress-bars div.active {
            background: green;
            font-weight: bold;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
            border-radius: 20px 0px 0px 20px;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">


            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}



                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                ->get();
                            // dd($userRoles);

                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                         <a class="text-white"
                                href="{{ route('marketcomplaint.MarketComplaintAuditReport', $data->id) }}"><button class="button_theme1"> Audit Trail
                            </button> </a>
                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button></a>


                        @elseif($data->stage == 2 && (in_array(14, $userRoleIds) || in_array(18, $userRoleIds)))
                            <a href="#rejection-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button></a>
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Review
                            </button></a>
                           <a href="#cancel-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button></a>


                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <a href="#rejection-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button></a>
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                               CFT Review Complete
                            </button></a>
                            <a href="#signature-modal"></a>


                        @elseif($data->stage == 4 && (in_array(15, $userRoleIds) || in_array(18, $userRoleIds)))
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Review Complete
                            </button></a>
                       <a href="#child-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Action Item
                    </button></a>
                    <a href="#child-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Capa
                    </button></a>
                        @elseif($data->stage == 5 && (in_array(14, $userRoleIds) || in_array(18, $userRoleIds)))
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approve Plan
                        </button></a>
                            <a href="#rejection-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Reject
                            </button></a>


                        @elseif($data->stage == 6 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            All CAPA Closed
                        </button></a>
                            {{-- ====regulatroy single child --}}
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal4">
                                Child
                            </button> --}}




                        {{-- @elseif($data->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Send Letter
                        </button></a>
                           <a href="#child-modal3"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                            Child
                        </button></a> --}}

                        {{-- @elseif($data->stage == 8 )
                        <a href="{{ route('reopen.stage', $data->id) }}">
                            <button class="button_theme1"> Re Open </button>
                        </a>
                      --}}
                        @endif
                         <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"><button class="button_theme1"> Exit
                            </button> </a>


                    </div>

                </div>


                <!--------------------------Modal-------------------->



                <div class="modal fade" id="rejection-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">E-Signature</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('marketcomplaint.mar_comp_reject_stateChange', $data->id) }}"
                                method="POST">
                                @csrf
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3 text-justify">
                                        Please select a meaning and a outcome for this task and enter your username
                                        and password for this task. You are performing an electronic signature,
                                        which is legally binding equivalent of a hand written signature.
                                    </div>
                                    <div class="group-input">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="comment">Comment <span class="text-danger">*</span></label>
                                        <input type="comment" name="comment" required>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <!-- <div class="modal-footer">
                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                        <button>Close</button>
                                    </div> -->
                                <div class="modal-footer">
                                    <button type="submit">Submit</button>
                                    <button type="button" data-bs-dismiss="modal">Close</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="modal fade" id="signature-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">E-Signature</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('marketcomplaint.mar_comp_stagechange', $data->id) }}" method="POST">
                                @csrf
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3 text-justify">
                                        Please select a meaning and a outcome for this task and enter your username
                                        and password for this task. You are performing an electronic signature,
                                        which is legally binding equivalent of a hand written signature.
                                    </div>
                                    <div class="group-input">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <input type="comment" name="comment">
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <!-- <div class="modal-footer">
                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                        <button>Close</button>
                                    </div> -->
                                <div class="modal-footer">
                                    <button type="submit">Submit</button>
                                    <button type="button" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                <div class="modal fade" id="cancel-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">E-Signature</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('marketcomplaint.MarketComplaintCancel', $data->id) }}" method="POST">
                                @csrf
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3 text-justify">
                                        Please select a meaning and a outcome for this task and enter your username
                                        and password for this task. You are performing an electronic signature,
                                        which is legally binding equivalent of a hand written signature.
                                    </div>
                                    <div class="group-input">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" required>
                                    </div>
                                    <div class="group-input">
                                        <label for="comment">Comment <span class="text-danger">*</span></label>
                                        <input type="comment" name="comment" required>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <!-- <div class="modal-footer">
                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                        <button>Close</button>
                                    </div> -->
                                <div class="modal-footer">
                                    <button type="submit">Submit</button>
                                    <button type="button" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
{{-- ==================================capa and  Action child=============================================== --}}


                <div class="modal fade" id="child-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Child</h4>
                            </div>
                            <div class="model-body">

                                <form action="{{ route('marketcomplaint.capa_action_child', $data->id) }}" method="POST">
                                    @csrf
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="group-input">
                                            <label style="  display: flex;     gap: 18px; width: 60px;" for="capa-child">
                                                <input type="radio" name="revision" id="capa-child" value="capa-child">
                                                CAPA
                                            </label>
                                        </div>
                                        <div class="group-input">
                                            <label  style=" display: flex;     gap: 16px; width: 60px;" for="root-item">
                                                <input type="radio" name="revision" id="root-item" value="Action-Item">
                                                Action Item
                                            </label>
                                        </div>
                                        {{-- <div class="group-input">
                                            <label for="root-item">
                                             <input type="radio" name="revision" id="root-item" value="effectiveness-check">
                                                Effectiveness check
                                            </label>
                                        </div> --}}
                                    </div>

                                    <!-- Modal footer -->
                                    <!-- <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Close</button>
                                        <button type="submit">Continue</button>
                                    </div> -->
                                    <div class="modal-footer">
                                              <button type="submit">Submit</button>
                                             <button type="button" data-bs-dismiss="modal">Close</button>
                                   </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

{{-- ==================================RCA and Action child=============================================== --}}
                <div class="modal fade" id="child-modal1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Child</h4>
                            </div>
                            <div class="model-body">
                            <form action="{{ route('marketcomplaint.rca_action_child', $data->id) }}" method="POST">
                                @csrf
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="group-input">
                                        <label style="  display: flex;     gap: 18px; width: 60px;" for="capa-child">
                                            <input type="radio" name="revision" id="capa-child" value="rca-child">
                                           RCA
                                        </label>
                                    </div>
                                    <div class="group-input">
                                        <label style=" display: flex;     gap: 16px; width: 60px;" for="root-item">
                                            <input type="radio" name="revision" id="root-item" value="Action-Item">
                                          <span style="width: 100px;">  Action Item</span>
                                        </label>
                                    </div>

                                </div>


                                <div class="modal-footer">
                                          <button type="submit">Submit</button>
                                         <button type="button" data-bs-dismiss="modal">Close</button>
                               </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
{{-- ==================================Regulatory  Reporting  and Effectiveness  Check child=============================================== --}}

<div class="modal fade" id="child-modal3">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <div class="model-body">

                <form action="{{ route('marketcomplaint.Regu_Effec_child', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{-- <div class="group-input">
                            <label style=" display: flex;     gap: 16px; width: 60px;" for="capa-child">
                                <input type="radio" name="revision" id="rca-child" value="regulatory-child">
                                Regulatory Reporting
                            </label>
                        </div> --}}
                        <div class="group-input">
                            <label style="  display: flex;     gap: 18px; width: 60px;"for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Effectiveness-child">
                                Effectiveness Check
                            </label>
                        </div>

                    </div>


                    <div class="modal-footer">
                              <button type="submit">Submit</button>
                             <button type="button" data-bs-dismiss="modal">Close</button>
                   </div>
                </form>
            </div>

        </div>
    </div>
</div>
{{-- ==========================single regulatory ======================= --}}
<div class="modal fade" id="child-modal4">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <div class="model-body">

                <form action="{{ route('marketcomplaint.Regu_Effec_child', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label style=" display: flex;     gap: 16px; width: 60px;" for="capa-child">
                                <input type="radio" name="revision" id="rca-child" value="regulatory-child">
                                Regulatory Reporting
                            </label>
                        </div>


                    </div>


                    <div class="modal-footer">
                              <button type="submit">Submit</button>
                             <button type="button" data-bs-dismiss="modal">Close</button>
                   </div>
                </form>
            </div>

        </div>
    </div>
</div>
                <style>
                    #step-form>div {
                        display: none
                    }

                    #step-form>div:nth-child(1) {
                        display: block;
                    }
                    .input_full_width{
                        width: 100%;
                border-radius: 5px;
                margin-bottom: 10px;
                    }
                </style>








                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const removeButtons = document.querySelectorAll('.remove-file');

                        removeButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const fileName = this.getAttribute('data-file-name');
                                const fileContainer = this.closest('.file-container');

                                // Hide the file container
                                if (fileContainer) {
                                    fileContainer.style.display = 'none';
                                }
                            });
                        });
                    });
                </script>

                <script>
                    var maxLength = 240;
                    $('#duedoc').keyup(function() {
                        var textlen = maxLength - $(this).val().length;
                        $('#rchar').text(textlen);
                    });
                </script>









                <!-------------------------- end Modal-------------------->


                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex" style="font-size: 15px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Supervisor Review </div>
                            @else
                                <div class="">Supervisor Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Investigation and Root Cause Analysis</div>
                            @else
                                <div class="">Investigation and Root Cause
                                    Analysis</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">CFT Review</div>
                            @else
                                <div class="">CFT Review</div>
                            @endif

                            @if ($data->stage >= 5)
                                <div class="active">In QA Review</div>
                            @else
                                <div class="">In QA Review</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">Pending Actions Completion</div>
                            @else
                                <div class="">Pending Actions Completion</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">Pending Response Letter</div>
                            @else
                                <div class="">Pending Response Letter</div>
                            @endif
                            @if ($data->stage >= 8)
                                <div class="bg-danger">Pending Response Letter</div>
                            @else
                                <div class="">Pending Response Letter</div>
                            @endif
                             @if ($data->stage >= 9)
                        <div class="bg-danger">Closed - Done</div>
                        @else
                        <div class="">Closed - Done</div>
                        @endif
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>


        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">HOD/Supervisor Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">CFT Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Complaint Acknowledgement</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Closure</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button>

        </div>

        <form action="{{ route('marketcomplaint.marketcomplaintupdate', $data->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div id="step-form">
                @if (!empty($parent_id))
                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record" id="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/MC/{{ date('y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Division Code </b></label>
                                    <input disabled type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ $data->division_id }}">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}" />
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Due"><b>Date of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due"><b>Date of Initiation</b></label>
                                    @php
                                        $formattedDate = \Carbon\Carbon::parse($data->intiation_date)->format('j-F-Y');
                                    @endphp
                                    <input disabled type="text" value="{{ $formattedDate }}" name="intiation_date_display">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                </div>
                            </div> --}}
                            <div class="col-md-6 ">
                                <div class="group-input ">
                                    <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                        class="text-danger">*</span></label>
                                        <span id="rchars">255</span> Characters remaining

                                    <input  name="description_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} id="docname" required value="{{ $data->description_gi }}"  maxlength="255" >

                                </div>
                            </div>

                            {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date <span class="text-danger">*</span></label>
                                    <div class="calenderauditee">
                                        <!-- Display the formatted date in a readonly input -->
                                        <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate(30, true) }}" />

                                        <input type="date" name="due_date_gi" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate(30, false) }}" class="hide-input" readonly />
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <script>
                                function handleDateInput(dateInput, displayId) {
                                    const date = new Date(dateInput.value);
                                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                                    document.getElementById(displayId).value = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                }

                                // Call this function initially to ensure the correct format is shown on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dateInput = document.querySelector('input[name="due_date"]');
                                    handleDateInput(dateInput, 'due_date_display');
                                });
                                </script>

                                <style>
                                .hide-input {
                                    display: none;
                                }
                                </style> --}}
                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <!-- Format ki hui date dikhane ke liye readonly input -->
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate123($data->intiation_date, true) }}" />
                                            <!-- Hidden input date format ke sath -->
                                            <input type="date" name="due_date_gi" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate123($data->intiation_date, true, 'Y-m-d') }}" class="hide-input"  />
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <!-- Display the formatted date in a readonly input -->
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{$data->due_date_gi}}" />
                                            <!-- Hidden input date format ke sath -->
                                            <input type="date" id="due_date_input" name="due_date_gi" min="{{ \Carbon\Carbon::now()->format('j-F-Y') }}" class="hide-input" onchange="updateDueDateDisplay()" value="{{ $data->due_date_gi }}"/>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date </label>{{--<span class="text-danger">*</span> --}}
                                        <div class="calenderauditee">
                                            <!-- Display the formatted date in a readonly input -->
                                            <input type="text" id="due_date_display" placeholder="DD-MMM-YYYY" value="" class="form-control" />
                                            <!-- Hidden input date format ke sath -->
                                            <input type="date" id="due_date_input" name="due_date_gi" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->due_date_gi }}" class="form-control hide-input" onchange="updateDueDateDisplay()" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function updateDueDateDisplay() {
                                        var dateInput = document.getElementById('due_date_input').value;
                                        if (dateInput) {
                                            var date = new Date(dateInput);
                                            var options = { day: '2-digit', month: 'short', year: 'numeric' };
                                            var formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                            document.getElementById('due_date_display').value = formattedDate;
                                        } else {
                                            document.getElementById('due_date_display').value = '';
                                            document.getElementById('due_date_display').placeholder = 'DD-MMM-YYYY';
                                        }
                                    }

                                    // To show the existing value if it's already set (for example, in an edit form)
                                    $(document).ready(function() {
                                        updateDueDateDisplay();
                                    });
                                </script>

                                {{-- <script>
                                    function updateDueDateDisplay() {
                                        var dateInput = document.getElementById('due_date_input').value;
                                        var date = new Date(dateInput);
                                        var options = { day: '2-digit', month: 'long', year: 'numeric' };
                                        var formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                        document.getElementById('due_date_display').value = formattedDate;
                                    }

                                    // To show the existing value if it's already set (for example, in an edit form)
                                    $(document).ready(function() {
                                        updateDueDateDisplay();
                                    });
                                </script> --}}




                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description">Initiator Department  <span class="text-danger"></span></label>
                                    <select name="initiator_group" id="initiator_group" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                        <option selected disabled value="">---select---</option>
                                        @foreach (Helpers::getInitiatorGroups() as $code => $initiator_groups)
                                            <option value="{{ $initiator_group}}" @if ($data->initiator_group == $initiator_groups) selected @endif>
                                                {{ $initiator_group }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Department Code</label>
                                    <input readonly type="text" name="initiator_group_code_gi" id="initiator_group_code_gi" value="{{ $data->initiator_group_code_gi ?? '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                </div>
                            </div>

                            <script>
                                document.getElementById('initiator_group').addEventListener('change', function() {
                                    var selectedValue = this.value;
                                    document.getElementById('initiator_group_code_gi').value = selectedValue;
                                });

                                // Set the group code on page load if a value is already selected
                                document.addEventListener('DOMContentLoaded', function() {
                                    var initiatorGroupElement = document.getElementById('initiator_group');
                                    if (initiatorGroupElement.value) {
                                        document.getElementById('initiator_group_code_gi').value = initiatorGroupElement.value;
                                    }
                                });
                            </script> --}}


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description">Initiator Department <span class="text-danger"></span></label>
                                    <select name="initiator_group" id="initiator_group" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                        <option selected disabled value="">---select---</option>
                                        @foreach (Helpers::getInitiatorGroups() as $code => $initiator_group)
                                            <option value="{{ $initiator_group }}" data-code="{{ $code }}" @if ($data->initiator_group == $initiator_group) selected @endif>
                                                {{ $initiator_group }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Department Code</label>
                                    <input readonly type="text" name="initiator_group_code_gi" id="initiator_group_code_gi" value="{{ $data->initiator_group_code_gi ?? '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                </div>
                            </div>

                            <script>
                                document.getElementById('initiator_group').addEventListener('change', function() {
                                    var selectedOption = this.options[this.selectedIndex];
                                    var selectedCode = selectedOption.getAttribute('data-code');
                                    document.getElementById('initiator_group_code_gi').value = selectedCode;
                                });

                                // Set the group code on page load if a value is already selected
                                document.addEventListener('DOMContentLoaded', function() {
                                    var initiatorGroupElement = document.getElementById('initiator_group');
                                    if (initiatorGroupElement.value) {
                                        var selectedOption = initiatorGroupElement.options[initiatorGroupElement.selectedIndex];
                                        var selectedCode = selectedOption.getAttribute('data-code');
                                        document.getElementById('initiator_group_code_gi').value = selectedCode;
                                    }
                                });
                            </script>


                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group">Initiated Through</label>
                                    <div><small class="text-primary">Please select related information</small></div>
                                    <select name="initiated_through_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} id="initiated_through_gi">
                                        <option value="">-- select --</option>
                                        <option value="recall"
                                            {{ $data->initiated_through_gi == 'recall' ? 'selected' : '' }}>Recall</option>
                                        <option value="return"
                                            {{ $data->initiated_through_gi == 'return' ? 'selected' : '' }}>Return</option>
                                        <option value="deviation"
                                            {{ $data->initiated_through_gi == 'deviation' ? 'selected' : '' }}>Deviation
                                        </option>
                                        <option value="complaint"
                                            {{ $data->initiated_through_gi == 'complaint' ? 'selected' : '' }}>Complaint
                                        </option>
                                        <option value="regulatory"
                                            {{ $data->initiated_through_gi == 'regulatory' ? 'selected' : '' }}>Regulatory
                                        </option>
                                        <option value="lab-incident"
                                            {{ $data->initiated_through_gi == 'lab-incident' ? 'selected' : '' }}>Lab
                                            Incident</option>
                                        <option value="improvement"
                                            {{ $data->initiated_through_gi == 'improvement' ? 'selected' : '' }}>
                                            Improvement</option>
                                        <option value="others"
                                            {{ $data->initiated_through_gi == 'others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="If Other">If Other</label>
                                    <div>
                                        <small class="text-primary">Please insert "NA" in the data field if it does not require completion</small>
                                    </div>
                                    <textarea  name="if_other_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->if_other_gi }}</textarea>
                                </div>
                            </div> --}}

                            {{-- <script>
                                $(document).ready(function() {
                                    $('#summernote-1').summernote({
                                        callbacks: {
                                            onInit: function() {
                                                @if($data->stage >= 0 && $data->stage <= 8)
                                                    $('#summernote-1').summernote('disable'); // Disable Summernote editor
                                                    $('#summernote-1').prop('disabled', true); // Disable textarea
                                                @endif
                                            }
                                        }
                                    });
                                });
                            </script> --}}

                        <div class="col-12">
                             <div class="group-input">
                                <label for="Inv Attachments">Information Attachment</label>
                                <div>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="initial_attachment_gi">

                                        @if ($data->initial_attachment_gi)
                                            @foreach (json_decode($data->initial_attachment_gi) as $file)
                                                <h6 type="button" class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                            class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a type="button" class="remove-file"
                                                        data-file-name="{{ $file }}"><i
                                                            class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="initial_attachment_gi" name="initial_attachment_gi[]"
                                            oninput="addMultipleFiles(this,'initial_attachment_gi')" multiple>
                                    </div>
                                </div>
                            </div>
                       </div>

                {{-- <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Initiator Group">Complainant</label>
                        <select id="select-state" placeholder="Select..." name="complainant_gi">
                            <option value="">Select a value</option>
                            @foreach ($users as $value)
                                <option {{ $data->complainant_gi == $value->name ? 'selected' : '' }}
                                    value="{{ $value->name }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('complainant_gi')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Initiator Group">Complainant</label>
                      <input type="text" name="complainant_gi" value="{{ $data->complainant_gi }}">

                    </div>
                </div>

                <div class="col-lg-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="complaint_reported_on">Complaint Reported On</label>
                        <div class="calenderauditee">
                            <input type="text" id="complaint_dat" readonly placeholder="DD-MMM-YYYY" value="{{ $data->complaint_reported_on_gi ? \Carbon\Carbon::parse($data->complaint_reported_on_gi)->format('d-M-Y') : '' }}" />
                            <input type="date" id="complaint_date_picker" name="complaint_reported_on_gi" value="{{ $data->complaint_reported_on_gi ? \Carbon\Carbon::parse($data->complaint_reported_on_gi)->format('Y-m-d') : '' }}" class="hide-input" oninput="handleDateInput(this, 'complaint_dat')" />
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        const dateInput = document.getElementById('complaint_date_picker');
                        const today = new Date().toISOString().split('T')[0];
                        dateInput.setAttribute('max', today);

                        // Show the date picker when clicking on the readonly input
                        const readonlyInput = document.getElementById('complaint_dat');
                        readonlyInput.addEventListener('click', () => {
                            dateInput.style.display = 'block';
                            dateInput.focus();
                        });

                        // Update the readonly input when a date is selected
                        dateInput.addEventListener('change', () => {
                            const selectedDate = new Date(dateInput.value);
                            readonlyInput.value = formatDate(selectedDate);
                            dateInput.style.display = 'none';
                        });
                    });

                    function handleDateInput(dateInput, readonlyInputId) {
                        const readonlyInput = document.getElementById(readonlyInputId);
                        const selectedDate = new Date(dateInput.value);
                        readonlyInput.value = formatDate(selectedDate);
                    }

                    function formatDate(date) {
                        const options = { day: '2-digit', month: 'short', year: 'numeric' };
                        return date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                    }
                </script>



                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Details Of Nature Market Complaint">Details Of Nature Market
                                        Complaint</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="details_of_nature_market_complaint_gi" id="summernote-1">{{ $data->details_of_nature_market_complaint_gi }}
                                    </textarea>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Product Details
                                        <button type="button" id="Details" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>

                                    <table class="table table-bordered" id="ProductsDetails" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px;">Row #</th>
                                                <th>Product Name</th>
                                                <th>Batch No.</th>
                                                <th>Mfg. Date</th>
                                                <th>Exp. Date</th>
                                                <th>Batch Size</th>
                                                <th>Pack Size</th>
                                                <th>Dispatch Quantity</th>
                                                <th>Remarks</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $productsdetails = 1;
                                        @endphp
                                        @if (!empty($productsgi) && is_array($productsgi->data))
                                            @foreach ($productsgi->data as $index => $detail)
                                                <tr>
                                                    <td>{{ $productsdetails++ }}</td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_product_name]" value="{{ array_key_exists('info_product_name', $detail) ? $detail['info_product_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_batch_no]" value="{{ array_key_exists('info_batch_no', $detail) ? $detail['info_batch_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td>
                                                        <div class="new-date-data-field">
                                                            <div class="group-input input-date">
                                                                <div class="calenderauditee">
                                                                    <input
                                                                        class="click_date"
                                                                        id="date_{{ $index }}_mfg_date"
                                                                        type="text"
                                                                        name="serial_number_gi[{{ $index }}][info_mfg_date]"
                                                                        placeholder="DD-MMM-YYYY"
                                                                        value="{{ !empty($detail['info_mfg_date']) ? \Carbon\Carbon::parse($detail['info_mfg_date'])->format('d-M-Y') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                    />
                                                                    <input
                                                                        type="date"
                                                                        name="serial_number_gi[{{ $index }}][info_mfg_date]"
                                                                        value="{{ !empty($detail['info_mfg_date']) ? \Carbon\Carbon::parse($detail['info_mfg_date'])->format('Y-m-d') : '' }}"
                                                                        id="date_{{ $index }}_mfg_date_picker"
                                                                        class="hide-input show_date"
                                                                        style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                        onchange="handleDateInput(this, 'date_{{ $index }}_mfg_date')" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="new-date-data-field">
                                                            <div class="group-input input-date">
                                                                <div class="calenderauditee">
                                                                    <input
                                                                        class="click_date"
                                                                        id="date_{{ $index }}_expiry_date"
                                                                        type="text"
                                                                        name="serial_number_gi[{{ $index }}][info_expiry_date]"
                                                                        placeholder="DD-MMM-YYYY"
                                                                        value="{{ !empty($detail['info_expiry_date']) ? \Carbon\Carbon::parse($detail['info_expiry_date'])->format('d-M-Y') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                    />
                                                                    <input
                                                                        type="date"
                                                                        name="serial_number_gi[{{ $index }}][info_expiry_date]"
                                                                        value="{{ !empty($detail['info_expiry_date']) ? \Carbon\Carbon::parse($detail['info_expiry_date'])->format('Y-m-d') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                        id="date_{{ $index }}_expiry_date_picker"
                                                                        class="hide-input show_date"
                                                                        style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                        onchange="handleDateInput(this, 'date_{{ $index }}_expiry_date')"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_batch_size]" value="{{ array_key_exists('info_batch_size', $detail) ? $detail['info_batch_size'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_pack_size]" value="{{ array_key_exists('info_pack_size', $detail) ? $detail['info_pack_size'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_dispatch_quantity]" value="{{ array_key_exists('info_dispatch_quantity', $detail) ? $detail['info_dispatch_quantity'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $index }}][info_remarks]" value="{{ array_key_exists('info_remarks', $detail) ? $detail['info_remarks'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Remove</button></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">No product details found</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>

                                </div>
                            </div> --}}


                            {{-- <script>
                                $(document).ready(function() {
                                    let indexDetail = {{ ($productsgi && is_array($productsgi->data)) ? count($productsgi->data) : 0 }};
                                    $('#Details').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial_number_gi[' + serialNumber + '][serial]" value="' + (serialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_product_name]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_batch_no]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_'+ indexDetail +'_mfg_date" type="text" name="serial_number_gi[' + indexDetail + '][info_mfg_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + indexDetail + '][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ indexDetail +'_mfg_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ indexDetail +'_mfg_date\')" /> </div> </div></div></td>' +
                                                '<td>  <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ indexDetail +'_expiry_date" type="text" name="serial_number_gi[' + indexDetail + '][info_expiry_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + indexDetail + '][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ indexDetail +'_expiry_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ indexDetail +'_expiry_date\')" /> </div> </div></div></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_batch_size]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_pack_size]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_dispatch_quantity]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_remarks]"></td>' +
                                                '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                                                '</tr>';
                                                indexDetail++;
                                            return html;
                                        }

                                        var tableBody = $('#ProductsDetails tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script> --}}


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Product Details
                                        <button type="button" id="Details" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                              data-bs-target="#document-details-field-instruction-modal"
                                              style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <table class="table table-bordered" id="ProductsDetails" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px;">Row #</th>
                                                <th>Product Name</th>
                                                <th>Batch No.</th>
                                                <th>Mfg. Date</th>
                                                <th>Exp. Date</th>
                                                <th>Batch Size</th>
                                                <th>Pack Size</th>
                                                <th>Dispatch Quantity</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $productsdetails = 1; @endphp
                                            @if (!empty($productsgi) && is_array($productsgi->data))
                                                @foreach ($productsgi->data as $index => $detail)
                                                    <tr>
                                                        <td>{{ $productsdetails++ }}</td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_product_name]" value="{{ array_key_exists('info_product_name', $detail) ? $detail['info_product_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_batch_no]" value="{{ array_key_exists('info_batch_no', $detail) ? $detail['info_batch_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td>
                                                            <input type="text" name="serial_number_gi[{{ $index }}][info_mfg_date]" value="{{ array_key_exists('info_mfg_date', $detail) ? $detail['info_mfg_date'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} placeholder="DD-MMM-YYYY">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="serial_number_gi[{{ $index }}][info_expiry_date]" value="{{ array_key_exists('info_expiry_date', $detail) ? $detail['info_expiry_date'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} placeholder="DD-MMM-YYYY">
                                                        </td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_batch_size]" value="{{ array_key_exists('info_batch_size', $detail) ? $detail['info_batch_size'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_pack_size]" value="{{ array_key_exists('info_pack_size', $detail) ? $detail['info_pack_size'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_dispatch_quantity]" value="{{ array_key_exists('info_dispatch_quantity', $detail) ? $detail['info_dispatch_quantity'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="serial_number_gi[{{ $index }}][info_remarks]" value="{{ array_key_exists('info_remarks', $detail) ? $detail['info_remarks'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}></td>
                                                        <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="9">No product details found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    let indexDetail = {{ ($productsgi && is_array($productsgi->data)) ? count($productsgi->data) : 0 }};

                                    $('#Details').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td>' + (serialNumber + 1) + '</td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_product_name]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_batch_no]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_mfg_date]" placeholder="DD-MMM-YYYY"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_expiry_date]" placeholder="DD-MMM-YYYY"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_batch_size]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_pack_size]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_dispatch_quantity]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + indexDetail + '][info_remarks]"></td>' +
                                                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                            indexDetail++;
                                            return html;
                                        }

                                        var tableBody = $('#ProductsDetails tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });

                                    $(document).on('click', '.removeRowBtn', function() {
                                        $(this).closest('tr').remove();
                                    });
                                });
                            </script>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Traceability
                                        <button type="button" id="traceblity_add" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="traceblity" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Product Name</th>
                                                    <th>Batch No.</th>
                                                    <th>Manufacturing Location</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $traceabilityIndex = 1;
                                                @endphp
                                                {{-- @if (!empty($traceability_gi)) --}}
                                                @if (!empty($traceability_gi) && is_array($traceability_gi->data))

                                                    @foreach ($traceability_gi->data as $index => $tracebil)
                                                        <tr>
                                                            <td><input disabled type="text" name="trace_ability[{{ $index }}][serial]" value="{{ $traceabilityIndex++ }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="trace_ability[{{ $index }}][product_name_tr]" value="{{ $tracebil['product_name_tr'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="trace_ability[{{ $index }}][batch_no_tr]" value="{{ $tracebil['batch_no_tr'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="trace_ability[{{ $index }}][manufacturing_location_tr]" value="{{ $tracebil['manufacturing_location_tr'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="trace_ability[{{ $index }}][remarks_tr]" value="{{ $tracebil['remarks_tr'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                           <td><button type="text" class="removeRowBtn"{{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} >Remove</button></td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No found</td>
                                                     </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#traceblity_add').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="trace_ability[' + serialNumber + '][serial]" value="' + (serialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="trace_ability[' + serialNumber + '][product_name_tr]"></td>' +
                                                '<td><input type="text" name="trace_ability[' + serialNumber + '][batch_no_tr]"></td>' +
                                                '<td><input type="text" name="trace_ability[' + serialNumber + '][manufacturing_location_tr]"></td>' +
                                                '<td><input type="text" name="trace_ability[' + serialNumber + '][remarks_tr]"></td>' +
                                                '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +

                                                '</tr>';
                                            return html;
                                        }

                                        var tableBody = $('#traceblity tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group">Categorization of complaint</label>
                                    <select name="categorization_of_complaint_gi" onchange="" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                        <option value="">-- select --</option>
                                        <option value="Critical" {{ $data->categorization_of_complaint_gi == 'Critical' ? 'selected' : '' }}>Critical</option>
                                        <option value="Major" {{ $data->categorization_of_complaint_gi == 'Major' ? 'selected' : '' }}>Major</option>
                                        <option value="Minor" {{ $data->categorization_of_complaint_gi == 'Minor' ? 'selected' : '' }}>Minor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="is_repeat_gi">Is Repeat</label>
                                    <select name="is_repeat_gi" id="is_repeat_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                        <option value="" {{ $data->is_repeat_gi == '0' ? 'selected' : '' }}>-- select --</option>
                                        <option value="yes" {{ $data->is_repeat_gi == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ $data->is_repeat_gi == 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3" id="repeat_nature_div" style="display: none;">
                                <div class="group-input">
                                    <label for="repeat_nature_gi">Repeat Nature</label>
                                    <div>
                                        <small class="text-primary">Please insert "NA" in the data field if it does not require completion</small>
                                    </div>
                                    <textarea name="repeat_nature_gi" id="repeat_nature_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->repeat_nature_gi }}</textarea>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var isRepeatSelect = document.getElementById('is_repeat_gi');
                                    var repeatNatureDiv = document.getElementById('repeat_nature_div');

                                    // Handle the change event for the select element
                                    isRepeatSelect.addEventListener('change', function() {
                                        if (isRepeatSelect.value === 'yes') {
                                            repeatNatureDiv.style.display = 'block';
                                        } else {
                                            repeatNatureDiv.style.display = 'none';
                                        }
                                    });

                                    // Check the current value and show/hide the repeat nature div on page load
                                    if (isRepeatSelect.value === 'yes') {
                                        repeatNatureDiv.style.display = 'block';
                                    }
                                });
                            </script>


                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="is_repeat_gi">Is Repeat</label>
                                    <select name="is_repeat_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                        <option value="" {{ $data->is_repeat_gi == '0' ? 'selected' : '' }}>--
                                            select --</option>
                                        <option value="yes" {{ $data->is_repeat_gi == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no" {{ $data->is_repeat_gi == 'no' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Repeat Nature">Repeat Nature</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="repeat_nature_gi" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} id="summernote-1">{{ $data->repeat_nature_gi }}

                                    </textarea>
                                </div>
                            </div> --}}


                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Complaint Sample">Review of Complaint Sample</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_complaint_sample_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_complaint_sample_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Control Sample">Review of Control Sample</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_control_sample_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_control_sample_gi }}
                                    </textarea>
                                </div>
                            </div>





                            <div class="button-block">
                                <button type="submit" class="saveButton" id="saveButton"{{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} >Save</button>




                        {{-- <script>
                            function showAlert(event) {
                                event.preventDefault(); // Prevent form submission
                                var alertMessage = document.getElementById('alert-message').innerText;
                                alert(alertMessage);
                            }

                            document.addEventListener('DOMContentLoaded', function () {
                                var stage = {{ $data->stage }};


                            });
                        </script> --}}

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head col-12"> Investigation</div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Investigation Team
                                        <button type="button" id="investigation_team_add" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Investing_team" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Name</th>
                                                    <th>Department</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $investingTeamIndex = 1;
                                                @endphp
                                                {{-- @if (!empty($investing_team)) --}}
                                                @if (!empty($investing_team) && is_array($investing_team->data))

                                                    @foreach ($investing_team->data as $index => $inves)
                                                        <tr>
                                                            <td><input disabled type="text" name="Investing_team[{{ $index }}][serial]" value="{{ $investingTeamIndex++ }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Investing_team[{{ $index }}][name_inv_tem]" value="{{ $inves['name_inv_tem'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Investing_team[{{ $index }}][department_inv_tem]" value="{{ $inves['department_inv_tem'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Investing_team[{{ $index }}][remarks_inv_tem]" value="{{ $inves['remarks_inv_tem'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                             <td><button type="text" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} >Remove</button></td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4">No data found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#investigation_team_add').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="Investing_team[' + serialNumber + '][serial]" value="' + (serialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="Investing_team[' + serialNumber + '][name_inv_tem]"></td>' +
                                                '<td><input type="text" name="Investing_team[' + serialNumber + '][department_inv_tem]"></td>' +
                                                '<td><input type="text" name="Investing_team[' + serialNumber + '][remarks_inv_tem]"></td>' +
                                                '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +

                                                '</tr>';
                                            return html;
                                        }

                                        var tableBody = $('#Investing_team tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Batch manufacturing record (BMR)">Review
                                        of Batch manufacturing
                                        record (BMR)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_batch_manufacturing_record_BMR_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_batch_manufacturing_record_BMR_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label
                                        for="Review of Raw materials used in batch
                                        manufacturing">Review
                                        of Raw materials used in batch
                                        manufacturing</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_raw_materials_used_in_batch_manufacturing_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_raw_materials_used_in_batch_manufacturing_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Batch Packing record (BPR)">Review of Batch Packing record
                                        (BPR)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_Batch_Packing_record_bpr_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_Batch_Packing_record_bpr_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of packing materials used in batch packing">Review of packing
                                        materials used in batch
                                        packing</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_packing_materials_used_in_batch_packing_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_packing_materials_used_in_batch_packing_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Analytical Data">Review of Analytical Data</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_analytical_data_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_analytical_data_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of training record of Concern Persons">Review of training record
                                        of Concern Persons</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_training_record_of_concern_persons_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_training_record_of_concern_persons_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Equipment/Instrument qualification/Calibration record">Review
                                        of Equipment/Instrument qualification/Calibration record</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="rev_eq_inst_qual_calib_record_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->rev_eq_inst_qual_calib_record_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Equipment Break-down and Maintainance Record">Review of
                                        Equipment Break-down and Maintainance Record</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_equipment_break_down_and_maintainance_record_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_equipment_break_down_and_maintainance_record_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Review of Past history of product">Review of Past history of
                                        product</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="review_of_past_history_of_product_gi" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->review_of_past_history_of_product_gi }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Brain Storming Session/Discussion with Concerned Person
                                        <button type="button" id="brain-stroming" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="brain_stroming_details" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Possibility</th>
                                                    <th>Facts/Controls</th>
                                                    <th>Probable Cause</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $brainindex = 1;
                                                @endphp
                                                {{-- @if (!empty($brain_stroming_details)) --}}
                                                @if (!empty($brain_stroming_details) && is_array($brain_stroming_details->data))

                                                    @foreach ($brain_stroming_details->data as $index => $bra_st_s)
                                                        <tr>
                                                            <td><input disabled type="text" name="brain_stroming_details[{{ $index }}][serial]" value="{{ $brainindex++ }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="brain_stroming_details[{{ $index }}][possibility_bssd]" value="{{ $bra_st_s['possibility_bssd'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="brain_stroming_details[{{ $index }}][factscontrols_bssd]" value="{{ $bra_st_s['factscontrols_bssd'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="brain_stroming_details[{{ $index }}][probable_cause_bssd]" value="{{ $bra_st_s['probable_cause_bssd'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="brain_stroming_details[{{ $index }}][remarks_bssd]" value="{{ $bra_st_s['remarks_bssd'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                              <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Remove</button></td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No product details found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#brain-stroming').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="brain_stroming_details[' + serialNumber + '][serial]" value="' + (serialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="brain_stroming_details[' + serialNumber + '][possibility_bssd]"></td>' +
                                                '<td><input type="text" name="brain_stroming_details[' + serialNumber + '][factscontrols_bssd]"></td>' +
                                                '<td><input type="text" name="brain_stroming_details[' + serialNumber + '][probable_cause_bssd]"></td>' +
                                                '<td><input type="text" name="brain_stroming_details[' + serialNumber + '][remarks_bssd]"></td>' +
                                                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +

                                                '</tr>';
                                            return html;
                                        }

                                        var tableBody = $('#brain_stroming_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>
                            <div class="sub-head col-12">HOD/Supervisor Review</div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="conclusion_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->conclusion_hodsr }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Root Cause Analysis">Root Cause Analysis</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="root_cause_analysis_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->root_cause_analysis_hodsr }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="The most probable root causes identified of the complaint are as below">The
                                        most probable root causes identified of the complaint are as below</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="probable_root_causes_complaint_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->probable_root_causes_complaint_hodsr }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment">Impact Assessment :</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="impact_assessment_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->impact_assessment_hodsr }}
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Corrective Action">Corrective Action :</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="corrective_action_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->corrective_action_hodsr }}
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Preventive Action">Preventive Action :</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="preventive_action_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->preventive_action_hodsr }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Summary and Conclusion">Summary and Conclusion</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="summary_and_conclusion_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->summary_and_conclusion_hodsr }}
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Team Members
                                        <button type="button" id="team_members" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="team_members_details" style="width: %;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Names</th>
                                                    <th>Department</th>
                                                    <th>Sign</th>
                                                    <th>Date</th>
                                                    <th>Action</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $teammebindex = 1;
                                            @endphp

                                            @if (!empty($team_members) && is_array($team_members->data))
                                                @foreach ($team_members->data as $index  => $tem_meb)
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[{{ $index }}]" value="{{ $teammebindex++ }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}> </td>
                                                    <td><input type="text" name="Team_Members[{{ $index }}][names_tm]" value="{{ array_key_exists('names_tm', $tem_meb) ? $tem_meb['names_tm'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="Team_Members[{{ $index }}][department_tm]" value="{{ array_key_exists('department_tm', $tem_meb) ? $tem_meb['department_tm'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td><input type="text" name="Team_Members[{{ $index }}][sign_tm]" value="{{ array_key_exists('sign_tm', $tem_meb) ? $tem_meb['sign_tm'] : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                    <td>
                                                        <div class="new-date-data-field">
                                                            <div class="group-input input-date">
                                                                <div class="calenderauditee">
                                                                    <input
                                                                    class="click_date"
                                                                    id="date_{{ $index }}_date_tm"
                                                                    type="text" name="Team_Members[{{ $index }}][date_tm]"
                                                                     placeholder="DD-MMM-YYYY"
                                                                      value="{{  !empty($tem_meb['date_tm']) ?   \Carbon\Carbon::parse($tem_meb['date_tm'])->format('d-M-Y') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                       />
                                                                    <input type="date"
                                                                    name="Team_Members[{{ $index }}][date_tm]"

                                                                    value="{{ !empty($tem_meb['date_tm']) ? \Carbon\Carbon::parse($tem_meb['date_tm'])->format('Y-m-d') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                    id="date_{{ $index }}_date_tm"
                                                                    class="hide-input show_date"
                                                                     style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                     onchange="handleDateInput(this, 'date_{{ $index }}_date_tm')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><button type="text" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Remove</button></td>

                                                </tr>
                                                @endforeach
                                            {{-- @else
                                                <tr>
                                                    <td colspan="9">No product details found</td>
                                                </tr> --}}
                                            @endif


                                            </tbody>
                                        </table>
                                   </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    let indexteam = {{ (!empty($team_members) && is_array($team_members->data)) ? count($team_members->data) : 0 }};
                                    $('#team_members').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(teamserialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="Team_Members[' + teamserialNumber + '][serial]" value="' + (teamserialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="Team_Members[' + indexteam + '][names_tm]"></td>' +
                                                '<td><input type="text" name="Team_Members[' + indexteam + '][department_tm]"></td>' +
                                                '<td><input type="text" name="Team_Members[' + indexteam + '][sign_tm]"></td>' +
                                                '<td>  <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ indexteam +'_date_tm" type="text" name="Team_Members[' + indexteam + '][date_tm]" placeholder="DD-MMM-YYYY" /> <input type="date" name="Team_Members[' + indexteam + '][date_tm]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="" id="date_'+ indexteam +'_date_tm" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ indexteam +'_date_tm\')" /> </div> </div></td>' +
                                                '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                                                '</tr>';
                                            indexteam++;
                                            return html;
                                        }

                                        var tableBody = $('#team_members_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>






                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Report Approval
                                        <button type="button" id="report_approval" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="report_approval_details" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Names</th>
                                                    <th>Department</th>
                                                    <th>Sign</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $reportindex = 1;
                                                @endphp
                                                @if (!empty($report_approval) && is_array($report_approval->data))
                                                    @foreach ($report_approval->data as $index => $rep_ap)
                                                        <tr>
                                                            <td><input disabled type="text" name="Report_Approval[{{ $index }}][serial]" value="{{ $reportindex++ }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Report_Approval[{{ $index }}][names_rrv]" value="{{ $rep_ap['names_rrv'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Report_Approval[{{ $index }}][department_rrv]" value="{{ $rep_ap['department_rrv'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td><input type="text" name="Report_Approval[{{ $index }}][sign_rrv]" value="{{ $rep_ap['sign_rrv'] }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}></td>
                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input
                                                                                class="click_date"
                                                                                id="date_{{ $index }}_date_rrv"
                                                                                type="text"
                                                                                name="Report_Approval[{{ $index }}][date_rrv]"
                                                                                placeholder="DD-MMM-YYYY"
                                                                                value="{{ !empty($rep_ap['date_rrv']) ? \Carbon\Carbon::parse($rep_ap['date_rrv'])->format('d-M-Y') : '' }}" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            />
                                                                            <input
                                                                                type="date"
                                                                                name="Report_Approval[{{ $index }}][date_rrv]"
                                                                                value="{{ !empty($rep_ap['date_rrv']) ? \Carbon\Carbon::parse($rep_ap['date_rrv'])->format('Y-m-d') : '' }}"
                                                                                id="date_{{ $index }}_date_rrv"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'date_{{ $index }}_date_rrv')" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <script>
                                $(document).ready(function() {
                                    let indexReaprovel = {{ ($report_approval && is_array($report_approval->data)) ? count($report_approval->data) : 0 }};

                                    $('#report_approval').click(function(e) {
                                        e.preventDefault();

                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="Report_Approval[' + serialNumber + '][serial]" value="' + (serialNumber + 1) + '"></td>' +
                                                '<td><input type="text" name="Report_Approval[' + serialNumber + '][names_rrv]"></td>' +
                                                '<td><input type="text" name="Report_Approval[' + serialNumber + '][department_rrv]"></td>' +
                                                '<td><input type="text" name="Report_Approval[' + serialNumber + '][sign_rrv]"></td>' +
                                                '<td><div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ serialNumber +'_date_rrv" type="text" name="Report_Approval[' + serialNumber + '][date_rrv]" placeholder="DD-MMM-YYYY" value="" /> <input type="date" name="Report_Approval[' + serialNumber + '][date_rrv]" value="" id="date_'+ serialNumber +'_date_rrv" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_date_rrv\')" /> </div></div></div></td>' +
                                                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                            indexReaprovel++;
                                            return html;
                                        }

                                        var tableBody = $('#report_approval_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });

                                    $(document).on('click', '.removeRowBtn', function() {
                                        $(this).closest('tr').remove();
                                    });
                                });

                                function handleDateInput(dateInput, textInputId) {
                                    const textInput = document.getElementById(textInputId);
                                    if (dateInput.value) {
                                        const date = new Date(dateInput.value);
                                        const formattedDate = date.toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: 'short',
                                            year: 'numeric'
                                        }).replace(/ /g, '-');
                                        textInput.value = formattedDate;
                                    } else {
                                        textInput.value = '';
                                    }
                                }
                            </script>





                <div class="col-12">
                    <div class="group-input">
                        <label for="Inv Attachments">HOD Attachment</label>
                        <div>
                            <small class="text-primary">
                                Please Attach all relevant or supporting documents
                            </small>
                        </div>
                        <div class="file-attachment-field">
                            <div class="file-attachment-list" id="initial_attachment_hodsr">

                                @if ($data->initial_attachment_hodsr)
                                    @foreach (json_decode($data->initial_attachment_hodsr) as $file)
                                        <h6 type="button" class="file-container text-dark"
                                            style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                    class="fa fa-eye text-primary"
                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a type="button" class="remove-file"
                                                data-file-name="{{ $file }}"><i
                                                    class="fa-solid fa-circle-xmark"
                                                    style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                    @endforeach
                                @endif
                            </div>
                            <div class="add-btn">
                                <div>Add</div>
                                <input type="file" id="initial_attachment_hodsr" name="initial_attachment_hodsr[]"
                                    oninput="addMultipleFiles(this,'initial_attachment_hodsr')" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} multiple>
                            </div>
                        </div>
                    </div>
                </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Comments">Comments(if Any)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="comments_if_any_hodsr" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->comments_if_any_hodsr }}
                                    </textarea>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Support_doc">Supporting Documents</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Support_doc"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Support_doc[]"
                                                    oninput="addMultipleFiles(this, 'Support_doc')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton" id="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} >Save</button>

                        {{-- <div id="alert-message" style="display:none;">
                            Your stage is Closed - Done You Cannot Edit or Save.
                        </div>


                        <script>
                            function showAlert(event) {
                                event.preventDefault(); // Prevent form submission
                                var alertMessage = document.getElementById('alert-message').innerText;
                                alert(alertMessage);
                            }

                            document.addEventListener('DOMContentLoaded', function () {
                                var stage = {{ $data->stage }};


                            });
                        </script> --}}
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="CCForm6" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">
                            Production (Tablet/Capsule/Powder)
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Production_Table_Review !== 'yes')

                                    $('.p_erson').hide();

                                    $('[name="Production_Table_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.p_erson').show();
                                            $('.p_erson span').show();
                                        } else {
                                            $('.p_erson').hide();
                                            $('.p_erson span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp
                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review Table"> Production TAble Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Production_Table_Review" id="Production_Table_Review"
                                        @if ($data->stage == 4) disabled @endif
                                        @if ($data->stage == 3) required @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Table_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Production_Table_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Production_Table_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 51,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                // $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 p_erson">
                                <div class="group-input">
                                    <label for="Production notification">Production Table Person <span
                                            id="asteriskProduction"
                                            style="display: {{ $data1->Production_Table_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Production_Table_Person" class="Production_Table_Person"
                                        id="Production_Table_Person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Production_Table_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 p_erson">
                                <div class="group-input">
                                    <label for="Production assessment">Impact Table Assessment (By Production)
                                        <span id="asteriskProduction1"
                                            style="display: {{ $data1->Production_Table_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Production_Table_Review == 'yes' && $data->stage == 4) required @endif class="summernote Production_Table_Assessment"
                                        @if ($data->stage == 3 || Auth::user()->id != $data1->Production_Table_Person) readonly @endif name="Production_Table_Assessment" id="summernote-17">{{ $data1->Production_Table_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 p_erson">
                                <div class="group-input">
                                    <label for="Production Table feedback">Production Table Feedback <span
                                            id="asteriskProduction2"
                                            style="display: {{ $data1->Production_Table_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Production_Table_Feedback" @if ($data->stage == 3 || Auth::user()->id != $data1->Production_Table_Person) readonly @endif
                                        name="Production_Table_Feedback" id="summernote-18" @if ($data1->Production_Table_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Production_Table_Feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 p_erson">
                                <div class="group-input">
                                    <label for="production attachment">Production Table Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Production_Table_Attachment">
                                            @if ($data1->Production_Table_Attachment)
                                                @foreach (json_decode($data1->Production_Table_Attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Production_Table_Attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Production_Table_Attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 p_erson">
                                <div class="group-input">
                                    <label for="Production Review Table Completed By">Production Review Table
                                        Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Production_Table_By }}"
                                        name="Production_Table_By"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Production_Table_By">


                                </div>
                            </div>
                            <div class="col-6 new-date-data-field p_erson">
                                <div class="group-input input-date">
                                    <label for="Production Review Table Completed On">Production Review Table
                                        Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->

                                    <div class="calenderauditee">
                                        <input type="text" id="Production_Table_On" readonly
                                            placeholder="DD-MMM-YYYY"
                                            value="{{ Helpers::getdateFormat($data1->Production_Table_On) }}" />
                                        <input type="date"
                                            name="Production_Table_On"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input"
                                            oninput="handleDateInput(this, 'Production_Table_On')" />
                                    </div>
                                    @error('Production_Table_On')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Production_Table_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Production_Table_Person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Table_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Table_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskProduction');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review Table">Production Table Review Required
                                        ?</label>
                                    <select name="Production_Table_Review" disabled
                                        id="Production_Table_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Table_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Production_Table_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Production_Table_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 22,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                //$users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 p_erson">
                                <div class="group-input">
                                    <label for="Production notification">Production Table Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Production_Table_Person" disabled
                                        id="Production_Table_Person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Production_Table_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 p_erson">
                                    <div class="group-input">
                                        <label for="Production assessment">Impact Assessment (By Production Table)
                                            <span id="asteriskInvi12" style="display: none"
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Production_Table_Assessment" id="summernote-17">{{ $data1->Production_Table_Assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 p_erson">
                                    <div class="group-input">
                                        <label for="Production Table feedback">Production Table Feedback <span
                                                id="asteriskInvi22" style="display: none"
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Production_Table_Feedback" id="summernote-18">{{ $data1->Production_Table_Feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 p_erson">
                                    <div class="group-input">
                                        <label for="Production assessment">Impact Assessment (By Production Table)
                                            <span id="asteriskInvi12" style="display: none"
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Production_Table_Assessment" id="summernote-17">{{ $data1->Production_Table_Assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 p_erson">
                                    <div class="group-input">
                                        <label for="Production Table feedback">Production Table Feedback <span
                                                id="asteriskInvi22" style="display: none"
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Production_Table_Feedback" id="summernote-18">{{ $data1->Production_Table_Feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 p_erson">
                                <div class="group-input">
                                    <label for="production attachment">Production Table Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Production_Table_Attachment">
                                            @if ($data1->Production_Table_Attachment)
                                                @foreach (json_decode($data1->Production_Table_Attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Production_Table_Attachment[]"
                                                oninput="addMultipleFiles(this, 'Production_Table_Attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 p_erson">
                                <div class="group-input">
                                    <label for="Production Review Table Completed By">Production Review Table
                                        Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Production_Table_By }}"
                                        name="Production_Table_By" id="Production_Table_By">


                                </div>
                            </div>
                            <div class="col-6 new-date-data-field p_erson">
                                <div class="group-input input-date">
                                    <label for="Production Review Table Completed On">Production Review Table
                                        Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->

                                    <div class="calenderauditee">
                                        <input type="text" id="Production_Table_On" readonly
                                            placeholder="DD-MMM-YYYY"
                                            value="{{ Helpers::getdateFormat($data1->Production_Table_On) }}" />
                                        <input type="date" name="Production_Table_On"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input"
                                            oninput="handleDateInput(this, 'Production_Table_On')" />
                                    </div>
                                    @error('Production_Table_On')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="sub-head">
                            Production Injection
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Production_Injection_Review !== 'yes')
                                    $('.productionInjection').hide();

                                    $('[name="Production_Injection_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.productionInjection').show();
                                            $('.productionInjection span').show();
                                        } else {
                                            $('.productionInjection').hide();
                                            $('.productionInjection span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Injection"> Production Injection Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Production_Injection_Review" id="Production_Injection_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Injection_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Production_Injection_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Production_Injection_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 53,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection notification">Production Injection Person
                                        <span id="asteriskPT"
                                            style="display: {{ $data1->Production_Injection_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Production_Injection_Person" class="Production_Injection_Person"
                                        id="Production_Injection_Person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Production_Injection_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection assessment">Impact Assessment (By Production
                                        Injection) <span id="asteriskPT1"
                                            style="display: {{ $data1->Production_Injection_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Production_Injection_Review == 'yes' && $data->stage == 4) required @endif class="summernote Production_Injection_Assessment"
                                        @if (
                                            $data->stage == 3 ||
                                                (isset($data1->Production_Injection_Person) && Auth::user()->id != $data1->Production_Injection_Person)) readonly @endif name="Production_Injection_Assessment" id="summernote-17">{{ $data1->Production_Injection_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection feedback">Production Injection Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->Production_Injection_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Production_Injection_Feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->Production_Injection_Person) && Auth::user()->id != $data1->Production_Injection_Person)) readonly @endif
                                        name="Production_Injection_Feedback" id="summernote-18" @if ($data1->Production_Injection_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Production_Injection_Feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection attachment">Production Injection
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Production_Injection_Attachment">
                                            @if ($data1->Production_Injection_Attachment)
                                                @foreach (json_decode($data1->Production_Injection_Attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Production_Injection_Attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Production_Injection_Attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection Completed By">Production Injection Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->Production_Injection_By }}"
                                        name="Production_Injection_By"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Production_Injection_By">


                                </div>
                            </div>
                            <div class="col-lg-6 productionInjection">
                                <div class="group-input ">
                                    <label for="Production Injection Completed On">Production Injection Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Production_Injection_On"
                                        name="Production_Injection_On"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Production_Injection_On }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Production_Injection_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Production_Injection_Person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Injection">Production Injection Required ?</label>
                                    <select name="Production_Injection_Review" disabled
                                        id="Production_Injection_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Injection_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Production_Injection_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Production_Injection_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 53,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection notification">Production Injection Person
                                        <span id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Production_Injection_Person" disabled
                                        id="Production_Injection_Person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Production_Injection_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection assessment">Impact Assessment (By
                                            Production Injection)
                                            <!-- <span
                                                                                                                                                                    id="asteriskInvi12" style="display: none"
                                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Production_Injection_Assessment" id="summernote-17">{{ $data1->Production_Injection_Assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection feedback">Production Injection Feedback
                                            <!-- <span
                                                                                                                                                                    id="asteriskInvi22" style="display: none"
                                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Production_Injection_Feedback" id="summernote-18">{{ $data1->Production_Injection_Feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection assessment">Impact Assessment (By
                                            Production Injection)
                                            <!-- <span
                                                                                                                                                                    id="asteriskInvi12" style="display: none"
                                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Production_Injection_Assessment" id="summernote-17">{{ $data1->Production_Injection_Assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection feedback">Production Injection Feedback
                                            <!-- <span
                                                                                                                                                                    id="asteriskInvi22" style="display: none"
                                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Production_Injection_Feedback" id="summernote-18">{{ $data1->Production_Injection_Feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection attachment">Production Injection
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Production_Injection_Attachment">
                                            @if ($data1->Production_Injection_Attachment)
                                                @foreach (json_decode($data1->Production_Injection_Attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Production_Injection_Attachment[]"
                                                oninput="addMultipleFiles(this, 'Production_Injection_Attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection Completed By">Production Injection Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->Production_Injection_By }}"
                                        name="Production_Injection_By" id="Production_Injection_By">


                                </div>
                            </div>
                            <div class="col-lg-6 productionInjection">
                                <div class="group-input">
                                    <label for="Production Injection Completed On">Production Injection Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date"id="Production_Injection_On"
                                        name="Production_Injection_On"
                                        value="{{ $data1->Production_Injection_On }}">
                                </div>
                            </div>
                        @endif


                        <div class="sub-head">
                            Research & Development
                        </div>
                        <script>
                            $(document).ready(function() {

                                @if ($data1->ResearchDevelopment_Review !== 'yes')
                                    $('.researchDevelopment').hide();

                                    $('[name="ResearchDevelopment_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.researchDevelopment').show();
                                            $('.researchDevelopment span').show();
                                        } else {
                                            $('.researchDevelopment').hide();
                                            $('.researchDevelopment span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Research Development"> Research Development Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 55,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development notification">Research Development Person
                                        <span id="asteriskPT"
                                            style="display: {{ $data1->ResearchDevelopment_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="ResearchDevelopmentStore_person"
                                        class="ResearchDevelopment_person" id="ResearchDevelopment_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ResearchDevelopment_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development assessment">Impact Assessment (By Research
                                        Development) <span id="asteriskPT1"
                                            style="display: {{ $data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif class="summernote ResearchDevelopment_assessment"
                                        @if (
                                            $data->stage == 3 ||
                                                (isset($data1->ResearchDevelopmentStore_person) && Auth::user()->id != $data1->ResearchDevelopmentStore_person)) readonly @endif name="ResearchDevelopment_assessment" id="summernote-17">{{ $data1->ResearchDevelopment_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development feedback">Research Development Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote ResearchDevelopment_feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->ResearchDevelopmentStore_person) && Auth::user()->id != $data1->ResearchDevelopmentStore_person)) readonly @endif
                                        name="ResearchDevelopment_feedback" id="summernote-18" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->ResearchDevelopment_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development attachment">Research Development
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ResearchDevelopment_attachment">
                                            @if ($data1->ResearchDevelopment_attachment)
                                                @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ResearchDevelopment_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development Completed By">Research Development Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->ResearchDevelopment_by }}"
                                        name="ResearchDevelopment_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="ResearchDevelopment_by">


                                </div>
                            </div>
                            <div class="col-lg-6 researchDevelopment">
                                <div class="group-input ">
                                    <label for="Research Development Completed On">Research Development Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="ResearchDevelopment_on"
                                        name="ResearchDevelopment_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->ResearchDevelopment_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('ResearchDevelopment_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('ResearchDevelopment_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Research Development">Research Development Required ?</label>
                                    <select name="ResearchDevelopment_Review" disabled
                                        id="ResearchDevelopment_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ResearchDevelopment_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 55,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development notification">Research Development Person
                                        <span id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="ResearchDevelopment_person" disabled
                                        id="ResearchDevelopment_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ResearchDevelopment_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development assessment">Impact Assessment (By
                                            Research
                                            Development)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ResearchDevelopment_assessment" id="summernote-17">{{ $data1->ResearchDevelopment_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development feedback">Research Development
                                            Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ResearchDevelopment_feedback" id="summernote-18">{{ $data1->ResearchDevelopment_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development assessment">Impact Assessment (By
                                            Research
                                            Development)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="ResearchDevelopment_assessment" id="summernote-17">{{ $data1->ResearchDevelopment_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development feedback">Research Development
                                            Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="ResearchDevelopment_feedback" id="summernote-18">{{ $data1->ResearchDevelopment_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development attachment">Research Development
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ResearchDevelopment_attachment">
                                            @if ($data1->ResearchDevelopment_attachment)
                                                @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ResearchDevelopment_attachment[]"
                                                oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development Completed By">Research Development Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->ResearchDevelopment_by }}"
                                        name="ResearchDevelopment_by" id="StorResearchDevelopment_by">


                                </div>
                            </div>
                            <div class="col-lg-6 researchDevelopment">
                                <div class="group-input">
                                    <label for="Research Development Completed On">Research Development Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="ResearchDevelopment_on"
                                        name="ResearchDevelopment_on"
                                        value="{{ $data1->ResearchDevelopment_on }}">
                                </div>
                            </div>
                        @endif
                        <div class="sub-head">
                            Human Resource
                        </div>
                        <script>
                            $(document).ready(function() {

                                @if ($data1->Human_Resource_review !== 'yes')
                                    $('.Human_Resource').hide();

                                    $('[name="Human_Resource_review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.Human_Resource').show();
                                            $('.Human_Resource span').show();
                                        } else {
                                            $('.Human_Resource').hide();
                                            $('.Human_Resource span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Human Resource"> Human Resource Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Human_Resource_review" id="Human_Resource_review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Human_Resource_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Human_Resource_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Human_Resource_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 31,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource notification">Human Resource Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->Human_Resource_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Human_Resource_person" class="Human_Resource_person"
                                        id="Human_Resource_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Human_Resource_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource assessment">Impact Assessment (By Human Resource)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->Human_Resource_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif class="summernote Human_Resource_assessment"
                                        @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) readonly @endif name="Human_Resource_assessment" id="summernote-17">{{ $data1->Human_Resource_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource feedback">Human Resource Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->Human_Resource_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Human_Resource_feedback" @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) readonly @endif
                                        name="Human_Resource_feedback" id="summernote-18" @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Human_Resource_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource attachment">Human Resource Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Human_Resource_attachment">
                                            @if ($data1->Human_Resource_attachment)
                                                @foreach (json_decode($data1->Human_Resource_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Human_Resource_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Human_Resource_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource Completed By">Human Resource Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Human_Resource_by }}"
                                        name="Human_Resource_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Human_Resource_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Human_Resource">
                                <div class="group-input ">
                                    <label for="Human Resource Completed On">Human Resource Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Human_Resource_on"
                                        name="Human_Resource_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Human_Resource_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Human_Resource_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Human_Resource_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Human Resource">Human Resource Required ?</label>
                                    <select name="Human_Resource_review" disabled id="Human_Resource_review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Human_Resource_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Human_Resource_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Human_Resource_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 31,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource notification">Human Resource Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Human_Resource_person" disabled id="Human_Resource_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Human_Resource_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 Human_Resource">
                                    <div class="group-input">
                                        <label for="Human Resource assessment">Impact Assessment (By Human
                                            Resource)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Human_Resource_assessment" id="summernote-17">{{ $data1->Human_Resource_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Human_Resource">
                                    <div class="group-input">
                                        <label for="Human Resource feedback">Human Resource Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Human_Resource_feedback" id="summernote-18">{{ $data1->Human_Resource_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 Human_Resource">
                                    <div class="group-input">
                                        <label for="Human Resource assessment">Impact Assessment (By Human
                                            Resource)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Human_Resource_assessment" id="summernote-17">{{ $data1->Human_Resource_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Human_Resource">
                                    <div class="group-input">
                                        <label for="Human Resource feedback">Human Resource Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Human_Resource_feedback" id="summernote-18">{{ $data1->Human_Resource_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource attachment">Human Resource Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Human_Resource_attachment">
                                            @if ($data1->Human_Resource_attachment)
                                                @foreach (json_decode($data1->Human_Resource_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Human_Resource_attachment[]"
                                                oninput="addMultipleFiles(this, 'Human_Resource_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource Completed By">Human Resource Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Human_Resource_by }}"
                                        name="Human_Resource_by" id="Human_Resource_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Human_Resource">
                                <div class="group-input">
                                    <label for="Human Resource Completed On">Human Resource Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Human_Resource_on"
                                        name="Human_Resource_on" value="{{ $data1->Human_Resource_on }}">
                                </div>
                            </div>
                        @endif



                        <div class="sub-head">
                            Corporate Quality Assurance
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->CorporateQualityAssurance_Review !== 'yes')
                                    $('.CQA').hide();


                                    $('[name="CorporateQualityAssurance_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.CQA').show();
                                            $('.CQA span').show();
                                        } else {
                                            $('.CQA').hide();
                                            $('.CQA span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Corporate Quality Assurance"> Corporate Quality Assurance Required
                                        ?
                                        <span class="text-danger">*</span></label>
                                    <select name="CorporateQualityAssurance_Review"
                                        id="CorporateQualityAssurance_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 58,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 CQA">
                                <div class="group-input">
                                    <label for="RA notification">Corporate Quality Assurance Person <span
                                            id="asteriskRA"
                                            style="display: {{ $data1->CorporateQualityAssurance_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="CorporateQualityAssurance_person"
                                        class="CorporateQualityAssurance_person"
                                        id="CorporateQualityAssurance_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->CorporateQualityAssurance_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 CQA">
                                <div class="group-input">
                                    <label for="RA assessment">Impact Assessment (By Corporate Quality Assurance)
                                        <span id="asteriskRA1"
                                            style="display: {{ $data1->CorporateQualityAssurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->CorporateQualityAssurance_Review == 'yes' && $data->stage == 4) required @endif
                                        class="summernote CorporateQualityAssurance_assessment" @if (
                                            $data->stage == 3 ||
                                                (isset($data1->CorporateQualityAssurance_person) &&
                                                    Auth::user()->id != $data1->CorporateQualityAssurance_person)) readonly @endif
                                        name="CorporateQualityAssurance_assessment" id="summernote-17">{{ $data1->CorporateQualityAssurance_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 CQA">
                                <div class="group-input">
                                    <label for="RA feedback">Corporate Quality Assurance Feedback <span
                                            id="asteriskRA2"
                                            style="display: {{ $data1->CorporateQualityAssurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote CorporateQualityAssurance_feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->CorporateQualityAssurance_person) &&
                                                Auth::user()->id != $data1->CorporateQualityAssurance_person)) readonly @endif
                                        name="CorporateQualityAssurance_feedback" id="summernote-18"
                                        @if ($data1->CorporateQualityAssurance_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->CorporateQualityAssurance_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 CQA">
                                <div class="group-input">
                                    <label for="RA attachment">Corporate Quality Assurance Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="CorporateQualityAssurance_attachment">
                                            @if ($data1->CorporateQualityAssurance_attachment)
                                                @foreach (json_decode($data1->CorporateQualityAssurance_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="CorporateQualityAssurance_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'CorporateQualityAssurance_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 CQA">
                                <div class="group-input">
                                    <label for="Corporate Quality Assurance Completed By">Corporate Quality
                                        Assurance
                                        Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->CorporateQualityAssurance_by }}"
                                        name="CorporateQualityAssurance_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="CorporateQualityAssurance_by">

                                </div>
                            </div>
                            <div class="col-lg-6 CQA">
                                <div class="group-input ">
                                    <label for="Corporate Quality Assurance Completed On">Corporate Quality
                                        Assurance
                                        Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="CorporateQualityAssurance_on"
                                        name="CorporateQualityAssurance_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->CorporateQualityAssurance_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('CorporateQualityAssurance_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('CorporateQualityAssurance_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('CorporateQualityAssurance_assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('CorporateQualityAssurance_feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskRA');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Corporate Quality Assurance">Corporate Quality Assurance Required
                                        ?</label>
                                    <select name="CorporateQualityAssurance_Review"
                                        id="CorporateQualityAssurance_Review" disabled>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->CorporateQualityAssurance_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 58,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 CQA">
                                <div class="group-input">
                                    <label for="RA notification">Corporate Quality Assurance Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="CorporateQualityAssurance_person" disabled
                                        id="CorporateQualityAssurance_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->CorporateQualityAssurance_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="RA assessment">Impact Assessment (By Corporate Quality
                                            Assurance)
                                            <!-- <span
                                                                                                                                                    id="asteriskInvi12" style="display: none"
                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="CorporateQualityAssurance_assessment" id="summernote-17">{{ $data1->CorporateQualityAssurance_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="RA feedback">Corporate Quality Assurance Feedback
                                            <!-- <span
                                                                                                                                                    id="asteriskInvi22" style="display: none"
                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="CorporateQualityAssurance_feedback" id="summernote-18">{{ $data1->CorporateQualityAssurance_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="RA assessment">Impact Assessment (By Corporate Quality
                                            Assurance)
                                            <!-- <span
                                                                                                                                                    id="asteriskInvi12" style="display: none"
                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="CorporateQualityAssurance_assessment" id="summernote-17">{{ $data1->CorporateQualityAssurance_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="RA feedback">Corporate Quality Assurance Feedback
                                            <!-- <span
                                                                                                                                                    id="asteriskInvi22" style="display: none"
                                                                                                                                                    class="text-danger">*</span> -->
                                        </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="CorporateQualityAssurance_feedback" id="summernote-18">{{ $data1->CorporateQualityAssurance_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 CQA">
                                <div class="group-input">
                                    <label for="RA attachment">Corporate Quality Assurance Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="CorporateQualityAssurance_attachment">
                                            @if ($data1->CorporateQualityAssurance_attachment)
                                                @foreach (json_decode($data1->CorporateQualityAssurance_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="CorporateQualityAssurance_attachment[]"
                                                oninput="addMultipleFiles(this, 'CorporateQualityAssurance_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 CQA">
                                <div class="group-input">
                                    <label for="Corporate Quality Assurance Completed By">Corporate Quality
                                        Assurance
                                        Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->CorporateQualityAssurance_by }}"
                                        name="CorporateQualityAssurance_by" id="CorporateQualityAssurance_by">


                                </div>
                            </div>
                            <div class="col-lg-6 CQA">
                                <div class="group-input">
                                    <label for="Corporate Quality Assurance Completed On">Corporate Quality
                                        Assurance
                                        Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date"id="CorporateQualityAssurance_on"
                                        name="CorporateQualityAssurance_on"
                                        value="{{ $data1->CorporateQualityAssurance_on }}">
                                </div>
                            </div>
                        @endif



                        <div class="sub-head">
                            Stores
                        </div>
                        <script>
                            $(document).ready(function() {

                                @if ($data1->Store_Review !== 'yes')
                                    $('.store').hide();

                                    $('[name="Store_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.store').show();
                                            $('.store span').show();
                                        } else {
                                            $('.store').hide();
                                            $('.store span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Store"> Store Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Store_Review" id="Store_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Store_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Store_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Store_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 54,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 store">
                                <div class="group-input">
                                    <label for="Store notification">Store Person <span id="asteriskPT"
                                            style="display: {{ $data1->Store_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Store_person" class="Store_person" id="Store_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Store_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 store">
                                <div class="group-input">
                                    <label for="Store assessment">Impact Assessment (By Store) <span
                                            id="asteriskPT1"
                                            style="display: {{ $data1->Store_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Store_Review == 'yes' && $data->stage == 4) required @endif class="summernote Store_assessment"
                                        @if ($data->stage == 3 || (isset($data1->Store_person) && Auth::user()->id != $data1->Store_person)) readonly @endif name="Store_assessment" id="summernote-17">{{ $data1->Store_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 store">
                                <div class="group-input">
                                    <label for="store feedback">store Feedback <span id="asteriskPT2"
                                            style="display: {{ $data1->Store_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Store_feedback" @if ($data->stage == 3 || (isset($data1->Store_person) && Auth::user()->id != $data1->Store_person)) readonly @endif
                                        name="Store_feedback" id="summernote-18" @if ($data1->Store_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Store_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 store">
                                <div class="group-input">
                                    <label for="Store attachment">Store Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Store_attachment">
                                            @if ($data1->Store_attachment)
                                                @foreach (json_decode($data1->Store_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Store_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Store_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 store">
                                <div class="group-input">
                                    <label for="Store Completed By">Store Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Store_by }}"
                                        name="Store_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Store_by">


                                </div>
                            </div>
                            <div class="col-lg-6 store">
                                <div class="group-input ">
                                    <label for="Store Completed On">Store Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Store_on"
                                        name="Store_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Store_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Store_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Store_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Store">Store Required ?</label>
                                    <select name="Store_Review" disabled id="Store_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Store_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Store_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Store_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 54,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 store">
                                <div class="group-input">
                                    <label for="Store notification">Store Person <span id="asteriskInvi11"
                                            style="display: none" class="text-danger">*</span></label>
                                    <select name="Store_person" disabled id="Store_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Store_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store assessment">Impact Assessment (By Store)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Store_assessment" id="summernote-17">{{ $data1->Store_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store feedback">Store Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Store_feedback" id="summernote-18">{{ $data1->Store_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store assessment">Impact Assessment (By Store)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Store_assessment" id="summernote-17">{{ $data1->Store_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store feedback">Store Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Store_feedback" id="summernote-18">{{ $data1->Store_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 store">
                                <div class="group-input">
                                    <label for="Store attachment">Store Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Store_attachment">
                                            @if ($data1->Store_attachment)
                                                @foreach (json_decode($data1->Store_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Store_attachment[]"
                                                oninput="addMultipleFiles(this, 'Store_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 store">
                                <div class="group-input">
                                    <label for="Store Completed By">Store Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Store_by }}"
                                        name="Store_by" id="Store_by">


                                </div>
                            </div>
                            <div class="col-lg-6 store">
                                <div class="group-input">
                                    <label for="Store Completed On">Store Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Store_on" name="Store_on"
                                        value="{{ $data1->Store_on }}">
                                </div>
                            </div>
                        @endif


                        <div class="sub-head">
                            Engineering
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Engineering_review !== 'yes')
                                    $('.Engineering').hide();

                                    $('[name="Engineering_review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.Engineering').show();
                                            $('.Engineering span').show();
                                        } else {
                                            $('.Engineering').hide();
                                            $('.Engineering span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Engineering"> Engineering Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Engineering_review" id="Engineering_review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Engineering_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Engineering_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Engineering_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 25,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Engineering">
                                <div class="group-input">
                                    <label for="Engineering notification">Engineering Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->Engineering_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Engineering_person" class="Engineering_person"
                                        id="Engineering_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Engineering_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Engineering">
                                <div class="group-input">
                                    <label for="Engineering assessment">Impact Assessment (By Engineering) <span
                                            id="asteriskPT1"
                                            style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif class="summernote Engineering_assessment"
                                        @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) readonly @endif name="Engineering_assessment" id="summernote-17">{{ $data1->Engineering_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Engineering">
                                <div class="group-input">
                                    <label for="Engineering feedback">Engineering Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Engineering_feedback" @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) readonly @endif
                                        name="Engineering_feedback" id="summernote-18" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Engineering_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 Engineering">
                                <div class="group-input">
                                    <label for="Engineering attachment">Engineering Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Engineering_attachment">
                                            @if ($data1->Engineering_attachment)
                                                @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Engineering_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Engineering">
                                <div class="group-input">
                                    <label for="Engineering Completed By">Engineering Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Engineering_by }}"
                                        name="Engineering_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Engineering_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Engineering">
                                <div class="group-input ">
                                    <label for="Engineering Completed On">Engineering Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Engineering_on"
                                        name="Engineering_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Engineering_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Engineering_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Engineering_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Engineering">Engineering Required ?</label>
                                    <select name="Engineering_review" disabled id="Engineering_review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Engineering_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Engineering_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Engineering_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 25,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Engineering">
                                <div class="group-input">
                                    <label for="Engineering notification">Engineering Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Engineering_person" disabled id="Engineering_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Engineering_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 Engineering">
                                    <div class="group-input">
                                        <label for="Engineering assessment">Impact Assessment (By
                                            Engineering)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Engineering_assessment" id="summernote-17">{{ $data1->Engineering_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Engineering">
                                    <div class="group-input">
                                        <label for="Engineering feedback">Engineering Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Engineering_feedback" id="summernote-18">{{ $data1->Engineering_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 Engineering">
                                    <div class="group-input">
                                        <label for="Engineering assessment">Impact Assessment (By
                                            Engineering)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Engineering_assessment" id="summernote-17">{{ $data1->Engineering_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Engineering">
                                    <div class="group-input">
                                        <label for="Engineering feedback">Engineering Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Engineering_feedback" id="summernote-18">{{ $data1->Engineering_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 Engineering">
                                <div class="group-input">
                                    <label for="Engineering attachment">Engineering Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Engineering_attachment">
                                            @if ($data1->Engineering_attachment)
                                                @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Engineering_attachment[]"
                                                oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Engineering">
                                <div class="group-input">
                                    <label for="Engineering Completed By">Engineering Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Engineering_by }}"
                                        name="Engineering_by" id="Engineering_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Engineering">
                                <div class="group-input">
                                    <label for="Engineering Completed On">Engineering Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Engineering_on" name="Engineering_on"
                                        value="{{ $data1->Engineering_on }}">
                                </div>
                            </div>
                        @endif

                        <div class="sub-head">
                            Regulatory Affair
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->RegulatoryAffair_Review !== 'yes')
                                    $('.RegulatoryAffair').hide();

                                    $('[name="RegulatoryAffair_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.RegulatoryAffair').show();
                                            $('.RegulatoryAffair span').show();
                                        } else {
                                            $('.RegulatoryAffair').hide();
                                            $('.RegulatoryAffair span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RegulatoryAffair"> Regulatory Affair Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 57,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair notification">Regulatory Affair Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->RegulatoryAffair_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="RegulatoryAffair_person" class="RegulatoryAffair_person"
                                        id="RegulatoryAffair_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->RegulatoryAffair_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair assessment">Impact Assessment (By Regulatory
                                        Affair)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif class="summernote RegulatoryAffair_assessment"
                                        @if (
                                            $data->stage == 3 ||
                                                (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) readonly @endif name="RegulatoryAffair_assessment" id="summernote-17">{{ $data1->RegulatoryAffair_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair feedback">Regulatory Affair Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote RegulatoryAffair_feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) readonly @endif
                                        name="RegulatoryAffair_feedback" id="summernote-18" @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->RegulatoryAffair_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair attachment">Regulatory Affair
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="RegulatoryAffair_attachment">
                                            @if ($data1->RegulatoryAffair_attachment)
                                                @foreach (json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="RegulatoryAffair_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair Completed By">Regulatory Affair Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->RegulatoryAffair_by }}"
                                        name="RegulatoryAffair_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="RegulatoryAffair_by">
                                </div>
                            </div>
                            <div class="col-lg-6 RegulatoryAffair">
                                <div class="group-input ">
                                    <label for="Regulatory Affair Completed On">Regulatory Affair Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="RegulatoryAffair_on"
                                        name="RegulatoryAffair_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->RegulatoryAffair_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('RegulatoryAffair_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('RegulatoryAffair_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Regulatory Affair">Regulatory Affair Required ?</label>
                                    <select name="RegulatoryAffair_Review" disabled
                                        id="RegulatoryAffair_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->RegulatoryAffair_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 57,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair notification">Regulatory Affair Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="RegulatoryAffair_person" disabled
                                        id="RegulatoryAffair_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->RegulatoryAffair_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair assessment">Impact Assessment (By Regulatory
                                            Affair)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="RegulatoryAffair_assessment" id="summernote-17">{{ $data1->RegulatoryAffair_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair feedback">Regulatory Affair Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="RegulatoryAffair_feedback" id="summernote-18">{{ $data1->RegulatoryAffair_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair assessment">Impact Assessment (By Regulatory
                                            Affair)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="RegulatoryAffair_assessment" id="summernote-17">{{ $data1->RegulatoryAffair_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair feedback">Regulatory Affair Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="RegulatoryAffair_feedback" id="summernote-18">{{ $data1->RegulatoryAffair_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair attachment">Regulatory Affair
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="RegulatoryAffair_attachment">
                                            @if ($data1->RegulatoryAffair_attachment)
                                                @foreach (json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="RegulatoryAffair_attachment[]"
                                                oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair Completed By">Regulatory Affair Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->RegulatoryAffair_by }}"
                                        name="RegulatoryAffair_by" id="RegulatoryAffair_by">


                                </div>
                            </div>
                            <div class="col-lg-6 RegulatoryAffair">
                                <div class="group-input">
                                    <label for="Regulatory Affair Completed On">Regulatory Affair Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="RegulatoryAffair_on"
                                        name="RegulatoryAffair_on" value="{{ $data1->RegulatoryAffair_on }}">
                                </div>
                            </div>
                        @endif






                        <div class="sub-head">
                            Quality Assurance
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Quality_Assurance_Review !== 'yes')

                                    $('.quality_assurance').hide();

                                    $('[name="Quality_Assurance_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {
                                            $('.quality_assurance').show();
                                            $('.quality_assurance span').show();
                                        } else {
                                            $('.quality_assurance').hide();
                                            $('.quality_assurance span').hide();
                                        }
                                    });
                                @endif

                            });
                        </script>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Review Required">Quality Assurance Review Required ?
                                    <span class="text-danger">*</span></label>
                                <select @if ($data->stage == 3) required @endif
                                    name="Quality_Assurance_Review" id="Quality_Assurance_Review"
                                    @if ($data->stage == 4) disabled @endif>
                                    <option value="">-- Select --</option>
                                    <option @if ($data1->Quality_Assurance_Review == 'yes') selected @endif value="yes">
                                        Yes</option>
                                    <option @if ($data1->Quality_Assurance_Review == 'no') selected @endif value="no">
                                        No
                                    </option>
                                    <option @if ($data1->Quality_Assurance_Review == 'na') selected @endif value="na">
                                        NA
                                    </option>
                                </select>
                            </div>
                        </div>
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $data->division_id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('user_id')->toArray();
                            //$users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                        @endphp
                        <div class="col-lg-6 quality_assurance">
                            <div class="group-input">
                                <label for="Quality Assurance Person">Quality Assurance Person <span
                                        id="asteriskQQA"
                                        style="display: {{ $data1->Quality_Assurance_Review == 'yes' ? 'inline' : 'none' }}"
                                        class="text-danger">*</span></label>
                                <select name="QualityAssurance_person" class="QualityAssurance_person"
                                    id="QualityAssurance_person"
                                    @if ($data->stage == 4) disabled @endif>
                                    <option value="">-- Select --</option>
                                    @foreach ($users as $user)
                                        <option
                                            {{ $data1->QualityAssurance_person == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 quality_assurance">
                            <div class="group-input">
                                <label for="Impact Assessment3">Impact Assessment (By Quality Assurance) <span
                                        id="asteriskQQA1"
                                        style="display: {{ $data1->Quality_Assurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                        class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif class="summernote QualityAssurance_assessment"
                                    name="QualityAssurance_assessment" @if ($data->stage == 3 || Auth::user()->id != $data1->QualityAssurance_person) readonly @endif id="summernote-23">{{ $data1->QualityAssurance_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 quality_assurance">
                            <div class="group-input">
                                <label for="Quality Assurance Feedback">Quality Assurance Feedback <span
                                        id="asteriskQQA2"
                                        style="display: {{ $data1->Quality_Assurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                        class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif class="summernote QualityAssurance_feedback"
                                    name="QualityAssurance_feedback" @if ($data->stage == 3 || Auth::user()->id != $data1->QualityAssurance_person) readonly @endif id="summernote-24">{{ $data1->QualityAssurance_feedback }}</textarea>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var selectField = document.getElementById('Quality_Assurance_Review');
                                var inputsToToggle = [];

                                // Add elements with class 'facility-name' to inputsToToggle
                                var facilityNameInputs = document.getElementsByClassName('QualityAssurance_person');
                                for (var i = 0; i < facilityNameInputs.length; i++) {
                                    inputsToToggle.push(facilityNameInputs[i]);
                                }

                                selectField.addEventListener('change', function() {
                                    var isRequired = this.value === 'yes';

                                    inputsToToggle.forEach(function(input) {
                                        input.required = isRequired;
                                    });

                                    // Show or hide the asterisk icon based on the selected value
                                    var asteriskIcon = document.getElementById('asteriskQQA');
                                    asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                });
                            });
                        </script>
                        <div class="col-12 quality_assurance">
                            <div class="group-input">
                                <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list"
                                        id="Quality_Assurance_attachment">
                                        @if ($data1->Quality_Assurance_attachment)
                                            @foreach (json_decode($data1->Quality_Assurance_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><i class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a type="button" class="remove-file"
                                                        data-file-name="{{ $file }}"><i
                                                            class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                            type="file" id="myfile"
                                            name="Quality_Assurance_attachment[]"
                                            oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 quality_assurance">
                            <div class="group-input">
                                <label for="Quality Assurance Review Completed By">Quality Assurance Review
                                    Completed By</label>
                                <input type="text" name="QualityAssurance_by" id="QualityAssurance_by"
                                    value="{{ $data1->QualityAssurance_by }}" disabled>
                            </div>
                        </div>
                        <div class="col-6 mb-3 quality_assurance new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Quality Assurance Review Completed On">Quality Assurance Review
                                    Completed On</label>
                                <div class="calenderauditee">
                                    <input type="text" id="QualityAssurance_on" readonly
                                        placeholder="DD-MMM-YYYY"
                                        value="{{ Helpers::getdateFormat($data1->QualityAssurance_on) }}" />
                                    <input type="date" name="QualityAssurance_on"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                        class="hide-input"
                                        oninput="handleDateInput(this, 'QualityAssurance_on')" />
                                </div>
                                @error('QualityAssurance_on')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="sub-head">
                            Production (Liquid/Ointment)
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->ProductionLiquid_Review !== 'yes')
                                    $('.productionLiquid').hide();

                                    $('[name="ProductionLiquid_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.productionLiquid').show();
                                            $('.productionLiquid span').show();
                                        } else {
                                            $('.productionLiquid').hide();
                                            $('.productionLiquid span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Liquid"> Production Liquid Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="ProductionLiquid_Review" id="ProductionLiquid_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 52,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid notification">Production Liquid Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->ProductionLiquid_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="ProductionLiquid_person" class="ProductionLiquid_person"
                                        id="ProductionLiquid_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ProductionLiquid_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid assessment">Impact Assessment (By Production
                                        Liquid)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->ProductionLiquid_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->ProductionLiquid_Review == 'yes' && $data->stage == 4) required @endif class="summernote ProductionLiquid_assessment"
                                        @if (
                                            $data->stage == 3 ||
                                                (isset($data1->ProductionLiquid_person) && Auth::user()->id != $data1->ProductionLiquid_person)) readonly @endif name="ProductionLiquid_assessment" id="summernote-17">{{ $data1->ProductionLiquid_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid feedback">Production Liquid Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->ProductionLiquid_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote ProductionLiquid_feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->ProductionLiquid_person) && Auth::user()->id != $data1->ProductionLiquid_person)) readonly @endif
                                        name="ProductionLiquid_feedback" id="summernote-18" @if ($data1->ProductionLiquid_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->ProductionLiquid_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid attachment">Production Liquid
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ProductionLiquid_attachment">
                                            @if ($data1->ProductionLiquid_attachment)
                                                @foreach (json_decode($data1->ProductionLiquid_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ProductionLiquid_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'ProductionLiquid_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid Completed By">Production Liquid Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->ProductionLiquid_by }}"
                                        name="ProductionLiquid_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="ProductionLiquid_by">


                                </div>
                            </div>
                            <div class="col-lg-6 productionLiquid">
                                <div class="group-input ">
                                    <label for="Production Liquid Completed On">Production Liquid Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="ProductionLiquid_on"
                                        name="ProductionLiquid_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->ProductionLiquid_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('ProductionLiquid_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('ProductionLiquid_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Liquid">Production Liquid Required ?</label>
                                    <select name="ProductionLiquid_Review" disabled
                                        id="ProductionLiquid_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ProductionLiquid_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 52,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid notification">Production Liquid Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="ProductionLiquid_person" disabled
                                        id="ProductionLiquid_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ProductionLiquid_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid assessment">Impact Assessment (By Production
                                            Liquid)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ProductionLiquid_assessment" id="summernote-17">{{ $data1->ProductionLiquid_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid feedback">Production Liquid Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ProductionLiquid_feedback" id="summernote-18">{{ $data1->ProductionLiquid_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid assessment">Impact Assessment (By Production
                                            Liquid)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not
require completion</small></div>
                                        <textarea disabled class="tiny" name="ProductionLiquid_assessment" id="summernote-17">{{ $data1->ProductionLiquid_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid feedback">Production Liquid Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="ProductionLiquid_feedback" id="summernote-18">{{ $data1->ProductionLiquid_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid attachment">Production Liquid
                                        Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ProductionLiquid_attachment">
                                            @if ($data1->ProductionLiquid_attachment)
                                                @foreach (json_decode($data1->ProductionLiquid_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ProductionLiquid_attachment[]"
                                                oninput="addMultipleFiles(this, 'ProductionLiquid_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid Completed By">Production Liquid Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->ProductionLiquid_by }}"
                                        name="ProductionLiquid_by" id="ProductionLiquid_by">


                                </div>
                            </div>
                            <div class="col-lg-6 productionLiquid">
                                <div class="group-input">
                                    <label for="Production Liquid Completed On">Production Liquid Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="ProductionLiquid_on"
                                        name="ProductionLiquid_on" value="{{ $data1->ProductionLiquid_on }}">
                                </div>
                            </div>
                        @endif

                        <div class="sub-head">
                            Quality Control
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Quality_review !== 'yes')
                                    $('.qualityControl').hide();

                                    $('[name="Quality_review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.qualityControl').show();
                                            $('.qualityControl span').show();
                                        } else {
                                            $('.qualityControl').hide();
                                            $('.qualityControl span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Quality Control"> Quality Control Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Quality_review" id="Quality_review_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Quality_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Quality_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Quality_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 24,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control notification">Quality Control Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->Quality_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Quality_Control_Person" class="Quality_Control_Person"
                                        id="Quality_Control_Person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Quality_Control_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control assessment">Impact Assessment (By Quality Control)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif class="summernote Quality_Control_assessment"
                                        @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) readonly @endif name="Quality_Control_assessment" id="summernote-17">{{ $data1->Quality_Control_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control feedback">Quality Control Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                            does not require completion</small></div>
                                    <textarea class="summernote Quality_Control_feedback" @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) readonly @endif
                                        name="Quality_Control_feedback" id="summernote-18" @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Quality_Control_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control attachment">Quality Control Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Quality_Control_attachment">
                                            @if ($data1->Quality_Control_attachment)
                                                @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Quality_Control_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control Completed By">Quality Control Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Quality_Control_by }}"
                                        name="Quality_Control_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Quality_Control_by">


                                </div>
                            </div>
                            <div class="col-lg-6 qualityControl">
                                <div class="group-input ">
                                    <label for="Quality Control Completed On">Quality Control Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Quality_Control_on"
                                        name="Quality_Control_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Quality_Control_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Quality_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Quality_Control_Person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Quality Control">Quality Control Required ?</label>
                                    <select name="Quality_review" disabled id="Quality_review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Quality_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Quality_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Quality_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 24,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control notification">Quality Control Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Quality_Control_Person" disabled id="Quality_Control_Person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Quality_Control_Person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 qualityControl">
                                    <div class="group-input">
                                        <label for="Quality Control assessment">Impact Assessment (By Quality
                                            Control)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Quality_Control_assessment" id="summernote-17">{{ $data1->Quality_Control_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 qualityControl">
                                    <div class="group-input">
                                        <label for="Quality Control feedback">Quality Control Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Quality_Control_feedback" id="summernote-18">{{ $data1->Quality_Control_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 qualityControl">
                                    <div class="group-input">
                                        <label for="Quality Control assessment">Impact Assessment (By Quality
                                            Control)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Quality_Control_assessment" id="summernote-17">{{ $data1->Quality_Control_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 qualityControl">
                                    <div class="group-input">
                                        <label for="Quality Control feedback">Quality Control Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Quality_Control_feedback" id="summernote-18">{{ $data1->Quality_Control_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control attachment">Quality Control Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Quality_Control_attachment">
                                            @if ($data1->Quality_Control_attachment)
                                                @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Store_attachment[]"
                                                oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control Completed By">Quality Control Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Quality_Control_by }}"
                                        name="Quality_Control_by" id="Quality_Control_by">


                                </div>
                            </div>
                            <div class="col-lg-6 qualityControl">
                                <div class="group-input">
                                    <label for="Quality Control Completed On">Quality Control Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Quality_Control_on"
                                        name="Quality_Control_on" value="{{ $data1->Quality_Control_on }}">
                                </div>
                            </div>
                        @endif

                        <div class="sub-head">
                            Microbiology
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('.Microbiology').hide();
                                @if ($data1->Microbiology_Review !== 'yes')

                                    $('[name="Microbiology_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.Microbiology').show();
                                            $('.Microbiology span').show();
                                        } else {
                                            $('.Microbiology').hide();
                                            $('.Microbiology span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Microbiology"> Microbiology Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Microbiology_Review" id="Microbiology_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Microbiology_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Microbiology_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Microbiology_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 56,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology notification">Microbiology Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->Microbiology_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Microbiology_person" class="Microbiology_person"
                                        id="Microbiology_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Microbiology_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology assessment">Impact Assessment (By Microbiology)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->Microbiology_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif class="summernote Microbiology_assessment"
                                        @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) readonly @endif name="Microbiology_assessment" id="summernote-17">{{ $data1->Microbiology_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology feedback">Microbiology Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->Microbiology_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea class="summernote Microbiology_feedback" @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) readonly @endif
                                        name="Microbiology_feedback" id="summernote-18" @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Microbiology_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Microbiology_attachment">
                                            @if ($data1->Microbiology_attachment)
                                                @foreach (json_decode($data1->Microbiology_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Microbiology_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Microbiology_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology Completed By">Microbiology Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Microbiology_by }}"
                                        name="Microbiology_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Microbiology_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Microbiology">
                                <div class="group-input ">
                                    <label for="Microbiology Completed On">Microbiology Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Microbiology_on"
                                        name="Microbiology_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Microbiology_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Microbiology_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Microbiology_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Microbiology">Microbiology Required ?</label>
                                    <select name="Microbiology_Review" disabled id="Microbiology_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Microbiology_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Microbiology_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Microbiology_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 56,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology notification">Microbiology Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="Microbiology_person" disabled id="Microbiology_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Microbiology_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology assessment">Impact Assessment (By
                                            Microbiology)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Microbiology_assessment" id="summernote-17">{{ $data1->Microbiology_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology feedback">Microbiology Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Microbiology_feedback" id="summernote-18">{{ $data1->Microbiology_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology assessment">Impact Assessment (By
                                            Microbiology)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Microbiology_assessment" id="summernote-17">{{ $data1->Microbiology_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology feedback">Microbiology Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Microbiology_feedback" id="summernote-18">{{ $data1->Microbiology_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Microbiology_attachment">
                                            @if ($data1->Microbiology_attachment)
                                                @foreach (json_decode($data1->Microbiology_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Microbiology_attachment[]"
                                                oninput="addMultipleFiles(this, 'Microbiology_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology Completed By">Microbiology Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->Microbiology_by }}"
                                        name="Microbiology_by" id="Microbiology_by">


                                </div>
                            </div>
                            <div class="col-lg-6 Microbiology">
                                <div class="group-input">
                                    <label for="Microbiology Completed On">Microbiology Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Microbiology_on" name="Microbiology_on"
                                        value="{{ $data1->Microbiology_on }}">
                                </div>
                            </div>
                        @endif


                        <div class="sub-head">
                            Safety
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->Environment_Health_review !== 'yes')
                                    $('.safety').hide();

                                    $('[name="Environment_Health_review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.safety').show();
                                            $('.safety span').show();
                                        } else {
                                            $('.safety').hide();
                                            $('.safety span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Safety"> Safety Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="Environment_Health_review" id="Environment_Health_review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Environment_Health_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Environment_Health_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Environment_Health_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 59,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 safety">
                                <div class="group-input">
                                    <label for="Safety notification">Safety Person <span id="asteriskPT"
                                            style="display: {{ $data1->Environment_Health_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="Environment_Health_Safety_person"
                                        class="Environment_Health_Safety_person"
                                        id="Environment_Health_Safety_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Environment_Health_Safety_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 safety">
                                <div class="group-input">
                                    <label for="Safety assessment">Impact Assessment (By Safety) <span
                                            id="asteriskPT1"
                                            style="display: {{ $data1->Environment_Health_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->Environment_Health_review == 'yes' && $data->stage == 4) required @endif class="summernote Health_Safety_assessment"
                                        @if (
                                            $data->stage == 3 ||
                                                (isset($data1->Environment_Health_Safety_person) &&
                                                    Auth::user()->id != $data1->Environment_Health_Safety_person)) readonly @endif name="Health_Safety_assessment" id="summernote-17">{{ $data1->Health_Safety_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 safety">
                                <div class="group-input">
                                    <label for="Safety feedback">Safety Feedback <span id="asteriskPT2"
                                            style="display: {{ $data1->Environment_Health_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea class="summernote Health_Safety_feedback" @if (
                                        $data->stage == 3 ||
                                            (isset($data1->Environment_Health_Safety_person) &&
                                                Auth::user()->id != $data1->Environment_Health_Safety_person)) readonly @endif
                                        name="Health_Safety_feedback" id="summernote-18" @if ($data1->Environment_Health_review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Health_Safety_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 safety">
                                <div class="group-input">
                                    <label for="Safety attachment">Safety Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Environment_Health_Safety_attachment">
                                            @if ($data1->Environment_Health_Safety_attachment)
                                                @foreach (json_decode($data1->Environment_Health_Safety_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Environment_Health_Safety_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 safety">
                                <div class="group-input">
                                    <label for="Safety Completed By">Safety Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->Environment_Health_Safety_by }}"
                                        name="Environment_Health_Safety_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="Environment_Health_Safety_by">


                                </div>
                            </div>
                            <div class="col-lg-6 safety">
                                <div class="group-input ">
                                    <label for="Safety Completed On">Safety Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="Environment_Health_Safety_on"
                                        name="Environment_Health_Safety_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->Environment_Health_Safety_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Environment_Health_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Environment_Health_Safety_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Safety">Safety Required ?</label>
                                    <select name="Environment_Health_review" disabled
                                        id="Environment_Health_review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Environment_Health_review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->Environment_Health_review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->Environment_Health_review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 59,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 safety">
                                <div class="group-input">
                                    <label for="Safety notification">Safety Person <span id="asteriskInvi11"
                                            style="display: none" class="text-danger">*</span></label>
                                    <select name="Environment_Health_Safety_person" disabled
                                        id="Environment_Health_Safety_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->Environment_Health_Safety_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 safety">
                                    <div class="group-input">
                                        <label for="Safety assessment">Impact Assessment (By Safety)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Health_Safety_assessment" id="summernote-17">{{ $data1->Health_Safety_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 safety">
                                    <div class="group-input">
                                        <label for="Safety feedback">Safety Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="Health_Safety_feedback" id="summernote-18">{{ $data1->Health_Safety_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 safety">
                                    <div class="group-input">
                                        <label for="Safety assessment">Impact Assessment (By Safety)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Health_Safety_assessment" id="summernote-17">{{ $data1->Health_Safety_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 safety">
                                    <div class="group-input">
                                        <label for="Safety feedback">Safety Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="Health_Safety_feedback" id="summernote-18">{{ $data1->Health_Safety_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 safety">
                                <div class="group-input">
                                    <label for="Safety attachment">Safety Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="Environment_Health_Safety_attachment">
                                            @if ($data1->Environment_Health_Safety_attachment)
                                                @foreach (json_decode($data1->Environment_Health_Safety_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="Environment_Health_Safety_attachment[]"
                                                oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 safety">
                                <div class="group-input">
                                    <label for="Safety Completed By">Safety Completed
                                        By</label>
                                    <input readonly type="text"
                                        value="{{ $data1->Environment_Health_Safety_by }}"
                                        name="Environment_Health_Safety_by" id="Environment_Health_Safety_by">


                                </div>
                            </div>
                            <div class="col-lg-6 safety">
                                <div class="group-input">
                                    <label for="Safety Completed On">Safety Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="Environment_Health_Safety_on"
                                        name="Environment_Health_Safety_on"
                                        value="{{ $data1->Environment_Health_Safety_on }}">
                                </div>
                            </div>
                        @endif


                        <div class="sub-head">
                            Contract Giver
                        </div>
                        <script>
                            $(document).ready(function() {
                                @if ($data1->ContractGiver_Review !== 'yes')
                                    $('.ContractGiver').hide();

                                    $('[name="ContractGiver_Review"]').change(function() {
                                        if ($(this).val() === 'yes') {

                                            $('.ContractGiver').show();
                                            $('.ContractGiver span').show();
                                        } else {
                                            $('.ContractGiver').hide();
                                            $('.ContractGiver span').hide();
                                        }
                                    });
                                @endif
                            });
                        </script>
                        @php
                            $data1 = DB::table('market_complaint_cfts')
                                ->where('mc_id', $data->id)
                                ->first();
                        @endphp

                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Contract Giver"> Contract Giver Required ? <span
                                            class="text-danger">*</span></label>
                                    <select name="ContractGiver_Review" id="ContractGiver_Review"
                                        @if ($data->stage == 4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ContractGiver_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ContractGiver_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ContractGiver_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 60,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 store">
                                <div class="group-input">
                                    <label for="Contract Giver notification">Contract Giver Person <span
                                            id="asteriskPT"
                                            style="display: {{ $data1->ContractGiver_Review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage == 4) disabled @endif
                                        name="ContractGiver_person" class="ContractGiver_person"
                                        id="ContractGiver_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ContractGiver_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 store">
                                <div class="group-input">
                                    <label for="Contract Giver assessment">Impact Assessment (By Contract
                                        Giver)
                                        <span id="asteriskPT1"
                                            style="display: {{ $data1->ContractGiver_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea @if ($data1->ContractGiver_Review == 'yes' && $data->stage == 4) required @endif class="summernote ContractGiver_assessment"
                                        @if ($data->stage == 3 || (isset($data1->ContractGiver_person) && Auth::user()->id != $data1->ContractGiver_person)) readonly @endif name="ContractGiver_assessment" id="summernote-17">{{ $data1->ContractGiver_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 store">
                                <div class="group-input">
                                    <label for="Contract Giver feedback">Contract Giver Feedback <span
                                            id="asteriskPT2"
                                            style="display: {{ $data1->ContractGiver_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if
                                            it
                                            does not require completion</small></div>
                                    <textarea class="summernote ContractGiver_feedback" @if ($data->stage == 3 || (isset($data1->ContractGiver_person) && Auth::user()->id != $data1->ContractGiver_person)) readonly @endif
                                        name="ContractGiver_feedback" id="summernote-18" @if ($data1->ContractGiver_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->ContractGiver_feedback }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-12 store">
                                <div class="group-input">
                                    <label for="Contract Giver attachment">Contract Giver Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ContractGiver_attachment">
                                            @if ($data1->ContractGiver_attachment)
                                                @foreach (json_decode($data1->ContractGiver_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ContractGiver_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'ContractGiver_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 store">
                                <div class="group-input">
                                    <label for="Contract Giver Completed By">Contract Giver Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->ContractGiver_by }}"
                                        name="ContractGiver_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }}
                                        id="ContractGiver_by">


                                </div>
                            </div>
                            <div class="col-lg-6 store">
                                <div class="group-input ">
                                    <label for="Contract Giver Completed On">Contract Giver Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="ContractGiver_on"
                                        name="ContractGiver_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        value="{{ $data1->ContractGiver_on }}">
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('ContractGiver_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('ContractGiver_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_Injection_Feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskPT');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                        @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Contract Giver">Contract Giver Required ?</label>
                                    <select name="ContractGiver_Review" disabled id="ContractGiver_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->ContractGiver_Review == 'yes') selected @endif
                                            value='yes'>
                                            Yes</option>
                                        <option @if ($data1->ContractGiver_Review == 'no') selected @endif
                                            value='no'>
                                            No</option>
                                        <option @if ($data1->ContractGiver_Review == 'na') selected @endif
                                            value='na'>
                                            NA</option>
                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where([
                                        'q_m_s_roles_id' => 60,
                                        'q_m_s_divisions_id' => $data->division_id,
                                    ])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 ContractGiver">
                                <div class="group-input">
                                    <label for="Contract Giver notification">Contract Giver Person <span
                                            id="asteriskInvi11" style="display: none"
                                            class="text-danger">*</span></label>
                                    <select name="ContractGiver_person" disabled id="ContractGiver_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $data1->ContractGiver_person) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($data->stage == 4)
                                <div class="col-md-12 mb-3 ContractGiver">
                                    <div class="group-input">
                                        <label for="Contract Giver assessment">Impact Assessment (By Contract
                                            Giver)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ContractGiver_assessment" id="summernote-17">{{ $data1->ContractGiver_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 ContractGiver">
                                    <div class="group-input">
                                        <label for="Contract Giver feedback">Contract Giver Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea class="tiny" name="ContractGiver_feedback" id="summernote-18">{{ $data1->ContractGiver_feedback }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 mb-3 ContractGiver">
                                    <div class="group-input">
                                        <label for="Contract Giver assessment">Impact Assessment (By Contract
                                            Giver)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="ContractGiver_assessment" id="summernote-17">{{ $data1->ContractGiver_assessment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 ContractGiver">
                                    <div class="group-input">
                                        <label for="Contract Giver feedback">Contract Giver Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field
                                                if
                                                it
                                                does not require completion</small></div>
                                        <textarea disabled class="tiny" name="ContractGiver_feedback" id="summernote-18">{{ $data1->ContractGiver_feedback }}</textarea>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="col-12 ContractGiver">
                                <div class="group-input">
                                    <label for="Contract Giver attachment">Contract Giver Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list"
                                            id="ContractGiver_attachment">
                                            @if ($data1->ContractGiver_attachment)
                                                @foreach (json_decode($data1->ContractGiver_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile"
                                                name="ContractGiver_attachment[]"
                                                oninput="addMultipleFiles(this, 'ContractGiver_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6 mb-3 ContractGiver">
                                <div class="group-input">
                                    <label for="Contract Giver Completed By">Contract Giver Completed
                                        By</label>
                                    <input readonly type="text" value="{{ $data1->ContractGiver_by }}"
                                        name="ContractGiver_by" id="ContractGiver_by">
                                </div>
                            </div>
                            <div class="col-lg-6 ContractGiver">
                                <div class="group-input">
                                    <label for="Contract Giver Completed On">Contract Giver Completed
                                        On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date" id="ContractGiver_on"
                                        name="ContractGiver_on" value="{{ $data1->ContractGiver_on }}">
                                </div>
                            </div>
                        @endif



                        @if ($data->stage == 3 || $data->stage == 4)
                            <div class="sub-head">
                                Other's 1 ( Additional Person Review From Departments If Required)
                            </div>
                            <script>
                                $(document).ready(function() {
                                    @if ($data1->Other1_review !== 'yes')
                                        $('.other1_reviews').hide();

                                        $('[name="Other1_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.other1_reviews').show();
                                                $('.other1_reviews span').show();
                                            } else {
                                                $('.other1_reviews').hide();
                                                $('.other1_reviews span').hide();
                                            }
                                        });
                                    @endif
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Required1"> Other's 1 Review Required? </label>
                                    <select name="Other1_review"
                                        @if ($data->stage == 4) disabled @endif id="Other1_review"
                                        value="{{ $data1->Other1_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other1_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other1_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other1_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 other1_reviews ">
                                <div class="group-input">
                                    <label for="Person1"> Other's 1 Person <span id="asterisko1"
                                            style="display: {{ $data1->Other1_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other1_person"
                                        @if ($data->stage == 4) disabled @endif id="Other1_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other1_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12 other1_reviews ">

                                <div class="group-input">
                                    <label for="Department1"> Other's 1 Department <span id="asteriskod1"
                                            style="display: {{ $data1->Other1_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other1_Department_person"
                                        @if ($data->stage == 4) disabled @endif
                                        id="Other1_Department_person"
                                        value="{{ $data1->Other1_Department_person }}">
                                        <option value="CQA"
                                            @if ($data1->Other1_Department_person == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QA"
                                            @if ($data1->Other1_Department_person == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QC"
                                            @if ($data1->Other1_Department_person == 'QC') selected @endif>Quality
                                            Control</option>
                                        <option value="QM"
                                            @if ($data1->Other1_Department_person == 'QM') selected @endif>Quality
                                            Control (Microbiology department)
                                        </option>
                                        <option value="PG"
                                            @if ($data1->Other1_Department_person == 'PG') selected @endif>Production
                                            General</option>
                                        <option value="PL"
                                            @if ($data1->Other1_Department_person == 'PL') selected @endif>Production
                                            Liquid Orals</option>
                                        <option value="PT"
                                            @if ($data1->Other1_Department_person == 'PT') selected @endif>Production
                                            Tablet and Powder</option>
                                        <option value="PE"
                                            @if ($data1->Other1_Department_person == 'PE') selected @endif>Production
                                            External (Ointment, Gels, Creams and
                                            Liquid)</option>
                                        <option value="PC"
                                            @if ($data1->Other1_Department_person == 'PC') selected @endif>Production
                                            Capsules</option>
                                        <option value="PI"
                                            @if ($data1->Other1_Department_person == 'PI') selected @endif>Production
                                            Injectable</option>
                                        <option value="EN"
                                            @if ($data1->Other1_Department_person == 'EN') selected @endif>Engineering
                                        </option>
                                        <option value="HR"
                                            @if ($data1->Other1_Department_person == 'HR') selected @endif>Human
                                            Resource</option>
                                        <option value="ST"
                                            @if ($data1->Other1_Department_person == 'ST') selected @endif>Store
                                        </option>
                                        <option value="IT"
                                            @if ($data1->Other1_Department_person == 'IT') selected @endif>Electronic
                                            Data Processing
                                        </option>
                                        <option value="FD"
                                            @if ($data1->Other1_Department_person == 'FD') selected @endif>Formulation
                                            Development
                                        </option>
                                        <option value="AL"
                                            @if ($data1->Other1_Department_person == 'AL') selected @endif>Analytical
                                            research and Development
                                            Laboratory
                                        </option>
                                        <option value="PD"
                                            @if ($data1->Other1_Department_person == 'PD') selected @endif>Packaging
                                            Development
                                        </option>
                                        <option value="PU"
                                            @if ($data1->Other1_Department_person == 'PU') selected @endif>Purchase
                                            Department
                                        </option>
                                        <option value="DC"
                                            @if ($data1->Other1_Department_person == 'DC') selected @endif>Document Cell
                                        </option>
                                        <option value="RA"
                                            @if ($data1->Other1_Department_person == 'RA') selected @endif>Regulatory
                                            Affairs
                                        </option>
                                        <option value="PV"
                                            @if ($data1->Other1_Department_person == 'PV') selected @endif>
                                            Pharmacovigilance
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3 other1_reviews ">
                                <div class="group-input">
                                    <label for="Impact Assessment12">Impact Assessment (By Other's 1)
                                    </label>
                                    <textarea @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif class="tiny" name="Other1_assessment"
                                        @if ($data->stage == 3 || Auth::user()->id != $data1->Other1_person) readonly @endif id="summernote-41">{{ $data1->Other1_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 other1_reviews ">
                                <div class="group-input">
                                    <label for="Feedback1"> Other's 1 Feedback
                                    </label>
                                    <textarea @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif class="tiny" name="Other1_feedback"
                                        @if ($data->stage == 3 || Auth::user()->id != $data1->Other1_person) readonly @endif id="summernote-42">{{ $data1->Other1_feedback }}</textarea>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Other1_review');
                                    var inputsToToggle = [];

                                    var facilityNameInputs = document.getElementsByClassName('Other1_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    var facilityNameInputs = document.getElementsByClassName('Other1_Department_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                        });

                                        var asteriskIcon = document.getElementById('asterisko1');
                                        var asteriskIcon1 = document.getElementById('asteriskod1');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                            <div class="col-12 other1_reviews ">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other1_attachment">
                                            @if ($data1->Other1_attachment)
                                                @foreach (json_decode($data1->Other1_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other1_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other1_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 other1_reviews ">
                                <div class="group-input">
                                    <label for="Review Completed By1"> Other's 1 Review Completed By</label>
                                    <input disabled type="text" value="{{ $data1->Other1_by }}"
                                        name="Other1_by" id="Other1_by">

                                </div>
                            </div>
                            <div class="col-md-6 mb-3 other1_reviews ">
                                <div class="group-input">
                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                    <input disabled type="date" name="Other1_on" id="Other1_on"
                                        value="{{ $data1->Other1_on }}">

                                </div>
                            </div>
                            <div class="sub-head">
                                Other's 2 ( Additional Person Review From Departments If Required)
                            </div>
                            <script>
                                $(document).ready(function() {
                                    @if ($data1->Other2_review !== 'yes')
                                        $('.Other2_reviews').hide();

                                        $('[name="Other2_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other2_reviews').show();
                                                $('.Other2_reviews span').show();
                                            } else {
                                                $('.Other2_reviews').hide();
                                                $('.Other2_reviews span').hide();
                                            }
                                        });
                                    @endif
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review2"> Other's 2 Review Required ?</label>
                                    <select name="Other2_review"
                                        @if ($data->stage == 4) disabled @endif id="Other2_review"
                                        value="{{ $data1->Other2_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other2_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other2_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other2_review == 'na') selected @endif
                                            value="na">
                                            NA</option>
                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Other2_reviews">
                                <div class="group-input">
                                    <label for="Person2"> Other's 2 Person <span id="asterisko2"
                                            style="display: {{ $data1->Other2_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other2_person"
                                        @if ($data->stage == 4) disabled @endif id="Other2_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other2_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12 Other2_reviews">
                                <div class="group-input">
                                    <label for="Department2"> Other's 2 Department <span id="asteriskod2"
                                            style="display: {{ $data1->Other2_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other2_Department_person"
                                        @if ($data->stage == 4) disabled @endif
                                        id="Other2_Department_person">
                                        <option value="">-- Select --</option>
                                        <option value="CQA"
                                            @if ($data1->Other2_Department_person == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QA"
                                            @if ($data1->Other2_Department_person == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QC"
                                            @if ($data1->Other2_Department_person == 'QC') selected @endif>Quality
                                            Control</option>
                                        <option value="QM"
                                            @if ($data1->Other2_Department_person == 'QM') selected @endif>Quality
                                            Control (Microbiology department)
                                        </option>
                                        <option value="PG"
                                            @if ($data1->Other2_Department_person == 'PG') selected @endif>Production
                                            General</option>
                                        <option value="PL"
                                            @if ($data1->Other2_Department_person == 'PL') selected @endif>Production
                                            Liquid Orals</option>
                                        <option value="PT"
                                            @if ($data1->Other2_Department_person == 'PT') selected @endif>Production
                                            Tablet and Powder</option>
                                        <option value="PE"
                                            @if ($data1->Other2_Department_person == 'PE') selected @endif>Production
                                            External (Ointment, Gels, Creams and
                                            Liquid)</option>
                                        <option value="PC"
                                            @if ($data1->Other2_Department_person == 'PC') selected @endif>Production
                                            Capsules</option>
                                        <option value="PI"
                                            @if ($data1->Other2_Department_person == 'PI') selected @endif>Production
                                            Injectable</option>
                                        <option value="EN"
                                            @if ($data1->Other2_Department_person == 'EN') selected @endif>Engineering
                                        </option>
                                        <option value="HR"
                                            @if ($data1->Other2_Department_person == 'HR') selected @endif>Human
                                            Resource</option>
                                        <option value="ST"
                                            @if ($data1->Other2_Department_person == 'ST') selected @endif>Store
                                        </option>
                                        <option value="IT"
                                            @if ($data1->Other2_Department_person == 'IT') selected @endif>Electronic
                                            Data Processing
                                        </option>
                                        <option value="FD"
                                            @if ($data1->Other2_Department_person == 'FD') selected @endif>Formulation
                                            Development
                                        </option>
                                        <option value="AL"
                                            @if ($data1->Other2_Department_person == 'AL') selected @endif>Analytical
                                            research and Development
                                            Laboratory
                                        </option>
                                        <option value="PD"
                                            @if ($data1->Other2_Department_person == 'PD') selected @endif>Packaging
                                            Development
                                        </option>
                                        <option value="PU"
                                            @if ($data1->Other2_Department_person == 'PU') selected @endif>Purchase
                                            Department
                                        </option>
                                        <option value="DC"
                                            @if ($data1->Other2_Department_person == 'DC') selected @endif>Document Cell
                                        </option>
                                        <option value="RA"
                                            @if ($data1->Other2_Department_person == 'RA') selected @endif>Regulatory
                                            Affairs
                                        </option>
                                        <option value="PV"
                                            @if ($data1->Other2_Department_person == 'PV') selected @endif>
                                            Pharmacovigilance
                                        </option>


                                    </select>

                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Other2_review');
                                    var inputsToToggle = [];

                                    var facilityNameInputs = document.getElementsByClassName('Other2_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    var facilityNameInputs = document.getElementsByClassName('Other2_Department_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                        });

                                        var asteriskIcon = document.getElementById('asterisko2');
                                        var asteriskIcon1 = document.getElementById('asteriskod2');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                            <div class="col-md-12 mb-3 Other2_reviews">
                                <div class="group-input">
                                    <label for="Impact Assessment13">Impact Assessment (By Other's 2)
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other2_person) readonly @endif class="tiny" name="Other2_Assessment"
                                        @if ($data1->Other2_review == 'yes' && $data->stage == 4) required @endif id="summernote-43">{{ $data1->Other2_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Other2_reviews">
                                <div class="group-input">
                                    <label for="Feedback2"> Other's 2 Feedback
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other2_person) readonly @endif class="tiny" name="Other2_feedback"
                                        @if ($data1->Other2_review == 'yes' && $data->stage == 4) required @endif id="summernote-44">{{ $data1->Other2_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 Other2_reviews">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 2 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other2_attachment">
                                            @if ($data1->Other2_attachment)
                                                @foreach (json_decode($data1->Other2_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other2_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other2_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other2_reviews">
                                <div class="group-input">
                                    <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                    <input type="text" name="Other2_by" id="Other2_by"
                                        value="{{ $data1->Other2_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other2_reviews">
                                <div class="group-input">
                                    <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                    <input disabled type="date" name="Other2_on" id="Other2_on"
                                        value="{{ $data1->Other2_on }}">
                                </div>
                            </div>

                            <div class="sub-head">
                                Other's 3 ( Additional Person Review From Departments If Required)
                            </div>
                            <script>
                                $(document).ready(function() {
                                    @if ($data1->Other3_review !== 'yes')
                                        $('.Other3_reviews').hide();

                                        $('[name="Other3_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other3_reviews').show();
                                                $('.Other3_reviews span').show();
                                            } else {
                                                $('.Other3_reviews').hide();
                                                $('.Other3_reviews span').hide();
                                            }
                                        });
                                    @endif
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review3"> Other's 3 Review Required ?</label>
                                    <select name="Other3_review"
                                        @if ($data->stage == 4) disabled @endif id="Other3_review"
                                        value="{{ $data1->Other3_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other3_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other3_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other3_review == 'na') selected @endif
                                            value="na">
                                            NA</option>
                                    </select>

                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Other3_reviews">
                                <div class="group-input">
                                    <label for="Person3">Other's 3 Person <span id="asterisko3"
                                            style="display: {{ $data1->Other3_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other3_person"
                                        @if ($data->stage == 4) disabled @endif id="Other3_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other3_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12 Other3_reviews">
                                <div class="group-input">
                                    <label for="Department3">Other's 3 Department <span id="asteriskod3"
                                            style="display: {{ $data1->Other3_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other3_Department_person"
                                        @if ($data->stage == 4) disabled @endif
                                        id="Other3_Department_person">
                                        <option value="">-- Select --</option>
                                        <option value="CQA"
                                            @if ($data1->Other3_Department_person == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QA"
                                            @if ($data1->Other3_Department_person == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QC"
                                            @if ($data1->Other3_Department_person == 'QC') selected @endif>Quality
                                            Control</option>
                                        <option value="QM"
                                            @if ($data1->Other3_Department_person == 'QM') selected @endif>Quality
                                            Control (Microbiology department)
                                        </option>
                                        <option value="PG"
                                            @if ($data1->Other3_Department_person == 'PG') selected @endif>Production
                                            General</option>
                                        <option value="PL"
                                            @if ($data1->Other3_Department_person == 'PL') selected @endif>Production
                                            Liquid Orals</option>
                                        <option value="PT"
                                            @if ($data1->Other3_Department_person == 'PT') selected @endif>Production
                                            Tablet and Powder</option>
                                        <option value="PE"
                                            @if ($data1->Other3_Department_person == 'PE') selected @endif>Production
                                            External (Ointment, Gels, Creams and
                                            Liquid)</option>
                                        <option value="PC"
                                            @if ($data1->Other3_Department_person == 'PC') selected @endif>Production
                                            Capsules</option>
                                        <option value="PI"
                                            @if ($data1->Other3_Department_person == 'PI') selected @endif>Production
                                            Injectable</option>
                                        <option value="EN"
                                            @if ($data1->Other3_Department_person == 'EN') selected @endif>Engineering
                                        </option>
                                        <option value="HR"
                                            @if ($data1->Other3_Department_person == 'HR') selected @endif>Human
                                            Resource</option>
                                        <option value="ST"
                                            @if ($data1->Other3_Department_person == 'ST') selected @endif>Store
                                        </option>
                                        <option value="IT"
                                            @if ($data1->Other3_Department_person == 'IT') selected @endif>Electronic
                                            Data Processing
                                        </option>
                                        <option value="FD"
                                            @if ($data1->Other3_Department_person == 'FD') selected @endif>Formulation
                                            Development
                                        </option>
                                        <option value="AL"
                                            @if ($data1->Other3_Department_person == 'AL') selected @endif>Analytical
                                            research and Development
                                            Laboratory
                                        </option>
                                        <option value="PD"
                                            @if ($data1->Other3_Department_person == 'PD') selected @endif>Packaging
                                            Development
                                        </option>
                                        <option value="PU"
                                            @if ($data1->Other3_Department_person == 'PU') selected @endif>Purchase
                                            Department
                                        </option>
                                        <option value="DC"
                                            @if ($data1->Other3_Department_person == 'DC') selected @endif>Document Cell
                                        </option>
                                        <option value="RA"
                                            @if ($data1->Other3_Department_person == 'RA') selected @endif>Regulatory
                                            Affairs
                                        </option>
                                        <option value="PV"
                                            @if ($data1->Other3_Department_person == 'PV') selected @endif>
                                            Pharmacovigilance
                                        </option>

                                    </select>

                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Other3_review');
                                    var inputsToToggle = [];

                                    var facilityNameInputs = document.getElementsByClassName('Other3_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    var facilityNameInputs = document.getElementsByClassName('Other3_Department_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                        });

                                        var asteriskIcon = document.getElementById('asterisko3');
                                        var asteriskIcon1 = document.getElementById('asteriskod3');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                            <div class="col-md-12 mb-3 Other3_reviews">
                                <div class="group-input">
                                    <label for="Impact Assessment14">Impact Assessment (By Other's 3)
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other3_person) readonly @endif class="tiny" name="Other3_Assessment"
                                        @if ($data1->Other3_review == 'yes' && $data->stage == 4) required @endif id="summernote-45">{{ $data1->Other3_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Other3_reviews">
                                <div class="group-input">
                                    <label for="feedback3"> Other's 3 Feedback
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other3_person) readonly @endif class="tiny" name="Other3_feedback"
                                        @if ($data1->Other3_review == 'yes' && $data->stage == 4) required @endif id="summernote-46">{{ $data1->Other3_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 Other3_reviews">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 3 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other3_attachment">
                                            @if ($data1->Other3_attachment)
                                                @foreach (json_decode($data1->Other3_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other3_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other3_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other3_reviews">
                                <div class="group-input">
                                    <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                    <input type="text" name="Other3_by" id="Other3_by"
                                        value="{{ $data1->Other3_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other3_reviews">
                                <div class="group-input">
                                    <label for="productionfeedback">Other's 3 Review Completed On</label>
                                    <input disabled type="date" name="Other3_on" id="Other3_on"
                                        value="{{ $data1->Other3_on }}">
                                </div>
                            </div>
                            <div class="sub-head">
                                Other's 4 ( Additional Person Review From Departments If Required)
                            </div>
                            <script>
                                $(document).ready(function() {
                                    @if ($data1->Other4_review !== 'yes')
                                        $('.Other4_reviews').hide();

                                        $('[name="Other4_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other4_reviews').show();
                                                $('.Other4_reviews span').show();
                                            } else {
                                                $('.Other4_reviews').hide();
                                                $('.Other4_reviews span').hide();
                                            }
                                        });
                                    @endif
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review4">Other's 4 Review Required ?</label>
                                    <select name="Other4_review"
                                        @if ($data->stage == 4) disabled @endif id="Other4_review"
                                        value="{{ $data1->Other4_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other4_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other4_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other4_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Other4_reviews">
                                <div class="group-input">
                                    <label for="Person4"> Other's 4 Person <span id="asterisko4"
                                            style="display: {{ $data1->Other4_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other4_person"
                                        @if ($data->stage == 4) disabled @endif id="Other4_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other4_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12 Other4_reviews">
                                <div class="group-input">
                                    <label for="Department4"> Other's 4 Department <span id="asteriskod4"
                                            style="display: {{ $data1->Other4_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other4_Department_person"
                                        @if ($data->stage == 4) disabled @endif
                                        id="Other4_Department_person">
                                        <option value="">-- Select --</option>
                                        <option value="CQA"
                                            @if ($data1->Other4_Department_person == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QA"
                                            @if ($data1->Other4_Department_person == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QC"
                                            @if ($data1->Other4_Department_person == 'QC') selected @endif>Quality
                                            Control</option>
                                        <option value="QM"
                                            @if ($data1->Other4_Department_person == 'QM') selected @endif>Quality
                                            Control (Microbiology department)
                                        </option>
                                        <option value="PG"
                                            @if ($data1->Other4_Department_person == 'PG') selected @endif>Production
                                            General</option>
                                        <option value="PL"
                                            @if ($data1->Other4_Department_person == 'PL') selected @endif>Production
                                            Liquid Orals</option>
                                        <option value="PT"
                                            @if ($data1->Other4_Department_person == 'PT') selected @endif>Production
                                            Tablet and Powder</option>
                                        <option value="PE"
                                            @if ($data1->Other4_Department_person == 'PE') selected @endif>Production
                                            External (Ointment, Gels, Creams and
                                            Liquid)</option>
                                        <option value="PC"
                                            @if ($data1->Other4_Department_person == 'PC') selected @endif>Production
                                            Capsules</option>
                                        <option value="PI"
                                            @if ($data1->Other4_Department_person == 'PI') selected @endif>Production
                                            Injectable</option>
                                        <option value="EN"
                                            @if ($data1->Other4_Department_person == 'EN') selected @endif>Engineering
                                        </option>
                                        <option value="HR"
                                            @if ($data1->Other4_Department_person == 'HR') selected @endif>Human
                                            Resource</option>
                                        <option value="ST"
                                            @if ($data1->Other4_Department_person == 'ST') selected @endif>Store
                                        </option>
                                        <option value="IT"
                                            @if ($data1->Other4_Department_person == 'IT') selected @endif>Electronic
                                            Data Processing
                                        </option>
                                        <option value="FD"
                                            @if ($data1->Other4_Department_person == 'FD') selected @endif>Formulation
                                            Development
                                        </option>
                                        <option value="AL"
                                            @if ($data1->Other4_Department_person == 'AL') selected @endif>Analytical
                                            research and Development
                                            Laboratory
                                        </option>
                                        <option value="PD"
                                            @if ($data1->Other4_Department_person == 'PD') selected @endif>Packaging
                                            Development
                                        </option>
                                        <option value="PU"
                                            @if ($data1->Other4_Department_person == 'PU') selected @endif>Purchase
                                            Department
                                        </option>
                                        <option value="DC"
                                            @if ($data1->Other4_Department_person == 'DC') selected @endif>Document Cell
                                        </option>
                                        <option value="RA"
                                            @if ($data1->Other4_Department_person == 'RA') selected @endif>Regulatory
                                            Affairs
                                        </option>
                                        <option value="PV"
                                            @if ($data1->Other4_Department_person == 'PV') selected @endif>
                                            Pharmacovigilance
                                        </option>

                                    </select>

                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Other4_review');
                                    var inputsToToggle = [];

                                    var facilityNameInputs = document.getElementsByClassName('Other4_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    var facilityNameInputs = document.getElementsByClassName('Other4_Department_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                        });

                                        var asteriskIcon = document.getElementById('asterisko4');
                                        var asteriskIcon1 = document.getElementById('asteriskod4');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                            <div class="col-md-12 mb-3 Other4_reviews">
                                <div class="group-input">
                                    <label for="Impact Assessment15">Impact Assessment (By Other's 4)
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other4_person) readonly @endif class="tiny" name="Other4_Assessment"
                                        @if ($data1->Other4_review == 'yes' && $data->stage == 4) required @endif id="summernote-47">{{ $data1->Other4_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Other4_reviews">
                                <div class="group-input">
                                    <label for="feedback4"> Other's 4 Feedback
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other4_person) readonly @endif class="tiny" name="Other4_feedback"
                                        @if ($data1->Other4_review == 'yes' && $data->stage == 4) required @endif id="summernote-48">{{ $data1->Other4_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 Other4_reviews">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 4 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other4_attachment">
                                            @if ($data1->Other4_attachment)
                                                @foreach (json_decode($data1->Other4_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other4_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other4_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other4_reviews">
                                <div class="group-input">
                                    <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                    <input type="text" name="Other4_by" id="Other4_by"
                                        value="{{ $data1->Other4_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other4_reviews">
                                <div class="group-input">
                                    <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                    <input disabled type="date" name="Other4_on" id="Other4_on"
                                        value="{{ $data1->Other4_on }}">

                                </div>
                            </div>



                            <div class="sub-head">
                                Other's 5 ( Additional Person Review From Departments If Required)
                            </div>
                            <script>
                                $(document).ready(function() {
                                    @if ($data1->Other5_review !== 'yes')
                                        $('.Other5_reviews').hide();

                                        $('[name="Other5_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other5_reviews').show();
                                                $('.Other5_reviews span').show();
                                            } else {
                                                $('.Other5_reviews').hide();
                                                $('.Other5_reviews span').hide();
                                            }
                                        });
                                    @endif
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review5">Other's 5 Review Required ?</label>
                                    <select name="Other5_review"
                                        @if ($data->stage == 4) disabled @endif id="Other5_review"
                                        value="{{ $data1->Other5_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other5_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other5_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other5_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6 Other5_reviews">
                                <div class="group-input">
                                    <label for="Person5">Other's 5 Person
                                        <span id="asterisko5"
                                            style="display: {{ $data1->Other5_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="Other5_person"
                                        @if ($data->stage == 4) disabled @endif id="Other5_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other5_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12 Other5_reviews">
                                <div class="group-input">
                                    <label for="Department5"> Other's 5 Department <span id="asteriskod5"
                                            style="display: {{ $data1->Other5_review == 'yes' ? 'inline' : 'none' }}"
                                            class="text-danger">*</span></label>
                                    <select name="Other5_Department_person"
                                        @if ($data->stage == 4) disabled @endif
                                        id="Other5_Department_person">
                                        <option value="">-- Select --</option>
                                        <option value="CQA"
                                            @if ($data1->Other5_Department_person == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QA"
                                            @if ($data1->Other5_Department_person == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QC"
                                            @if ($data1->Other5_Department_person == 'QC') selected @endif>Quality
                                            Control</option>
                                        <option value="QM"
                                            @if ($data1->Other5_Department_person == 'QM') selected @endif>Quality
                                            Control (Microbiology department)
                                        </option>
                                        <option value="PG"
                                            @if ($data1->Other5_Department_person == 'PG') selected @endif>Production
                                            General</option>
                                        <option value="PL"
                                            @if ($data1->Other5_Department_person == 'PL') selected @endif>Production
                                            Liquid Orals</option>
                                        <option value="PT"
                                            @if ($data1->Other5_Department_person == 'PT') selected @endif>Production
                                            Tablet and Powder</option>
                                        <option value="PE"
                                            @if ($data1->Other5_Department_person == 'PE') selected @endif>Production
                                            External (Ointment, Gels, Creams and
                                            Liquid)</option>
                                        <option value="PC"
                                            @if ($data1->Other5_Department_person == 'PC') selected @endif>Production
                                            Capsules</option>
                                        <option value="PI"
                                            @if ($data1->Other5_Department_person == 'PI') selected @endif>Production
                                            Injectable</option>
                                        <option value="EN"
                                            @if ($data1->Other5_Department_person == 'EN') selected @endif>Engineering
                                        </option>
                                        <option value="HR"
                                            @if ($data1->Other5_Department_person == 'HR') selected @endif>Human
                                            Resource</option>
                                        <option value="ST"
                                            @if ($data1->Other5_Department_person == 'ST') selected @endif>Store
                                        </option>
                                        <option value="IT"
                                            @if ($data1->Other5_Department_person == 'IT') selected @endif>Electronic
                                            Data Processing
                                        </option>
                                        <option value="FD"
                                            @if ($data1->Other5_Department_person == 'FD') selected @endif>Formulation
                                            Development
                                        </option>
                                        <option value="AL"
                                            @if ($data1->Other5_Department_person == 'AL') selected @endif>Analytical
                                            research and Development
                                            Laboratory
                                        </option>
                                        <option value="PD"
                                            @if ($data1->Other5_Department_person == 'PD') selected @endif>Packaging
                                            Development
                                        </option>
                                        <option value="PU"
                                            @if ($data1->Other5_Department_person == 'PU') selected @endif>Purchase
                                            Department
                                        </option>
                                        <option value="DC"
                                            @if ($data1->Other5_Department_person == 'DC') selected @endif>Document Cell
                                        </option>
                                        <option value="RA"
                                            @if ($data1->Other5_Department_person == 'RA') selected @endif>Regulatory
                                            Affairs
                                        </option>
                                        <option value="PV"
                                            @if ($data1->Other5_Department_person == 'PV') selected @endif>
                                            Pharmacovigilance
                                        </option>

                                    </select>

                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var selectField = document.getElementById('Other5_review');
                                    var inputsToToggle = [];

                                    var facilityNameInputs = document.getElementsByClassName('Other5_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    var facilityNameInputs = document.getElementsByClassName('Other5_Department_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }

                                    selectField.addEventListener('change', function() {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function(input) {
                                            input.required = isRequired;
                                        });

                                        var asteriskIcon = document.getElementById('asterisko5');
                                        var asteriskIcon1 = document.getElementById('asteriskod5');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                            <div class="col-md-12 mb-3 Other5_reviews">
                                <div class="group-input">
                                    <label for="Impact Assessment16">Impact Assessment (By Other's 5)
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other5_person) readonly @endif class="tiny"
                                        name="Other5_Assessment"@if ($data1->Other5_review == 'yes' && $data->stage == 4) required @endif id="summernote-49">{{ $data1->Other5_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 Other5_reviews">
                                <div class="group-input">
                                    <label for="productionfeedback"> Other's 5 Feedback
                                    </label>
                                    <textarea @if ($data->stage == 3 || Auth::user()->id != $data1->Other5_person) readonly @endif class="tiny"
                                        name="Other5_feedback"@if ($data1->Other5_review == 'yes' && $data->stage == 4) required @endif id="summernote-50">{{ $data1->Other5_feedback }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 Other5_reviews">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 5 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other5_attachment">
                                            @if ($data1->Other5_attachment)
                                                @foreach (json_decode($data1->Other5_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other5_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other5_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other5_reviews">
                                <div class="group-input">
                                    <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                    <input type="text" name="Other5_by" id="Other5_by"
                                        value="{{ $data1->Other5_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3 Other5_reviews">
                                <div class="group-input">
                                    <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                    <input disabled type="date" name="Other5_on" id="Other5_on"
                                        value="{{ $data1->Other5_on }}">
                                </div>
                            </div>
                        @else
                            <div class="sub-head">
                                Other's 1 ( Additional Person Review From Departments If Required)
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Required1"> Other's 1 Review Required? </label>
                                    <select disabled
                                        name="Other1_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other1_review" value="{{ $data1->Other1_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other1_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other1_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other1_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Person1"> Other's 1 Person </label>
                                    <select disabled
                                        name="Other1_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other1_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other1_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Department1"> Other's 1 Department</label>
                                    <select disabled
                                        name="Other1_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other1_Department_person"
                                        value="{{ $data1->Other1_Department_person }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other1_Department_person == 'Production') selected @endif
                                            value="Production">
                                            Production</option>
                                        <option @if ($data1->Other1_Department_person == 'Warehouse') selected @endif
                                            value="Warehouse"> Warehouse
                                        </option>
                                        <option @if ($data1->Other1_Department_person == 'Quality_Control') selected @endif
                                            value="Quality_Control">
                                            Quality Control
                                        </option>
                                        <option @if ($data1->Other1_Department_person == 'Quality_Assurance') selected @endif
                                            value="Quality_Assurance">
                                            Quality
                                            Assurance</option>
                                        <option @if ($data1->Other1_Department_person == 'Engineering') selected @endif
                                            value="Engineering">
                                            Engineering</option>
                                        <option @if ($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif
                                            value="Analytical_Development_Laboratory">Analytical Development
                                            Laboratory</option>
                                        <option @if ($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif
                                            value="Process_Development_Lab">Process
                                            Development Laboratory / Kilo Lab
                                        </option>
                                        <option @if ($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif
                                            value="Technology transfer/Design">
                                            Technology Transfer/Design</option>
                                        <option @if ($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif
                                            value="Environment, Health & Safety">
                                            Environment, Health & Safety</option>
                                        <option @if ($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif
                                            value="Human Resource & Administration">
                                            Human Resource & Administration
                                        </option>
                                        <option @if ($data1->Other1_Department_person == 'Information Technology') selected @endif
                                            value="Information Technology">
                                            Information Technology</option>
                                        <option @if ($data1->Other1_Department_person == 'Project management') selected @endif
                                            value="Project management">
                                            Project
                                            management</option>

                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment12">Impact Assessment (By Other's 1)</label>
                                    <textarea disabled class="tiny"
                                        name="Other1_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-41">{{ $data1->Other1_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Feedback1"> Other's 1 Feedback</label>
                                    <textarea disabled class="tiny"
                                        name="Other1_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-42">{{ $data1->Other1_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other1_attachment">
                                            @if ($data1->Other1_attachment)
                                                @foreach (json_decode($data1->Other1_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other1_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other1_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed By1"> Other's 1 Review Completed By</label>
                                    <input disabled type="text" value="{{ $data1->Other1_by }}"
                                        name="Other1_by" id="Other1_by">

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                    <input disabled type="date" name="Other1_on" id="Other1_on"
                                        value="{{ $data1->Other1_on }}">

                                </div>
                            </div>

                            <div class="sub-head">
                                Other's 2 ( Additional Person Review From Departments If Required)
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review2"> Other's 2 Review Required ?</label>
                                    <select disabled
                                        name="Other2_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other2_review" value="{{ $data1->Other2_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other2_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other2_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other2_review == 'na') selected @endif
                                            value="na">
                                            NA</option>
                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Person2"> Other's 2 Person</label>
                                    <select disabled
                                        name="Other2_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other2_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other2_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Department2"> Other's 2 Department</label>
                                    <select disabled
                                        name="Other2_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other2_Department_person">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other2_Department_person == 'Production') selected @endif
                                            value="Production">
                                            Production</option>
                                        <option @if ($data1->Other2_Department_person == 'Warehouse') selected @endif
                                            value="Warehouse"> Warehouse
                                        </option>
                                        <option @if ($data1->Other2_Department_person == 'Quality_Control') selected @endif
                                            value="Quality_Control">
                                            Quality Control
                                        </option>
                                        <option @if ($data1->Other2_Department_person == 'Quality_Assurance') selected @endif
                                            value="Quality_Assurance">
                                            Quality
                                            Assurance</option>
                                        <option @if ($data1->Other2_Department_person == 'Engineering') selected @endif
                                            value="Engineering">
                                            Engineering</option>
                                        <option @if ($data1->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif
                                            value="Analytical_Development_Laboratory">Analytical Development
                                            Laboratory</option>
                                        <option @if ($data1->Other2_Department_person == 'Process_Development_Lab') selected @endif
                                            value="Process_Development_Lab">Process
                                            Development Laboratory / Kilo Lab
                                        </option>
                                        <option @if ($data1->Other2_Department_person == 'Technology transfer/Design') selected @endif
                                            value="Technology transfer/Design">
                                            Technology Transfer/Design</option>
                                        <option @if ($data1->Other2_Department_person == 'Environment, Health & Safety') selected @endif
                                            value="Environment, Health & Safety">
                                            Environment, Health & Safety</option>
                                        <option @if ($data1->Other2_Department_person == 'Human Resource & Administration') selected @endif
                                            value="Human Resource & Administration">
                                            Human Resource & Administration
                                        </option>
                                        <option @if ($data1->Other2_Department_person == 'Information Technology') selected @endif
                                            value="Information Technology">
                                            Information Technology</option>
                                        <option @if ($data1->Other2_Department_person == 'Project management') selected @endif
                                            value="Project management">
                                            Project
                                            management</option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment13">Impact Assessment (By Other's 2)</label>
                                    <textarea disabled ="summernote"
                                        name="Other2_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-43">{{ $data1->Other2_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Feedback2"> Other's 2 Feedback</label>
                                    <textarea disabled class="tiny"
                                        name="Other2_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-44">{{ $data1->Other2_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 2 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other2_attachment">
                                            @if ($data1->Other2_attachment)
                                                @foreach (json_decode($data1->Other2_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other2_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other2_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                    <input type="text" name="Other2_by" id="Other2_by"
                                        value="{{ $data1->Other2_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                    <input disabled type="date" name="Other2_on" id="Other2_on"
                                        value="{{ $data1->Other2_on }}">
                                </div>
                            </div>

                            <div class="sub-head">
                                Other's 3 ( Additional Person Review From Departments If Required)
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review3"> Other's 3 Review Required ?</label>
                                    <select disabled
                                        name="Other3_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other3_review" value="{{ $data1->Other3_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other3_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other3_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other3_review == 'na') selected @endif
                                            value="na">
                                            NA</option>
                                    </select>

                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Person3">Other's 3 Person</label>
                                    <select disabled
                                        name="Other3_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other3_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other3_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Department3">Other's 3 Department</label>
                                    <select disabled
                                        name="Other3_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other3_Department_person">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other3_Department_person == 'Production') selected @endif
                                            value="Production">
                                            Production</option>
                                        <option @if ($data1->Other3_Department_person == 'Warehouse') selected @endif
                                            value="Warehouse"> Warehouse
                                        </option>
                                        <option @if ($data1->Other3_Department_person == 'Quality_Control') selected @endif
                                            value="Quality_Control">
                                            Quality Control
                                        </option>
                                        <option @if ($data1->Other3_Department_person == 'Quality_Assurance') selected @endif
                                            value="Quality_Assurance">
                                            Quality
                                            Assurance</option>
                                        <option @if ($data1->Other3_Department_person == 'Engineering') selected @endif
                                            value="Engineering">
                                            Engineering</option>
                                        <option @if ($data1->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif
                                            value="Analytical_Development_Laboratory">Analytical Development
                                            Laboratory</option>
                                        <option @if ($data1->Other3_Department_person == 'Process_Development_Lab') selected @endif
                                            value="Process_Development_Lab">Process
                                            Development Laboratory / Kilo Lab
                                        </option>
                                        <option @if ($data1->Other3_Department_person == 'Technology transfer/Design') selected @endif
                                            value="Technology transfer/Design">
                                            Technology Transfer/Design</option>
                                        <option @if ($data1->Other3_Department_person == 'Environment, Health & Safety') selected @endif
                                            value="Environment, Health & Safety">
                                            Environment, Health & Safety</option>
                                        <option @if ($data1->Other3_Department_person == 'Human Resource & Administration') selected @endif
                                            value="Human Resource & Administration">
                                            Human Resource & Administration
                                        </option>
                                        <option @if ($data1->Other3_Department_person == 'Information Technology') selected @endif
                                            value="Information Technology">
                                            Information Technology</option>
                                        <option @if ($data1->Other3_Department_person == 'Project management') selected @endif
                                            value="Project management">
                                            Project
                                            management</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment14">Impact Assessment (By Other's 3)</label>
                                    <textarea disabled class="tiny"
                                        name="Other3_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-45">{{ $data1->Other3_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="feedback3"> Other's 3 Feedback</label>
                                    <textarea disabled class="tiny"
                                        name="Other3_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-46">{{ $data1->Other3_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 3 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other3_attachment">
                                            @if ($data1->Other3_attachment)
                                                @foreach (json_decode($data1->Other3_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other3_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other3_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                    <input type="text" name="Other3_by" id="Other3_by"
                                        value="{{ $data1->Other3_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="productionfeedback">Other's 3 Review Completed On</label>
                                    <input disabled type="date" name="Other3_on" id="Other3_on"
                                        value="{{ $data1->Other3_on }}">
                                </div>
                            </div>
                            <div class="sub-head">
                                Other's 4 ( Additional Person Review From Departments If Required)
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review4">Other's 4 Review Required ?</label>
                                    <select disabled
                                        name="Other4_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other4_review" value="{{ $data1->Other4_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other4_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other4_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other4_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>

                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Person4"> Other's 4 Person</label>
                                    <select
                                        name="Other4_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other4_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other4_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Department4"> Other's 4 Department</label>
                                    <select disabled
                                        name="Other4_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other4_Department_person">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other4_Department_person == 'Production') selected @endif
                                            value="Production">
                                            Production</option>
                                        <option @if ($data1->Other4_Department_person == 'Warehouse') selected @endif
                                            value="Warehouse"> Warehouse
                                        </option>
                                        <option @if ($data1->Other4_Department_person == 'Quality_Control') selected @endif
                                            value="Quality_Control">
                                            Quality Control
                                        </option>
                                        <option @if ($data1->Other4_Department_person == 'Quality_Assurance') selected @endif
                                            value="Quality_Assurance">
                                            Quality
                                            Assurance</option>
                                        <option @if ($data1->Other4_Department_person == 'Engineering') selected @endif
                                            value="Engineering">
                                            Engineering</option>
                                        <option @if ($data1->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif
                                            value="Analytical_Development_Laboratory">Analytical Development
                                            Laboratory</option>
                                        <option @if ($data1->Other4_Department_person == 'Process_Development_Lab') selected @endif
                                            value="Process_Development_Lab">Process
                                            Development Laboratory / Kilo Lab
                                        </option>
                                        <option @if ($data1->Other4_Department_person == 'Technology transfer/Design') selected @endif
                                            value="Technology transfer/Design">
                                            Technology Transfer/Design</option>
                                        <option @if ($data1->Other4_Department_person == 'Environment, Health & Safety') selected @endif
                                            value="Environment, Health & Safety">
                                            Environment, Health & Safety</option>
                                        <option @if ($data1->Other4_Department_person == 'Human Resource & Administration') selected @endif
                                            value="Human Resource & Administration">
                                            Human Resource & Administration
                                        </option>
                                        <option @if ($data1->Other4_Department_person == 'Information Technology') selected @endif
                                            value="Information Technology">
                                            Information Technology</option>
                                        <option @if ($data1->Other4_Department_person == 'Project management') selected @endif
                                            value="Project management">
                                            Project
                                            management</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment15">Impact Assessment (By Other's 4)</label>
                                    <textarea disabled class="tiny"
                                        name="Other4_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-47">{{ $data1->Other4_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="feedback4"> Other's 4 Feedback</label>
                                    <textarea disabled class="tiny"
                                        name="Other4_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-48">{{ $data1->Other4_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 4 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other4_attachment">
                                            @if ($data1->Other4_attachment)
                                                @foreach (json_decode($data1->Other4_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"

                  style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other4_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other4_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                    <input type="text" name="Other4_by" id="Other4_by"
                                        value="{{ $data1->Other4_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                    <input disabled type="date" name="Other4_on" id="Other4_on"
                                        value="{{ $data1->Other4_on }}">

                                </div>
                            </div>



                            <div class="sub-head">
                                Other's 5 ( Additional Person Review From Departments If Required)
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review5">Other's 5 Review Required ?</label>
                                    <select disabled
                                        name="Other5_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other5_review" value="{{ $data1->Other5_review }}">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other5_review == 'yes') selected @endif
                                            value="yes">
                                            Yes</option>
                                        <option @if ($data1->Other5_review == 'no') selected @endif
                                            value="no">
                                            No</option>
                                        <option @if ($data1->Other5_review == 'na') selected @endif
                                            value="na">
                                            NA</option>

                                    </select>

                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['q_m_s_divisions_id' => $data->division_id])
                                    ->select('user_id')
                                    ->distinct()
                                    ->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Person5">Other's 5 Person</label>
                                    <select disabled
                                        name="Other5_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other5_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option {{ $data1->Other5_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Department5"> Other's 5 Department</label>
                                    <select disabled
                                        name="Other5_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                        id="Other5_Department_person">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data1->Other5_Department_person == 'Production') selected @endif
                                            value="Production">
                                            Production</option>
                                        <option @if ($data1->Other5_Department_person == 'Warehouse') selected @endif
                                            value="Warehouse"> Warehouse
                                        </option>
                                        <option @if ($data1->Other5_Department_person == 'Quality_Control') selected @endif
                                            value="Quality_Control">
                                            Quality Control
                                        </option>
                                        <option @if ($data1->Other5_Department_person == 'Quality_Assurance') selected @endif
                                            value="Quality_Assurance">
                                            Quality
                                            Assurance</option>
                                        <option @if ($data1->Other5_Department_person == 'Engineering') selected @endif
                                            value="Engineering">
                                            Engineering</option>
                                        <option @if ($data1->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif
                                            value="Analytical_Development_Laboratory">Analytical Development
                                            Laboratory</option>
                                        <option @if ($data1->Other5_Department_person == 'Process_Development_Lab') selected @endif
                                            value="Process_Development_Lab">Process
                                            Development Laboratory / Kilo Lab
                                        </option>
                                        <option @if ($data1->Other5_Department_person == 'Technology transfer/Design') selected @endif
                                            value="Technology transfer/Design">
                                            Technology Transfer/Design</option>
                                        <option @if ($data1->Other5_Department_person == 'Environment, Health & Safety') selected @endif
                                            value="Environment, Health & Safety">
                                            Environment, Health & Safety</option>
                                        <option @if ($data1->Other5_Department_person == 'Human Resource & Administration') selected @endif
                                            value="Human Resource & Administration">
                                            Human Resource & Administration
                                        </option>
                                        <option @if ($data1->Other5_Department_person == 'Information Technology') selected @endif
                                            value="Information Technology">
                                            Information Technology</option>
                                        <option @if ($data1->Other5_Department_person == 'Project management') selected @endif
                                            value="Project management">
                                            Project
                                            management</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment16">Impact Assessment (By Other's 5)</label>
                                    <textarea disabled class="tiny"
                                        name="Other5_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-49">{{ $data1->Other5_Assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="productionfeedback"> Other's 5 Feedback</label>
                                    <textarea disabled class="tiny"
                                        name="Other5_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-50">{{ $data1->Other5_feedback }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Other's 5 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Other5_attachment">
                                            @if ($data1->Other5_attachment)
                                                @foreach (json_decode($data1->Other5_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}"
                                                            target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="Other5_attachment[]"
                                                oninput="addMultipleFiles(this, 'Other5_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                    <input type="text" name="Other5_by" id="Other5_by"
                                        value="{{ $data1->Other5_by }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                    <input disabled type="date" name="Other5_on" id="Other5_on"
                                        value="{{ $data1->Other5_on }}">
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="button-block">
                        <button style=" justify-content: center; width: 4rem; margin-left: 1px;;"
                            type="submit"{{ $data->stage == 0 || $data->stage == 7 || $data->stage == 9 ? 'disabled' : '' }}
                            id="ChangesaveButton" class="saveButton saveAuditFormBtn d-flex"
                            style="align-items: center;">
                            <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Save
                        </button>
                        <button style=" justify-content: center; width: 4rem; margin-left: 1px;;"
                            type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                            id="ChangeNextButton" class="nextButton">Next</button>
                        <button style=" justify-content: center; width: 4rem; margin-left: 1px;;"
                            type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                        @if (
                            $data->stage == 2 ||
                                $data->stage == 3 ||
                                $data->stage == 4 ||
                                $data->stage == 5 ||
                                $data->stage == 6 ||
                                $data->stage == 7)
                            {{-- <a style="  justify-content: center; width: 10rem; margin-left: 1px;;" type="button"
                                    class="button  launch_extension" data-bs-toggle="modal"
                                    data-bs-target="#launch_extension">
                                    Launch Extension
                                </a> --}}
                        @endif
                        <!-- <a type="button" class="button  launch_extension" data-bs-toggle="modal"
                                                                                    data-bs-target="#effectivenss_extension">
                                                                                    Launch Effectiveness Check
                                                                                </a> -->
                    </div>
                </div>
            </div>
            </div>

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <button id="printButton" onclick="printTabContent()" style="margin-left: 110rem; width:60px">Print</button>
                        <script>
                            function printTabContent() {
                                var printContents = document.getElementById('CCForm3').innerHTML;
                                var originalContents = document.body.innerHTML;

                                document.body.innerHTML = printContents;
                                window.print();
                                document.body.innerHTML = originalContents;
                            }
                        </script>
                        <div class="sub-head">Acknowledgement</div>



                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Manufacturer name & Address">Manufacturer name & Address</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not
                                        require completion</small></div>
                                <textarea class="summernote" name="manufacturer_name_address_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->manufacturer_name_address_ca }}
                                    </textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="root_cause">
                                    Product/Material Detail
                                    <button type="button" id="promate_add"  {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="prod_mate_details" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px;">Row #</th>
                                                <th>Product Name</th>
                                                <th>Batch No.</th>
                                                <th>Mfg. Date</th>
                                                <th>Exp. Date</th>
                                                <th>Batch Size</th>
                                                <th>Pack Profile</th>
                                                <th>Released Quantity</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $productmateIndex = 0;
                                            @endphp
                                            @if (!empty($product_materialDetails) && is_array($product_materialDetails->data))
                                                @foreach ($product_materialDetails->data as $index => $Prodmateriyal)
                                                    <tr>
                                                        <td>{{  ++$productmateIndex }}</td>
                                                        <td><input  {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}type="text" name="Product_MaterialDetails[{{ $index }}][product_name_ca]" value="{{ array_key_exists('product_name_ca', $Prodmateriyal) ? $Prodmateriyal['product_name_ca'] : '' }}"></td>
                                                        <td><input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" name="Product_MaterialDetails[{{ $index }}][batch_no_pmd_ca]" value="{{ array_key_exists('batch_no_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['batch_no_pmd_ca'] : '' }}"></td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            class="click_date"
                                                                            id="date_{{ $index }}_mfg_date_pmd_ca" type="text"
                                                                            name="Product_MaterialDetails[{{ $index }}][mfg_date_pmd_ca]"
                                                                            placeholder="DD-MMM-YYYY"
                                                                            value="{{ !empty($Prodmateriyal['mfg_date_pmd_ca']) ? \Carbon\Carbon::parse($Prodmateriyal['mfg_date_pmd_ca'])->format('d-M-Y') : '' }}"
                                                                        />
                                                                        <input type="date" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            name="Product_MaterialDetails[{{ $index }}][mfg_date_pmd_ca]"
                                                                            value="{{ !empty($Prodmateriyal['mfg_date_pmd_ca']) ? \Carbon\Carbon::parse($Prodmateriyal['mfg_date_pmd_ca'])->format('Y-m-d') : '' }}"
                                                                            id="date_{{ $index }}_mfg_date_pmd_ca"
                                                                            class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                            onchange="handleDateInput(this, 'date_{{ $index }}_mfg_date_pmd_ca')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            class="click_date"
                                                                            id="date_{{ $index }}_expiry_date_pmd_ca" type="text"
                                                                            name="Product_MaterialDetails[{{ $index }}][expiry_date_pmd_ca]"
                                                                            placeholder="DD-MMM-YYYY"
                                                                            value="{{ !empty($Prodmateriyal['expiry_date_pmd_ca']) ? \Carbon\Carbon::parse($Prodmateriyal['expiry_date_pmd_ca'])->format('d-M-Y') : '' }}"
                                                                        />
                                                                        <input type="date" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                                                            name="Product_MaterialDetails[{{ $index }}][expiry_date_pmd_ca]"
                                                                            value="{{ !empty($Prodmateriyal['expiry_date_pmd_ca']) ? \Carbon\Carbon::parse($Prodmateriyal['expiry_date_pmd_ca'])->format('Y-m-d') : '' }}"
                                                                            id="date_{{ $index }}_expiry_date_pmd_ca"
                                                                            class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                            onchange="handleDateInput(this, 'date_{{ $index }}_expiry_date_pmd_ca')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" name="Product_MaterialDetails[{{ $index }}][batch_size_pmd_ca]" value="{{ array_key_exists('batch_size_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['batch_size_pmd_ca'] : '' }}"></td>
                                                        <td><input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" name="Product_MaterialDetails[{{ $index }}][pack_profile_pmd_ca]" value="{{ array_key_exists('pack_profile_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['pack_profile_pmd_ca'] : '' }}"></td>
                                                        <td><input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" name="Product_MaterialDetails[{{ $index }}][released_quantity_pmd_ca]" value="{{ array_key_exists('released_quantity_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['released_quantity_pmd_ca'] : '' }}"></td>
                                                        <td><input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" name="Product_MaterialDetails[{{ $index }}][remarks_ca]" value="{{ array_key_exists('remarks_ca', $Prodmateriyal) ? $Prodmateriyal['remarks_ca'] : '' }}"></td>
                                                        <td><button {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="text" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="10">No found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                let indexMaetDetails = {{ ($product_materialDetails && is_array($product_materialDetails->data)) ? count($product_materialDetails->data) : 0 }};
                                $('#promate_add').click(function(e) {
                                    e.preventDefault();

                                    function generateTableRow(productserialno) {
                                        var html =
                                            '<tr>' +
                                                '<td>' + (productserialno + 1) + '</td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][product_name_ca]"></td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][batch_no_pmd_ca]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ productserialno +'_mfg_date_pmd_ca" type="text" name="Product_MaterialDetails[' + productserialno + '][mfg_date_pmd_ca]" placeholder="DD-MMM-YYYY" /> <input type="date" name="Product_MaterialDetails[' + productserialno + '][mfg_date_pmd_ca]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ productserialno +'_mfg_date_pmd_ca" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ productserialno +'_mfg_date_pmd_ca\')" /> </div></div></div> </td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ productserialno +'_expiry_date_pmd_ca" type="text" name="Product_MaterialDetails[' + productserialno + '][expiry_date_pmd_ca]" placeholder="DD-MMM-YYYY" /> <input type="date" name="Product_MaterialDetails[' + productserialno + '][expiry_date_pmd_ca]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ productserialno +'_expiry_date_pmd_ca" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ productserialno +'_expiry_date_pmd_ca\')" /> </div></div></div> </td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][batch_size_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][pack_profile_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][released_quantity_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][remarks_ca]"></td>' +
                                                '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                                            '</tr>';
                                        return html;
                                    }

                                    var tableBody = $('#prod_mate_details tbody');
                                    var rowCount = tableBody.children('tr').length;
                                    var newRow = generateTableRow(rowCount);
                                    tableBody.append(newRow);
                                    indexMaetDetails++;
                                });
                            });
                        </script>








                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Complaint Sample Required">Complaint Sample Required</label>
                                <select name="complaint_sample_required_ca" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                    <option value="">-- select --</option>
                                    <option value="yes" {{ isset($data) && $data->complaint_sample_required_ca == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ isset($data) && $data->complaint_sample_required_ca == 'no' ? 'selected' : '' }}>No</option>
                                    <option value="na" {{ isset($data) && $data->complaint_sample_required_ca == 'na' ? 'selected' : '' }}>NA</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Complaint Sample Status">Complaint Sample Status</label>
                                <input type="text" name="complaint_sample_status_ca" id="date_of_initiation"
                                {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} value="{{ $data->complaint_sample_status_ca }}">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Brief Description of complaint">Brief Description of complaint:</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="brief_description_of_complaint_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->brief_description_of_complaint_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Batch Record review observation">Batch Record review
                                    observation</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="batch_record_review_observation_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->batch_record_review_observation_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Analytical Data review observation">Analytical Data review
                                    observation</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="analytical_data_review_observation_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->analytical_data_review_observation_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Retention sample review observation">Retention sample review
                                    observation</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="retention_sample_review_observation_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->retention_sample_review_observation_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Stablity study data review">Stablity study data review</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="stability_study_data_review_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->stability_study_data_review_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="QMS Events(if any) review Observation">QMS Events(if any) review
                                    Observation</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="qms_events_ifany_review_observation_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->qms_events_ifany_review_observation_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Repeated complaints/queries for product">Repeated complaints/queries
                                    for product:</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="repeated_complaints_queries_for_product_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->repeated_complaints_queries_for_product_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Interpretation on compalint sample">Interpretation on compalint
                                    sample(if recieved)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="interpretation_on_complaint_sample_ifrecieved_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->interpretation_on_complaint_sample_ifrecieved_ca }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Comments">Comments(if Any)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does
                                        not require completion</small></div>
                                <textarea class="summernote" name="comments_ifany_ca" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->comments_ifany_ca }}
                                </textarea>
                            </div>
                        </div>
                        {{-- <div class="sub-head">
                            Proposal to accomplish investigation:
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <div class="why-why-chart">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr. No.</th>
                                                <th style="width: 40%;">Requirements</th>
                                                <th style="width: 8%;">Yes/No</th>
                                                <th style="width: 20%;">Expected date of investigation completion</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="flex text-center">1</td>
                                                <td>Complaint sample Required</td>
                                                <td></td>
                                                <td>
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="csr1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Complaint sample Required']['csr1'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="csr2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Complaint sample Required']['csr2'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="flex text-center">2</td>
                                                <td>Additional info. From Complainant</td>
                                                <td></td>

                                                <td>
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea  {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}name="afc1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Additional info. From Complainant']['afc1'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="afc2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Additional info. From Complainant']['afc2'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="flex text-center">3</td>
                                                <td>Analysis of complaint Sample</td>
                                                <td></td>
                                                <td>
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="acs1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Analysis of complaint Sample']['acs1'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="acs2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Analysis of complaint Sample']['acs2'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="flex text-center">4</td>
                                                <td>QRM Approach</td>
                                                <td></td>
                                                <td>
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea  {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}name="qrm1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['QRM Approach']['qrm1'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="qrm2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['QRM Approach']['qrm2'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="flex text-center">5</td>
                                                <td>Others</td>
                                                <td></td>
                                                <td>
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="oth1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Others']['oth1'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="margin: auto; display: flex; justify-content: center;">
                                                        <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="oth2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Others']['oth2'] ?? '' }}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                    <div class="sub-head">
                        Proposal to accomplish investigation:
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <div class="why-why-chart">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Sr. No.</th>
                                            <th style="width: 40%;">Requirements</th>
                                            <th style="width: 10%;">Yes/No</th>
                                            <th style="width: 20%;">Expected date of investigation completion</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <style>
                                        .main-head{
                                           display: flex;
                                           justify-content: space-around;
                                           gap: 12px;
                                        }
                                        .label-head{
                                           display: flex !important;
                                            gap: 14px;
                                        }
                                        .input-head{
                                           margin-top: 4px;
                                        }
                                    </style>
                                    <tbody>
                                        <tr>
                                            <td class="flex text-center">1</td>
                                            <td>Complaint sample Required</td>
                                            <td class="main-head">
                                                <label class="label-head">
                                                    <span class="input-head">
                                                        <input type="radio" name="csr1_yesno" value="yes" {{ isset($proposalData['Complaint sample Required']['csr3']) && $proposalData['Complaint sample Required']['csr3'] == 'yes' ? 'checked' : '' }} onchange="toggleInputs('csr1_yesno', 'csr1', 'csr2')">
                                                    </span>
                                                    <span>Yes</span>
                                                </label>
                                                <label class="label-head">
                                                    <span class="input-head">
                                                        <input type="radio" name="csr1_yesno" value="no" {{ isset($proposalData['Complaint sample Required']['csr3']) && $proposalData['Complaint sample Required']['csr3'] == 'no' ? 'checked' : '' }} onchange="toggleInputs('csr1_yesno', 'csr1', 'csr2')">
                                                    </span>
                                                    <span>No</span>
                                                </label>
                                            </td>
                                            <td>
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="csr1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Complaint sample Required']['csr1'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="csr2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Complaint sample Required']['csr2'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flex text-center">2</td>
                                            <td>Additional info. From Complainant</td>
                                            <td class="main-head">
                                                <label class="label-head">
                                                    <input type="radio" name="afc1_yesno" value="yes" {{ isset($proposalData['Additional info. From Complainant']['afc3']) && $proposalData['Additional info. From Complainant']['afc3'] == 'yes' ? 'checked' : '' }} onchange="toggleInputs('afc1_yesno', 'afc1', 'afc2')">
                                                    <span>Yes</span>
                                                </label>
                                                <label class="label-head">
                                                    <input type="radio" name="afc1_yesno" value="no" {{ isset($proposalData['Additional info. From Complainant']['afc3']) && $proposalData['Additional info. From Complainant']['afc3'] == 'no' ? 'checked' : '' }} onchange="toggleInputs('afc1_yesno', 'afc1', 'afc2')">
                                                    <span>No</span>
                                                </label>
                                            </td>
                                            <td>
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="afc1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Additional info. From Complainant']['afc1'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="afc2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Additional info. From Complainant']['afc2'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flex text-center">3</td>
                                            <td>Analysis of complaint Sample</td>
                                            <td class="main-head">
                                                <label class="label-head">
                                                    <input type="radio" name="acs1_yesno" value="yes" {{ isset($proposalData['Analysis of complaint Sample']['acs3']) && $proposalData['Analysis of complaint Sample']['acs3'] == 'yes' ? 'checked' : '' }} onchange="toggleInputs('acs1_yesno', 'acs1', 'acs2')">
                                                    <span>Yes</span>
                                                </label>
                                                <label class="label-head">
                                                    <input type="radio" name="acs1_yesno" value="no" {{ isset($proposalData['Analysis of complaint Sample']['acs3']) && $proposalData['Analysis of complaint Sample']['acs3'] == 'no' ? 'checked' : '' }} onchange="toggleInputs('acs1_yesno', 'acs1', 'acs2')">
                                                    <span>No</span>
                                                </label>
                                            </td>
                                            <td>
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="acs1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Analysis of complaint Sample']['acs1'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="acs2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Analysis of complaint Sample']['acs2'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flex text-center">4</td>
                                            <td>QRM Approach</td>
                                            <td class="main-head">
                                                <label class="label-head">
                                                    <input type="radio" name="qrm1_yesno" value="yes" {{ isset($proposalData['QRM Approach']['qrm3']) && $proposalData['QRM Approach']['qrm3'] == 'yes' ? 'checked' : '' }} onchange="toggleInputs('qrm1_yesno', 'qrm1', 'qrm2')">
                                                    <span>Yes</span>
                                                </label>
                                                <label class="label-head">
                                                    <input type="radio" name="qrm1_yesno" value="no" {{ isset($proposalData['QRM Approach']['qrm3']) && $proposalData['QRM Approach']['qrm3'] == 'no' ? 'checked' : '' }} onchange="toggleInputs('qrm1_yesno', 'qrm1', 'qrm2')">
                                                    <span>No</span>
                                                </label>
                                            </td>
                                            <td>
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="qrm1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['QRM Approach']['qrm1'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="qrm2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['QRM Approach']['qrm2'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flex text-center">5</td>
                                            <td>Others</td>
                                            <td class="main-head">
                                                <label class="label-head">
                                                    <input type="radio" name="oth1_yesno" value="yes" {{ isset($proposalData['Others']['oth3']) && $proposalData['Others']['oth3'] == 'yes' ? 'checked' : '' }} onchange="toggleInputs('oth1_yesno', 'oth1', 'oth2')">
                                                    <span>Yes</span>
                                                </label>
                                                <label class="label-head">
                                                    <input type="radio" name="oth1_yesno" value="no" {{ isset($proposalData['Others']['oth3']) && $proposalData['Others']['oth3'] == 'no' ? 'checked' : '' }} onchange="toggleInputs('oth1_yesno', 'oth1', 'oth2')">
                                                    <span>No</span>
                                                </label>
                                            </td>
                                            <td>
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="oth1" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Others']['oth1'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="margin: auto; display: flex; justify-content: center;">
                                                    <textarea {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} name="oth2" style="border-radius: 7px; border: 1.5px solid black;">{{ $proposalData['Others']['oth2'] ?? '' }}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleInputs(radioName, textarea1, textarea2) {
                            const radios = document.getElementsByName(radioName);
                            let selectedValue = '';
                            for (const radio of radios) {
                                if (radio.checked) {
                                    selectedValue = radio.value;
                                    break;
                                }
                            }

                            document.getElementsByName(textarea1)[0].disabled = selectedValue !== 'yes';
                            document.getElementsByName(textarea2)[0].disabled = selectedValue !== 'yes';
                        }

                        // Call toggleInputs for each row on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            toggleInputs('csr1_yesno', 'csr1', 'csr2');
                            toggleInputs('afc1_yesno', 'afc1', 'afc2');
                            toggleInputs('acs1_yesno', 'acs1', 'acs2');
                            toggleInputs('qrm1_yesno', 'qrm1', 'qrm2');
                            toggleInputs('oth1_yesno', 'oth1', 'oth2');
                        });
                    </script>



                    <div class="col-12">
                        <div class="group-input">
                            <label for="Inv Attachments">Acknowledgement Attachment</label>
                            <div>
                                <small class="text-primary">
                                    Please Attach all relevant or supporting documents
                                </small>
                            </div>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="initial_attachment_ca">

                                    @if ($data->initial_attachment_ca)
                                        @foreach (json_decode($data->initial_attachment_ca) as $file)
                                            <h6 type="button" class="file-container text-dark"
                                                style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                        class="fa fa-eye text-primary"
                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a type="button" class="remove-file"
                                                    data-file-name="{{ $file }}"><i
                                                        class="fa-solid fa-circle-xmark"
                                                        style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="file" id="initial_attachment_ca" name="initial_attachment_ca[]"
                                        oninput="addMultipleFiles(this,'initial_attachment_ca')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="button-block">
                    <button type="submit" class="saveButton" id="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} >Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                            Exit </a> </button>
                </div>
            </div>
    </div>





    <div id="CCForm4" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Closure
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="group-input">
                        <label for="Closure Comment">Closure Comment</label>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not
                                require completion</small></div>
                        <textarea class="summernote" name="closure_comment_c" id="summernote-1" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->closure_comment_c }}
                                    </textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="group-input">
                        <label for="Inv Attachments">Closure Attachment</label>
                        <div>
                            <small class="text-primary">
                                Please Attach all relevant or supporting documents
                            </small>
                        </div>
                        <div class="file-attachment-field">
                            <div class="file-attachment-list" id="initial_attachment_c">

                                @if ($data->initial_attachment_c)
                                    @foreach (json_decode($data->initial_attachment_c) as $file)
                                        <h6 type="button" class="file-container text-dark"
                                            style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                    class="fa fa-eye text-primary"
                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a type="button" class="remove-file"
                                                data-file-name="{{ $file }}"><i
                                                    class="fa-solid fa-circle-xmark"
                                                    style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                    @endforeach
                                @endif
                            </div>
                            <div class="add-btn">
                                <div>Add</div>
                                <input  {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} type="file" id="initial_attachment_c" name="initial_attachment_c[]"
                                    oninput="addMultipleFiles(this,'initial_attachment_c')" multiple>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="button-block">
                <button type="submit" class="saveButton" id="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Save</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                    </a> </button>
            </div>
        </div>
    </div>

    <div id="CCForm5" class="inner-block cctabcontent">
        <div class="inner-block-content">

            <div class="row">



                <div class="sub-head">
                    Activity Log
                </div>


                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Submit By : </label>
                        <div class="static">{{ $data->submitted_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Submit On : </label>
                        <div class="Date">{{ $data->submitted_on }}</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->submitted_comment }}</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">More Information Required By: </label>
                        <div class="static">{{ $data->more_information_required_by}}</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">More Information Required On: </label>
                        <div class="date">{{ $data->more_information_required_on}}</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->more_information_required_comment }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Cancel By: </label>
                        <div class="static">{{ $data->cancelled_by}}</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Cancel On: </label>
                        <div class="date">{{ $data->cancelled_on}}</div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->cancelled_comment }}</div>
                    </div>
                </div>



                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Complete Review By : </label>
                        <div class="static">{{ $data->complete_review_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Complete Review On :</label>
                        <div class="date">{{ $data->complete_review_on }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->complete_review_comment }}</div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Investigation Completed By :</label>
                        <div class="static">{{ $data->investigation_completed_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Investigation Completed On : </label>

                        <div class="date">{{ $data->investigation_completed_on }}</div>



                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->investigation_completed_comment }}</div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Propose Plan By : </label>
                        <div class="static">{{ $data->propose_plan_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Propose Plan On : </label>

                        <div class="date">{{ $data->propose_plan_on }}</div>



                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->propose_plan_comment }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Reject By : </label>
                        <div class="static">{{ $data->reject_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Reject On : </label>

                        <div class="date">{{ $data->reject_on}}</div>



                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->reject_comment}}</div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Approve Plan By : </label>
                        <div class="static">{{ $data->approve_plan_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Approve Plan On : </label>
                        <div class="date">{{ $data->approve_plan_on }}</div>




                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->approve_plan_comment }}</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">All CAPA Closed By : </label>
                        <div class="static">{{ $data->all_capa_closed_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">All CAPA Closed On : </label>
                        <div class="date">{{ $data->all_capa_closed_on }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->all_capa_closed_comment }}</div>
                    </div>
                </div>



                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Initiator Group">Closure Done By : </label>
                        <div class="static">{{ $data->closed_done_by }}</div>

                    </div>
                </div>

                <div class="col-lg-4 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="OOC Logged On">Closure Done On : </label>
                        <div class="date">{{ $data->closed_done_on }}</div>




                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="group-input">
                        <label for="Comment">Comment</label>
                        <div class="static">{{ $data->closed_done_comment }}</div>
                    </div>
                </div>




            </div>




            <div class="button-block">
                <button type="submit" class="saveButton">Save</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                    </a> </button>
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
        VirtualSelect.init({
            ele: '#related_records, #hod'
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
        VirtualSelect.init({
            ele: '#reference_record, #notify_to'
        });

        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'italic']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'italic']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        let referenceCount = 1;

        function addReference() {
            referenceCount++;
            let newReference = document.createElement('div');
            newReference.classList.add('row', 'reference-data-' + referenceCount);
            newReference.innerHTML = `
            <div class="col-lg-6">
                <input type="text" name="reference-text">
            </div>
            <div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div><div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div>
        `;
            let referenceContainer = document.querySelector('.reference-data');
            referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
        }
    </script>
  <script>
    var maxLength = 255;
    var textlen = maxLength - $('#docname').val().length;
    $('#rchars').text(textlen);

    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
    {{-- ====================script for record number and intir--code ===================== --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
var originalRecordNumber = document.getElementById('record').value;
var initialPlaceholder = '---';

document.getElementById('initiator_group').addEventListener('change', function() {
    var selectedValue = this.value;
    var recordNumberElement = document.getElementById('record');
    var initiatorGroupCodeElement = document.getElementById('initiator_group_code');

    // Update the initiator group code
    initiatorGroupCodeElement.value = selectedValue;

    // Update the record number by replacing the initial placeholder with the selected initiator group code
    var newRecordNumber = originalRecordNumber.replace(initialPlaceholder, selectedValue);
    recordNumberElement.value = newRecordNumber;

    // Update the original record number to keep track of changes
    originalRecordNumber = newRecordNumber;
    initialPlaceholder = selectedValue;
});
});

</script> --}}

@endsection
