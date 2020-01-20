<?php

namespace Twitf\Framework\Auth;


use Hyperf\Utils\Str;
use Psr\Http\Message\ServerRequestInterface;

abstract class Authorization
{

    public function validateAuthorizationHeader(ServerRequestInterface $request)
    {
        if (Str::startsWith(strtolower($request->getHeader('authorization')), $this->getAuthorizationMethod())) {
            return true;
        }

        throw new BadRequestHttpException;
    }
}
