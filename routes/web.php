<?php

use Livewire\Volt\Volt;

Volt::route('/', 'pages.images')->name('images');

Volt::route('/create', 'pages.create-image')->name('create-image');

Volt::route('/{image}', 'pages.image')->name('image');

Volt::route('/{image}/edit', 'pages.edit-image')->name('edit-image');
