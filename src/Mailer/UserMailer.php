<?php
/**

 */
namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function welcome($user)
    {
        $this
            ->setTo($user->email)
            ->setSubject('Bienvenue sur notre plateforme !')
            ->setEmailFormat('html') 
            ->viewBuilder()
                ->setTemplate('welcome') 
                ->setLayout('default'); 

        $this->setViewVars(['user' => $user]); 
    }
}

?>



