<?php

class ImageValidation
{
    static $ERROR_IMG_INDISPO   = "Aucune image envoyée";
    static $ERROR_IMG_ENVOIE    = "Erreur lors de l'envoie de l'image";
    static $ERROR_IMG_SIZE      = "La taille doit être inférieur à 2Mo";
    static $ERROR_IMG_FOMAT     = "Les formats autorisées sont : ";


    static function validate_post_img($data)
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

        if($data["imgarticle"]["size"] > 2000000)
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

    static function validate_legende($data)
    {
        //Initialisation
        Valitron\Validator::lang('fr');
        $v = new Valitron\Validator($data);

        //condition
        $v->rule('required' , 'legende')->label('Le titre');
        $v->rule('lengthMin', 'legende', 5)->label('Le titre');

        if($v->validate() === true)
        {
            return true;
        }

        $reponse["errors"] = $v->errors();
        return $reponse;
    }

    static function validate_actif($data)
    {
        //Initialisation
        Valitron\Validator::lang('fr');
        $v = new Valitron\Validator($data);

        //condition
        $v->rule('required' , 'actif')->label('Actif');
        $v->rule('integer', 'actif')->label('Actif'); 


        if($v->validate() === true)
        {
            return true;
        }

        $reponse["errors"] = $v->errors();
        return $reponse;
    }
}