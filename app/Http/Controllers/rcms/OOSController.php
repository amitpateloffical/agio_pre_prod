<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OOS;
use App\Models\Oosgrids;

class OOSController extends Controller
{
    public function index()
    {
        return view('frontend.OOS.oos_form');
    }
    // public function store(Request $request)
    // {   
    //     $input = $request->all();
    //     // file attechment of all pages
    //     if (!empty ($request->initial_attachment_gi)) {
    //         $files = [];
    //         if ($request->hasfile('initial_attachment_gi')) {
    //             foreach ($request->file('initial_attachment_gi') as $file) {
                    
    //                 $name =  'initial_attachment_gi' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
    //                 $file->move('upload/', $name);
    //                 $files[] = $name;
    //             }
    //         }
    //         $input['initial_attachment_gi'] = json_encode($files);
    //     }
    //     $OosDataRecord = OOS::create($input);
    //     // =========== oos grid start =====================
    //     if(!empty($OosDataRecord)){
    //         $info_product_item = $request->info_product_item;
    //     // ======== General Information =>Info On Product/Material =========
    //         if(isset($info_product_item) && $info_product_item!=''){
    //             $i=0;
    //             foreach ($info_product_item as $key => $value1) {
    //             $genaralGridInfoData = array(
    //             'oot_id'=> $genaralDataRecord->id,
    //             'identifier' => $request->identifier[$i],
    //             'info_product_item' => $info_product_item[$i],
    //             'info_product_lot_batch' => $request->info_product_lot_batch[$i],
    //             'info_product_arnumber' => $request->info_product_arnumber[$i],
    //             'info_product_mfg_date' => $request->info_product_mfg_date[$i], 
    //             'info_expiry_date' => $request->info_expiry_date[$i], 
    //             'info_label_claim' => $request->info_label_claim[$i],
    //             ); 
    //             $genaralGridInfoDatas = OotGrids::insert($genaralGridInfoData);
    //             $i++;  
    //             }
    //         }
    //     }
        
