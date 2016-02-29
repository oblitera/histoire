<?php

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model {

	protected $table = 'auteurs';
	public $timestamps = true;

	public function articles()
	{
		return $this->hasMany('Article', 'auteur_id');
	}

	public function commentaires()
	{
		return $this->hasMany('Commentaire', 'auteur_id');
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
        $cible->actif = $data["actif"];
		$cible->save();
    }
}