<?php

class ImageValidation
{
    static $ERROR_IMG_INDISPO   = "Aucune image envoyée";
    static $ERROR_IMG_ENVOIE    = "Erreur lors de l'envoie de l'image";
    static $ERROR_IMG_SIZE      = "La taille doit être inférieur à 2Mo";
    static $ERROR_IMG_FOMAT     = "Les formats autorisées sont : ";

    static function validate_created($data)
    {
        $validation = self::validate_post($data);
        if($validation !== true)
        {
            return $validation;
        }

        return true;
    }

    static function validate_post($data)
    {
        $reponse = Validation::init_reponse();
        $reponse["values"]["imgarticle"] = $data;
        $format_autoriser = array("image/png", "image/jpeg");

        if(empty($data["imgarticle"]))
        {
            $reponse["errors"]["imgarticle"][] = self::$ERROR_IMG_INDISPO;
            return $reponse;
        }

        if(empty($data["imgarticle"]["name"]))
        {
            $reponse["errors"]["imgarticle"][] = self::$ERROR_IMG_INDISPO;
            return $reponse;
        }

        if(!empty($data["imgarticle"]["error"]))
        {
            $reponse["errors"]["imgarticle"][] = self::$ERROR_IMG_ENVOIE;
            return $reponse;
        }  

        if($data["imgarticle"]["size"] > 200000)
        {
            $reponse["errors"]["imgarticle"][] = self::$ERROR_IMG_SIZE;
            return $reponse;
        } 

        if(!in_array(strtolower($data["imgarticle"]["type"]), $format_autoriser))
        {
            $reponse["errors"]["imgarticle"][] =self::$ERROR_IMG_FOMAT.implode(",",$format_autoriser);
            return $reponse;
        }

	    return true;	    
    }


}