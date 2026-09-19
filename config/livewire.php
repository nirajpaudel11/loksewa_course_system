<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root class namespace for Livewire component classes in
    | your application. This value will change where component auto-discovery
    | finds components. It's also referenced by the make:livewire command.
    |
    */

    'class_namespace' => 'App\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value is the path where Livewire component views are stored.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    | The default layout view that will be used when rendering a component via
    | Route::get('/foo', MyComponent::class);
    |
    */

    'layout' => 'components.layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |--------------------------------------------------------------------------
    | Livewire allows you to lazy load components that would otherwise slow down
    | the initial page load. Every component can have a custom placeholder or
    | you can define the default placeholder view so you don't have to define it
    | every time.
    |
    */

    'lazy_placeholder' => null,

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire handles file uploads originally by storing them in a temporary
    | directory before storing them in a permanent location. You can configure
    | that directory and other options here.
    |
    */

    'temporary_file_upload' => [
        'disk' => null,
        'rules' => ['file', 'max:102400'],
        'directory' => 'livewire-tmp',
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma', 'pdf',
        ],
        'max_upload_time' => 30,
        'cleanup' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Render On Redirect
    |--------------------------------------------------------------------------
    |
    | This value determines if Livewire will run a component's `render()` method
    | after a redirect has been triggered using something like `redirect(...)`
    | Setting this to true will allow morphdom to properly patch the DOM,
    |
    */

    'render_on_redirect' => false,

    /*
    |--------------------------------------------------------------------------
    | Eloquent Model Binding
    |--------------------------------------------------------------------------
    |
    | Previous versions of Livewire supported binding directly to eloquent model
    | properties using wire:model="post.title". Now, this behavior is disabled
    | by default for safety.
    |
    */

    'legacy_model_binding' => false,

    /*
    |--------------------------------------------------------------------------
    | Auto-inject Frontend Assets
    |--------------------------------------------------------------------------
    |
    | By default, Livewire automatically injects its JavaScript and CSS into the
    | <head> and <body> of pages containing Livewire components. By setting this
    | to false, you will need to manually include <livewire:styles /> and
    | <livewire:scripts /> on every page where you want to use Livewire.
    |
    */

    'inject_assets' => true,

    /*
    |--------------------------------------------------------------------------
    | Navigate (SPA mode)
    |--------------------------------------------------------------------------
    |
    | By default, Livewire treats all links as standard HTML links. By setting
    | this to true, all links will automatically use wire:navigate.
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#10b981',
    ],

    /*
    |--------------------------------------------------------------------------
    | HTML Morph Markers
    |--------------------------------------------------------------------------
    |
    | Livewire puts comments before and after components to determine where they
    | start and end. This is so that Livewire can morph the DOM without
    | destroying surrounding elements.
    |
    */

    'pagination_theme' => 'tailwind',

];
