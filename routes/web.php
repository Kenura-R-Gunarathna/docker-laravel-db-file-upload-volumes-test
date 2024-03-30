<?php

use Livewire\Volt\Volt;

Volt::route('/', 'pages.images');

Volt::route('/create', 'pages.create-image');

Volt::route('/{id}', 'pages.image');

Volt::route('/{id}/edit', 'pages.edit-image');

Volt::route('/{id}/delete', 'pages.delete-image');
