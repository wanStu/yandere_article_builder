<?php

namespace App\Http\Middleware;

use App\Http\Services\CommonService;
use App\Http\Services\JsonWebTokenService;
use Illuminate\Support\Facades\Cache;
use Closure;

class VerifyUserToken
{
    protected $jwt;
    protected $common;
    public function __construct(JsonWebTokenService $jwt, CommonService $common) {
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
