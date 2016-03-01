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

    static function stat($nbJours)
    {
    	$tablDay = Tools::get_array_jours(7);
    	
    	foreach ($tablDay as $date => &$value) 
    	{
    		$value = Auteur::whereRaw('created_at > "'.$date.' 00:00:00" and created_at < "'.$date.' 23:59:59"')->count();
    	}
    	unset($value);
    	
    	return $tablDay;
    }
}