<?PHP

// DataLife Engine Hash Domain
// Final Release 3.2
// by coollink, kicker
// This product is distributed free of charge

// Web download: skripter.info and prowebber.ru

if( !defined('DATALIFEENGINE') ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

if(file_exists(ROOT_DIR . '/language/' . $config["langs"] . '/hashdomain.lng')) { include_once (DLEPlugins::Check(ROOT_DIR . '/language/' . $config["langs"] . '/hashdomain.lng'));

if(!file_exists(ENGINE_DIR . '/data/dbhash.php')) { exit( $lang_hash['hash_module_update']); } else { if(DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php')) {
include_once (DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php')); } else { include_once (ENGINE_DIR . '/data/dbhash.php'); } }
$nam_e = $settings['home_title']; $metatags['description'] = $settings['home_title'].' v'.$version; $metatags['keywords'] = $lang_hash['keywords']; }
else { exit('Language file modules not found: /language/' . $config["langs"] . '/hashdomain.lng'); exit; }

if(!file_exists(ENGINE_DIR . '/classes/idna.class.php')) { exit( $lang_hash['hash_module_file']." /engine/classes/idna.class.php"); } else {
	require_once ENGINE_DIR . '/classes/idna.class.php';
}

if($nam_e) {
	$metatags['title'] = $nam_e . $page_extra . ' &raquo; ' . $metatags['title'];
	$rss_title = $metatags['title'];
} elseif ($titl_e) {
	$metatags['title'] = $titl_e . $page_extra . ' &raquo; ' . $config['home_title'];
} else $metatags['title'] .= $page_extra;

if ($config['speedbar'] AND !$view_template ) {
	
	$s_navigation = "<span itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a href=\"{$config['http_home_url']}\" itemprop=\"url\"><span itemprop=\"title\">" . $config['short_title'] . "</span></a></span>";

	if( $config['start_site'] == 3 AND $_SERVER['QUERY_STRING'] == "" AND !$_POST['do']) $titl_e = "";

	if (intval($category_id)){
		
		if($titl_e OR (isset($_GET['cstart']) AND intval($_GET['cstart']) > 1) ) {
			$last_link = true;
		} else $last_link = false;
		
		$s_navigation .= " {$config['speedbar_separator']} " . get_breadcrumbcategories ( intval($category_id), $config['speedbar_separator'], $last_link );
		
	} elseif ($do == 'tags') {
		
		if ($config['allow_alt_url']) $s_navigation .= " {$config['speedbar_separator']} <span itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a href=\"" . $config['http_home_url'] . "tags/\" itemprop=\"url\"><span itemprop=\"title\">" . $lang['tag_cloud'] . "</span></a></span> {$config['speedbar_separator']} " . $tag;
		else $s_navigation .= " {$config['speedbar_separator']} <span itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a href=\"?do=tags\" itemprop=\"url\"><span itemprop=\"title\">" . $lang['tag_cloud'] . "</span></a></span> {$config['speedbar_separator']} " . $tag;

	} elseif ($nam_e) $s_navigation .= " {$config['speedbar_separator']} " . $nam_e;

	if ($titl_e) {
		
		$s_navigation .= " {$config['speedbar_separator']} " . $titl_e;
		
	} else {

		if ( isset($_GET['cstart']) AND intval($_GET['cstart']) > 1 ){
		
			$page_extra = " {$config['speedbar_separator']} ".$lang['news_site']." ".intval($_GET['cstart']);
		
		} else $page_extra = '';

		$s_navigation .= $page_extra;

	}
	
	$tpl->load_template ( 'speedbar.tpl' );
	$tpl->set ( '{speedbar}', '<span id="dle-speedbar">' . stripslashes ( $s_navigation ) . '</span>' );
	$tpl->compile ( 'speedbar' );
	$tpl->clear ();

}

if( !$is_logged AND $settings['captcha'] == 1 ) {
	
	if ($config['allow_recaptcha']) {

		if ( $_POST['g-recaptcha-response'] ) {

			include_once (DLEPlugins::Check(ENGINE_DIR . '/classes/recaptcha.php'));
			$reCaptcha = new ReCaptcha($config['recaptcha_private_key']);

			$resp = $reCaptcha->verifyResponse(get_ip(), $_POST['g-recaptcha-response'] );
		
			if ( $resp != null && $resp->success ) {

					$_POST['sec_code'] = 1;
					$_SESSION['sec_code_session'] = 1;

			 } else $_SESSION['sec_code_session'] = false;
			 
		} else $_SESSION['sec_code_session'] = false;

	}
	
	if( $_POST['sec_code'] != $_SESSION['sec_code_session'] OR !$_SESSION['sec_code_session'] ) {
		$stop .= $lang['reg_err_19'];
	}

	$_SESSION['sec_code_session'] = false;
}

if($config['version_id'] < 13.0) { echo $lang_hash['hash_module_version']; exit; }

function last_micro() {
	global $dbhash;
	$version = array_keys($dbhash);
	return $version[0];	
}

function search($dest = null, $sort = null) {
	global $dbhash;
	$i = 1;
	if($sort == false) {
		foreach($dbhash as $version => $hash) {
			$i++;
			if($dest == $hash) {
				return $version;
			}
		}
	} else {
		$dest = str_replace("FR","",$dest);
		foreach($dbhash as $version => $hash) {
			$i++;
			if($dest == $version) {
				return $hash;
			}
		}
	}
}


function last($var = null, $num = null) {
	
	global $dbhash;

	if(!$num == true) {

		$version = array_keys($dbhash);
		$version = preg_replace("([^0-9])", "", $version[0]);
		return $version[0].$version[1].".".$version[2];

	} else {

		$array = array('100','098','097','096','095',
					   '094','093','092','090','085',
					   '083','082','080','075','073',
					   '072','070');

		$version = preg_replace("([^0-9])", "", $var);
		if(array_search($version, $array)) { return $version[1].".".$version[2]; }
		else { return $version[0].$version[1].".".$version[2]; }

	}

}

function select_hash($check) {
	
	global $dbhash;
	global $lang_hash;
	global $settings;
	
	if($settings['select_br'] == 1) {
		$array = array('210','200','190','180','170','160','150',
				   	   '140','130','120','110','100','090','080');
	} else { $array = array(); }
	$i = 1;
	foreach($dbhash as $version => $hash) {
		$i++;
		if("FR".$version == $check) { $selected = 'selected="selected"'; } else { $selected = ''; }
		if($version == last_micro() AND $settings['select_optgroup'] == 1) { $select[] = '<optgroup label="'.$lang_hash['ver_actual'].'">'; }
		if($version == $settings['select_actual']) { $mset = current($dbhash); }
		if($version == search($mset) AND $settings['select_optgroup'] == 1) { $select[] = '<optgroup label="'.$lang_hash['ver_title_old'].'">'; }
		if(array_search($version, $array) && $version != '070') {
			$select[] = '<option '.$selected.' value="FR'.$version.'" label="DataLife Engine v.'.last($version, true).'">'.last($version, true).'</option><option disabled="disabled"></option>';
		} else {
			$select[] = '<option '.$selected.' value="FR'.$version.'" label="DataLife Engine v.'.last($version, true).'">'.last($version, true).'</option>';
		}
		
		if($version == $settings['select_actual'] AND $settings['select_optgroup'] == 1) { $select[] = '</optgroup>'; }
		if($version == '070' AND $settings['select_optgroup'] == 1) { $select[] = '</optgroup>'; }
		
	}
	return implode( "\n", $select );
	
}

function dle_hash_domain($query) {
	
	$domen_md5 = explode( '.', $query );
	$count_key = count( $domen_md5 ) - 1;
	unset( $domen_md5[$count_key] );
	if( end( $domen_md5 ) == "com" or end( $domen_md5 ) == "net" ) $count_key --;
	$domen_md5 = $domen_md5[$count_key - 1];
	$domen_md5 = md5( md5( $domen_md5 . "780918" ) );
	return $domen_md5;
	
}

function is_valid_domain_name($domain_name) {
	
	if($domain_name != convert_cyr_string($domain_name , 'w' , 'k')) {
		$domain_name = punycode_encode($domain_name);
		return (preg_match("/^([a-zа-яё\d](-*[a-zа-яё\d])*)(\.([a-zа-яё\d](-*[a-zа-яё\d])*))*$/i", $domain_name)
				&& preg_match("/^.{1,253}$/", $domain_name)
				&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   );
	} else {
		return (preg_match("/^([a-zа-яё\d](-*[a-zа-яё\d])*)(\.([a-zа-яё\d](-*[a-zа-яё\d])*))*$/i", $domain_name)
				&& preg_match("/^.{1,253}$/", $domain_name)
				&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   );
	}
	
}

function punycode_encode($query) {
	
	global $idna;
	$dutf8 = (isset($query)) ? $query : '';
	return $idna->encode($dutf8);
	
}

function punycode_decode($query) {
	
	global $idna;
	$dutf8 = (isset($query)) ? $query : '';
	return iconv("UTF-8", "Windows-1251", $idna->decode($dutf8));
	
}

if($_POST['send_btn']) {
	$domain = $_POST['domain'];
	$hash_version = $_POST['hash_version'];
	$_SESSION['hash_version'] = $_POST['hash_version'];
}

$tpl->load_template('keygen.tpl');

$tpl->set('{description}', $settings['home_title']);
$tpl->set('{version}', $version);
$tpl->set('{last_version_hash}', last());


$tpl->set('{example}', punycode_decode($_SERVER['HTTP_HOST']));

$tpl->set('{select_hash}', select_hash($_SESSION['hash_version']));
$tpl->set('{domain}', $_POST['domain']);

if($hash_version == "FR070") { if($domain != convert_cyr_string($domain , 'w' , 'k')) { $hash_domain = dle_hash_domain($domain); } 
else { $hash_domain = dle_hash_domain(punycode_encode($domain)); } } 
else { if($domain != convert_cyr_string($domain , 'w' , 'k')) { $hash_domain = md5(dle_hash_domain($domain).search($hash_version, true)); } 
else { $hash_domain = md5(dle_hash_domain(punycode_encode($domain)).search($hash_version, true)); } }

if($_POST['download']) {
$domain = $_POST['domain'];
$hash_version = $_POST['hash_version'];
if($hash_version == "FR070") { if($domain != convert_cyr_string($domain , 'w' , 'k')) { $hash_domain = dle_hash_domain($domain); } 
else { $hash_domain = dle_hash_domain(punycode_encode($domain)); } } 
else { if($domain != convert_cyr_string($domain , 'w' , 'k')) { $hash_domain = md5(dle_hash_domain($domain).search($hash_version, true)); } 
else { $hash_domain = md5(dle_hash_domain(punycode_encode($domain)).search($hash_version, true)); } }
$name = 'keygen';
$tmp = '\"{$value}\"';
$tmp2 = '\$config = array';

$body = "<?PHP

// DataLife Engine Hash Domain (MINI)
// Final Release 3.2
// by coollink, kicker
// This product is distributed free of charge

define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
require_once ENGINE_DIR . '/data/config.php';

\$config['key'] = \"".$hash_domain."\";
\$handler = fopen(ENGINE_DIR . '/data/config.php', \"w\");

fwrite(\$handler, \"<?php 

//System Configurations

{$tmp2} (

\");

foreach(\$config as \$name => \$value) {
	fwrite(\$handler, \"'{\$name}' => {$tmp},
\");
}
fwrite(\$handler, \");
?>\");
fclose(\$handler);

header('Refresh: 1; url=http://'.\$_SERVER['HTTP_HOST'].'/admin.php');

exit('DLE Hash Domain (DHD Mini)');

?>";

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . sprintf('%s.php', $name));
header('Content-Length: ' . sizeof($body));	

exit($body);
	
}

if(!is_valid_domain_name($domain)) {
	$tpl->set('{domain_idn}', $domain);
	$tpl->set('{hash_domain}', $hash_domain);
} else {
	$tpl->set('{domain_idn}', "<font color=\"#006600\">".punycode_encode($domain)."</font>");
	$tpl->set('{hash_domain}', punycode_encode($hash_domain));
}

if($settings['download'] == 1) {
	$tpl->set( '[download]', "" );
	$tpl->set( '[/download]', "" );
} else {
	$tpl->set_block( "'\\[download\\](.*?)\\[/download\\]'si", "" );
}

if( !$is_logged AND $settings['captcha'] == 1 ) {

	if ( $config['allow_recaptcha'] ) {

		$tpl->set( '[recaptcha]', "" );
		$tpl->set( '[/recaptcha]', "" );

	$tpl->set( '{recaptcha}', "<div class=\"g-recaptcha\" data-sitekey=\"{$config['recaptcha_public_key']}\" data-theme=\"{$config['recaptcha_theme']}\"></div><script src='https://www.google.com/recaptcha/api.js?hl={$lang['wysiwyg_language']}' async defer></script>" );

		$tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
		$tpl->set( '{code}', "" );

	} else {

		$tpl->set( '[sec_code]', "" );
		$tpl->set( '[/sec_code]', "" );	
		$tpl->set( '{code}', "<a onclick=\"reload(); return false;\" href=\"#\" title=\"{$lang['reload_code']}\"><span id=\"dle-captcha\"><img src=\"engine/modules/antibot/antibot.php\" alt=\"{$lang['reload_code']}\" width=\"160\" height=\"80\" /></span></a>" );
		$tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
		$tpl->set( '{recaptcha}', "" );

	}
} else {
	$tpl->set( '{code}', "" );
	$tpl->set( '{recaptcha}', "" );
	$tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
	$tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
}

if($_POST['send_btn']) {
	if($stop) {
		msgbox( $lang['all_err_1'], $lang['reg_err_19'] );
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$_SESSION['el_stop'] = 0;
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
	} else if(!is_valid_domain_name($_POST['domain'])) {
		msgbox( $lang['all_err_1'], $lang_hash['hash_domain_error1']);
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
	} else {
		$tpl->set_block( "'\\[if\\](.*?)\\[/if\\]'si", "" );
		$tpl->set( '[else]', "" );
		$tpl->set( '[/else]', "" );
		if(preg_match("/^([a-zа-яё\d](-*[a-zа-яё\d])*)(\.([a-zа-яё\d](-*[a-zа-яё\d])*))*$/i", $domain)
				&& preg_match("/^.{1,253}$/", $domain)
				&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain)) {
			$tpl->set_block( "'\\[idn\\](.*?)\\[/idn\\]'si", "" );
		} else {
			$tpl->set( '[idn]', "" );
			$tpl->set( '[/idn]', "" );
		}
		$_SESSION['el_stop'] = 1;
	}
} else {
	$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
	$tpl->set( '[if]', "" );
	$tpl->set( '[/if]', "" );
}

$tpl->compile('content');
$tpl->clear();

?>