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

	static function get_post_multiple()
	{
		$candidats = array();
		$format_autoriser = array("image/png", "image/jpeg");


		if(empty($_FILES["imgarticle"]))
		{
			return false;
		}

		if(empty($_FILES["imgarticle"]["name"]))
		{
			return false;
		}

		foreach ($_FILES["imgarticle"]["name"] as $index => $img) 
		{
			if(empty($img))
			{
				continue;
			}

			if(!empty($_FILES["imgarticle"]["error"][$index]))
			{
				continue;
			}

			$legende = (empty($_POST["imgarticle"][$index])) ? "" : strip_tags($_POST["imgarticle"][$index]);

			$candidats[] = array(
				"name" 		=> $img,
				"type" 		=> $_FILES["imgarticle"]["type"][$index],
				"tmp_name" 	=> $_FILES["imgarticle"]["tmp_name"][$index],
				"size" 		=> $_FILES["imgarticle"]["size"][$index],
				"legende"	=> $legende,
				"erreur"	=> array(),
				"index_inp"	=> $index 
			);
		}

		if(empty($candidats))
		{
			return false;
		}

		foreach ($candidats as &$candidat) 
		{
			if($candidat["size"] > 200000)
			{
				$candidat["erreur"][] = "La taille doit être inférieur à 2Mo";
			}

			$format = strtolower($candidat["type"]);
			if(!in_array($format, $format_autoriser))
			{
				$candidat["erreur"][] = "Les formats autorisées sont :".implode(",",$format_autoriser);
			}			
		}
		
		return $candidats;
	}

}