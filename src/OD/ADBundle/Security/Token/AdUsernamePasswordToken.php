<?php

namespace OD\ADBundle\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Description of AdUsernamePasswordToken
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 *
 * @SuppressWarnings(PHPMD)
 */
class AdUsernamePasswordToken extends UsernamePasswordToken
{

    /**
     * The user mail adress
     *
     * @var string
     */
    private $mail;

    /**
     * The user display name
     *
     * @var string
     */
    private $displayName;

    /**
     * The user dn
     *
     * @var string
     */
    private $dn;

    /**
     * Constructor
     *
     * @param AdUser  $user
     * @param string  $credentials
     * @param string  $providerKey
     * @param array   $roles
     * @param string  $mail
     * @param string  $displayName
     * @param string  $dn
     */
    public function __construct(
    $user, $credentials, $providerKey, array $roles = array(), $mail = '', $displayName = '',
    $dn = ''
    )
    {
        parent::__construct($user, $credentials, $providerKey, $roles);

        $this->mail = $mail;
        $this->displayName = $displayName;
        $this->dn = $dn;
    }

    /**
     *  Return the token user
     *
     * @return AdUser
     */
    public function getUser()
    {
        $user = parent::getUser();
        $user->setMail($this->mail);
        $user->setDisplayName($this->displayName);
        $user->setDn($this->dn);

        return $user;
    }

    /**
     *  Accessor
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
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Serialization method
     *
     * @return mixed
     */
    public function serialize()
    {
        return serialize(
                array(
                    $this->mail,
                    $this->displayName,
                    $this->dn,
                    parent::serialize()
                )
        );
    }

    /**
     * Unserialize token method
     *
     * @param string $str the serialized string
     */
    public function unserialize($str)
    {

        list(
            $this->mail,
            $this->displayName,
            $this->dn,
            $parentStr
            ) = unserialize($str);

        parent::unserialize($parentStr);
    }

}