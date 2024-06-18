<div id="CCForm13" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="sub-head">
             Approval Comment
        </div>
        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="group-input">
                    <label for="Description Deviation"> Approval Comments </label>
                    <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                    <textarea class="summernote" name="reopen_approval_comments_uaa" id="summernote-1">
                                {{ $data->reopen_approval_comments_uaa ?? '' }}
                                </textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="group-input">
                    <label for="Reference Recores">Approval Attachment</label>
                    <small class="text-primary">
                        Please Attach all relevant or supporting documents
                    </small>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="file_attach">

                            @if ($data->addendum_attachment_uaa)
                            @foreach ($data->addendum_attachment_uaa as $file)
                            <h6 type="button" class="file-container text-dark"
                                style="background-color: rgb(243, 242, 240);">
                                <b>{{ $file }}</b>
                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                        class="fa fa-eye text-primary"
                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                        class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                            </h6>
                            @endforeach
                            @endif

                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfile" name="addendum_attachment_uaa[]"
                                oninput="addMultipleFiles(this, 'file_attach')" multiple>
                        </div>
                    </div>
                </div>
            </div>


            <div class="button-block">
                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                        Exit </a> </button>
            </div>
        </div>
    </div>

</div>