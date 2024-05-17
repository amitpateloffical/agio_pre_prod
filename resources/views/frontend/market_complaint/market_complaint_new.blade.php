@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>

    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Market Complaint
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




    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">HOD/Supervisor Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Complaint Acknowledgement</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Closure</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signature</button>

            </div>

            <form action="{{ route('marketcomplaint.mcstore') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                        <input disabled type="text" name="record_number" value="">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label disabled for="Short Description">Division Code<span class="text-danger"></span></label>
                                        <input disabled type="text" name="division_code"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                            <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="group-input ">
                                        <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <p class="text-primary"> last date this record should be closed by</p>

                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date_gi"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="initiator_group_gi" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA">
                                                Corporate Quality Assurance</option>
                                            <option value="QAB">Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC">Central
                                                Quality Control</option>
                                            <option value="MANU">
                                                Manufacturing</option>
                                            <option value="PSG">Plasma
                                                Sourcing Group</option>
                                            <option value="CS">Central
                                                Stores</option>
                                            <option value="ITG">
                                                Information Technology Group</option>
                                            <option value="MM">
                                                Molecular Medicine</option>
                                            <option value="CL">
                                                Central Laboratory</option>

                                            <option value="TT">Tech
                                                team</option>
                                            <option value="QA">
                                                Quality Assurance</option>
                                            <option value="QM">
                                                Quality Management</option>
                                            <option value="IA">IT
                                                Administration</option>
                                            <option value="ACC">
                                                Accounting</option>
                                            <option value="LOG">
                                                Logistics</option>
                                            <option value="SM">
                                                Senior Management</option>
                                            <option value="BA">
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" name="initiator_group_code_gi" id="initiator_group_code"
                                            value="">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initiator Group">Initiated Through</label>
                                        <div><small class="text-primary">Please select related information</small></div>
                                        <select name="initiated_through_gi" onchange="">
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

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="If Other">If Other</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="if_other_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initiator Group">Is Repeat</label>
                                        <select name="is_repeat_gi" onchange="">
                                            <option value="0">-- select --</option>
                                            <option value="asdsa">sfs</option>
                                            <option value="asddvdsdsa">sfdsvsdvs</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Repeat Nature">Repeat Nature</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="repeat_nature_gi" id="summernote-1">

                                    </textarea>
                                    </div>
                                </div>



                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="description_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id=""></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="initial_attachment_gi[]" oninput=""
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Complainant</label>
                                        <select name="complainant_gi" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="person">person</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="OOC Logged On"> Complaint Reported On </label>

                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="complaint_reported_on_gi"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="" />
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Details Of Nature Market Complaint">Details Of Nature Market
                                            Complaint</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="details_of_nature_market_complaint_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Product Details
                                            {{-- <button type="button" id="product_details">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span> --}}
                                            <button type="button" onclick="add4Input('product_details_details')">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="product_details_details"
                                                style="width: %;">
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


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="info_product_name[]"></td>
                                                    <td><input type="text" name="info_batch_no[]"></td>
                                                    <td><input type="date" name="info_mfg_date[]"></td>
                                                    <td><input type="date" name="info_expiry_date[]"></td>
                                                    <td><input type="text" name="info_batch_size[]"></td>
                                                    <td><input type="text" name="info_pack_size[]"></td>
                                                    <td><input type="text" name="info_dispatch_quantity[]"></td>
                                                    <td><input type="text" name="info_remarks[]"></td>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#product_details').click(function(e) {
                                            function generateTableRow(serialNumber) {

                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="Product_Name[]"></td>' +
                                                    '<td><input type="text" name="Batch_No[]"></td>' +
                                                    '<td><input type="date" name="Mfg_Date[]"></td>' +
                                                    '<td><input type="date" name="Exp_Date[]"></td>' +
                                                    '<td><input type="text" name="Batch_Size[]"></td>' +
                                                    '<td><input type="text" name="Pack_Size[]"></td>' +
                                                    '<td><input type="text" name="Dispatch_Quantity[]"></td>' +
                                                    '<td><input type="text" name="Remarks[]"></td>' +


                                                    '</tr>';

                                                return html;
                                            }

                                            var tableBody = $('#product_details_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Traceability
                                            <button type="button" onclick="add4Input('traceblity')">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="traceblity" style="width: %;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">Row #</th>
                                                        <th>Product Name</th>
                                                        <th>Batch No.</th>
                                                        <th>Manufacturing Location</th>

                                                        <th>Remarks</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="product_name_tr[]"></td>
                                                    <td><input type="text" name="batch_no_tr[]"></td>
                                                    <td><input type="text" name="manufacturing_location_tr[]"></td>
                                                    <td><input type="text" name="remarks_tr[]"></td>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initiator Group">Categorization of complaint</label>
                                        <select name="categorization_of_complaint_gi" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="">Critical</option>
                                            <option value="">Major</option>
                                            <option value="">Minor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Complaint Sample">Review of Complaint Sample</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_complaint_sample_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Control Sample">Review of Control Sample</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_control_sample_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Investingation Team
                                            <button type="button" onclick="add4Input('Investing_team')">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>Product Details
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Investing_team" style="width: %;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">Row #</th>
                                                        <th>Name</th>
                                                        <th>Department</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="name_inv_tem[]"></td>
                                                    <td><input type="text" name="department_inv_tem[]"></td>
                                                    <td><input type="text" name="remarks_inv_tem[]"></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Batch manufacturing record (BMR)">Review
                                            of Batch manufacturing
                                            record (BMR)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_batch_manufacturing_record_BMR_gi" id="summernote-1">
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
                                        <textarea class="summernote" name="review_of_raw_materials_used_in_batch_manufacturing_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Batch Packing record (BPR)">Review of Batch Packing record
                                            (BPR)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_Batch_Packing_record_bpr_gi" id="summernote-1">
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
                                        <textarea class="summernote" name="review_of_packing_materials_used_in_batch_packing_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Analytical Data">Review of Analytical Data</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_analytical_data_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of training record of Concern Persons">Review of training record
                                            of Concern Persons</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_training_record_of_concern_persons_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Equipment/Instrument qualification/Calibration record">Review
                                            of Equipment/Instrument qualification/Calibration record</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="rev_eq_inst_qual_calib_record_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Equipment Break-down and Maintainance Record">Review of
                                            Equipment Break-down and Maintainance Record</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_equipment_break_down_and_maintainance_record_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Review of Past history of product">Review of Past history of
                                            product</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="review_of_past_history_of_product_gi" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Brain stroming Session/Discussion with Concered Person
                                            <button type="button" id="brain-stroming">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="brain-stroming-details"
                                                style="width: %;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">Row #</th>
                                                        <th>Possiblity</th>
                                                        <th>Facts/Controls</th>
                                                        <th>Probable Cause</th>
                                                        <th>Remarks</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    {{-- <td><input type="text" name="row[]"></td> --}}
                                                    <td><input type="text" name="possiblity_bssd[]"></td>
                                                    <td><input type="text" name="factscontrols_bssd[]"
                                                            value="Facts Available"></td>
                                                    <td><input type="text" name="probable_cause_bssd[]"></td>
                                                    <td><input type="text" name="remarks_bssd[]"></td>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <script>
                                    $(document).ready(function() {
                                        $('#brain-stroming').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="Possiblity[]"></td>' +
                                                    '<td><input type="text" name="Facts/Controls[]" value="Facts Available"></td>' +
                                                    '<td><input type="text" name="Probable_Cause[]"></td>' +
                                                    '<td><input type="text" name="Remarks[]"></td>' +
                                                    '</tr>';
                                                return html;
                                            }

                                            var tableBody = $('#brain-stroming-details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>


                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
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
                                <div class="sub-head col-12">HOD/Supervisor Review</div>



                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Conclusion">Conclusion</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="conclusion_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Root Cause Analysis">Root Cause Analysis</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="root_cause_analysis_hodsr[]" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label
                                            for="The most probable root causes identified of the complaint are as below">The
                                            most probable root causes identified of the complaint are as below</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="probable_root_causes_complaint_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment">Impact Assessment :</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="impact_assessment_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Corrective Action">Corrective Action :</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="corrective_action_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Preventive Action">Preventive Action :</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="preventive_action_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Summary and Conclusion">Summary and Conclusion</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="summary_and_conclusion_hodsr" id="summernote-1">
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Team Members
                                            <button type="button" id="team_members">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="team_members_details"
                                                style="width: %;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">Row #</th>
                                                        <th>Names</th>
                                                        <th>Department</th>
                                                        <th>Sign</th>
                                                        <th>Date</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="names_tm[]"></td>
                                                    <td><input type="text" name="department_tm[]"></td>
                                                    <td><input type="text" name="sign_tm[]"></td>
                                                    <td><input type="date" name="date_tm[]"></td>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#team_members').click(function(e) {
                                            function generateTableRow(serialNumber) {

                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="Names[]"></td>' +
                                                    '<td><input type="text" name="Department[]"></td>' +
                                                    '<td><input type="text" name="Sign[]"></td>' +
                                                    '<td><input type="date" name="Date[]"></td>' +
                                                    '</tr>';

                                                return html;
                                            }

                                            var tableBody = $('#team_members_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>



                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Report Approval
                                            <button type="button" id="report_approval">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="report_approval_details"
                                                style="width: %;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">Row #</th>
                                                        <th>Names</th>
                                                        <th>Department</th>
                                                        <th>Sign</th>
                                                        <th>Date</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="names_rrv[]"></td>
                                                    <td><input type="text" name="department_rrv[]"></td>
                                                    <td><input type="text" name="sign_rrv[]"></td>
                                                    <td><input type="date" name="date_rrv[]"></td>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    $(document).ready(function() {
                                        $('#report_approval').click(function(e) {
                                            function generateTableRow(serialNumber) {

                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="Names[]"></td>' +
                                                    '<td><input type="text" name="Department[]"></td>' +
                                                    '<td><input type="text" name="Sign[]"></td>' +
                                                    '<td><input type="date" name="Date[]"></td>' +
                                                    '</tr>';

                                                return html;
                                            }

                                            var tableBody = $('#report_approval_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id=""></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="initial_attachment_hodsr[]" oninput=""
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Comments">Comments(if Any)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote" name="comments_if_any_hodsr" id="summernote-1">
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
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">


                            <div class="sub-head">Acknowledgement</div>



                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Manufacturer name & Address">Manufacturer name & Address</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not
                                            require completion</small></div>
                                    <textarea class="summernote" name="manufacturer_name_address_ca" id="summernote-1">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Product/Material Details
                                        <button type="button" id="product_material">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="product_material_details"
                                            style="width: %;">
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


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="product_name_pmd[]"></td>
                                                <td><input type="text" name="batch_no_pmd[]"></td>
                                                <td><input type="date" name="mfg_date_pmd[]"></td>
                                                <td><input type="date" name="expiry_date_pmd[]"></td>
                                                <td><input type="text" name="batch_size_pmd[]"></td>
                                                <td><input type="text" name="pack_profile_pmd[]"></td>
                                                <td><input type="text" name="released_quantity_pmd[]"></td>
                                                <td><input type="text" name="remarks_pmd[]"></td>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#product_material').click(function(e) {
                                        function generateTableRow(serialNumber) {

                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                '"></td>' +
                                                '<td><input type="text" name="Product_Name[]"></td>' +
                                                '<td><input type="text" name="Batch_No[]"></td>' +
                                                '<td><input type="date" name="Mfg_Date[]"></td>' +
                                                '<td><input type="date" name="Exp_Date[]"></td>' +
                                                '<td><input type="text" name="Batch_Size[]"></td>' +
                                                '<td><input type="text" name="pack_profile[]"></td>' +
                                                '<td><input type="text" name="released_quantity[]"></td>' +
                                                '<td><input type="text" name="remarks[]"></td>' +


                                                '</tr>';

                                            return html;
                                        }

                                        var tableBody = $('#product_material_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Complaint Sample Required">Complaint Sample Required</label>
                                    <select name="complaint_sample_required_ca" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="">Yes</option>
                                        <option value="">No</option>
                                        <option value="">NA</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Complaint Sample Status">Complaint Sample Status</label>
                                    <input type="text" name="complaint_sample_status_ca" id="date_of_initiation">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Brief Description of complaint">Brief Description of complaint:</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="brief_description_of_complaint_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Batch Record review observation">Batch Record review
                                        observation</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="batch_record_review_observation_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Analytical Data review observation">Analytical Data review
                                        observation</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="analytical_data_review_observation_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Retention sample review observation">Retention sample review
                                        observation</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="retention_sample_review_observation_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Stablity study data review">Stablity study data review</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="stability_study_data_review_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="QMS Events(if any) review Observation">QMS Events(if any) review
                                        Observation</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="qms_events_ifany_review_observation_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Repeated complaints/queries for product">Repeated complaints/queries
                                        for product:</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="repeated_complaints_queries_for_product_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Interpretation on compalint sample">Interpretation on compalint
                                        sample(if recieved)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="interpretation_on_complaint_sample_ifrecieved_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Comments">Comments(if Any)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does
                                            not require completion</small></div>
                                    <textarea class="summernote" name="comments_ifany_ca" id="summernote-1">
                                </textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Proposal to accomplish investigation:
                            </div>
                            <div class="col-12">
                                {{-- <label for="Audit Attachments">PHASE- I B INVESTIGATION REPORT</label> --}}
                                <div class="group-input">
                                    <div class="why-why-chart">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Sr. No.</th>
                                                    <th style="width: 40%;">Requirements</th>
                                                    <th style="width: 20%;">Expected date of investigation completion
                                                    </th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="flex text-center">1</td>
                                                    <td>Complaint sample Required</td>
                                                    <td>

                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                            <textarea name="csr1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                        </div>


                                                    </td>
                                                    </td>

                                                    <td style="vertical-align: middle;">
                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                            <textarea name="csr2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                        </div>
                                                    </td>



                                                </tr>
                                                <tr>
                                                    <td class="flex text-center">2</td>
                                                    <td>Additional info. From Complainant</td>
                                                    <td>
                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                            <textarea name="afc1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                        </div>
                                    </div>
                                    </td>

                                    <td style="vertical-align: middle;">
                                        <div style="margin: auto; display: flex; justify-content: center;">
                                            <textarea name="afc2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                        </div>
                                    </td>



                                    </tr>
                                    <tr>
                                        <td class="flex text-center">3</td>
                                        <td>Analysis of complaint Sample</td>
                                        <td>
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="acs1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle;">
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="acs2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>




                                    </tr>
                                    <tr>
                                        <td class="flex text-center">4</td>
                                        <td>QRM Approach</td>
                                        <td>
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="qrm1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle;">
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="qrm2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>



                                    </tr>
                                    <tr>
                                        <td class="flex text-center">5</td>
                                        <td>Others</td>
                                        <td>
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="oth1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle;">
                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                <textarea name="oth2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                            </div>
                                        </td>



                                    </tr>

                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="group-input">
                                <label for="Inv Attachments">Initial Attachment</label>
                                <div>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id=""></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="initial_attachment_ca[]" oninput="" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
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
                            <textarea class="summernote" name="closure_comment_c" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="Inv Attachments">Initial Attachment</label>
                            <div>
                                <small class="text-primary">
                                    Please Attach all relevant or supporting documents
                                </small>
                            </div>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id=""></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="initial_attachment_c[]" oninput="" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
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


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Submit By : </label>

                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="OOC Logged On">Submit On : </label>




                        </div>
                    </div>



                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">HOD Review Completed By : </label>

                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="OOC Logged On">HOD Review Completed On :</label>




                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">QA Initial Review Completed By :</label>

                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="OOC Logged On">QA Initial Review Completed On : </label>




                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">QA Final Review Completed By : </label>

                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="OOC Logged On">QA Final Review Completed On : </label>




                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Closure Done By : </label>

                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="OOC Logged On">Closure Done On : </label>




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
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>

<script>
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
    });
    
    function setCurrentDate(item){
        if(item == 'yes'){
            $('#effect_check_date').val('{{ date('d-M-Y')}}');
        }
        else{
            $('#effect_check_date').val('');
        }
    }
</script>
@endsection
