<?php

if (! function_exists('appName')) {
    /**
     * Return the application name.
     *
     * @return string
     */
    function appName(): string
    {
        return config('app.name', env('APP_NAME', 'Laravel'));
    }
}
