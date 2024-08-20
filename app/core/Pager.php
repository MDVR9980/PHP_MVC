<?php 

/**
 * pagination class for pagination
 */

namespace Core;

defined('ROOTPATH') OR exit('Access Denied!');

class Pager
{
	public $links 			= array();
	public $offset 			= 0;
	public $page_number 	= 1;
	public $start 			= 1;
	public $end 			= 1;
	public $limit 			= 10;
	public $nav_class 		= "";
	public $ul_class 		= "pagination justify-content-center";
	public $li_class 		= "page-item";
	public $a_class 		= "page-link";

	public function __construct($limit = 10, $extras = 1)
	{
		// code...
  		$page_number = isset($_GET['page']) ? (int)$_GET['page']: 1;
 		$page_number = $page_number < 1 ? 1:$page_number;

 		$this->end = $page_number + $extras;
 		$this->start = $page_number - $extras;
 		if($this->start < 1)
 		{
 			$this->start = 1;
 		}

 		$this->offset = ($page_number - 1) * $limit;
 		$this->page_number = $page_number;
 		$this->limit = $limit;

 		$url = isset($_GET['url']) ? $_GET['url'] : '';

  		$current_link = ROOT. "/". $url . '?' .trim(str_replace("url=", "", str_replace($url, "", $_SERVER['QUERY_STRING'])),'&');
 		$current_link = !strstr($current_link, "page=") ? $current_link . "&page=1":$current_link;
 		
 		if(!strstr($current_link, "?")){
 			$current_link = str_replace("&page=", "?page=", $current_link);
 		}

 		$first_link = preg_replace('/page=[0-9]+/', "page=1", $current_link);
 		$next_link = preg_replace('/page=[0-9]+/', "page=".($page_number + $extras + 1), $current_link);

 		$this->links['first'] = $first_link;
 		$this->links['current'] = $current_link;
 		$this->links['next'] = $next_link;
	}

	public function display($record_count = null)
	{
		if($record_count == null)
			$record_count = $this->limit;
		
		if($record_count == $this->limit || $this->page_number > 1){
		?>
		<br class="clearfix">
		<div>
			<nav class="<?=$this->nav_class?>">
			  <ul class="<?=$this->ul_class?>">
			    <li class="<?=$this->li_class?>"><a class="<?=$this->a_class?>" href="<?=$this->links['first']?>">First</a></li>

			    <?php for($x = $this->start; $x <= $this->end;$x++):?>
 			    	<li class="<?=$this->li_class?> 
 			    	<?=($x == $this->page_number)?' active ':'';?>
 			    	"><a class="<?=$this->a_class?>" href="
 			    		<?= preg_replace('/page=[0-9]+/', "page=".$x, $this->links['current'])?>
 			    		"><?=$x?></a></li>
 				<?php endfor;?>

			    <li class="<?=$this->li_class?>"><a class="<?=$this->a_class?>" href="<?=$this->links['next']?>">Next</a></li>
			  </ul>
			</nav>
	 	</div>
	 	<?php 
	 	}
	}
}