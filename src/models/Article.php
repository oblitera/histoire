<?php

namespace App;

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

}