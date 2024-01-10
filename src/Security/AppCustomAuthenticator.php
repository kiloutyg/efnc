<?php

namespace App\Security;

use App\Repository\UserRepository;

use Psr\Log\LoggerInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

use Symfony\Component\Security\Http\Util\TargetPathTrait;

// Manage the authentication of the user using the login form
class AppCustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    protected $urlGenerator;
    protected $controller;
    protected $userRepository;
    protected $logger;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        LoggerInterface $logger
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function authenticate(Request $request): Passport
    {

        $name = $request->request->get('username', '');

        $user = $this->userRepository->findOneBy(['username' => $name]);

        if ($user === null) {
            // Handle case where the username is not found
            throw new CustomUserMessageAuthenticationException('Username could not be found.');
        }

        if ($user->getPassword() === null) {
            // Handle case where the user does not have a password
            throw new CustomUserMessageAuthenticationException('This user does not have log in rights.');
        }
        return new Passport(
            new UserBadge($name),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}