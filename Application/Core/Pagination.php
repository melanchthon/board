<?php
class Core_Pagination 
{
	public $currentPage;
	public $pagesCount;
	public $view;

	public function __construct ($currentPage,$pagesCount) 
	{
		$this->currentPage = $currentPage;
		$this->pagesCount = $pagesCount;
		$this->view = new Core_View();
	}
	
	public function generate()
	{
		$this->view->renderPartial('View_Pagination.php',array(
		'pagesCount'=>$this->pagesCount,
	    'currentPage'=>$this->currentPage,
		)
		);
	}
	

}