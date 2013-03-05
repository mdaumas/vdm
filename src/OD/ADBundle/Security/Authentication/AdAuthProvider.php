<?php

namespace OD\ADBundle\Security\Authentication;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use OD\ADBundle\Security\Token\AdUsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use OD\ADBundle\Service\AdldapService;
use OD\ADBundle\Security\User\AdUserProvider;
use OD\ADBundle\Security\User\AdUser;

/**
 * Authentication provider class
 * Handle Authentication Provider Interface for AD
 */
class AdAuthProvider implements AuthenticationProviderInterface
{

    /**
     * The user provider instance
     *
     * @var OD\ADBundle\Security\User\adUserProvider
     */
    private $userProvider;

    /**
     *
     * @var type
     */
    private $config;

    /**
     *
     * @var type
     */
    private $adLdapService;

    /**
     * Constructor
     *
     * @param AdUserProvider $userProvider  the user provider instance
     * @param type           $config        the config
     * @param AdldapService  $adldapService the adLdapService
     */
    public function __construct(AdUserProvider $userProvider, $config, AdldapService $adldapService)
    {
        $this->userProvider = $userProvider;
        $this->config = $config;
        $this->adLdapService = $adldapService;
    }

    /**
     * Attempts to authenticates a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        $adLdap = $this->adLdapService->getInstance();
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if (!$adLdap->authenticate($user->getUsername(), $token->getCredentials())) {
            throw new BadCredentialsException('Bad credentials.');
        }

        $user->setPassword($token->getCredentials());
        $this->userProvider->fetchData($user, $adLdap);

        $newToken = new AdUsernamePasswordToken(
                $user,
                $token->getCredentials(),
                "active.directory.user.provider",
                $user->getRoles(),
                $user->getMail(),
                $user->getDisplayName(),
                $user->getDn()
        );

        return $newToken;
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return Boolean true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }

}