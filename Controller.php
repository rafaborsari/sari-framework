<?php 

class Controller extends Sari
{
	public function title($title = '', $description = '')
	{
		echo
		"<title>".$title."</title>",
		"<meta name='description' content='".$description."' >";
	}

}
