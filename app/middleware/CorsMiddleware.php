<?php
declare (strict_types = 1);

namespace app\middleware;

use think\Request;
use think\Response;

class CorsMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        // 允许的域名列表，根据你的需求进行修改
        $allowOrigin = [
            'http://localhost:3000', // 允许的前端域名
        ];

        $origin = $request->header('origin');

        // if (in_array($origin, $allowOrigin)) {
            header('Access-Control-Allow-Origin: *' );
            header('Access-Control-Allow-Headers: Content-Type');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Credentials: true');
        // }

        if ($request->isOptions()) {
            return Response::create()->code(200);
        }

        return $next($request);
    }
}
