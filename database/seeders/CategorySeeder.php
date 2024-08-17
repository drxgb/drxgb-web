<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $plugins = Category::create([ 'name' => 'Plugins' ]);
        $mv = Category::create([ 'name' => 'RPG Maker MV' ]);
        $mz = Category::create([ 'name' => 'RPG Maker MZ' ]);

		$plugins->subcategories()->save($mv);
		$plugins->subcategories()->save($mz);
    }
}
