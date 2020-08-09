<?php

namespace Julienbourdeau\LaravelMailView;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class Authorize
{
    public function handle($request, $next)
    {
        return $this->check($request) ? $next($request) : abort(403);
    }

    protected function check($request)
    {
        return App::environment('local') ||
            Gate::check('viewMailView', [$request->user()]);
    }
}
