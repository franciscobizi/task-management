<?php

namespace FB\src;
use App\db\DB;

/**
 * Auth class for authentication
 * 
 * PHP Version 7+
 *
 * Methods : getUserData, generateRandom, loginUser, isLoggedIn, loggedOut
 *
 * @author Francisco Bizi <taylorsoft28@gmail.com>
*/
class Auth extends Model 
{
    /**
    *   
    *  Method getting user data
    *
    *  @param string $username
    *  @return array $data
    */
    private static function getUserData($username) 
    {
        return parent::query("SELECT id, password FROM users WHERE username=:username", 
                              array(':username' => $username));
    }

    /**
    *   
    *  Method that generate token
    *
    *  @param int $length
    *  @return string $token
    */
    private static function generateRandom($length = 64) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
    *   
    *  Method for inserting token after successful authentication
    *
    *  @param string $username
    *  @param string $password
    *  @return array $data
    */
    public static function loginUser($username, $password) 
    {
        $tok = self::generateRandom();
        $user = self::getUserData($username);
        if(password_verify($password, $user[0]['password']))
        {
            setcookie("SSID", $tok, time() + 3600, BASEDIR);
            return parent::query("INSERT INTO log_tokens (token, uid) VALUES (:token,:uid)", array(':uid' => $user[0]['id'], ':token' => sha1($tok)));
            
        }
    }

    /**
    *   
    *  Method for checking if user are loggedin
    *
    *  
    *  @return boolean true/false
    */
    public static function isLoggedIn() 
    {
        if (isset($_COOKIE['SSID'])) {
          return true;
        } else {
          return false;
        }
    }

    /**
    *   
    *  Method that logout the user from his account
    *
    *  
    *  @return boolean true
    */
    public static function loggedOut() 
    {
        if (isset($_COOKIE['SSID'])) {
            unset($_COOKIE['SSID']);
            setcookie("SSID", '', time() - 3600, BASEDIR);
            return true;
        }
    }

}
