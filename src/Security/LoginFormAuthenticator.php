<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    private RouterInterface $router;

    public const LOGIN_ROUTE = 'app_login';



    public function __construct(private UrlGeneratorInterface $urlGenerator, RouterInterface $router)
    {
        $this->router = $router;
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
    {
        // Get the referer from session
        $session = $request->getSession();
        $referer = $session->get('login_referer');

        // Clear the referer from session
        $session->remove('login_referer');

        // Check if referer is the reservation page
        if ($referer && strpos($referer, $this->router->generate('app_reservation')) !== false) {
            return new RedirectResponse($this->router->generate('app_reservation'));
        }

        // Default to dashboard
        return new RedirectResponse($this->router->generate('app_account'));
    }

    // public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    // {
    //     // Optionally handle failure
    //     return parent::onAuthenticationFailure($request, $exception);
    // }
}
