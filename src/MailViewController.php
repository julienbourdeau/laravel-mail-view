<?php

namespace Julienbourdeau\LaravelMailView;

use App\Mail\PaymentOrderConfirmed;
use App\Payment;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Tests\MailPreview;

class MailViewController extends BaseController
{
    public function index()
    {
        return view('laravel-mail-view::index', [
            'mailViewCollection' => app()->make(MailViewFinder::class)->find(),
        ]);
    }

    public function show($className, $methodName)
    {
        $className = rtrim(config('mail-view.namespace'), "\\") ."\\".$className;
        $mailable =  (new $className)->{$methodName}();

        /** @var \Illuminate\Mail\Message $message */
        $message = $mailable->send($this->getNullMailer());

        return view('laravel-mail-view::show', [
            'title' => Str::of($methodName)->kebab()->replace('-', ' ')->title(),
            'subject' => $message->getHeaders()->getAll('subject'),
            'from' => $message->getHeaders()->getAll('from'),
            'headers' => $message->getHeaders()->getAll(),
            'body' => $message->getSwiftMessage()->getBody()
        ]);
    }

    private function getNullMailer()
    {
        $transport = Mail::createTransport(['host'=> 'local.local', 'port' => 666]);

        return new NullMailer(
            'null_mailer',
            app()['view'],
            new \Swift_Mailer($transport)
        );
    }
}
