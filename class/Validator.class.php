<?php

abstract class Validator {
    
    static function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }
    
    static function validateLogin($login) {
        if (preg_match("/^([a-zA-Z0-9]+)$/", $login))
            return true;
        return false;
    }
    
    static function validatePassword($password) {
        $uppercase = preg_match('/[A-Z]/', $password);
        $lowercase = preg_match('/[a-z]/', $password);
        $number    = preg_match('/[0-9]/', $password);
        
        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8)
            return false;
        return true;
    }
}