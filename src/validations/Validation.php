<?php

class Validation
{
	static function init_reponse()
	{
		return array(
			"errors" => array(),
			"values" => array(),
			"errors_general" => array()
		);
	}

	static function get_validateur($data, $lang = 'fr')
	{
    	Valitron\Validator::lang($lang);
		return new Valitron\Validator($data);		 
	}
}