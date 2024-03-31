<?php

use function Livewire\Volt\{layout, title, state, mount};
use Illuminate\Support\Str;
use App\Models\Image;

layout('components.layouts.app');

title('Image');

state(['title' => '', 'description' => '', 'image']);

mount(function (Image $image) {

    $this->title = $image->title;

    $this->description = $image->description;

    $this->image = $image->imageURL;

});
 
?>

<div class="max-w-lg mx-auto my-10">

    <div class="flex flex-col bg-white md:flex-row">
        <img class="object-cover w-full rounded-lg h-full md:h-auto md:w-48" src="{{ $image }}" alt="{{ $title }}">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                {{ $title }}
            </h5>
            <p class="mb-3 font-normal text-gray-700">
                {{ $description }}
            </p>
        </div>
    </div>

</div>
