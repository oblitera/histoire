<?php

class Recherche {

	static function recherche_by_text($text, $offset=0, $limit=6)
	{
		$reponse = array(
			"data" 			=> self::build_condition_text($text)->take($limit)->offset($offset)->get()->toArray(),
			"limit" 		=> $limit,
			"offset" 		=> $offset,
			"total_result" 	=> self::build_condition_text($text)->count()			
		);

		$reponse["nbPage"] 		= round($reponse["total_result"] / $limit);
		$reponse["currentPage"] = round($offset/$limit);

		return $reponse;
	}

	static function build_condition_text($text)
	{
		return Article::with('images')
					->where('titre', 'like', $text)
					->orWhere('contenu', 'like', $text);
	}

	static function recherche_by_proximity($long, $lat, $rayon = 30)
	{
		$condition_gps ="(6366*ACOS(COS(RADIANS(".$lat."))*COS(RADIANS(coordonnee_lat))*COS(RADIANS(coordonnee_long)-RADIANS(".$long."))+SIN(RADIANS(".$lat."))*SIN(RADIANS(coordonnee_lat))))<".$rayon;

		return Article::with('images','auteur')
					->whereRaw($condition_gps)
					->take(10)
					->offset(0)
					->get()
					->toArray();
	}
}