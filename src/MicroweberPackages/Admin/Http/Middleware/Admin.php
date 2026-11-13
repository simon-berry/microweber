<?php

namespace MicroweberPackages\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use MicroweberPackages\Admin\Events\ServingAdmin;

class Admin
{
    protected $except = [
        'admin.login.*',
        'admin.reset.*',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (!mw_is_installed()) {
            return redirect(site_url());
        }

        ServingAdmin::dispatch();
        event_trigger('mw.admin');
        event_trigger('mw_backend');

        view()->share('isIframe', $request->header('Sec-Fetch-Dest') === 'iframe');

        if ($this->inExceptArray($request) || (Auth::check() && intval(Auth::user()->is_admin) === 1)) {
            if (defined('MW_VERSION')) {
                app()->update->perform_post_update_if_needed();
            }

            return $next($request);
        }

        // Installed sites must not grant access merely because no administrator exists.
        return redirect()->guest(route('admin.login'));
    }

    protected function inExceptArray($request)
    {
        $routeName = optional($request->route())->getName();

        if (!is_string($routeName)) {
            return false;
        }

        foreach ($this->except as $except) {
            if (Str::is($except, $routeName)) {
                return true;
            }
        }

        return false;
    }
}
