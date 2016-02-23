<?php

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;

	public function commentaires()
	{
		return $this->hasMany('Commentaire', 'article_id');
	}

	public function user()
	{
		return $this->belongsTo('Auteur', 'auteur_id');
	}

	public function images()
	{
		return $this->hasMany('Image', 'article_id');
	}

	static function validate($data)
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
    	$article = new Article();
		$article->titre = $data["titre"];
		$article->contenu = $data["contenu"];
		$article->coordonnee_long = $data["coordonnee_long"];
		$article->coordonnee_lat = $data["coordonnee_lat"];
		$article->auteur_id = $data["auteur_id"];
		$article->save();
    }

}