<?php

namespace Innoscripta\Domain\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth->guard();
    }

    public function __invoke()
    {
        try {
            $this->auth->logout();
        } catch (Exception $exception) {
            return response(null, Response::HTTP_BAD_REQUEST);
        }

        return response(null, Response::HTTP_OK);
    }
}
