<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\Comment;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'comment_id' => Comment::inRandomOrder()->first()->id, // Aleatorio
            'url' => $this->faker->imageUrl(640, 480, 'nature'),
        ];
    }
}
