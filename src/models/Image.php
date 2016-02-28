<?php
use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	protected $table = 'images';
	public $timestamps = true;
	static $repertoire_img = "img/articles/";
	static $default_img = "image.fr";

	public function article()
	{
		return $this->belongsTo('\Article', 'article_id');
	}

	public function add($fichier, $legende, $article)
	{
		$image = new Image();
		$image->src = self::$default_img;
		$image->legende = $legende;
		$image->article_id = $article->id;
		$image->save();
		$nom = $article->id."_".$image->id."_".Tools::slugify($article->titre).Tools::getExtension($fichier["imgarticle"]["name"]);
		$image->src = $nom;
		$image->save(); 

		move_uploaded_file($fichier["imgarticle"]["tmp_name"], self::$repertoire_img.$nom);
	}

    static function edit_file($cible, $data)
    {
		move_uploaded_file($data["imgarticle"]["tmp_name"], self::$repertoire_img.$cible->src);
    }
}