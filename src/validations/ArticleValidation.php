<?php

class ArticleValidation
{
    static function validate_created($data)
    {
    	$validation = self::validate_post($_POST);
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

	    return true;
    }

    static function validate_post($data, $include_actif = false)
    {
    	//Initialisation
    	Valitron\Validator::lang('fr');
		$v = new Valitron\Validator($data);

		//condition
		$v->rule('required'	, 'titre')->label('Le titre');
		$v->rule('lengthMin', 'titre', 5)->label('Le titre');

		$v->rule('required'	, 'contenu')->label('Le contenu');
		$v->rule('lengthMin', 'contenu', 10)->label('Le contenu');

		$v->rule('required'	, 'coordonnee_long')->label('La longitude');
		$v->rule('numeric', 'coordonnee_long')->label('La longitude');

		$v->rule('required'	, 'coordonnee_lat')->label('La latitude');
		$v->rule('numeric', 'coordonnee_lat')->label('La latitude');

		$v->rule('required'	, 'auteur_id')->label('L\'auteur');
		$v->rule('integer', 'auteur_id')->label('L\'auteur');

        if($include_actif)
        {
            $v->rule('required' , 'actif')->label('Le mot de passe');
            $v->rule('integer', 'actif')->label('Le mot de passe');        
        }


		if($v->validate() === true)
		{
			return true;
		}

		$reponse["errors"] = $v->errors();
		return $reponse;
    }
}