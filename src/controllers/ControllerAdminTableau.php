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
		$nbJourStat = 7;

		$data = array(
			"articles" 				=> Article::all()->count(),
			"commentaires" 			=> Commentaire::all()->count(),
			"auteurs" 				=> Auteur::all()->count(),
			"label_by_jours"		=> json_encode(array_keys(Tools::get_array_jours($nbJourStat))),
			"articles_by_jours"		=> json_encode(array_values(Article::stat($nbJourStat))),
			"commentaires_by_jours"	=> json_encode(array_values(Auteur::stat($nbJourStat))),
			"auteurs_by_jours"		=> json_encode(array_values(Commentaire::stat($nbJourStat))),
		);
		
		return $this->app->view->render($this->response, 'admin/admin_index.html', $data);
	}

}