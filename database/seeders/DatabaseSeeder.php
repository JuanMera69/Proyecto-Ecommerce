<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory()->create([
            'name' => 'Juan Mera',
            'email' => 'juan@gmail.com',
            'email_verified_at' => now(),
        ]);

        Category::factory(10)->create()->each(function ($category) {
            Product::factory(rand(1, 10))->create(['category_id' => $category->id]);
        });
    }
}