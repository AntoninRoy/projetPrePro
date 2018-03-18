<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;
///https://stackoverflow.com/questions/9129784/implement-change-password-in-symfony2
class ChangeParameters
{
        /**
        * @Assert\NotBlank()
     * @SecurityAssert\UserPassword(
     *     message = "Ce n'est pas l'ancien mot de passe"
     * )
     */
     protected $oldPassword;

    /**
    * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Le nouveau mot de passe doit faire plus de 6 caractères"
     * )
     */
     protected $newPassword;


    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }
     public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }
     public function getNewPassword()
    {
        return $this->newPassword;
    }

}


