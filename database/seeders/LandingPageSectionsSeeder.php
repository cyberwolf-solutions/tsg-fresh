<?php

namespace Database\Seeders;

use App\Models\landing_page_sections;
use App\Models\LandingPageSection;
use Illuminate\Database\Seeder;

class LandingPageSectionsSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            ['name' => 'carousel', 'title' => 'Main Carousel'],
            ['name' => 'button_line', 'title' => 'Button Line'],
            ['name' => 'paralax', 'title' => 'Paralax Section'],
            ['name' => 'best_selling', 'title' => 'Best Selling Products'],
            ['name' => 'boat_to_plate', 'title' => 'Boat to Plate'],
            ['name' => 'categories', 'title' => 'Browse Categories'],
            ['name' => 'news', 'title' => 'Latest News'],
        ];

        foreach ($sections as $section) {
            landing_page_sections::create($section);
        }
    }
}
