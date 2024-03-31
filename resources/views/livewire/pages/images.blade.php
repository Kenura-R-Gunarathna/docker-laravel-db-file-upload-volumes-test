<?php

use function Livewire\Volt\{layout, title, state, rendering};
use Illuminate\Support\Str;
use App\Models\Image;

layout('components.layouts.app');

title('All images');

state(['images' => fn () => Image::all()]);

$remove = function(string $id){
    
    $image = Image::find($id);

    $image->delete();

    $this->images = Image::all();
}

?>

<div class="max-w-2xl mx-auto my-10">
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($images as $key => $image)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $image->title }}
                        </th>
                        <td class="px-6 py-4">
                            <div class="max-w-8 line-clamp-3">
                                {{ $image->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <img class="object-cover w-full rounded-lg h-8" src="{{ $image->imageURL }}" alt="{{ $image->title }}">
                        </td>
                        <td class="flex items-center px-6 py-4">
                            <a href="{{ route('edit-image', ['image' => $image->id]) }}" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <a wire:click="remove('{{ $image->id }}')" class="cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                        </td>
                    </tr>
                @endforeach
            
            </tbody>
        </table>
    </div>

</div>
