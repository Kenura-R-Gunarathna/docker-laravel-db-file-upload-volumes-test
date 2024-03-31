<?php

use function Livewire\Volt\{usesFileUploads, layout, title, state, mount, rules};
use Illuminate\Support\Str;
use App\Models\Image;
 
usesFileUploads();

layout('components.layouts.app');

title('Create Images');

state(['title' => '', 'description' => '', 'image', 'status']);

rules(['title' => 'required|min:5|max:50', 'description' => 'required|min:5|max:500', 'image' => 'required|image|max:1024']);

mount(function () {

    $this->status = ['is_error' => false, 'message' => ''];
});

$save = function () {
    
    $validated = $this->validate();

    try {
        
        $imageName = $this->image->storePubliclyAs(path: 'public/images', name: Str::uuid()->toString(). '.' . $this->image->getClientOriginalExtension());
        $imagePath = str_replace('public/', 'storage/', $imageName);
        
        $image = new Image;
        $image->title = $this->title;
        $image->description = $this->description;
        $image->image_path = $imagePath;
        $image->save();

        $this->status['is_error'] = false;
        $this->status['message'] = $th->getMessage();

    } catch (\Throwable $th) {

        $this->status['is_error'] = true;
        $this->status['message'] = $th->getMessage();
    }

};
 
?>

<div>
    <form wire:submit="save" class="max-w-sm mx-auto my-10">
        <h2 class="text-2xl text-gray-900 mb-5">Create Images</h2>
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Image title</label>
            <input 
                wire:model="title"
                type="text" 
                id="title" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                placeholder="Awsome foods" 
            />
            @error('title') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-5">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Image description</label>
            <textarea 
                wire:model="description"
                id="message" 
                rows="4" 
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Write your image description here..."
            >
            </textarea>
            @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-5">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-fit border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 p-2">
                    @if ($image) 
                        <img class="rounded-lg" src="{{ $image->temporaryUrl() }}">
                    @else
                        <div class="flex flex-col items-center justify-center p-8">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                    @endif
                    <input
                        wire:model="image" 
                        id="dropzone-file" 
                        type="file" 
                        class="hidden" 
                    />
                </label>
            </div> 
            @error('image') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <button 
            type="submit" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
        >
            Submit
        </button>

        @if($status['is_error'])
            <div class="flex items-center p-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Error</span>
                <div>
                    {{ $status['message'] }}
                </div>
            </div>
        @else
            @if($status['message'])
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Success</span>
                    <div>
                        {{ $status['message'] }}
                    </div>
                </div>
            @endif
        @endif

    </form>

</div>
