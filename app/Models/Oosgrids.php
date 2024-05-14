<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oosgrids extends Model
{
    use HasFactory;
    protected $table = 'oos_grids';
    protected $fillable = [
        'info_product_code',
        'info_batch_no',
        'info_product_arnumber',
        'info_mfg_date',
        'info_expiry_date',
        'info_label_claim',
        'info_pack_size',
        'info_analyst_name',
        'info_others_specify',
        'info_process_sample_stage',
        'info_packing_material_type',
        'info_stability_for',
        'stability_study_arnumber',
        'stability_study_condition_temprature_rh',
        'stability_study_Interval',
        'stability_study_orientation',
        'stability_study_pack_details',
        'stability_study_specification_no',
        'stability_study_sample_description',
        'oos_arnumber',
        'oos_test_name',
        'oos_results_obtained',
        'oos_specification_limit',
        'oos_details_obvious_error',
        'oot_file_attachment',
        'oos_submit_by',
        'oot_submit_on',
        'preliminary_phase1_question',
        'preliminary_phase1_response',
        'preliminary_phase1_remarks',
        'info_oos_number',
        'info_oos_reported_date',
        'info_oos_description',
        'info_oos_previous_root_cause',
        'info_oos_capa',
        'info_oos_closure_date',
        'info_oos_capa_requirement',
        'info_oos_capa_reference_number',
        'phase2_question',
        'phase2_response',
        'phase2_remarks',
        'summary_results_analysis_detials',
        'summary_results_hypothesis_experimentation_test_pr_no',
        'summary_results',
        'summary_results_analyst_name',
        'summary_results_remarks',
        'conclusion_review_product_name',
        'conclusion_review_batch_no',
        'conclusion_review_any_other_information',
        'conclusion_review_action_affecte_batch',
    ];
    protected $casts = [
        'info_product_code' => 'array',
        'info_batch_no' => 'array',
        'info_product_arnumber' => 'array',
        'info_mfg_date' => 'array',
        'info_expiry_date' => 'array',
        'info_label_claim' => 'array',
        'info_pack_size' => 'array',
        'info_analyst_name' => 'array',
        'info_others_specify' => 'array',
        'info_process_sample_stage' => 'array',
        'info_packing_material_type' => 'array',
        'info_stability_for' => 'array',
        'stability_study_arnumber' => 'array',
        'stability_study_condition_temprature_rh' => 'array',
        'stability_study_Interval' => 'array',
        'stability_study_orientation' => 'array',
        'stability_study_pack_details' => 'array',
        'stability_study_specification_no' => 'array',
        'stability_study_sample_description' => 'array',
        'oos_arnumber' => 'array',
        'oos_test_name' => 'array',
        'oos_results_obtained' => 'array',
        'oos_specification_limit' => 'array',
        'oos_details_obvious_error' => 'array',
        'oot_file_attachment' => 'array',
        'oos_submit_by' => 'array',
        'oot_submit_on' => 'array',
        'preliminary_phase1_question' => 'array',
        'preliminary_phase1_response' => 'array',
        'preliminary_phase1_remarks' => 'array',
        'info_oos_number' => 'array',
        'info_oos_reported_date' => 'array',
        'info_oos_description' => 'array',
        'info_oos_previous_root_cause' => 'array',
        'info_oos_capa' => 'array',
        'info_oos_closure_date' => 'array',
        'info_oos_capa_requirement' => 'array',
        'info_oos_capa_reference_number' => 'array',
        'phase2_question' => 'array',
        'phase2_response' => 'array',
        'phase2_remarks' => 'array',
        'summary_results_analysis_detials' => 'array',
        'summary_results_hypothesis_experimentation_test_pr_no' => 'array',
        'summary_results' => 'array',
        'summary_results_analyst_name' => 'array',
        'summary_results_remarks' => 'array',
        'conclusion_review_product_name' => 'array',
        'conclusion_review_batch_no' => 'array',
        'conclusion_review_any_other_information' => 'array',
        'conclusion_review_action_affecte_batch' => 'array'
    ];
}
