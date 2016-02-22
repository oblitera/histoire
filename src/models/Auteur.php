<?php

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model {

	protected $table = 'auteurs';
	public $timestamps = true;

	public function articles()
	{
		return $this->hasMany('Article', 'auteur_id');
	}

    static function validate($data, $include_mdp = true)
    {
    	//Initialisation
    	Valitron\Validator::lang('fr');
		$v = new Valitron\Validator($data);

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

		$v->rule('required'	, 'email')->label('L\'email');
		$v->rule('lengthMax', 'email', 50)->label('L\'email');
		$v->rule('lengthMin', 'email', 3)->label('L\'email');
		$v->rule('email'	, 'email')->label('L\'email');


		if($v->validate() === true)
		{
			return true;
		}

		return $erreurs = array(
			"errors"	=> $v->errors(),
			"values"	=> $data
		);
    }

    static function add($data)
    {
    	$auteur = new Auteur();
		$auteur->pseudo = $data["pseudo"];
		$auteur->email = $data["email"];
		$auteur->mdp = md5($data["mdp"]);
		$auteur->save();
    }

    static function edit($cible, $data)
    {
		$cible->pseudo = $data["pseudo"];
		$cible->email = $data["email"];
		$cible->save();
    }

    static function isUniqueEmail($email)
    {
    	$recherche = self::where('email', '=', $email)->get()->toArray();
    	return (empty($recherche)) ? true : false;
    }

    static function isUniquePseudo($pseudo)
    {
    	$recherche = self::where('pseudo', '=', $pseudo)->get()->toArray();
    	return (empty($recherche)) ? true : false;
    }

    static function isValidUpdateEmail($oldEmail, $newEmail)
    {
    	if($oldEmail == $newEmail)
    	{
    		return true;
    	}
    	else
    	{
    		return self::isUniqueEmail($newEmail);
    	}
    }

    static function isValidUpdatePseudo($oldPseudo, $newPseudo)
    {
    	if($oldPseudo == $newPseudo)
    	{
    		return true;
    	}
    	else
    	{
    		return self::isUniquePseudo($newPseudo);
    	}
    }
}