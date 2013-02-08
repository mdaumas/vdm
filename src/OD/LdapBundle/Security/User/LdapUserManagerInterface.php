<?php

namespace OD\LdapBundle\Security\User;

/**
 * Interface for user management
 */
interface LdapUserManagerInterface
{

    /**
     * Looks for username in LDAP
     *
     * @param string $username
     */
    function hasUsername($username);

    /**
     * Request all usernames in LDAP
     */
    function getUsernames();

    /**
     * Get all roles found in LDAP
     */
    function getRoles();

    /**
     * Get roles for username
     *
     * @param type $username
     */
    function getRolesForUsername($username);
}
