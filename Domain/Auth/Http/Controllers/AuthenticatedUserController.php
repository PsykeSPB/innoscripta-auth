<?php

namespace Innoscripta\Domain\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;
use Innoscripta\Domain\Auth\Http\Resources\UserResource;

class AuthenticatedUserController extends Controller
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
            return (new UserResource($user = $this->auth->user()))->additional([
                'data' => [
                    'roles' => $user->role_list,
                    'permissions' => $user->permission_list,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(
                ['Error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
