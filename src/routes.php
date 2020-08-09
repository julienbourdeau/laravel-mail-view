<?php

use Julienbourdeau\LaravelMailView\MailViewController;

Route::get('mail_view', [MailViewController::class, 'index']);
Route::get('mail_view/{class_name}/{method_name}', [MailViewController::class, 'show'])->name('mailview.show');
