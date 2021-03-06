<?php

class CommentaireValidation
{
    static function validate_post($data, $include_auteur = false, $include_actif = false)
    {
    	//Initialisation
    	$v = Validation::get_validateur($data);
    	$reponse = Validation::init_reponse();
    	$reponse["values"] = $data;

		//condition
		$v->rule('required'	, 'contenu')->label('Le message');
		$v->rule('lengthMin', 'contenu', 6)->label('Le message');

        if($include_auteur)
        {
            $v->rule('required' , 'auteur_id')->label('Auteur');
            $v->rule('integer', 'auteur_id')->label('Auteur');
        }

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