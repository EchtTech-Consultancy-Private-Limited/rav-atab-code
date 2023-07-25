<?php

namespace Database\Seeders;
use App\Models\Faq;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $FAQ=Faq::create(['title' => 'FAQs','description' => 'Put here your FAQs details','status' => 1]);
    }
}
