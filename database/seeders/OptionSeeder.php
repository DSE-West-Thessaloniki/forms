<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            ['name' => 'first_run', 'value' => '1']
        ];

        foreach($options as $option) {
            Option::updateOrCreate($option);
        }
    }
}
