<?php

namespace Julienbourdeau\MailView;

use App\Mail\PaymentOrderConfirmed;
use App\Payment;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Tests\MailPreview;

class MailViewController extends BaseController
{
    public function index()
    {
        return view('mail-view::index', [
            'mailViewCollection' => app()->make(MailViewFinder::class)->findAll(),
        ]);
    }

    public function show($className, $methodName)
    {
        $className = rtrim(config('mail-view.namespace'), "\\") ."\\".$className;
        $preview = new $className;
        $mailable =  $preview->{$methodName}();

        $reflexionClass = new \ReflectionClass(new $className);
        $reflextionMethod = $reflexionClass->getMethod($methodName);

        /** @var \Illuminate\Mail\Message $message */
        $message = $mailable->send($this->getNullMailer());

        $attributes = [
            'title' => Str::of($methodName)->kebab()->replace('-', ' ')->title(),
            'subject' => $message->getHeaders()->getAll('subject'),
            'from' => $message->getHeaders()->getAll('from'),
            'headers' => $message->getHeaders()->getAll(),
            'body' => $message->getSwiftMessage()->getBody(),
            'attributes' => MailViewFinder::getMethodAttributes($reflextionMethod),
        ];

        if (method_exists($preview, $afterMethodName = 'after'.Str::studly($methodName))) {
            $afterReflextionMethod = $reflexionClass->getMethod($afterMethodName);
            $afterReflextionMethod->setAccessible(true);
            $afterReflextionMethod->invoke($preview, $afterMethodName);
        }

        if (method_exists($preview, $afterAllMethodName = 'afterAll')) {
            $afterReflextionMethod = $reflexionClass->getMethod($afterAllMethodName);
            $afterReflextionMethod->setAccessible(true);
            $afterReflextionMethod->invoke($preview, $afterAllMethodName);
        }

        return view('mail-view::show', $attributes);
    }

    public function sendAll()
    {
        $email = $this->getEmailAddress();
        $templateList = app()->make(MailViewFinder::class)->findAll();

        $templateList->flatten(1)->each(function ($attr) use ($email) {
            $mailable = (new $attr['className'])->{$attr['methodName']}();
            return Mail::to($email)->send($mailable);
        });

        return redirect(route('mail-view.index'))->with('status', "All emails preview were sent to $email");
    }

    public function send($className, $methodName)
    {
        $className = rtrim(config('mail-view.namespace'), "\\") . "\\" . $className;
        $preview = new $className;
        $mailable = $preview->{$methodName}();
        $email = $this->getEmailAddress();

        Mail::to($email)->send($mailable);

        return redirect(route('mail-view.index'))->with('status', Str::studly($methodName)." preview sent to $email");
    }

    private function getNullMailer()
    {
        $transport = Mail::createTransport([
            'transport' => 'smtp',
            'host'=> 'mail-view.local',
            'port' => 666
        ]);

        return new NullMailer(
            'null_mailer',
            app()['view'],
            new \Swift_Mailer($transport)
        );
    }

    private function getEmailAddress()
    {
        return Auth::user()->email ?? config('mail-view.to');
    }
}
