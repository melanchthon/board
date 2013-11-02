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
		if($this->pagesCount <= 1){
			return false;
		}
		
		$this->view->renderPartial('View_Pagination.php',array(
		'pagesCount'=>$this->pagesCount,
		'currentPage'=>$this->currentPage,
		'firstVisiblePage'=>$this->getFirstVisiblePage(),
		'lastVisiblePage'=>$this->getLastVisiblePage(),
		)
		);
	}


	public function getLastVisiblePage()
	{
		$pages = min($this->pagesCount,9);
		if($this->currentPage>=9 && $this->pagesCount>9 ){
			return $this->currentPage+1;
		} else {
			return $pages;
		}
	}
	
	public function getFirstVisiblePage()
	{
		
		if($this->currentPage<8 ){
			return 0;
		} else {
			return $this->currentPage-8;
		}
	}
	
}