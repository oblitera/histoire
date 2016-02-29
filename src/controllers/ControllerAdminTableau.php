<?php

class ControllerAdminTableau extends ControllerAdmin 
{
	static $MSG_SECTION				= "tableau_bord";

	public function init()
	{
		parent::init();
		$this->setSection(self::$MSG_SECTION);
	}


	/*------------------
	 *  Affichage
	 *------------------
	 */


	public function index()
	{
		$data = array(
			"articles" 		=> Article::all()->count(),
			"commentaires" 	=> Commentaire::all()->count(),
			"auteurs" 		=> Auteur::all()->count(),
		);
		
		return $this->app->view->render($this->response, 'admin/admin_index.html', $data);
	}

}