<?php

namespace App\Http\Middleware;

use App\Http\Services\common;
use App\Http\Services\JsonWebToken;
use Illuminate\Support\Facades\Cache;
use Closure;

class VerifyUserToken
{
    protected $jwt;
    protected $common;
    public function __construct(JsonWebToken $jwt,common $common) {
        $this->jwt = $jwt;
        $this->common = $common;
    }

    public function handle($request,Closure $next) {
        $token = $this->jwt->getToken();
        if(!$token || !Cache::tags("userLogin")->has($token)) {
            return redirect("/admin/unlogin");
        }
        return $next($request);
    }
}
