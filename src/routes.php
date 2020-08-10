<?php

use Julienbourdeau\MailView\MailViewController;
use Julienbourdeau\MailView\Authorize;

Route::middleware(Authorize::class)->name('mail-view.')->group(function () {

    $urlPrefix = rtrim(config('mail-view.url_prefix'), '/');

    Route::get($urlPrefix, [MailViewController::class, 'index'])->name('index');

    Route::get($urlPrefix.'/{class_name}/{method_name}', [MailViewController::class, 'show'])->name('show');

});
