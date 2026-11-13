<?php

namespace Tests\Unit\TechTrac;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use MicroweberPackages\Admin\Http\Middleware\Admin;
use PHPUnit\Framework\TestCase;

class AdminRouteExceptionsTest extends TestCase
{
    public function test_only_expected_named_routes_are_excepted(): void
    {
        $middleware = new class extends Admin {
            public function matchesException(Request $request): bool
            {
                return $this->inExceptArray($request);
            }
        };

        $cases = [
            'admin.login' => true,
            'admin.login.index' => true,
            'admin.login.submit' => true,
            'admin.reset.password' => true,
            'admin.dashboard' => false,
            'admin.loginfoo' => false,
            'prefix.admin.login' => false,
            'prefix.admin.login.index' => false,
            'adminXloginYindex' => false,
            'admin.resetter.index' => false,
        ];

        foreach ($cases as $name => $expected) {
            $route = new Route('GET', '/', static function () {});
            $route->name($name);
            $request = Request::create('/');
            $request->setRouteResolver(static function () use ($route) {
                return $route;
            });

            self::assertSame($expected, $middleware->matchesException($request), $name);
        }

        self::assertFalse($middleware->matchesException(Request::create('/')));

        $unnamedRoute = new Route('GET', '/', static function () {});
        $request = Request::create('/');
        $request->setRouteResolver(static function () use ($unnamedRoute) {
            return $unnamedRoute;
        });
        self::assertFalse($middleware->matchesException($request));
    }
}
