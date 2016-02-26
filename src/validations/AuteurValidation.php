<?php

class AuteurValidation
{
	static $ERROR_PSEUDO_DUPLI		= "Ce pseudo est déjà utilisé";
	static $ERROR_EMAIL_DUPLI		= "Cet email est déjà utilisé";


    static function validate_created($data)
    {
    	$validation = self::validate_post($_POST);
	    if($validation !== true)
	    {
	    	return $validation;
	    }

	    $validation = self::isUniqueEmail($_POST['email']);
	    if($validation !== true)
	    {
	    	return $validation;
	    }

	    $validation = self::isUniquePseudo($_POST['pseudo']);
	    if($validation !== true)
	    {
	    	return $validation;
	    }

	    return true;	    
    }

    static function validate_update($data, $oldEmail, $oldPseudo)
    {
    	$validation = self::validate_post($_POST, false, true);
	    if($validation !== true)
	    {
	    	return $validation;
	    } 

    	if($oldEmail != $data["email"])
    	{
    		$validation = self::isUniqueEmail($data["email"]);
		    if($validation !== true)
		    {
		    	return $validation;
		    } 
    	}	

    	if($oldEmail != $data["email"])
    	{
    		$validation = self::isUniqueEmail($data["email"]);
		    if($validation !== true)
		    {
		    	return $validation;
		    } 
    	}

    	if($oldPseudo != $data["pseudo"])
    	{
    		$validation = self::isUniquePseudo($data["pseudo"]);
		    if($validation !== true)
		    {
		    	return $validation;
		    } 
    	}
    	
    	return true;
    }



    static function validate_post($data, $include_mdp = true, $include_actif = false)
    {
    	//Initialisation
    	$v = Validation::get_validateur($data);
    	$reponse = Validation::init_reponse();
    	$reponse["values"] = $data;

		//condition
		$v->rule('required'	, 'pseudo')->label('Le nom');
		$v->rule('lengthMax', 'pseudo', 30)->label('Le nom');
		$v->rule('lengthMin', 'pseudo', 3)->label('Le nom');

		if($include_mdp)
		{
			$v->rule('required'	, 'mdp')->label('Le mot de passe');
			$v->rule('lengthMax', 'mdp', 30)->label('Le mot de passe');
			$v->rule('lengthMin', 'mdp', 5)->label('Le mot de passe');			
		}

        if($include_actif)
        {
            $v->rule('required' , 'actif')->label('Le mot de passe');
            $v->rule('integer', 'actif')->label('Le mot de passe');        
        }

		$v->rule('required'	, 'email')->label('L\'email');
		$v->rule('lengthMax', 'email', 50)->label('L\'email');
		$v->rule('lengthMin', 'email', 3)->label('L\'email');
		$v->rule('email'	, 'email')->label('L\'email');


		if($v->validate() === true)
		{
			return true;
		}

		$reponse["errors"] = $v->errors();
		return $reponse;
    }


    /*
		SPECIFIQUE RULES
    */

    static function isValidePass($data)
    {
		$v = Validation::get_validateur($data);
        $v->rule('required' , 'mdp')->label('Le mot de passe');
        $v->rule('lengthMax', 'mdp', 30)->label('Le mot de passe');
        $v->rule('lengthMin', 'mdp', 5)->label('Le mot de passe'); 

        if($v->validate() === true)
        {
            return true;
        }

    	$reponse = Validation::init_reponse();
    	$reponse["values"] = $data;
    	$reponse["errors"] = $v->errors();
    	return $reponse;
    }

    static function isUniqueEmail($email)
    {
    	$recherche = Auteur::where('email', '=', $email)->get()->toArray();
    	
    	if(empty($recherche))
    	{
    		return true;
    	}

    	$reponse = Validation::init_reponse();
    	$reponse["values"]["email"] = $email;
    	$reponse["errors"]["email"] = self::$ERROR_EMAIL_DUPLI;
		return $reponse;    	
    }

    static function isUniquePseudo($pseudo)
    {
    	$recherche = Auteur::where('pseudo', '=', $pseudo)->get()->toArray();
    	
    	if(empty($recherche))
    	{
    		return true;
    	}

    	$reponse = Validation::init_reponse();
    	$reponse["values"]["email"] = $pseudo;
    	$reponse["errors"]["email"] = self::$ERROR_PSEUDO_DUPLI;
		return $reponse;  
    }
}