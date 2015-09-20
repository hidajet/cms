<?php
	//Ovdje cemo smjestiti nase funkcije

	function mysql_prep($value)
	{
		//provjera da li su aktivni magic_quotes
		$magic_quotes_active= get_magic_quotes_gpc();
		$enough_php = function_exists("mysql_real_escape_string");

		if($enough_php) //ukoliko je verzija php-a iznad v4.3.0
		{
			//ponisti efekte magic_quotes-a kako bi funkcija 
			//mysql_real_escape_string mogla raditi
			if($magic_quotes_active)
			{
				$value=stripslashes($value);
			}
			$value=mysql_real_escape_string($value);
		}else  //ukoliko je verzija php-a ispod v4.3.0
		{
			//ukoliko magic_quotes nisu vec aktivni dodaj slash rucno
			if(!$magic_quotes_active) { $value=addslashes($value);}
			// ako magic_quotes nisu aktivni onda slash-evi vec postoje
		}
		return $value;
			
	}

	function confirm_query($test_set)
	{
		if(!$test_set)
		{
			die("Query nije izvrsen".mysql_error());
		}
	}
	function get_all_subjects($public=false)
	{
		global $conn;
		$query="SELECT menu_name,id,position FROM subject";
		if($public){
			$query.=" WHERE visible=1";
		}
		$query.=" ORDER BY position ASC";
		$sub_set=mysql_query($query,$conn);
		confirm_query($sub_set);
		return $sub_set;
	}

	function get_all_pages_for_subject($sub_id, $public=false)
	{
		global $conn;
		$query="SELECT *  FROM pages WHERE subject_id={$sub_id} ";
		if($public){
			$query.=" AND visible=1 ";
		}
		$query.=" ORDER BY position ASC";
		$page_set=mysql_query($query,$conn);
		confirm_query($page_set);
		return $page_set;
	}

	function get_subject_by_id($id)
	{
		global $conn;
		$query="SELECT * FROM subject WHERE id={$id} LIMIT 1";
		$sub_set=mysql_query($query,$conn);
		confirm_query($sub_set);
		if($record=mysql_fetch_array($sub_set))
		{
			return $record;
		}
		else
		{
			return NULL;
		}
		
	}
	function get_page_by_id($id)
	{
		global $conn;
		$query="SELECT * FROM pages WHERE id={$id} LIMIT 1";
		$page_set=mysql_query($query,$conn);
		confirm_query($page_set);
		if($record=mysql_fetch_array($page_set))
		{
			return $record;
		}
		else
		{
			return NULL;
		}
	}
	function get_default_page($subject_id)
	{
		$page_set=get_all_pages_for_subject($subject_id);
		
		if($page=mysql_fetch_array($page_set))
		{
			return $page;
		}
		else
		{
			return NULL;
		}
		
	}

	function find_selected_page()
	{
		global $select_sub;
		global $select_page;
		if(isset($_GET['subj']))
		{
			$select_sub = get_subject_by_id($_GET['subj']);
			$select_page= get_default_page($select_sub['id']);
		}elseif (isset($_GET['page']))
		{
			$select_page=get_page_by_id($_GET['page']);
			$select_sub= NULL;
		}else
		{
			$select_sub= NULL;
			$select_page= NULL;
		}
	}
	
	function navigation($select_sub,$select_page, $public=false)
	{
		$output="<ul class=\"subjects\">";
		
		// 3. Izvrsiti query				
		$sub_set=get_all_subjects($public);
		// 4. Ispsi podatke iz baze
		while($menu=mysql_fetch_array($sub_set))
		{
			$output.="<li ";
			if($menu["id"]==$select_sub["id"])
			{
				$output.="class=\"selected sel\" ";
			}
			$output.="><a href=\"edit_sub.php?subj=".urlencode($menu["id"])."\">{$menu['menu_name']}</a>";
			
			if($menu["id"]==$select_sub["id"])
			{
				$page_set=get_all_pages_for_subject($menu["id"]);
				$output.="<ul class=\"pages\">";
				while($page=mysql_fetch_array($page_set))
				{
					$output.="<li ";
					if($page["id"]==$select_page["id"])
					{
						$output.="class=\"selected\" ";
					}
					$output.="><a href=\"edit_page.php?page=".urlencode($page["id"])."\">{$page['menu_name']}</a></li>";
				}
				$output.="</ul>";
			}
			$output.="</li>";
		}
		$output.="<br>";
		$output.="<li><a href=\"new_subject.php\">+ Add new subject </a></li>";
		$output.="</ul>";
		return $output;
	}

	function redirect_to($location = NULL)
	{
		if($location!=NULL)
		{
			header("Location: {$location}");
			exit;
		}
	}

	function public_navigation($select_sub,$select_page, $public=true)
	{
		$output="<ul class=\"subjects\">";
		
		// 3. Izvrsiti query				
		$sub_set=get_all_subjects($public);
		// 4. Ispsi podatke iz baze
		while($menu=mysql_fetch_array($sub_set))
		{
			$output.="<li ";
			if($menu["id"]==$select_sub["id"])
			{
				$output.="class=\"selected sel\" ";
			}
			$output.="><a href=\"index.php?subj=".urlencode($menu["id"])."\">{$menu['menu_name']}</a>";
			if($menu["id"]==$select_sub["id"])
			{
				$page_set=get_all_pages_for_subject($menu["id"],$public);
				$output.="<ul class=\"pages\">";
				while($page=mysql_fetch_array($page_set))
				{
					$output.="<li ";
					if($page["id"]==$select_page["id"])
					{
						$output.="class=\"selected\" ";
					}
					$output.="><a href=\"index.php?page=".urlencode($page["id"])."\">{$page['menu_name']}</a></li>";
				}
				$output.="</ul>";
			}
			$output.="</li>";
		}
		$output.="<br/><br/>";
		$output.="<li><a href=\"staff.php\"> Staff page </a></li>";
		$output.="</ul>";
		return $output;
	}

?>
