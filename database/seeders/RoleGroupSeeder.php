<?php

namespace Database\Seeders;

use App\Models\RoleGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            'Corporate',
            'Plant',
        ];

      $processes_roles = [
            'Effectiveness Check' => ['Initiator', 'Supervisor', 'QA', 'View Only', 'FP'],
            'Root Cause Analysis' => ['Initiator', 'QA', 'View Only', 'FP'],
            'Change Control' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'Head QA/Designee', 'View Only', 'FP'],
            'Lab Incident' => ['Initiator', 'HOD/Supervisor/Designee', 'Head QA', 'Initiator', 'Head QA', 'View Only', 'FP'],
            'CAPA' => ['Initiator', 'HOD/Designee', 'QA', 'QA Head/Designee', 'View Only', 'FP'],
            'Audit Program' => ['Initiator', 'Audit Manager', 'View Only', 'FP'],
            'Internal Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP'],
            'External Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP'],
            'Management Review' => ['Initiator', 'Responsible Person', 'View Only', 'FP'],
            'Risk Assessment' => ['Initiator', 'HOD/Designee', 'Work Group (Risk Management Head)', 'HOD/Designee', 'QA', 'View Only', 'FP'],
            'Action Item' => ['Initiator', 'Action Owner', 'View Only', 'FP'],
            'Extension' => ['Initiator', 'Head QA/Designee', 'View Only', 'FP'],
            'Observation' => ['Initiator', 'Lead Auditor', 'Lead Auditee', 'QA', 'View Only', 'FP'],
            'OOS Chemical' => ['Initiator', 'Lab Supervisor', 'QC Head/Designee', 'Lab Supervisor', 'QA', 'Lab Supervisor', 'QA', 'Head QA/Designee', 'View Only', 'FP'],
            'OOT' => ['Initiator', 'HOD/Supervisor/Designee', 'Head QA', 'Initiator', 'Head QA/Designee', 'View Only', 'FP'],
            'OOC' => ['Initiator', 'HOD/Designee', 'QC Head', 'QA', 'QC Supervisor', 'Manufacturing QA', 'QA', 'QA Head/Designee', 'View Only', 'FP'],
            'Deviation' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP'],
            'New Document' => ['Initiator', 'HOD/Designee', 'Approver', 'Reviewer', 'View Only', 'FP'],
            'Market Complaint' => ['Initiator', 'Supervisor', 'QA', 'Responsible Person', 'Supervisor', 'QA Head/Designee', 'Initiator', 'View Only', 'FP'],
            'Non Conformance' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP'],
            'Incident' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP'],
            'Failure Investigation' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP'],
            'ERRATA' => ['Initiator', 'QA Reviewer', 'Initiator', 'Supervisor', 'HOD/Designee', 'QA Head/Designee', 'View Only', 'FP'],
            'OOS Microbiology' => ['Initiator', 'Lab Supervisor', 'QC Head/Designee', 'Lab Supervisor', 'QA', 'Lab Supervisor', 'Head QA/Designee', 'View Only', 'FP'],
        ];

        $start_from_id = 1; // Initialize your starting ID

        foreach ($sites as $site) {
            foreach ($processes_roles as $process => $roles) {
                foreach ($roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $start_from_id;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                    $start_from_id++;
                }
            }
        }

        $cft_roles = [
            "Production",
            "Warehouse",
            "Quality Control",
            "Quality Assurance",
            "Engineering",
            "Analytical Development Laboratory",
            "Process Development Laboratory / Kilo Lab",
            "Technology Transfer / Design",
            "Environment, Health & Safety",
            "Human Resource & Administration",
            "Information Technology",
            "Project Management"
        ];

        $processes = [
            'Change Control',
            'Deviation',
            'Non Conformance',
            'Incident',
            'Failure Investigation',
        ];

        $incrementCount = $start_from_id;

        foreach ($processes as $process) {
            foreach ($sites as $site) {
                foreach ($cft_roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount++;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                }
            }
        }
    }
}
