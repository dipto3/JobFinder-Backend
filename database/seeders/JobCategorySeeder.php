<?php
namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Accounting/Finance',
            'Bank/Non-Bank Financial Institution',
            'Supply Chain/Procurement',
            'Education/Training',
            'Engineer/Architects',
            'Garments/Textile',
            'HR/Organizational Development',
            'General Management/Administration',
            'Design/Creative',
            'Production/Operation',
            'Hospitality/Travel/Tourism',
            'Commercial',
            'Beauty Care/Health & Fitness',
            'IT & Telecommunication',
            'Marketing/Sales',
            'Customer Service/Call Centre',
            'Media/Advertising/Event Management',
            'Medical/Pharmaceutical',
            'Agro (Plant/Animal/Fisheries)',
            'NGO/Development',
            'Research/Consultancy',
            'Receptionist/Personal Secretary',
            'Data Entry/Operator/BPO',
            'Driving/Motor Technician',
            'Security/Support Service',
            'Law/Legal',
            'Company Secretary/Regulatory Affairs',
        ];

        foreach ($categories as $category) {
            JobCategory::create([
                'name'   => $category,
                'status' => 1,
            ]);
        }
    }
}
