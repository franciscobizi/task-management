<?php

namespace FB\src;

/**
* Validator class for validating datas 
*
* PHP Version 7+
*
* Methods : isEmpty, IsEmail, cleanData
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class Validator 
{
	/**
    *   
    *  Method that verify empty values
    *
    *  @param array $data
    *  @return bool
    */
	public static function isEmpty($data) : bool
	{
		if (in_array("", $data)) {
			return true;
			exit;
		}

		return false;
	}

	/**
    *   
    *  Method that verify if is an email
    *
    *  @param string $email
    *  @return bool
    */
	public static function IsEmail($email) : bool
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		   return true;
		   exit;
		}

		return false;
	}

	/**
    *   
    *  Method that verify clear
    *
    *  @param array $data
    *  @return array $data
    */
	public static function cleanData($data) : array
	{
		$newData = array_map(function($val){
		    return trim(strip_tags($val));
		}, $data);

		return $newData;
	}
}