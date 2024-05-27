<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\RecordNumber;
use App\Models\incidentGrid;
use App\Models\incidentCft;
use App\Models\incidentAuditTrail;
use App\Models\incidentNewGridData;
use App\Models\incidentGridQrms;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\LaunchExtension;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Helpers;
use Illuminate\Pagination\Paginator;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;



class IncidentController extends Controller
{
    public function incidentIndex(Request $request)
    {
        $old_record = Incident::select('id', 'incident_id', 'record')->get();
        // $record_number = (RecordNumber::first()->value('counter')) + 1;
        // $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $pre = Incident::all();
        return response()->view('frontend.incident.incident_new', compact('formattedDate', 'due_date', 'old_record', 'pre'));

    }

    public function store(Request $request)
    {
        //  dd($request->all());
        $form_progress = null;

        if ($request->form_name == 'general')
        {
            $validator = Validator::make($request->all(), [
                'Initiator_Group' => 'required',
                'short_description' => 'required'

            ], [
                'Initiator_Group.required' => 'Department field required!',
                'short_description_required.required' => 'Nature of repeat field required!'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'general';
            }
        }

        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }

        $incident = new Incident();
        $incident->form_type = "Incident";

        $incident->record = ((RecordNumber::first()->value('counter')) + 1);
        $incident->initiator_id = Auth::user()->id;

        $incident->form_progress = isset($form_progress) ? $form_progress : null;

        # -------------new-----------
        //  $incident->record_number = $request->record_number;
        $incident->division_id = $request->division_id;
        $incident->assign_to = $request->assign_to;
        $incident->Facility = $request->Facility;
        $incident->due_date = $request->due_date;
        $incident->intiation_date = $request->intiation_date;
        $incident->Initiator_Group = $request->Initiator_Group;
        $incident->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
        $incident->initiator_group_code = $request->initiator_group_code;
        $incident->short_description = $request->short_description;
        $incident->incident_date = $request->incident_date;
        $incident->incident_time = $request->incident_time;
        $incident->incident_reported_date = $request->incident_reported_date;
        if (is_array($request->audit_type)) {
            $incident->audit_type = implode(',', $request->audit_type);
        }
        $incident->short_description_required = $request->short_description_required;
        $incident->nature_of_repeat = $request->nature_of_repeat;
        $incident->others = $request->others;

        $incident->Product_Batch = $request->Product_Batch;

        $incident->Description_incident =  $request->Description_incident;
        $incident->Immediate_Action = implode(',', $request->Immediate_Action);
        $incident->Preliminary_Impact = implode(',', $request->Preliminary_Impact);
        $incident->Product_Details_Required = $request->Product_Details_Required;

        $incident->HOD_Remarks = $request->HOD_Remarks;
        $incident->incident_category = $request->incident_category;
        if($request->incident_category=='')
        $incident->Justification_for_categorization = $request->Justification_for_categorization;
        $incident->Investigation_required = $request->Investigation_required;
        $incident->capa_required = $request->capa_required;
        $incident->qrm_required = $request->qrm_required;

        $incident->Investigation_Details = $request->Investigation_Details;
        $incident->Customer_notification = $request->Customer_notification;
        $incident->customers = $request->customers;
        $incident->QAInitialRemark = $request->QAInitialRemark;

        $incident->Investigation_Summary = $request->Investigation_Summary;
        $incident->Impact_assessment = $request->Impact_assessment;
        $incident->Root_cause = $request->Root_cause;
        $incident->CAPA_Rquired = $request->CAPA_Rquired;
        $incident->capa_type = $request->capa_type;
        $incident->CAPA_Description = $request->CAPA_Description;
        $incident->Post_Categorization = $request->Post_Categorization;
        $incident->Investigation_Of_Review = $request->Investigation_Of_Review;
        $incident->QA_Feedbacks = $request->QA_Feedbacks;
        $incident->Closure_Comments = $request->Closure_Comments;
        $incident->Disposition_Batch = $request->Disposition_Batch;
        $incident->Facility_Equipment = $request->Facility_Equipment;
        $incident->Document_Details_Required = $request->Document_Details_Required;
      
        if ($request->incident_category == 'major' || $request->incident_category == 'minor' || $request->incident_category == 'critical') {
            $list = Helpers::getHeadoperationsUserList();
                    foreach ($list as $u) {
                        if ($u->q_m_s_divisions_id == $incident->division_id) {
                            $email = Helpers::getInitiatorEmail($u->user_id);
                            if ($email !== null) {
                                 // Add this if statement
                                try {
                                    Mail::send(
                                        'mail.Categorymail',
                                        ['data' => $incident],
                                        function ($message) use ($email) {
                                            $message->to($email)
                                                ->subject("Activity Performed By " . Auth::user()->name);
                                        }
                                    );
                                } catch (\Exception $e) {
                                    //log error
                                }

                            }
                        }
                    }
                }


                if ($request->incident_category == 'major' || $request->incident_category == 'minor' || $request->incident_category == 'critical') {
                    $list = Helpers::getCEOUserList();
                            foreach ($list as $u) {
                                if ($u->q_m_s_divisions_id == $incident->division_id) {
                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                    if ($email !== null) {
                                         // Add this if statement
                                         try {
                                                Mail::send(
                                                    'mail.Categorymail',
                                                    ['data' => $incident],
                                                    function ($message) use ($email) {
                                                        $message->to($email)
                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                    }
                                                );
                                            } catch (\Exception $e) {
                                                //log error
                                            }

                                    }
                                }
                            }
                        }
                        if ($request->incident_category == 'major' || $request->incident_category == 'minor' || $request->incident_category == 'critical') {
                            $list = Helpers::getCorporateEHSHeadUserList();
                                    foreach ($list as $u) {
                                        if ($u->q_m_s_divisions_id == $incident->division_id) {
                                            $email = Helpers::getInitiatorEmail($u->user_id);
                                            if ($email !== null) {
                                                 // Add this if statement
                                                 try {
                                                        Mail::send(
                                                            'mail.Categorymail',
                                                            ['data' => $incident],
                                                            function ($message) use ($email) {
                                                                $message->to($email)
                                                                    ->subject("Activity Performed By " . Auth::user()->name);
                                                            }
                                                        );
                                                    } catch (\Exception $e) {
                                                        //log error
                                                    }

                                            }
                                        }
                                    }
                                }

                                if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                    $list = Helpers::getHeadoperationsUserList();
                                            foreach ($list as $u) {
                                                if ($u->q_m_s_divisions_id == $incident->division_id) {
                                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                                    if ($email !== null) {
                                                         // Add this if statement
                                                         try {
                                                            Mail::send(
                                                                'mail.Categorymail',
                                                                ['data' => $incident],
                                                                function ($message) use ($email) {
                                                                    $message->to($email)
                                                                        ->subject("Activity Performed By " . Auth::user()->name);
                                                                }
                                                            );
                                                        } catch (\Exception $e) {
                                                            //log error
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                        if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                            $list = Helpers::getCEOUserList();
                                                    foreach ($list as $u) {
                                                        if ($u->q_m_s_divisions_id == $incident->division_id) {
                                                            $email = Helpers::getInitiatorEmail($u->user_id);
                                                            if ($email !== null) {
                                                                 // Add this if statement
                                                                 try {
                                                                        Mail::send(
                                                                            'mail.Categorymail',
                                                                            ['data' => $incident],
                                                                            function ($message) use ($email) {
                                                                                $message->to($email)
                                                                                    ->subject("Activity Performed By " . Auth::user()->name);
                                                                            }
                                                                        );
                                                                    } catch (\Exception $e) {
                                                                        //log error
                                                                    }

                                                            }
                                                        }
                                                    }
                                                }
                                                if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                                    $list = Helpers::getCorporateEHSHeadUserList();
                                                            foreach ($list as $u) {
                                                                if ($u->q_m_s_divisions_id == $incident->division_id) {
                                                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                                                    if ($email !== null) {
                                                                         // Add this if statement
                                                                         try {
                                                                                Mail::send(
                                                                                    'mail.Categorymail',
                                                                                    ['data' => $incident],
                                                                                    function ($message) use ($email) {
                                                                                        $message->to($email)
                                                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                                                    }
                                                                                );
                                                                            } catch (\Exception $e) {
                                                                                //log error
                                                                            }

                                                                    }
                                                                }
                                                            }
                                                        }

        if (!empty ($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Audit_file = json_encode($files);
        }
        if (!empty ($request->initial_file)) {
            $files = [];
            if ($request->hasfile('initial_file')) {
                foreach ($request->file('initial_file') as $file) {
                    $name = $request->name . 'initial_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->initial_file = json_encode($files);
        }
        //dd($request->Initial_attachment);
        if (!empty ($request->Initial_attachment)) {
            $files = [];
            if ($request->hasfile('Initial_attachment')) {
                foreach ($request->file('Initial_attachment') as $file) {
                    $name = $request->name . 'Initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Initial_attachment = json_encode($files);
        }

        if (!empty ($request->QA_attachment)) {
            $files = [];
            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->QA_attachment = json_encode($files);
        }
        if (!empty ($request->Investigation_attachment)) {
            $files = [];
            if ($request->hasfile('Investigation_attachment')) {
                foreach ($request->file('Investigation_attachment') as $file) {
                    $name = $request->name . 'Investigation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Investigation_attachment = json_encode($files);
        }
        if (!empty ($request->Capa_attachment)) {
            $files = [];
            if ($request->hasfile('Capa_attachment')) {
                foreach ($request->file('Capa_attachment') as $file) {
                    $name = $request->name . 'Capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Capa_attachment = json_encode($files);
        }

        if (!empty ($request->QA_attachments)) {
            $files = [];
            if ($request->hasfile('QA_attachments')) {
                foreach ($request->file('QA_attachments') as $file) {
                    $name = $request->name . 'QA_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->QA_attachments = json_encode($files);
        }

        if (!empty ($request->closure_attachment)) {
            $files = [];
            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->closure_attachment = json_encode($files);
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $incident->status = 'Opened';
        $incident->stage = 1;

        $incident->save();

        $data3 = new incidentGrid();
        $data3->incident_grid_id = $incident->id;
        $data3->type = "incident";
        if (!empty($request->facility_name)) {
            $data3->facility_name = serialize($request->facility_name);
        }
        if (!empty($request->IDnumber)) {
            $data3->IDnumber = serialize($request->IDnumber);
        }

        if (!empty($request->Remarks)) {
            $data3->Remarks = serialize($request->Remarks);
        }
        $data3->save();
        $data4 = new incidentGrid();
        $data4->incident_grid_id = $incident->id;
        $data4->type = "Document ";
        if (!empty($request->Number)) {
            $data4->Number = serialize($request->Number);
        }
        if (!empty($request->ReferenceDocumentName)) {
            $data4->ReferenceDocumentName = serialize($request->ReferenceDocumentName);
        }

        if (!empty($request->Document_Remarks)) {
            $data4->Document_Remarks = serialize($request->Document_Remarks);
        }
        $data4->save();

        $data5 = new incidentGrid();
        $data5->incident_grid_id = $incident->id;
        $data5->type = "Product ";
        // if (!empty($request->product_name)) {
        //     $data5->product_name = serialize($request->product_name);
        // }
        // if (!empty($request->product_stage)) {
        //     $data5->product_stage = serialize($request->product_stage);
        // }

        // if (!empty($request->batch_no)) {
        //     $data5->batch_no = serialize($request->batch_no);
        // }
        $data5->save();



        // $Cft = new incidentCft();
        // $Cft->incident_id = $incident->id;
        // $Cft->Production_Review = $request->Production_Review;
        // $Cft->Production_person = $request->Production_person;
        // $Cft->Production_assessment = $request->Production_assessment;
        // $Cft->Production_feedback = $request->Production_feedback;
        // $Cft->production_on = $request->production_on;
        // $Cft->production_by = $request->production_by;

        // $Cft->Warehouse_review = $request->Warehouse_review;
        // $Cft->Warehouse_notification = $request->Warehouse_notification;
        // $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        // $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        // $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        // $Cft->Warehouse_on = $request->Warehouse_on;

        // $Cft->Quality_review = $request->Quality_review;
        // $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        // $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        // $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        // $Cft->Quality_Control_by = $request->Quality_Control_by;
        // $Cft->Quality_Control_on = $request->Quality_Control_on;

        // $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        // $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        // $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        // $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        // $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        // $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        // $Cft->Engineering_review = $request->Engineering_review;
        // $Cft->Engineering_person = $request->Engineering_person;
        // $Cft->Engineering_assessment = $request->Engineering_assessment;
        // $Cft->Engineering_feedback = $request->Engineering_feedback;
        // $Cft->Engineering_by = $request->Engineering_by;
        // $Cft->Engineering_on = $request->Engineering_on;

        // $Cft->Analytical_Development_review = $request->Analytical_Development_review;
        // $Cft->Analytical_Development_person = $request->Analytical_Development_person;
        // $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
        // $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
        // $Cft->Analytical_Development_by = $request->Analytical_Development_by;
        // $Cft->Analytical_Development_on = $request->Analytical_Development_on;

        // $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
        // $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
        // $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
        // $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
        // $Cft->Kilo_Lab_attachment_by = $request->Kilo_Lab_attachment_by;
        // $Cft->Kilo_Lab_attachment_on = $request->Kilo_Lab_attachment_on;

        // $Cft->Technology_transfer_review = $request->Technology_transfer_review;
        // $Cft->Technology_transfer_person = $request->Technology_transfer_person;
        // $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
        // $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
        // $Cft->Technology_transfer_by = $request->Technology_transfer_by;
        // $Cft->Technology_transfer_on = $request->Technology_transfer_on;

        // $Cft->Environment_Health_review = $request->Environment_Health_review;
        // $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        // $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        // $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        // $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        // $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        // $Cft->Human_Resource_review = $request->Human_Resource_review;
        // $Cft->Human_Resource_person = $request->Human_Resource_person;
        // $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        // $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        // $Cft->Human_Resource_by = $request->Human_Resource_by;
        // $Cft->Human_Resource_on = $request->Human_Resource_on;

        // $Cft->Information_Technology_review = $request->Information_Technology_review;
        // $Cft->Information_Technology_person = $request->Information_Technology_person;
        // $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        // $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        // $Cft->Information_Technology_by = $request->Information_Technology_by;
        // $Cft->Information_Technology_on = $request->Information_Technology_on;

        // $Cft->Project_management_review = $request->Project_management_review;
        // $Cft->Project_management_person = $request->Project_management_person;
        // $Cft->Project_management_assessment = $request->Project_management_assessment;
        // $Cft->Project_management_feedback = $request->Project_management_feedback;
        // $Cft->Project_management_by = $request->Project_management_by;
        // $Cft->Project_management_on = $request->Project_management_on;

        // $Cft->Other1_review = $request->Other1_review;
        // $Cft->Other1_person = $request->Other1_person;
        // $Cft->Other1_Department_person = $request->Other1_Department_person;
        // $Cft->Other1_assessment = $request->Other1_assessment;
        // $Cft->Other1_feedback = $request->Other1_feedback;
        // $Cft->Other1_by = $request->Other1_by;
        // $Cft->Other1_on = $request->Other1_on;

        // $Cft->Other2_review = $request->Other2_review;
        // $Cft->Other2_person = $request->Other2_person;
        // $Cft->Other2_Department_person = $request->Other2_Department_person;
        // $Cft->Other2_Assessment = $request->Other2_Assessment;
        // $Cft->Other2_feedback = $request->Other2_feedback;
        // $Cft->Other2_by = $request->Other2_by;
        // $Cft->Other2_on = $request->Other2_on;

        // $Cft->Other3_review = $request->Other3_review;
        // $Cft->Other3_person = $request->Other3_person;
        // $Cft->Other3_Department_person = $request->Other3_Department_person;
        // $Cft->Other3_Assessment = $request->Other3_Assessment;
        // $Cft->Other3_feedback = $request->Other3_feedback;
        // $Cft->Other3_by = $request->Other3_by;
        // $Cft->Other3_on = $request->Other3_on;

        // $Cft->Other4_review = $request->Other4_review;
        // $Cft->Other4_person = $request->Other4_person;
        // $Cft->Other4_Department_person = $request->Other4_Department_person;
        // $Cft->Other4_Assessment = $request->Other4_Assessment;
        // $Cft->Other4_feedback = $request->Other4_feedback;
        // $Cft->Other4_by = $request->Other4_by;
        // $Cft->Other4_on = $request->Other4_on;

        // $Cft->Other5_review = $request->Other5_review;
        // $Cft->Other5_person = $request->Other5_person;
        // $Cft->Other5_Department_person = $request->Other5_Department_person;
        // $Cft->Other5_Assessment = $request->Other5_Assessment;
        // $Cft->Other5_feedback = $request->Other5_feedback;
        // $Cft->Other5_by = $request->Other5_by;
        // $Cft->Other5_on = $request->Other5_on;

        // if (!empty ($request->production_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('production_attachment')) {
        //         foreach ($request->file('production_attachment') as $file) {
        //             $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->production_attachment = json_encode($files);
        // }
        // if (!empty ($request->Warehouse_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Warehouse_attachment')) {
        //         foreach ($request->file('Warehouse_attachment') as $file) {
        //             $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Warehouse_attachment = json_encode($files);
        // }
        // if (!empty ($request->Quality_Control_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Quality_Control_attachment')) {
        //         foreach ($request->file('Quality_Control_attachment') as $file) {
        //             $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Quality_Control_attachment = json_encode($files);
        // }
        // if (!empty ($request->Quality_Assurance_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Quality_Assurance_attachment')) {
        //         foreach ($request->file('Quality_Assurance_attachment') as $file) {
        //             $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Quality_Assurance_attachment = json_encode($files);
        // }
        // if (!empty ($request->Engineering_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Engineering_attachment')) {
        //         foreach ($request->file('Engineering_attachment') as $file) {
        //             $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Engineering_attachment = json_encode($files);
        // }
        // if (!empty ($request->Analytical_Development_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Analytical_Development_attachment')) {
        //         foreach ($request->file('Analytical_Development_attachment') as $file) {
        //             $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Analytical_Development_attachment = json_encode($files);
        // }
        // if (!empty ($request->Kilo_Lab_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Kilo_Lab_attachment')) {
        //         foreach ($request->file('Kilo_Lab_attachment') as $file) {
        //             $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Kilo_Lab_attachment = json_encode($files);
        // }
        // if (!empty ($request->Technology_transfer_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Technology_transfer_attachment')) {
        //         foreach ($request->file('Technology_transfer_attachment') as $file) {
        //             $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Technology_transfer_attachment = json_encode($files);
        // }
        // if (!empty ($request->Environment_Health_Safety_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Environment_Health_Safety_attachment')) {
        //         foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
        //             $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Environment_Health_Safety_attachment = json_encode($files);
        // }
        // if (!empty ($request->Human_Resource_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Human_Resource_attachment')) {
        //         foreach ($request->file('Human_Resource_attachment') as $file) {
        //             $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Human_Resource_attachment = json_encode($files);
        // }
        // if (!empty ($request->Information_Technology_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Information_Technology_attachment')) {
        //         foreach ($request->file('Information_Technology_attachment') as $file) {
        //             $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Information_Technology_attachment = json_encode($files);
        // }
        // if (!empty ($request->Project_management_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Project_management_attachment')) {
        //         foreach ($request->file('Project_management_attachment') as $file) {
        //             $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Project_management_attachment = json_encode($files);
        // }
        // if (!empty ($request->Other1_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Other1_attachment')) {
        //         foreach ($request->file('Other1_attachment') as $file) {
        //             $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Other1_attachment = json_encode($files);
        // }
        // if (!empty ($request->Other2_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Other2_attachment')) {
        //         foreach ($request->file('Other2_attachment') as $file) {
        //             $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Other2_attachment = json_encode($files);
        // }
        // if (!empty ($request->Other3_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Other3_attachment')) {
        //         foreach ($request->file('Other3_attachment') as $file) {
        //             $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Other3_attachment = json_encode($files);
        // }
        // if (!empty ($request->Other4_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Other4_attachment')) {
        //         foreach ($request->file('Other4_attachment') as $file) {
        //             $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Other4_attachment = json_encode($files);
        // }
        // if (!empty ($request->Other5_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Other5_attachment')) {
        //         foreach ($request->file('Other5_attachment') as $file) {
        //             $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $Cft->Other5_attachment = json_encode($files);
        // }

        // $Cft->save();

            $history = new incidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = Auth::user()->name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new incidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $incident->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new incidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Carbon::now()->format('d-M-Y');
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

        if (!empty ($request->short_description)){
            $history = new incidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $incident->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->Initiator_Group)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Department';
            $history->previous = "Null";
            $history->current = $incident->Initiator_Group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->incident_date)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'incident Observed';
            $history->previous = "Null";
            $history->current = $incident->incident_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (is_array($request->Facility) && $request->Facility[0] !== null){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Observed by';
            $history->previous = "Null";
            $history->current = $incident->Facility;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->incident_reported_date)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'incident Reported on';
            $history->previous = "Null";
            $history->current = $incident->incident_reported_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->audit_type[0] !== null){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'incident Related To';
            $history->previous = "Null";
            $history->current = $incident->audit_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->others)){
            $history = new IncidentAuditTrail();
            $history->incdent_id = $incident->id;
            $history->activity_type = 'Others';
            $history->previous = "Null";
            $history->current = $incident->others;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->action_name = 'Create';
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->save();
        }
        if (!empty ($request->Facility_Equipment)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Facility/ Equipment/ Instrument/ System Details Required?';
            $history->previous = "Null";
            $history->current = $incident->Facility_Equipment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Document_Details_Required)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Document Details Required';
            $history->previous = "Null";
            $history->current = $incident->Document_Details_Required;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Product_Batch)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Name of Product & Batch No';
            $history->previous = "Null";
            $history->current = $incident->Product_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($request->Description_incident)){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Description of incident';
            $history->previous = "Null";
            $history->current = $incident->Description_incident;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->Immediate_Action[0] !== null){
            $history = new incidentAuditTrail();
        $history->incident_id = $incident->id;
        $history->activity_type = 'Immediate Action (if any)';
        $history->previous = "Null";
        $history->current = $incident->Immediate_Action;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->change_to =   "Opened";
            $history->change_from = "Initiator";
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $incident->status;
        $history->action_name = 'Create';
        $history->save();
        }
        if ($request->Preliminary_Impact[0] !== null){
            $history = new IncidentAuditTrail();
            $history->incident_id = $incident->id;
            $history->activity_type = 'Preliminary Impact of incident';
            $history->previous = "Null";
            $history->current = $incident->Preliminary_Impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $incident->status;
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function incidentShow($id)
    {
        $old_record = Incident::select('id', 'division_id', 'record')->get();
        $data = Incident::find($id);
        $userData = User::all();
        $data1 = incidentCft::where('incident_id', $id)->latest()->first();
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $grid_data = IncidentGrid::where('incident_id', $id)->where('type', "Incident")->first();
        $grid_data1 = IncidentGrid::where('incident_id', $id)->where('type', "Document")->first();
        $grid_data2 = IncidentGrid::where('incident_id', $id)->where('type', "Product")->first();
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        // dd($data->initiator_id);
        $pre = Incident::all();
        $divisionName = DB::table('q_m_s_divisions')->where('id', $data->division_id)->value('name');
        $incidentNewGrid = incidentNewGridData::where('incident_id', $id)->latest()->first();

        $investigation_data = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'investication'])->first();
        $root_cause_data = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'rootCause'])->first();
        $why_data = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'why'])->first();
        $fishbone_data = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'fishbone'])->first();

        $grid_data_qrms = incidentGridQrms::where(['incident_id' => $id, 'identifier' => 'failure_mode_qrms'])->first();
        $grid_data_matrix_qrms = incidentGridQrms::where(['incident_id' => $id, 'identifier' => 'matrix_qrms'])->first();

        $capaExtension = LaunchExtension::where(['incident_id' => $id, "extension_identifier" => "Capa"])->first();
        $qrmExtension = LaunchExtension::where(['incident_id' => $id, "extension_identifier" => "QRM"])->first();
        $investigationExtension = LaunchExtension::where(['incident_id' => $id, "extension_identifier" => "Investigation"])->first();
        $incidentExtension = LaunchExtension::where(['incident_id' => $id, "extension_identifier" => "Incident"])->first();

        return view('frontend.incident.incident_view', compact('data','userData', 'grid_data_qrms','grid_data_matrix_qrms', 'capaExtension','qrmExtension','investigationExtension','incidentExtension', 'old_record', 'pre', 'data1', 'divisionName','grid_data','grid_data1', 'incidentNewGrid','grid_data2','investigation_data','root_cause_data', 'why_data', 'fishbone_data'));    
    }

    public function update(Request $request, $id)
    {
        $form_progress = null;
        
        $lastIncident = Incident::find($id);
        $incident = Incident::find($id);
        $incident->Delay_Justification = $request->Delay_Justification;

        if ($request->incident_category == 'major' || $request->incident_category == 'critical')
        {
            $incident->Investigation_required = "yes";
            $incident->capa_required = "yes";
            $incident->qrm_required = "yes";
        }

        if ($request->incident_category == 'minor')
        {
            $incident->Investigation_required = $request->Investigation_required;
            $incident->capa_required = $request->capa_required;
            $incident->qrm_required = $request->qrm_required;
        }

        if ($request->form_name == 'general-open')
        {

            // dd($request->Delay_Justification);
            $validator = Validator::make($request->all(), [
                'Initiator_Group' => 'required',
                'short_description' => 'required',
                'short_description_required' => 'required|in:Recurring,Non_Recurring',
                'nature_of_repeat' => 'required_if:short_description_required,Recurring',
                'incident_date' => 'required',
                'incident_time' => 'required',
                'incident_reported_date' => 'required',
                'Delay_Justification' => [
                    function ($attribute, $value, $fail) use ($request) {
                        $incident_date = Carbon::parse($request->incident_date);
                        $reported_date = Carbon::parse($request->incident_reported_date);
                        $diff_in_days = $reported_date->diffInDays($incident_date);
                        if ($diff_in_days !== 0) {
                            if(!$request->Delay_Justification){
                                $fail('The Delay Justification is required!');
                            }
                        }
                    },
                ],
                'audit_type' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail($attribute.' must not contain only null values.');
                        }
                    },
                ],
                'Facility_Equipment' => 'required|in:yes,no',
                'facility_name' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Facility_Equipment') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Facility name is required when Facility Equipment is yes.');
                        }
                    },
                ],
                'IDnumber' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Facility_Equipment') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The ID Number field is required when Facility Equipment is yes.');
                        }
                    },
                ],
                'Document_Details_Required' => 'required|in:yes,no',
                'Product_Details_Required' => 'required|in:yes,no',
                'Number' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Document_Details_Required') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Document Number field is required when Document Details Required is yes.');
                        }
                    },
                ],
                'ReferenceDocumentName' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Document_Details_Required') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Referrence Document Number field is required when Document Details Required is yes.');
                        }
                    },
                ],
                // 'Description_incident' => [
                //     'required',
                //     'array',
                //     function($attribute, $value, $fail) {
                //         if (count($value) === 1 && reset($value) === null) {
                //             return $fail('Description of incident must not be empty!.');
                //         }
                //     },
                // ],
                'Immediate_Action' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Immediate Action field must not be empty!.');
                        }
                    },
                ],
                'Preliminary_Impact' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Preliminary Impact field must not be empty!.');
                        }
                    },
                ],
            ], [
                'short_description_required.required' => 'Nature of Repeat required!',
                'nature_of_repeat.required' =>  'The nature of repeat field is required when nature of repeat is Recurring.',
                'audit_type' => 'Incident related to field required!'
            ]);

            $validator->sometimes('others', 'required|string|min:1', function ($input) {
                return in_array('Anyother(specify)', explode(',', $input->audit_type[0]));
            });

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'general-open';
            }
        }
        if ($request->form_name == 'qa')
        {
            $validator = Validator::make($request->all(), [
                'incident_category' => 'required|not_in:0',
                'Justification_for_categorization' => 'required',

                // 'Investigation_required' => 'required|in:yes,no|not_in:0',
                // 'capa_required' => 'required|in:yes,no|not_in:0',
                // 'qrm_required' => 'required|in:yes,no|not_in:0',
                'Investigation_Details' => 'required_if:Investigation_required,yes',
                'QAInitialRemark' => 'required'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'qa';
            }
        }

        if ($request->form_name == 'capa')
        {

            // ============ capa ======================
        if ($request->form_name == 'capa')
        {
            if($request->source_doc!=""){
                $incident->capa_number = $request->capa_number ? $request->capa_number : $incident->capa_number;
                $incident->department_capa = $request->department_capa ? $request->department_capa : $incident->department_capa;
                $incident->source_of_capa = $request->source_of_capa ? $request->source_of_capa : $incident->source_of_capa;
                $incident->capa_others = $request->capa_others ? $request->capa_others : $incident->capa_others;
                $incident->source_doc = $request->source_doc ? $request->source_doc : $incident->source_doc;
                $incident->Description_of_Discrepancy = $request->Description_of_Discrepancy ? $request->Description_of_Discrepancy : $incident->Description_of_Discrepancy;
                $incident->capa_root_cause = $request->capa_root_cause ? $request->capa_root_cause : $incident->capa_root_cause;
                $incident->Immediate_Action_Take = $request->Immediate_Action_Take ? $request->Immediate_Action_Take : $incident->Immediate_Action_Take;
                $incident->Corrective_Action_Details = $request->Corrective_Action_Details ? $request->Corrective_Action_Details : $incident->Corrective_Action_Details;
                $incident->Preventive_Action_Details = $request->Preventive_Action_Details ? $request->Preventive_Action_Details : $incident->Preventive_Action_Details;
                $incident->capa_completed_date = $request->capa_completed_date ? $request->capa_completed_date : $incident->capa_completed_date;
                $incident->Interim_Control = $request->Interim_Control ? $request->Interim_Control : $incident->Interim_Control;
                $incident->Corrective_Action_Taken = $request->Corrective_Action_Taken ? $request->Corrective_Action_Taken : $incident->Corrective_Action_Taken;
                $incident->Preventive_action_Taken = $request->Preventive_action_Taken ? $request->Preventive_action_Taken : $incident->Preventive_action_Taken;
                $incident->CAPA_Closure_Comments = $request->CAPA_Closure_Comments ? $request->CAPA_Closure_Comments : $incident->CAPA_Closure_Comments;

                 if (!empty ($request->CAPA_Closure_attachment)) {
                    $files = [];
                    if ($request->hasfile('CAPA_Closure_attachment')) {

                        foreach ($request->file('CAPA_Closure_attachment') as $file) {
                            $name = 'capa_closure_attachment-' . time() . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $incident->CAPA_Closure_attachment = json_encode($files);

                }
                $incident->update();
                toastr()->success('Document Sent');
                return back();
                }


                $validator = Validator::make($request->all(), [
                    'capa_root_cause' => 'required',
                    'CAPA_Rquired' => 'required|in:yes,no|not_in:0',
                    'Post_Categorization' => 'required',
                    'capa_type' => [
                        'required_if:CAPA_Rquired,yes',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value === '0' && $request->CAPA_Rquired == 'yes') {
                                $fail('The capa type field is required when CAPA required is set to yes.');
                            }
                        }
                    ],
                    'CAPA_Description' => 'required_if:CAPA_Rquired,yes',
                ],  [
                    'CAPA_Rquired.required' => 'Capa required field cannot be empty!',
                ]);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $form_progress = 'capa';
                }

            }



        }

        if ($request->form_name == 'qa-final')
        {
            $form_progress = 'capa';
        }

        if ($request->form_name == 'qah')
        {
            $validator = Validator::make($request->all(), [
                'Closure_Comments' => 'required',
                'Disposition_Batch' => 'required',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'qah';
            }
        }

        $incident->assign_to = $request->assign_to;
        $incident->Initiator_Group = $request->Initiator_Group;

        if ($incident->stage < 3) {
            $incident->short_description = $request->short_description;
        } else {
            $incident->short_description = $incident->short_description;
        }
        $incident->initiator_group_code = $request->initiator_group_code;
        $incident->incident_reported_date = $request->incident_reported_date;
        $incident->incident_date = $request->incident_date;
        $incident->incident_time = $request->incident_time;
        $incident->Delay_Justification = $request->Delay_Justification;
        // $incident->audit_type = implode(',', $request->audit_type);
        if (is_array($request->audit_type)) {
            $incident->audit_type = implode(',', $request->audit_type);
        }
        $incident->short_description_required = $request->short_description_required;
        $incident->nature_of_repeat = $request->nature_of_repeat;
        $incident->others = $request->others;
        $incident->Product_Batch = $request->Product_Batch;

        $incident->Description_incident = $request->Description_incident;
        if ($request->related_records) {
            $incident->Related_Records1 =  implode(',', $request->related_records);
        }
        $incident->Facility = $request->Facility;


        $incident->Immediate_Action = implode(',', $request->Immediate_Action);
        $incident->Preliminary_Impact = implode(',', $request->Preliminary_Impact);
        $incident->Product_Details_Required = $request->Product_Details_Required;


        $incident->HOD_Remarks = $request->HOD_Remarks;
        $incident->Justification_for_categorization = !empty($request->Justification_for_categorization) ? $request->Justification_for_categorization : $incident->Justification_for_categorization;

        $incident->Investigation_Details = !empty($request->Investigation_Details) ? $request->Investigation_Details : $incident->Investigation_Details;

        $incident->QAInitialRemark = $request->QAInitialRemark;
        $incident->Investigation_Summary = $request->Investigation_Summary;
        $incident->Impact_assessment = $request->Impact_assessment;
        $incident->Root_cause = $request->Root_cause;

        $incident->Conclusion = $request->Conclusion;
        $incident->Identified_Risk = $request->Identified_Risk;
        $incident->severity_rate = $request->severity_rate ? $request->severity_rate : $incident->severity_rate;
        $incident->Occurrence = $request->Occurrence ? $request->Occurrence : $incident->Occurrence;
        $incident->detection = $request->detection ? $request->detection: $incident->detection;

        $newDataGridqrms = incidentGridQrms::where(['incident_id' => $id, 'identifier' =>
        'failure_mode_qrms'])->firstOrCreate();
        $newDataGridqrms->incident_id = $id;
        $newDataGridqrms->identifier = 'failure_mode_qrms';
        $newDataGridqrms->data = $request->failure_mode_qrms;
        $newDataGridqrms->save();

        $matrixDataGridqrms = incidentGridQrms::where(['incident_id' => $id, 'identifier' => 'matrix_qrms'])->firstOrCreate();
        $matrixDataGridqrms->incident_id = $id;
        $matrixDataGridqrms->identifier = 'matrix_qrms';
        $matrixDataGridqrms->data = $request->matrix_qrms;
        $matrixDataGridqrms->save();

        if ($incident->stage < 6) {
            $incident->CAPA_Rquired = $request->CAPA_Rquired;
        }

        if ($incident->stage < 6) {
            $incident->capa_type = $request->capa_type;
        }

        $incident->CAPA_Description = !empty($request->CAPA_Description) ? $request->CAPA_Description : $incident->CAPA_Description;
        $incident->Post_Categorization = !empty($request->Post_Categorization) ? $request->Post_Categorization : $incident->Post_Categorization;
        $incident->Investigation_Of_Review = $request->Investigation_Of_Review;
        $incident->QA_Feedbacks = $request->has('QA_Feedbacks') ? $request->QA_Feedbacks : $incident->QA_Feedbacks;
        $incident->Closure_Comments = $request->Closure_Comments;
        $incident->Disposition_Batch = $request->Disposition_Batch;
        $incident->Facility_Equipment = $request->Facility_Equipment;
        $incident->Document_Details_Required = $request->Document_Details_Required;

        if ($incident->stage == 3)
        {
            $incident->Customer_notification = $request->Customer_notification;
            // $incident->Investigation_required = $request->Investigation_required;
            // $incident->capa_required = $request->capa_required;
            // $incident->qrm_required = $request->qrm_required;
            $incident->incident_category = $request->incident_category;
            $incident->QAInitialRemark = $request->QAInitialRemark;
            // $incident->customers = $request->customers;
        }

        if($incident->stage == 3 || $incident->stage == 4 ){


            if (!$form_progress) {
                $form_progress = 'cft';
            }

            $Cft = incidentCft::withoutTrashed()->where('incident_id', $id)->first();
            if($Cft && $incident->stage == 4 ){
                $Cft->Production_Review = $request->Production_Review == null ? $Cft->Production_Review : $request->Production_Review;
                $Cft->Production_person = $request->Production_person == null ? $Cft->Production_person : $request->Production_Review;
                $Cft->Warehouse_review = $request->Warehouse_review == null ? $Cft->Warehouse_review : $request->Warehouse_review;
                $Cft->Warehouse_notification = $request->Warehouse_notification == null ? $Cft->Warehouse_notification : $request->Warehouse_notification;
                $Cft->Quality_review = $request->Quality_review == null ? $Cft->Quality_review : $request->Quality_review;;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person == null ? $Cft->Quality_Control_Person : $request->Quality_Control_Person;
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review == null ? $Cft->Quality_Assurance_Review : $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person == null ? $Cft->QualityAssurance_person : $request->QualityAssurance_person;

                $Cft->Engineering_review = $request->Engineering_review == null ? $Cft->Engineering_review : $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person == null ? $Cft->Engineering_person : $request->Engineering_person;
                $Cft->Analytical_Development_review = $request->Analytical_Development_review == null ? $Cft->Analytical_Development_review : $request->Analytical_Development_review;
                $Cft->Analytical_Development_person = $request->Analytical_Development_person == null ? $Cft->Analytical_Development_person : $request->Analytical_Development_person;
                $Cft->Kilo_Lab_review = $request->Kilo_Lab_review == null ? $Cft->Kilo_Lab_review : $request->Kilo_Lab_review;
                $Cft->Kilo_Lab_person = $request->Kilo_Lab_person == null ? $Cft->Kilo_Lab_person : $request->Kilo_Lab_person;
                $Cft->Technology_transfer_review = $request->Technology_transfer_review == null ? $Cft->Technology_transfer_review : $request->Technology_transfer_review;
                $Cft->Technology_transfer_person = $request->Technology_transfer_person == null ? $Cft->Technology_transfer_person : $request->Technology_transfer_person;
                $Cft->Environment_Health_review = $request->Environment_Health_review == null ? $Cft->Environment_Health_review : $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person == null ? $Cft->Environment_Health_Safety_person : $request->Environment_Health_Safety_person;
                $Cft->Human_Resource_review = $request->Human_Resource_review == null ? $Cft->Human_Resource_review : $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person == null ? $Cft->Human_Resource_person : $request->Human_Resource_person;
                $Cft->Project_management_review = $request->Project_management_review == null ? $Cft->Project_management_review : $request->Project_management_review;
                $Cft->Project_management_person = $request->Project_management_person == null ? $Cft->Project_management_person : $request->Project_management_person;
                $Cft->Information_Technology_review = $request->Information_Technology_review == null ? $Cft->Information_Technology_review : $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person == null ? $Cft->Information_Technology_person : $request->Information_Technology_person;
                $Cft->Other1_review = $request->Other1_review  == null ? $Cft->Other1_review : $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person  == null ? $Cft->Other1_person : $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person  == null ? $Cft->Other1_Department_person : $request->Other1_Department_person;
                $Cft->Other2_review = $request->Other2_review  == null ? $Cft->Other2_review : $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person  == null ? $Cft->Other2_person : $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person  == null ? $Cft->Other2_Department_person : $request->Other2_Department_person;
                $Cft->Other3_review = $request->Other3_review  == null ? $Cft->Other3_review : $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person  == null ? $Cft->Other3_person : $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person  == null ? $Cft->Other3_Department_person : $request->Other3_Department_person;
                $Cft->Other4_review = $request->Other4_review  == null ? $Cft->Other4_review : $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person  == null ? $Cft->Other4_person : $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person  == null ? $Cft->Other4_Department_person : $request->Other4_Department_person;
                $Cft->Other5_review = $request->Other5_review  == null ? $Cft->Other5_review : $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person  == null ? $Cft->Other5_person : $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person  == null ? $Cft->Other5_Department_person : $request->Other5_Department_person;
            }
            else{
                $Cft->Production_Review = $request->Production_Review;
                $Cft->Production_person = $request->Production_person;
                $Cft->Warehouse_review = $request->Warehouse_review;
                $Cft->Warehouse_notification = $request->Warehouse_notification;
                $Cft->Quality_review = $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person;
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person;
                $Cft->Engineering_review = $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person;
                $Cft->Analytical_Development_review = $request->Analytical_Development_review;
                $Cft->Analytical_Development_person = $request->Analytical_Development_person;
                $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
                $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
                $Cft->Technology_transfer_review = $request->Technology_transfer_review;
                $Cft->Technology_transfer_person = $request->Technology_transfer_person;
                $Cft->Environment_Health_review = $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
                $Cft->Human_Resource_review = $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person;
                $Cft->Project_management_review = $request->Project_management_review;
                $Cft->Project_management_person = $request->Project_management_person;
                $Cft->Information_Technology_review = $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person;
                $Cft->Other1_review = $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person;
                $Cft->Other2_review = $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person;
                $Cft->Other3_review = $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person;
                $Cft->Other4_review = $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person;
                $Cft->Other5_review = $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person;
            }
            $Cft->Production_assessment = $request->Production_assessment;
            $Cft->Production_feedback = $request->Production_feedback;
            $Cft->Warehouse_assessment = $request->Warehouse_assessment;
            $Cft->Warehouse_feedback = $request->Warehouse_feedback;
            $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
            $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
            $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
            $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
            $Cft->Engineering_assessment = $request->Engineering_assessment;
            $Cft->Engineering_feedback = $request->Engineering_feedback;
            $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
            $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
            $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
            $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
            $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
            $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
            $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
            $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
            $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
            $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
            $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
            $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
            $Cft->Project_management_assessment = $request->Project_management_assessment;
            $Cft->Project_management_feedback = $request->Project_management_feedback;
            $Cft->Other1_assessment = $request->Other1_assessment;
            $Cft->Other1_feedback = $request->Other1_feedback;
            $Cft->Other2_Assessment = $request->Other2_Assessment;
            $Cft->Other2_feedback = $request->Other2_feedback;
            $Cft->Other3_Assessment = $request->Other3_Assessment;
            $Cft->Other3_feedback = $request->Other3_feedback;
            $Cft->Other4_Assessment = $request->Other4_Assessment;
            $Cft->Other4_feedback = $request->Other4_feedback;
            $Cft->Other5_Assessment = $request->Other5_Assessment;
            $Cft->Other5_feedback = $request->Other5_feedback;


            if (!empty ($request->production_attachment)) {
                $files = [];
                if ($request->hasfile('production_attachment')) {
                    foreach ($request->file('production_attachment') as $file) {
                        $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->production_attachment = json_encode($files);
            }
            if (!empty ($request->Warehouse_attachment)) {
                $files = [];
                if ($request->hasfile('Warehouse_attachment')) {
                    foreach ($request->file('Warehouse_attachment') as $file) {
                        $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Warehouse_attachment = json_encode($files);
            }
            if (!empty ($request->Quality_Control_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Control_attachment')) {
                    foreach ($request->file('Quality_Control_attachment') as $file) {
                        $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Quality_Control_attachment = json_encode($files);
            }
            if (!empty ($request->Quality_Assurance_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Assurance_attachment')) {
                    foreach ($request->file('Quality_Assurance_attachment') as $file) {
                        $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Quality_Assurance_attachment = json_encode($files);
            }
            if (!empty ($request->Engineering_attachment)) {
                $files = [];
                if ($request->hasfile('Engineering_attachment')) {
                    foreach ($request->file('Engineering_attachment') as $file) {
                        $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Engineering_attachment = json_encode($files);
            }
            if (!empty ($request->Analytical_Development_attachment)) {
                $files = [];
                if ($request->hasfile('Analytical_Development_attachment')) {
                    foreach ($request->file('Analytical_Development_attachment') as $file) {
                        $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Analytical_Development_attachment = json_encode($files);
            }
            if (!empty ($request->Kilo_Lab_attachment)) {
                $files = [];
                if ($request->hasfile('Kilo_Lab_attachment')) {
                    foreach ($request->file('Kilo_Lab_attachment') as $file) {
                        $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Kilo_Lab_attachment = json_encode($files);
            }
            if (!empty ($request->Technology_transfer_attachment)) {
                $files = [];
                if ($request->hasfile('Technology_transfer_attachment')) {
                    foreach ($request->file('Technology_transfer_attachment') as $file) {
                        $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Technology_transfer_attachment = json_encode($files);
            }
            if (!empty ($request->Environment_Health_Safety_attachment)) {
                $files = [];
                if ($request->hasfile('Environment_Health_Safety_attachment')) {
                    foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                        $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Environment_Health_Safety_attachment = json_encode($files);
            }
            if (!empty ($request->Human_Resource_attachment)) {
                $files = [];
                if ($request->hasfile('Human_Resource_attachment')) {
                    foreach ($request->file('Human_Resource_attachment') as $file) {
                        $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Human_Resource_attachment = json_encode($files);
            }
            if (!empty ($request->Information_Technology_attachment)) {
                $files = [];
                if ($request->hasfile('Information_Technology_attachment')) {
                    foreach ($request->file('Information_Technology_attachment') as $file) {
                        $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Information_Technology_attachment = json_encode($files);
            }
            if (!empty ($request->Project_management_attachment)) {
                $files = [];
                if ($request->hasfile('Project_management_attachment')) {
                    foreach ($request->file('Project_management_attachment') as $file) {
                        $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Project_management_attachment = json_encode($files);
            }
            if (!empty ($request->Other1_attachment)) {
                $files = [];
                if ($request->hasfile('Other1_attachment')) {
                    foreach ($request->file('Other1_attachment') as $file) {
                        $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other1_attachment = json_encode($files);
            }
            if (!empty ($request->Other2_attachment)) {
                $files = [];
                if ($request->hasfile('Other2_attachment')) {
                    foreach ($request->file('Other2_attachment') as $file) {
                        $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other2_attachment = json_encode($files);
            }
            if (!empty ($request->Other3_attachment)) {
                $files = [];
                if ($request->hasfile('Other3_attachment')) {
                    foreach ($request->file('Other3_attachment') as $file) {
                        $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other3_attachment = json_encode($files);
            }
            if (!empty ($request->Other4_attachment)) {
                $files = [];
                if ($request->hasfile('Other4_attachment')) {
                    foreach ($request->file('Other4_attachment') as $file) {
                        $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }

                $Cft->Other4_attachment = json_encode($files);
            }
            if (!empty ($request->Other5_attachment)) {
                $files = [];
                if ($request->hasfile('Other5_attachment')) {
                    foreach ($request->file('Other5_attachment') as $file) {
                        $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other5_attachment = json_encode($files);
            }


        $Cft->save();
                $IsCFTRequired = IncidentCftResponse::withoutTrashed()->where(['is_required' => 1, 'incident_id' => $id])->latest()->first();
                $cftUsers = DB::table('incident_cfts')->where(['incident_id' => $id])->first();
                // Define the column names
                $columns = ['Production_person', 'Warehouse_notification', 'Quality_Control_Person', 'QualityAssurance_person', 'Engineering_person', 'Analytical_Development_person', 'Kilo_Lab_person', 'Technology_transfer_person', 'Environment_Health_Safety_person', 'Human_Resource_person', 'Information_Technology_person', 'Project_management_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];

                // Initialize an array to store the values
                $valuesArray = [];

                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                // Remove duplicates from the array
                $valuesArray = array_unique($valuesArray);

                // Convert the array to a re-indexed array
                $valuesArray = array_values($valuesArray);

                foreach ($valuesArray as $u) {
                        $email = Helpers::getInitiatorEmail($u);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $incident],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("CFT Assgineed by " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                    }
                }


            if (!empty ($request->Initial_attachment)) {
                $files = [];

                if ($incident->Initial_attachment) {
                    $files = is_array(json_decode($incident->Initial_attachment)) ? $incident->Initial_attachment : [];
                }

                if ($request->hasfile('Initial_attachment')) {
                    foreach ($request->file('Initial_attachment') as $file) {
                        $name = $request->name . 'Initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $incident->Initial_attachment = json_encode($files);
            }
        }



        if (!empty ($request->Audit_file)) {

            $files = [];

            if ($incident->Audit_file) {
                $existingFiles = json_decode($incident->Audit_file, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
                // $files = is_array(json_decode($incident->Audit_file)) ? $incident->Audit_file : [];
            }

            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $incident->Audit_file = json_encode($files);
        }
        if (!empty($request->initial_file)) {
            $files = [];

            // Decode existing files if they exist
            if ($incident->initial_file) {
                $existingFiles = json_decode($incident->initial_file, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
            }

            // Process and add new files
            if ($request->hasfile('initial_file')) {
                foreach ($request->file('initial_file') as $file) {
                    $name = $request->name . 'initial_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            // Encode the files array and update the model
            $incident->initial_file = json_encode($files);
        }

        if (!empty ($request->QA_attachment)) {
            $files = [];

            if ($incident->QA_attachment) {
                $existingFiles = json_decode($incident->QA_attachment, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
                // $files = is_array(json_decode($incident->QA_attachment)) ? $incident->QA_attachment : [];
            }

            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->QA_attachment = json_encode($files);
        }

        if (!empty ($request->Investigation_attachment)) {

            $files = [];

            if ($incident->Investigation_attachment) {
                $existingFiles = json_decode($incident->Investigation_attachment, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
                // $files = is_array(json_decode($incident->QA_attachment)) ? $incident->QA_attachment : [];
            }

            if ($request->hasfile('Investigation_attachment')) {
                foreach ($request->file('Investigation_attachment') as $file) {
                    $name = $request->name . 'Investigation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Investigation_attachment = json_encode($files);
        }

        if (!empty ($request->Capa_attachment)) {

            $files = [];

            if ($incident->Capa_attachment) {
                $existingFiles = json_decode($incident->Capa_attachment, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
                // $files = is_array(json_decode($incident->Capa_attachment)) ? $incident->Capa_attachment : [];
            }

            if ($request->hasfile('Capa_attachment')) {
                foreach ($request->file('Capa_attachment') as $file) {
                    $name = $request->name . 'Capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->Capa_attachment = json_encode($files);
        }
        if (!empty ($request->QA_attachments)) {

            $files = [];

            if ($incident->QA_attachments) {
                $files = is_array(json_decode($incident->QA_attachments)) ? $incident->QA_attachments : [];
            }

            if ($request->hasfile('QA_attachments')) {
                foreach ($request->file('QA_attachments') as $file) {
                    $name = $request->name . 'QA_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->QA_attachments = json_encode($files);
        }

        if (!empty ($request->closure_attachment)) {

            $files = [];

            if ($incident->closure_attachment) {
                $existingFiles = json_decode($incident->closure_attachment, true); // Convert to associative array
                if (is_array($existingFiles)) {
                    $files = $existingFiles;
                }
                // $files = is_array(json_decode($incident->closure_attachment)) ? $incident->closure_attachment : [];
            }

            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $incident->closure_attachment = json_encode($files);
        }
        if($incident->stage > 0){


            //investiocation dynamic
            $incident->Discription_Event = $request->Discription_Event;
            $incident->objective = $request->objective;
            $incident->scope = $request->scope;
            $incident->imidiate_action = $request->imidiate_action;
            $incident->investigation_approach = is_array($request->investigation_approach) ? implode(',', $request->investigation_approach) : '';
            $incident->attention_issues = $request->attention_issues;
            $incident->attention_actions = $request->attention_actions;
            $incident->attention_remarks = $request->attention_remarks;
            $incident->understanding_issues = $request->understanding_issues;
            $incident->understanding_actions = $request->understanding_actions;
            $incident->understanding_remarks = $request->understanding_remarks;
            $incident->procedural_issues = $request->procedural_issues;
            $incident->procedural_actions = $request->procedural_actions;
            $incident->procedural_remarks = $request->procedural_remarks;
            $incident->behavioiral_issues = $request->behavioiral_issues;
            $incident->behavioiral_actions = $request->behavioiral_actions;
            $incident->behavioiral_remarks = $request->behavioiral_remarks;
            $incident->skill_issues = $request->skill_issues;
            $incident->skill_actions = $request->skill_actions;
            $incident->skill_remarks = $request->skill_remarks;
            $incident->what_will_be = $request->what_will_be;
            $incident->what_will_not_be = $request->what_will_not_be;
            $incident->what_rationable = $request->what_rationable;
            $incident->where_will_be = $request->where_will_be;
            $incident->where_will_not_be = $request->where_will_not_be;
            $incident->where_rationable = $request->where_rationable;
            $incident->when_will_not_be = $request->when_will_not_be;
            $incident->when_will_be = $request->when_will_be;
            $incident->when_rationable = $request->when_rationable;
            $incident->coverage_will_be = $request->coverage_will_be;
            $incident->coverage_will_not_be = $request->coverage_will_not_be;
            $incident->coverage_rationable = $request->coverage_rationable;
            $incident->who_will_be = $request->who_will_be;
            $incident->who_will_not_be = $request->who_will_not_be;
            $incident->who_rationable = $request->who_rationable;

            // dd($id);
            $newDataGridInvestication = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'investication'])->firstOrCreate();
            $newDataGridInvestication->incident_id = $id;
            $newDataGridInvestication->identifier = 'investication';
            $newDataGridInvestication->data = $request->investication;
            $newDataGridInvestication->save();

            $newDataGridRCA = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'rootCause'])->firstOrCreate();
            $newDataGridRCA->incident_id = $id;
            $newDataGridRCA->identifier = 'rootCause';
            $newDataGridRCA->data = $request->rootCause;
            $newDataGridRCA->save();

            $newDataGridWhy = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'why'])->firstOrCreate();
            $newDataGridWhy->incident_id = $id;
            $newDataGridWhy->identifier = 'why';
            $newDataGridWhy->data = $request->why;
            $newDataGridWhy->save();

            $newDataGridFishbone = incidentNewGridData::where(['incident_id' => $id, 'identifier' => 'fishbone'])->firstOrCreate();
            $newDataGridFishbone->incident_id = $id;
            $newDataGridFishbone->identifier = 'fishbone';
            $newDataGridFishbone->data = $request->fishbone;
            $newDataGridFishbone->save();
            
        }


        $incident->form_progress = isset($form_progress) ? $form_progress : null;
        $incident->update();
        // grid
         $data3=IncidentGrid::where('incident_grid_id', $incident->id)->where('type', "Incident")->first();
                if (!empty($request->IDnumber)) {
                    $data3->IDnumber = serialize($request->IDnumber);
                }
                if (!empty($request->facility_name)) {
                    $data3->facility_name = serialize($request->facility_name);
                }

                if (!empty($request->Remarks)) {
                    $data3->Remarks = serialize($request->Remarks);
                }

                $data3->update();
                // dd($request->Remarks);


            $data4=IncidentGrid::where('incident_grid_id', $incident->id)->where('type', "Document")->first();
            if (!empty($request->Number)) {
                $data4->Number = serialize($request->Number);
            }
            if (!empty($request->ReferenceDocumentName)) {
                $data4->ReferenceDocumentName = serialize($request->ReferenceDocumentName);
            }

            if (!empty($request->Document_Remarks)) {
                $data4->Document_Remarks = serialize($request->Document_Remarks);
            }
            $data4->update();

            $data5=IncidentGrid::where('incident_grid_id', $incident->id)->where('type', "Product")->first();
            if (!empty($request->product_name)) {
                $data5->product_name = serialize($request->product_name);
            }
            if (!empty($request->product_stage)) {
                $data5->product_stage = serialize($request->product_stage);
            }

            if (!empty($request->batch_no)) {
                $data5->batch_no = serialize($request->batch_no);
            }
            $data5->update();


        if ($lastIncident->short_description != $incident->short_description || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Short Description';
             $history->previous = $lastIncident->short_description;
            $history->current = $incident->short_description;
            $history->comment = $incident->submit_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = "Uppdate";
            $history->save();
        }
        if ($lastIncident->Initiator_Group != $incident->Initiator_Group || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = $lastIncident->Initiator_Group;
            $history->current = $incident->Initiator_Group;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->incident_date != $incident->incident_date || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Incident Observed';
            $history->previous = $lastIncident->incident_date;
            $history->current = $incident->incident_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Observed_by != $incident->Observed_by || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Observed by';
            $history->previous = $lastIncident->Observed_by;
            $history->current = $incident->Observed_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->incident_reported_date != $incident->incident_reported_date || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Incident Reported on';
            $history->previous = $lastIncident->incident_reported_date;
            $history->current = $incident->incident_reported_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->audit_type != $incident->audit_type || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Incident Related To';
            $history->previous = $lastIncident->audit_type;
            $history->current = $incident->audit_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Others != $incident->Others || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Others';
            $history->previous = $lastIncident->Others;
            $history->current = $incident->Others;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Facility_Equipment != $incident->Facility_Equipment || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Facility/ Equipment/ Instrument/ System Details Required?';
            $history->previous = $lastIncident->Facility_Equipment;
            $history->current = $incident->Facility_Equipment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Document_Details_Required != $incident->Document_Details_Required || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Document Details Required';
            $history->previous = $lastIncident->Document_Details_Required;
            $history->current = $incident->Document_Details_Required;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Product_Batch != $incident->Product_Batch || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Name of Product & Batch No';
            $history->previous = $lastIncident->Product_Batch;
            $history->current = $incident->Product_Batch;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Description_incident != $incident->Description_incident || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Description of Incident';
            $history->previous = $lastIncident->Description_incident;
            $history->current = $incident->Description_incident;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Immediate_Action != $incident->Immediate_Action || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Immediate Action (if any)';
            $history->previous = $lastIncident->Immediate_Action;
            $history->current = $incident->Immediate_Action;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Preliminary_Impact != $incident->Preliminary_Impact || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Preliminary Impact of Incident';
            $history->previous = $lastIncident->Preliminary_Impact;
            $history->current = $incident->Preliminary_Impact;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->HOD_Remarks != $incident->HOD_Remarks || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'HOD Remarks';
            $history->previous = $lastIncident->HOD_Remarks;
            $history->current = $incident->HOD_Remarks;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->incident_category != $incident->incident_category || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Initial Incident Category';
            $history->previous = $lastIncident->incident_category;
            $history->current = $incident->incident_category;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Justification_for_categorization != $incident->Justification_for_categorization || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Justification for Categorization';
            $history->previous = $lastIncident->Justification_for_categorization;
            $history->current = $incident->Justification_for_categorization;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Investigation_required != $incident->Investigation_required || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Investigation Is required ?';
            $history->previous = $lastIncident->Investigation_required;
            $history->current = $incident->Investigation_required;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Investigation_Details != $incident->Investigation_Details || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Investigation Details';
            $history->previous = $lastIncident->Investigation_Details;
            $history->current = $incident->Investigation_Details;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Customer_notification != $incident->Customer_notification || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Customer Notification Required ?';
            $history->previous = $lastIncident->Customer_notification;
            $history->current = $incident->Customer_notification;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->customers != $incident->customers || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Customer';
            $history->previous = $lastIncident->customers;
            $history->current = $incident->customers;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->QAInitialRemark != $incident->QAInitialRemark || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'QA Initial Remarks';
            $history->previous = $lastIncident->QAInitialRemark;
            $history->current = $incident->QAInitialRemark;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Investigation_Summary != $incident->Investigation_Summary || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = $lastIncident->Investigation_Summary;
            $history->current = $incident->Investigation_Summary;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->action_name = 'Update';
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->save();
        }

        if ($lastIncident->Impact_assessment != $incident->Impact_assessment || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Impact Assessment';
            $history->previous = $lastIncident->Impact_assessment;
            $history->current = $incident->Impact_assessment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Root_cause != $incident->Root_cause || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Root Cause';
            $history->previous = $lastIncident->Root_cause;
            $history->current = $incident->Root_cause;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->CAPA_Rquired != $incident->CAPA_Rquired || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'CAPA Required ?';
            $history->previous = $lastIncident->CAPA_Rquired;
            $history->current = $incident->CAPA_Rquired;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->capa_type != $incident->capa_type || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'CAPA Type?';
            $history->previous = $lastIncident->capa_type;
            $history->current = $incident->capa_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->CAPA_Description != $incident->CAPA_Description || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'CAPA Description';
            $history->previous = $lastIncident->CAPA_Description;
            $history->current = $incident->CAPA_Description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Post_Categorization != $incident->Post_Categorization || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Post Categorization Of Incident';
            $history->previous = $lastIncident->Post_Categorization;
            $history->current = $incident->Post_Categorization;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Investigation_Of_Review != $incident->Investigation_Of_Review || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Investigation Of Revised Categorization';
            $history->previous = $lastIncident->Investigation_Of_Review;
            $history->current = $incident->Investigation_Of_Review;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->QA_Feedbacks != $incident->QA_Feedbacks || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'QA Feedbacks';
            $history->previous = $lastIncident->QA_Feedbacks;
            $history->current = $incident->QA_Feedbacks;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Closure_Comments != $incident->Closure_Comments || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Closure Comments';
            $history->previous = $lastIncident->Closure_Comments;
            $history->current = $incident->Closure_Comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastIncident->Disposition_Batch != $incident->Disposition_Batch || !empty ($request->comment)) {
            // return 'history';
            $history = new IncidentAuditTrail;
            $history->incident_id = $id;
            $history->activity_type = 'Disposition of Batch';
            $history->previous = $lastIncident->Disposition_Batch;
            $history->current = $incident->Disposition_Batch;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastIncident->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastIncident->status;
            $history->action_name = 'Update';
            $history->save();
        }

        toastr()->success('Record is Update Successfully');

        return back();
    }

}
