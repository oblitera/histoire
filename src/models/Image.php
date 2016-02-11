<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	protected $table = 'images';
	public $timestamps = true;

	public function article()
	{
		return $this->belongsTo('\Article', 'article_id');
	}

}