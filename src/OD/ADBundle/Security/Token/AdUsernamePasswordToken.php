<?php

namespace OD\ADBundle\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Description of AdUsernamePasswordToken
 *
 * @author mdaumas
 */
class AdUsernamePasswordToken extends UsernamePasswordToken {

    private $mail;
    private $displayName;
    private $dn;

    public function __construct(
    $user, $credentials, $providerKey, array $roles = array(), $mail = '', $displayName = '', $dn = ''
    ) {
        parent::__construct($user, $credentials, $providerKey, $roles);

        $this->mail = $mail;
        $this->displayName = $displayName;
        $this->dn = $dn;
    }
    
    public function getUser(){
        $user = parent::getUser();
        $user->setMail($this->mail);
        $user->setDisplayName($this->displayName);
        $user->setDn($this->dn);
        
        return $user;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function serialize() {
        return serialize(
                        array(
                            $this->mail,
                            $this->displayName,
                            $this->dn,
                            parent::serialize())
        );
    }

    public function unserialize($str) {

        $_str = unserialize($str);
        list(
                $this->mail,
                $this->displayName,
                $this->dn,
                $parentStr
                ) = unserialize($str);

        parent::unserialize($parentStr);
    }

}