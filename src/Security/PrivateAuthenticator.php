<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class PrivateAuthenticator extends AbstractGuardAuthenticator
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function supports(Request $request): bool
    {
        return $request->getPathInfo() == '/private' && $request->isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        // Pas besoin de credentials pour une page accessible par tous les utilisateurs
        return [];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        // Aucun utilisateur à récupérer, car la page est accessible par tous
        return null;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // Aucune vérification de credentials nécessaire pour une page accessible par tous
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        // Redirection vers la page privée après une authentification réussie
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Gestion de l'échec d'authentification si nécessaire
        return parent::onAuthenticationFailure($request, $exception);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        // Redirection vers la page de login si l'utilisateur n'est pas authentifié
        return new RedirectResponse('/login');
    }
}