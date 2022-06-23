<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'name' => 'Food',
                'slug' => 'food',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ];

        $this->category->insert($categories);
    }
}
