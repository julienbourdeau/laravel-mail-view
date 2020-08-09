<?php

use function Pest\Laravel\get;

it('mail_view is not accessible by default', function () {
    get('/mail_view')->assertStatus(403);
});

it('mail_view works if Gate let you in', function () {
    \Illuminate\Support\Facades\Gate::define('mail_view', function ($user) {
        return true;
    });
    get('/mail_view')->assertStatus(403);
});
