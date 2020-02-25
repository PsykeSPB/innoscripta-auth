<?php

namespace Innoscripta\Domain\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ConsumeExternalService;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Response;
use Innoscripta\Domain\Auth\Http\Resources\UserResource;
use Innoscripta\Domain\Auth\Repositories\Contracts\UserRepository;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class LoginController extends Controller
{
    use ThrottlesLogins, HandlesOAuthErrors, ConsumeExternalService;

    /**
     * @var mixed
     */
    public $baseUri;

    /**
     * @var string
     */
    public $access_token;

    /**
     * The authorization server.
     *
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server;

    /**
     * The JWT parser instance.
     *
     * @var \Lcobucci\JWT\Parser
     */
    protected $jwt;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * LoginController constructor.
     *
     * @param AuthorizationServer $server
     * @param JwtParser $jwt
     * @param UserRepository $userRepository
     */
    public function __construct(AuthorizationServer $server, JwtParser $jwt, UserRepository $userRepository)
    {
        $this->baseUri = env('AUTHS_SERVICE_BASE_URL');
        $this->server = $server;
        $this->jwt = $jwt;
        $this->userRepository = $userRepository;
    }

    /**
     * Authorize a client to access the user's account.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $token = $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });

        $tokenParse = \json_decode($token->getContent(), true);
        if (!empty($tokenParse['access_token'])) {
            /**
             * {
             * "iss": "https://securetoken.google.com",
             * "sub": "user_id"
             * "aud": "project_id",
             * "iat": issued_at,
             * "exp": seconds_to_expiration,
             * "email": "user_email"
             * }
             */
            $this->access_token = $tokenParse['access_token'];
            $parsedToken = $this->jwt->parse($this->access_token);
            $user_id = $parsedToken->getClaim('sub');
            //$user = $this->performRequest('GET', '/api/auth/user');

            return (new UserResource($user = $this->userRepository->find($user_id)))->additional([
                'data' => [
                    'roles' => $user->role_list,
                    'permissions' => $user->permission_list,
                ],
                'meta' => $tokenParse
            ]);
        } else {
            return response()->json(
                ['Error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
