<?php

namespace OD\ADBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserInterface Implementation
 *
 * @SuppressWarnings(PHPMD)
 */
class AdUser implements UserInterface
{

    /**
     * The username
     *
     * @var string
     */
    private $username;

    /**
     * The password
     *
     * @var string
     */
    private $password;

    /**
     * The salt
     *
     * @var string
     */
    private $salt;

    /**
     * The roles
     *
     * @var array
     */
    private $roles;

    /**
     * The user mail adress
     *
     * @var string
     */
    private $mail;

    /**
     * The user dn
     *
     * @var string
     */
    private $dn;

    /**
     * The user display name
     *
     * @var string
     */
    private $displayName;

    /**
     * Constructor
     *
     * @param type  $username The username
     * @param type  $password The password
     * @param array $roles    The roles
     */
    public function __construct($username, $password, array $roles)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = '';
        $this->roles = $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *  Set the password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        //return void ;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array Role[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the roles
     *
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Accessor
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getDisplayName()
    {

        return $this->displayName;
    }

    /**
     * Accessor
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getMail()
    {

        return $this->mail;
    }

    /**
     * Accessor
     *
     * @param string $dn
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
    }

    /**
     * Accessor
     *
     * @return type
     */
    public function getDn()
    {

        return $this->dn;
    }

}