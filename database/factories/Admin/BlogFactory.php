<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Blog::class;
    public function definition()
    {
        $title = $this->faker->unique()->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => "true",
            'created_by' => 1,
            'description' => $this->faker->text(300),
        ];
    }
}
