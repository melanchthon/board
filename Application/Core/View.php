<?php
class Core_View
{
	

	public function render($content_view, $template_view, $data = null)
    {
        if(is_array($data)) {  
            extract($data);
        }
        include ('Application/View/'.$template_view);
    }
	
	public function h($text) {
		return htmlspecialchars($text, ENT_QUOTES);
	}
	
	public function renderPartial($content_view, $data = null)
    {
        if(is_array($data)) {  
            extract($data);
        }
        include ('Application/View/'.$content_view);
    }
}