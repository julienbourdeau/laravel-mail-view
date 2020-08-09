<?php

use Julienbourdeau\LaravelMailView\MailViewController;
use Julienbourdeau\LaravelMailView\Authorize;

Route::middleware(Authorize::class)->name('mail-view.')->group(function () {

    Route::get('mail_view', [MailViewController::class, 'index'])->name('index');

    Route::get('mail_view/{class_name}/{method_name}', [MailViewController::class, 'show'])->name('show');

});
