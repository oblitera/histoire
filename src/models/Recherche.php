<?php

class Recherche {

	static function recherche_by_text($text)
	{
		$results = Article::where('titre', 'like', $text)
							->orWhere('contenu', 'like', $text)
							->paginate(10);

		return $results;
	}
}