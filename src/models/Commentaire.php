<?php
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model {

	protected $table = 'commentaires';
	public $timestamps = true;

	public function article()
	{
		return $this->belongsTo('Article', 'article_id');
	}

    static function add($article, $data)
    {
    	$commentaire = new Commentaire();
		$commentaire->contenu = $data["contenu"];
		$commentaire->article_id = $article->id;
		$commentaire->auteur_id = $data["auteur_id"];
		$commentaire->save();
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