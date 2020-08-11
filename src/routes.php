<?php

use Julienbourdeau\MailView\MailViewController;
use Julienbourdeau\MailView\Authorize;

$urlPrefix = rtrim(config('mail-view.url_prefix'), '/');

Route::middleware(['web', Authorize::class])->prefix($urlPrefix)->name('mail-view.')->group(function () {

    Route::get('/', [MailViewController::class, 'index'])->name('index');

    Route::get('/{class_name}/{method_name}', [MailViewController::class, 'show'])->name('show');

    Route::get('/{class_name}/{method_name}/send', [MailViewController::class, 'send'])->name('send');

    Route::get('/send-all', [MailViewController::class, 'sendAll'])->name('send-all');

});
