<?php
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model {

	protected $table = 'commentaires';
	public $timestamps = true;

	public function article()
	{
		return $this->belongsTo('Article', 'article_id');
	}

}