    // }
    public function store(Request $request)
    {   
        $input = $request->all();
        //========== file attechment of all pages ==========
        if (!empty ($request->initial_attachment_gi)) {
            $files = [];
            if ($request->hasfile('initial_attachment_gi')) {
                foreach ($request->file('initial_attachment_gi') as $file) {
                    
                    $name =  'initial_attachment_gi' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['initial_attachment_gi'] = json_encode($files);
        }


        if (!empty ($request->file_attachments_pli)) {
            $files = [];
            if ($request->hasfile('file_attachments_pli')) {
                foreach ($request->file('file_attachments_pli') as $file) {
                    
                    $name =  'file_attachments_pli' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['file_attachments_pli'] = json_encode($files);
        }

        if (!empty ($request->supporting_attachment_plic)) {
            $files = [];
            if ($request->hasfile('supporting_attachment_plic')) {
                foreach ($request->file('supporting_attachment_plic') as $file) {
                    
                    $name =  'supporting_attachment_plic' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['supporting_attachment_plic'] = json_encode($files);
        }

        if (!empty ($request->supporting_attachments_plir)) {
            $files = [];
            if ($request->hasfile('supporting_attachments_plir')) {
                foreach ($request->file('supporting_attachments_plir') as $file) {
                    
                    $name =  'supporting_attachments_plir' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['supporting_attachments_plir'] = json_encode($files);
        }


        if (!empty ($request->file_attachments_pli)) {
            $files = [];
            if ($request->hasfile('file_attachments_pli')) {
                foreach ($request->file('file_attachments_pli') as $file) {
                    
                    $name =  'file_attachments_pli' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['file_attachments_pli'] = json_encode($files);
        }

        if (!empty ($request->attachments_piiqcr)) {
            $files = [];
            if ($request->hasfile('attachments_piiqcr')) {
                foreach ($request->file('attachments_piiqcr') as $file) {
                    
                    $name =  'attachments_piiqcr' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['attachments_piiqcr'] = json_encode($files);
        }

        if (!empty ($request->additional_testing_attachment_atp)) {
            $files = [];
            if ($request->hasfile('additional_testing_attachment_atp')) {
                foreach ($request->file('additional_testing_attachment_atp') as $file) {
                    
                    $name =  'additional_testing_attachment_atp' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['additional_testing_attachment_atp'] = json_encode($files);
        }

        if (!empty ($request->file_attachments_if_any_ooscattach)) {
            $files = [];
            if ($request->hasfile('file_attachments_if_any_ooscattach')) {
                foreach ($request->file('file_attachments_if_any_ooscattach') as $file) {
                    
                    $name =  'file_attachments_if_any_ooscattach' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['file_attachments_if_any_ooscattach'] = json_encode($files);
        }

        if (!empty ($request->conclusion_attachment_ocr)) {
            $files = [];
            if ($request->hasfile('conclusion_attachment_ocr')) {
                foreach ($request->file('conclusion_attachment_ocr') as $file) {
                    
                    $name =  'conclusion_attachment_ocr' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['conclusion_attachment_ocr'] = json_encode($files);
        }


        if (!empty ($request->cq_attachment_ocqr)) {
            $files = [];
            if ($request->hasfile('cq_attachment_ocqr')) {
                foreach ($request->file('cq_attachment_ocqr') as $file) {
                    
                    $name =  'cq_attachment_ocqr' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['cq_attachment_ocqr'] = json_encode($files);
        }


        if (!empty ($request->disposition_attachment_bd)) {
            $files = [];
            if ($request->hasfile('disposition_attachment_bd')) {
                foreach ($request->file('disposition_attachment_bd') as $file) {
                    
                    $name =  'disposition_attachment_bd' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['disposition_attachment_bd'] = json_encode($files);
        }

        if (!empty ($request->reopen_attachment_ro)) {
            $files = [];
            if ($request->hasfile('reopen_attachment_ro')) {
                foreach ($request->file('reopen_attachment_ro') as $file) {
                    
                    $name =  'reopen_attachment_ro' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['reopen_attachment_ro'] = json_encode($files);
        }

        if (!empty ($request->addendum_attachment_uaa)) {
            $files = [];
            if ($request->hasfile('addendum_attachment_uaa')) {
                foreach ($request->file('addendum_attachment_uaa') as $file) {
                    
                    $name =  'addendum_attachment_uaa' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['addendum_attachment_uaa'] = json_encode($files);
        }

        if (!empty ($request->addendum_attachments_uae)) {
            $files = [];
            if ($request->hasfile('addendum_attachments_uae')) {
                foreach ($request->file('addendum_attachments_uae') as $file) {
                    
                    $name =  'addendum_attachments_uae' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['addendum_attachments_uae'] = json_encode($files);
        }

        if (!empty ($request->required_attachment_uar)) {
            $files = [];
            if ($request->hasfile('required_attachment_uar')) {
                foreach ($request->file('required_attachment_uar') as $file) {
                    
                    $name =  'required_attachment_uar' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['required_attachment_uar'] = json_encode($files);
        }

        if (!empty ($request->verification_attachment_uar)) {
            $files = [];
            if ($request->hasfile('verification_attachment_uar')) {
                foreach ($request->file('verification_attachment_uar') as $file) {
                    
                    $name =  'verification_attachment_uar' . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $input['verification_attachment_uar'] = json_encode($files);
        }
        $OosDataRecord = OOS::create($input);

        // =========== oos grid start =====================
        if(!empty($OosDataRecord)){
            // ========== identifier_info_product_material ======
            $info_product_code = $request->info_product_code;
            if(isset($info_product_code) && $info_product_code!=''){
                $i=0;
                foreach ($info_product_item as $key => $value1) {
                $ProductData = array(
                'oot_id'=> $OosDataRecord->id,
                'identifier' => $request->identifier_info_product_material[$i],
                'info_batch_no' => $info_batch_no[$i],
                'info_mfg_date' => $info_mfg_date[$i],
                'info_expiry_date' => $info_expiry_date[$i],
                'info_label_claim' => $info_label_claim[$i],
                'info_pack_size' => $info_pack_size[$i],
                'info_analyst_name' => $info_analyst_name[$i],
                'info_others_specify' => $info_others_specify[$i],
                'info_process_sample_stage' => $info_process_sample_stage[$i]
                ); 
                $ProductDatas = OotGrids::insert($ProductData);
                $i++;  
                }
            }
            // ========== identifier_details_stability ======
            $stability_study_arnumber = $request->stability_study_arnumber;
            if(isset($stability_study_arnumber) && $stability_study_arnumber!=''){
                 $j=0;
                foreach ($stability_study_arnumber as $key => $value1) {
                $StabilityData = array(
                'oos_id'=> $OosDataRecord->id,
                'identifier' => $request->identifier_details_stability[$j],
                'stability_study_condition_temprature_rh' => $stability_study_condition_temprature_rh[$i],
                'stability_study_Interval' => $request->stability_study_Interval[$j],
                'stability_study_orientation' => $request->stability_study_orientation[$j],
                'stability_study_pack_details' => $request->stability_study_pack_details[$j],
                'stability_study_specification_no' => $request->stability_study_specification_no[$j],
                'stability_study_sample_description' => $request->stability_study_sample_description[$j]
                ); 
                $StabilityDatas = OotGrids::insert($StabilityData);
                $j++;  
                }
            }
            // ===========' identifier_oos_detail[$k]=========
            $oos_arnumber = $request->oos_arnumber;
            if(isset($oos_arnumber) && $oos_arnumber!=''){
                    $k=0;
                    foreach ($oos_arnumber as $key => $value1) {
                    $OosDetailData = array(
                    'oos_id'=> $OosDataRecord->id,
                    'identifier' => $request->identifier_oos_detail[$k],
                    'oos_test_name' => $request->oos_test_name[$k],
                    'oos_results_obtained' => $request->oos_results_obtained[$k],
                    'oos_specification_limit' => $request->oos_specification_limit[$k],
                    'oos_details_obvious_error' => $request->oos_details_obvious_error[$k],
                    'oos_file_attachment' => $request->oos_file_attachment[$k],
                    'oos_submit_on' => $request->oos_submit_on[$k]
                ); 
                $OosDetailDatas = OotGrids::insert($OosDetailData);
                $k++;  
                }
            }

        //     $info_oos_number = $request->info_oos_number;
        //     if(isset($info_oos_number) && $info_oos_number!=''){
        //         $k=0;
        //         foreach ($info_oos_number as $key => $value1) {
        //         $genaralGridInfoData = array(
        //         'oos_id'=> $genaralDataRecord->id,
        //         'identifier' => $request->identifier_oos_capa[$k],

        //         ); 
        //         $genaralGridInfoDatas = OotGrids::insert($genaralGridInfoData);
        //         $k++;  
        //         }
           
        //     }

        //     $summary_results_analysis_detials = $request->summary_results_analysis_detials;
        //     if(isset($summary_results_analysis_detials) && $summary_results_analysis_detials!=''){
        //         $l=0;
        //         foreach ($summary_results_analysis_detials as $key => $value1) {
        //         $genaralGridInfoData = array(
        //         'oos_id'=> $genaralDataRecord->id,
        //         'identifier' => $request->identifier_oos_conclusion[$l],

        //         ); 
        //         $genaralGridInfoDatas = OotGrids::insert($genaralGridInfoData);
        //         $l++;  
        //         }
        //     }

            // $conclusion_review_product_name = $request->conclusion_review_product_name;
            // if(isset($conclusion_review_product_name) && $conclusion_review_product_name!=''){
            //     //identifier_oos_conclusion_review
            //     $l=0;
            //     foreach ($conclusion_review_product_name as $key => $value1) {
            //     $genaralGridInfoData = array(
            //     'oos_id'=> $genaralDataRecord->id,
            //     'identifier' => $request->identifier_oos_conclusion_review[$l],

            //     ); 
            //     $genaralGridInfoDatas = OotGrids::insert($genaralGridInfoData);
            //     $l++;  
            //     }
           
            // }

        }
        
    }
}
