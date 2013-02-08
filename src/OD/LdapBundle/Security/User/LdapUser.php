<?php

namespace OD\LdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * LdapUser is the user implementation used by the LDAP user provider.
 */
class LdapUser implements UserInterface
{

    /**
     *
     * @var string the username
     */
    protected $username;

    /**
     *
     * @var array the user roles
     */
    protected $roles;

    /**
     * Constructor.
     *
     * @param string $username the username
     * @param array  $roles    the roles
     */
    public function __construct($username, array $roles = array())
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username cannot be empty.');
        }

        $this->username = $username;
        $this->roles = $roles;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::__toString()
     *
     * @return string the username
     */
    public function __toString()
    {
        return $this->username;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getRoles()
     *
     * @return array the user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getPassword()
     *
     * @return null
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getSalt()
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::getUsername()
     *
     * @return string the username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @see Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
     * @codeCoverageIgnore
     */
    public function eraseCredentials()
    {

    }

}
