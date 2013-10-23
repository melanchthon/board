<?php
class Core_View
{
    public function render($content_view, $template_view, $data = null, $params = array())
    {
        if(is_array($data)) {  
            extract($data);
        }

		foreach($params as $key=>$value){
			$_GET[$key] = $value;
		}
		
        include ('Application/View/'.$template_view);
    }
	
    public function h($text) 
    {
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