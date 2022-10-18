<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController 
{
    public static function login(Router $router)
    {
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();
            
            if(empty($alerts))
            {
                $user = User::where('email', $auth->email);
                if( $user?->token )
                {
                    User::setAlert("error", "You've already requested a password change, the email should be in your inbox.");
                }
                else if($user->confirmed === 1 and !$user?->token)
                {
                    $user->createToken();
                    $user->confirmed = 0;
                    $user->update();
                    
                    $email = new Email($user->first_name, $user->last_name, $user->email, $user->token);
                    $email->sendInstructions();
                    User::setAlert('success', 'We have sent you an email to reset your password.');
                }
                else
                {
                    User::setAlert('error', 'El user no existe o no esta confirmed');
                }
            }
        }
        $alerts = User::getAlert();
        $router->render('auth/forgot-password', [
            'alerts' => $alerts,
            'title' => 'Forgot Password'
        ]);
    }
   
}