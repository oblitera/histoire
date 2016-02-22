<?php

class ControllerAdmin extends Controller
{
	static $MSG_ERROR_DROIT				= "Vous n'avez pas les droits pour accéder à cette page";

	public function init()
	{
		if(empty($_SESSION["auteur"]))
		{
    		/*$route = $this->app
    					  ->router
    					  ->pathFor('front.index',[]);

    		$this->app
    			 ->flash
    			 ->addMessage('success', ControllerAdminAuteur::$MSG_CREATE_VALIDE);

			header('Location: '.$route);
			exit;*/
		}
	}
}