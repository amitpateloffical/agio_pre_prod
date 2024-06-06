@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        function openTab(tabName, ele) {
            let buttons = document.querySelector('.process-groups').children;
            let tables = document.querySelector('.process-tables-list').children;
            for (let element of Array.from(buttons)) {
                element.classList.remove('active');
            }
            ele.classList.add('active')
            for (let element of Array.from(tables)) {
                element.classList.remove('active');
                if (element.getAttribute('id') === tabName) {
                    element.classList.add('active');
                }
            }
        }
    </script>

    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .filter-sub {
            display: flex;
            gap: 16px;
            margin-left: 13px
        }
    </style>
    <style>
        .filter-bar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .filter-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .table-responsive {
            height: 100vh;
            overflow-x: scroll;

        }

        .filter-item label {
            margin-right: 10px;
        }

        table {
            overflow: scroll
        }
    </style>
    <div id="rcms-desktop">

        <div class="process-groups">
            <div class="active" onclick="openTab('internal-audit', this)">Market Complaint Log </div>
        </div>
        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list">
                    <div class="process-table active" id="internal-audit">
                        <div class="mt-1 mb-2 bg-white " style="height: 65px">
                            <div class="d-flex align-items-center">
                                <div class="scope-bar ml-3">
                                    <button style="width: 70px;margin-left:5px"
                                        class="print-btn btn btn-primary">Print</button>
                                </div>
                                <div class="flex-grow-2" style="margin-left:-50px; margin-bottom:12px">
                                    <div class="filter-bar d-flex justify-content-between">
                                        <div class="filter-item">
                                            <label for="process">Department</label>
                                            <select class="custom-select" id="process">
                                                <option value="all">All Records</option>

                                            </select>
                                        </div>
                                        <div class="filter-item">
                                            <label for="criteria">Division</label>
                                            <select class="custom-select" id="criteria">
                                                <option value="all">All Records</option>

                                            </select>
                                        </div>
                                        <div class="filter-item">
                                            <label for="division">Date From</label>
                                            <select class="custom-select" id="division">
                                                <option value="all">All Records</option>

                                            </select>
                                        </div>
                                        <div class="filter-item">
                                            <label for="originator">Date To</label>
                                            <select class="custom-select" id="originator">
                                                <option value="all">All Records</option>

                                            </select>
                                        </div> 
                                        <div class="filter-item">
                                            <label for="originator">Nature of complaint</label>
                                            <select class="custom-select" id="originator">
                                                <option value="all">All Records</option>

                                            </select>
                                        </div>
                                        <div class="filter-item">
                                            <label for="datewise">Select Period</label>
                                            <select class="custom-select" id="datewise">
                                                <option value="all">Select</option>
                                                <option value="all">Yearly</option>
                                                <option value="all">Quarterly</option>
                                                <option value="all">Mothly</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-block">
                            <div class="table-responsive" style="height: 300px">
                                <table class="table table-bordered" style="width: 120%;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Sr. No.</th>
                                            <th rowspan="2">Date of Initiation</th>
                                            <th rowspan="2">Complaint No.</th>
                                            <th rowspan="2">Description of Complaint</th>
                                            <th rowspan="2">Originator</th>
                                            <th rowspan="2">Department</th>
                                            <th rowspan="2">Division</th>
                                            <th colspan="4" style="text-align: center">Product Details</th>
                                            <th rowspan="2">Nature of complaint</th>
                                            <th rowspan="2">Category of complaint</th>
                                            <th rowspan="2">Response / Report (Date)</th>
                                            <th rowspan="2">Due Date</th>
                                            <th rowspan="2">Clouser Date</th>
                                            <th rowspan="2">Status</th>
                                        </tr>
                                        <tr>
                                            <th>Product Name & strength</th>
                                            <th>Batch No.</th>
                                            <th>Mfg. Date</th>
                                            <th>Exp. Date</th>
                                        </tr>
                                        
                                    </thead>
                                            

                                    <tbody>
                                        

                                        @foreach ($marketcomplaint as $marketlog)
                                            
                                        <tr>
                                            
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$marketlog->intiation_date}}</td>
                                            <td>{{ Helpers::getDivisionName($marketlog->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($marketlog->record, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $marketlog->description_gi }}</td>
                                            <td>{{ Auth::user()->name }}</td>
                                            <td>{{ $marketlog->initiator_group}}</td>
                                            <td>{{Helpers::getDivisionName(session()->get('division'))}}</td>
                                            <td>grid</td>
                                            <td>grid</td>
                                            <td>grid</td>
                                            <td>grid</td>
                                            <td>{{$marketlog->details_of_nature_market_complaint_gi}}</td>
                                            <td>{{$marketlog->categorization_of_complaint_gi}}</td>
                                            <td>{{$marketlog->complaint_reported_on_gi}}</td>
                                            <td>{{$marketlog->due_date_gi}}</td>
                                            <td>{{$marketlog->closed_done_on}}</td>
                                            <td>{{$marketlog->status}}</td>
                                        </tr>
                                        
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#capa_related_record ,#classRoom_training'
        });
    </script>
@endsection
