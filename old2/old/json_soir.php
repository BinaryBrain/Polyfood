<?php
function getCurrentMenu() {
	$rss = file_get_contents("http://menus.epfl.ch/cgi-bin/getMenus?&midisoir=soir");
	
	$rss = str_replace(array("<em>", "</em>", "<strong>", "</strong>", "<br>", "<br/>", "<br />"), "", $rss);
	preg_match('#<ul id="menulist">.*</ul>#ms', $rss, $ul);
	preg_match_all('#<li>.+</li>#msU', $ul[0], $li, PREG_SET_ORDER);
	
	$before = array();
	$before[0] = '#<div class="logo (.+)">.*</div>#msU';
	$before[1] = '#<div class="desc">(.*)</div>#msU';
	$before[2] = '#<div class="resto">(.*)</div>#msU';
	$before[3] = '#<div class="prix">(.*)</div>#msU';
	$before[4] = '#<div class="clear">(.*)</div>#msU';
	$before[5] = '#<li>(.*)</li>#msU';
	$before[6] = '#<span class="acro" title="(.*)">(.*)</span>\s+(.*)\s+#msU';
	$before[7] = '#<a href="(.*)".*>(.*)</a>#msU';
	
	$after = array();
	$after[0] = "<logo>$1</logo>";
	$after[1] = "<description>$1</description>";
	$after[2] = "<restaurant>$1</restaurant>";
	$after[3] = "<prix>$1</prix>";
	$after[4] = "";
	$after[5] = "<repas>$1</repas>";
	$after[6] = "<$2>$3</$2>";
	$after[7] = "<nom>$2</nom>\n<lien>$1</lien>";
		
	$results = array();
	
	foreach($li as $repas) {
		$item = preg_replace($before, $after, $repas);
		
		$item = str_replace("&", "&amp;", $item);
		$item = str_replace("'", "&apos;", $item);
		$item = str_replace("\"", "&quot;", $item);	
//var_dump($item[0]);

		$out = simplexml_load_string(utf8_encode($item[0]));
		$out->description = trim(preg_replace("#\n+\s+#", "\n", $out->description));
		
		$results[] = $out;
	}
	return json_encode($results);
}

function getMenu() {
	// CACHE SYSTEM
	$cache = "cache_soir.json";
	if(file_exists($cache)) {
		$content = file($cache, FILE_IGNORE_NEW_LINES);
		$time  = $content[0];
		$json = $content[1];
		if(time()-$time < 60*15) // 2h de cache
			return $json;
		else {
			$menu = getCurrentMenu();
			if($menu == "")
				return $json;
			file_put_contents($cache, time()."\n".$menu);
			return $menu;
		}
	}
	else {
		$menu = getCurrentMenu();
		file_put_contents($cache, time()."\n".$menu);
		return $menu;
	}
}

echo getMenu();
