<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Section::create(['section_name' => 'بنك الأهلي', 'created_by' => now()]);
        Section::create(['section_name' => 'بنك الرياض', 'created_by' => now()]);
        
    }
}
