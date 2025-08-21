<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubJob;
use App\Models\Job;

class SubJobSeeder extends Seeder
{
    public function run(): void
    {
        $subJobs = [
            'Education' => ['Teacher', 'School superintendent', 'Curriculum developer', 'University professor', 'Principal', 'School counsellor', 'Teaching assistant', 'Tutor', 'Academic dean', 'Special education teacher'],
            'Law & Government' => ['Dispatcher', 'Correctional officer', 'Crime scene investigator', 'Forensic analyst', 'Intelligence officer', 'Lawyer', 'Paralegal', 'Court clerk', 'Judge'],
            'Health Care' => ['Nurse', 'Social worker', 'Psychologist', 'Physical therapist', 'Doctor', 'Medical assistant', 'Pharmacy technician', 'Medical researcher', 'Radiologic technologist', 'Phlebotomist'],
            'Service Industry' => ['Esthetician', 'Hairstylist', 'Cashier', 'Salesperson', 'Barista', 'Server', 'Bartender', 'Chef', 'Guest services associate', 'Concierge'],
            'Transport' => ['Flight attendant', 'Pilot', 'Aircraft mechanic', 'Air traffic controller', 'Transportation officer', 'Truck driver', 'Bus driver', 'Freight agent', 'Service technician', 'Logistics coordinator'],
            'Arts' => ['Curator', 'Graphic designer', 'Photographer', 'Video editor', 'Art teacher', 'Interior designer', 'Gallery manager', 'Art therapist', 'Musician', 'Conservator'],
            'Communications' => ['Copywriter', 'Journalist', 'Editorial assistant', 'Publishing manager', 'Media planner', 'Public relations specialist', 'Brand strategist', 'Advertising account executive', 'Social media manager'],
            'Construction' => ['Electrician', 'Plumber', 'Carpenter', 'Construction supervisor', 'Architect', 'HVAC technician', 'Code inspector', 'Surveyor', 'Solar panel installer', 'Project engineer'],
            'Manufacturing' => ['Fabricator', 'Material handler', 'Machine operator', 'Equipment technician', 'Production supervisor', 'Warehouse manager', 'Plant manager', 'Safety coordinator', 'Quality control specialist', 'Automation engineer'],
            'Finance' => ['Bookkeeper', 'Accountant', 'Financial advisor', 'Actuary', 'Auditor', 'Financial controller', 'Investment banker', 'Portfolio manager', 'Financial analyst', 'Chief financial officer (CFO)'],
            'Business Administration' => ['Office administrator', 'Executive assistant', 'Business consultant', 'Sales manager', 'Research analyst', 'Human resources manager', 'Compliance officer', 'Director of development', 'Operations officer', 'Chief executive officer (CEO)'],
            'Technology' => ['IT technician', 'Web developer', 'Security analyst', 'Software developer', 'Systems engineer', 'Database administrator', 'Computer programmer', 'UI designer', 'Data scientist', 'Network architect'],
            'Sea Based' => ['Sea Based']
        ];

        foreach ($subJobs as $job => $subJobValue) {
            $jobRecord = Job::where('name', $job)->first();

            if ($jobRecord) {
                foreach ($subJobValue as $subjob) {
                    SubJob::firstOrCreate([
                        'job_id' => $jobRecord->id,
                        'name' => $subjob,
                        'remarks' => 'Seeder generated'
                    ]);
                }
            }
        }
    }
}
