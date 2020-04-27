<?php


namespace learn\middleware;


use app\Request;
use learn\exceptions\AuthException;
use learn\interfaces\MiddlewareInterface;

/**
 * token验证
 * Class AuthTokenMiddleware
 * @package learn\middleware
 */
class AuthTokenMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @param bool $force
     * @return mixed
     */
    public function handle(Request $request, \Closure $next, bool $force = true)
    {
        $authInfo = null;
        $token = trim(ltrim($request->header('Authori-zation'), 'Bearer'));
        if(!$token)  $token = trim(ltrim($request->header('Authorization'), 'Bearer'));
        try {
            $authInfo = UserRepository::parseToken($token);
        } catch (AuthException $e) {
            if ($force)
                return app('json')->make($e->getCode(), $e->getMessage());
        }
        if (!is_null($authInfo)) {
            Request::macro('user', function () use (&$authInfo) {
                return $authInfo['user'];
            });
            Request::macro('tokenData', function () use (&$authInfo) {
                return $authInfo['tokenData'];
            });
        }
        Request::macro('isLogin', function () use (&$authInfo) {
            return !is_null($authInfo);
        });
        Request::macro('uid', function () use (&$authInfo) {
            return is_null($authInfo) ? 0 : $authInfo['user']->uid;
        });
        return $next($request);
    }
}