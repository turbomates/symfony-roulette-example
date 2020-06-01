<?php
declare(strict_types=1);

namespace Identity\Infrastructure\Security;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Mock of authentication
 */
class Authenticator extends AbstractGuardAuthenticator
{
    private const LOGIN_ROUTE = 'login_check';

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse("", Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);
        if (!isset($credentials['username']) || !isset($credentials['password'])) {
            throw new \InvalidArgumentException("Username or password is missed");
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface|SecurityUser $user
     *
     * @return bool|void
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $user->getUser()->authenticate((string)$credentials['password']);

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new AuthenticationException("Bad credentials");
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return new JsonResponse("Ok");
    }

    public function supportsRememberMe()
    {
        return true;
    }
}