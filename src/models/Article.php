<?php

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;

	public function commentaires()
	{
		return $this->hasMany('Commentaire', 'article_id');
	}

	public function auteur()
	{
		return $this->belongsTo('Auteur', 'auteur_id');
	}

	public function images()
	{
		return $this->hasMany('Image', 'article_id');
	}

    static function add($data)
    {
    	$article = new Article();
		$article->titre = $data["titre"];
		$article->contenu = $data["contenu"];
		$article->coordonnee_long = $data["coordonnee_long"];
		$article->coordonnee_lat = $data["coordonnee_lat"];
		$article->auteur_id = (int)$data["auteur_id"];
		$article->save();
    }

    static function edit($cible, $data)
    {
		$cible->titre = $data["titre"];
		$cible->contenu = $data["contenu"];
		$cible->coordonnee_long = $data["coordonnee_long"];
		$cible->coordonnee_lat = $data["coordonnee_lat"];
		$cible->auteur_id = (int)$data["auteur_id"];
		$cible->actif = (int)$data["actif"];
		$cible->save();
    }

}