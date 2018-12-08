<?php

namespace FB\src;
use FB\db\DataBase;
use \Firebase\JWT\JWT;

/**
 * Auth class for authentication
 * 
 * PHP Version 7+
 *
 * Methods : getUserData, generateRandom, loginUser, isLoggedIn, loggedOut
 *
 * @author Francisco Bizi <taylorsoft28@gmail.com>
*/
class Auth extends DataBase 
{
    private static $Skey = 'THE_APP_PRIVATE_KEY';

    /**
    *   
    *  Method getting user data
    *
    *  @param string $username
    *  @return array $data
    */
    private static function getUserData(string $username) : array 
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
    private static function generateToken($user) 
    {
        
        $data = [
                    "iss" => "http://localhost/task-management/",
                    "aud" => "http://localhost/task-management/",
                    "iat" => time(),
                    'userName' => $user
                ];

        $jwt = JWT::encode($data, self::$Skey);

        return $jwt;
    }

    /**
    * Verify the token
    * 
    * @param string $token
    * @return array $payload if verified and false if not
    */
    public static function isValidToken($jwt)
    {    
        try 
        {
            JWT::$leeway = 60;
            return JWT::decode($jwt, self::$Skey, array('HS256'));
        }catch (Exception $e) {
            return false;
        }
    }

    /**
    *   
    *  Method for inserting token after successful authentication
    *
    *  @param string $username
    *  @param string $password
    *  @return array $data
    */
    public static function loginUser(string $username, string $password) 
    {
        $user = self::getUserData($username);
        if (!$user) {
            return 0;
        }

        if(password_verify($password, $user[0]['password']))
        {
            $tok = self::generateToken($username);
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
    public static function isLoggedIn() : bool
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
    public static function loggedOut() : bool
    {
        if (isset($_COOKIE['SSID'])) {
            unset($_COOKIE['SSID']);
            setcookie("SSID", '', time() - 3600, BASEDIR);
            return true;
        }
    }

}
