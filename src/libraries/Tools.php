<?php

class Tools 
{
	static public function slugify($text)
	{ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  $text = trim($text, '-');
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  $text = strtolower($text);
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  if (empty($text))
	  {
	    return 'n-a';
	  }

	  return $text;
	}

	static public function getExtension($name)
	{
		$extensions = array(
			".jpg",
			".png",
			".gif"
		);

		foreach ($extensions as $extension) 
		{
			if(strpos(strtolower($name), $extension))
			{
				return $extension;
			}
		}

		return "";
	}

    static function get_array_jours($nbJours)
    {
    	$current = new DateTime();
    	$tablDay = array();
    	for ($i=0; $i < $nbJours; $i++) 
    	{ 
    		$tablDay[$current->format('Y-m-d')] = 0;
    		$current->modify('-1 day');
    	}

    	return $tablDay;
    }
}