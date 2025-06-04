<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'organization_name' => 'Piko Tech Services',
            'branches' => ['Ndola HQ', 'Lusaka Office'],
            'departments' => ['IT', 'Sales', 'Support'],
        ]);

        Company::create([
            'organization_name' => 'Tradesmart Supplies Ltd',
            'branches' => ['Kitwe', 'Solwezi'],
            'departments' => ['Logistics', 'Procurement', 'HR'],
        ]);

        Company::create([
            'organization_name' => 'ZamTech Innovations',
            'branches' => ['Lusaka Tech Park', 'Livingstone Hub'],
            'departments' => ['Development', 'Research', 'Customer Success'],
        ]);
    }
}
