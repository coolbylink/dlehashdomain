<?php
/*
=====================================================
 DLE Hash Domain 2.8
-----------------------------------------------------
 2014-2018 PROWEBBER.RU
=====================================================
 Файл: keygen.php
=====================================================
*/

if(!defined('DATALIFEENGINE')) {
  die("Hacking attempt!");
}

session_start();

if($config['version_id'] < 10.1) { echo "Данный модуль работает на версиях DLE v10.1 и выше"; exit; }
require_once ENGINE_DIR . '/classes/idna.class.php';
$idna = new idna_convert();

if ($config['allow_recaptcha']) {
	if ($_POST['recaptcha_response_field'] AND $_POST['recaptcha_challenge_field']) {
	
		require_once ENGINE_DIR . '/classes/recaptcha.php';			
		$resp = recaptcha_check_answer ($config['recaptcha_private_key'],
										 $_SERVER['REMOTE_ADDR'],
										 $_POST['recaptcha_challenge_field'],
										 $_POST['recaptcha_response_field']);
	
			if ($resp->is_valid) {
	
				$_POST['sec_code'] = 1;
				$_SESSION['sec_code_session'] = 1;
	
			} else $_SESSION['sec_code_session'] = false;
	} else $_SESSION['sec_code_session'] = false;
}

if( $_POST['sec_code'] != $_SESSION['sec_code_session'] OR !$_SESSION['sec_code_session'] ) {
	$stop .= 1;
}

$_SESSION['sec_code_session'] = false;

function punycode_encode($query) {
	global $idna;
	$dutf8 = (isset($query)) ? $query : '';
	$dutf8 = iconv("Windows-1251", "UTF-8", $dutf8);
	return $idna->encode($dutf8);
}

function punycode_decode($query) {
	global $idna;
	$dutf8 = (isset($query)) ? $query : '';
	$dutf8 = iconv("Windows-1251", "UTF-8", $dutf8);
	return iconv("UTF-8", "Windows-1251", $idna->decode($dutf8));
}

$domain_name = $_POST['domain_name'];
$domain_name = stripslashes($domain_name);
$domain_name = htmlspecialchars($domain_name);
$domain_name = trim($domain_name);
$domain_button = $_POST['keygen'];
$domain_ltrm = $_POST['ltrm'];
$domain_else = $domain_name;

if($domain_button) {
	$_SESSION['domain_name'] = $_POST['domain_name'];
	$_SESSION['hash_version'] = $_POST['hash_version'];
}

$version = array( 'FR140' => '1404', 'FR133' => '1333', 'FR132' => '7232', 'FR131' => '7131', 'FR130' => '6821', 'FR121' => '2008', 'FR120' => '4712', 'FR113' => '4532','FR112' => '9353', 'FR111' => '9111','FR110' => '1116','FR106' => '1886','FR105' => '1295', 'FR104' => '1564', 'FR103' => '1130', 'FR102' => '1002', 'FR101' => '9519', 'FR100' => '7784', 'FR098' => '8034', 'FR097' => '1347', 'FR096' => '9096', 'FR095' => '9521', 'FR094' => '6524', 'FR093' => '2470', 'FR092' => '5323', 'FR090' => '8580', 'FR085' => '8500', 'FR083' => '1083', 'FR082' => '1072', 'FR080' => '8021', 'FR075' => '7103', 'FR073' => '3412', 'FR072' => '5971', 'FR070' => '5971', );

function dle_hash_domain($query) {
	$domen_md5 = explode( '.', $query );
	$count_key = count( $domen_md5 ) - 1;
	unset( $domen_md5[$count_key] );
	if( end( $domen_md5 ) == "com" or end( $domen_md5 ) == "net" ) $count_key --;
	$domen_md5 = $domen_md5[$count_key - 1];
	$domen_md5 = md5( md5( $domen_md5 . "780918" ) );
	return $domen_md5;
}

foreach($version as $ver=>$hash)
{ 
	$numv = eregi_replace("([^0-9])", "", $ver);
	if($_SESSION['hash_version'] == $ver) { if($numv >= "100") { $verloons = $numv[0].$numv[1].".".$numv[2]; } else { $verloons = $numv[1].".".$numv[2]; } $selected = 'selected="selected" '; } else { $selected = '';  }
	if($numv >= "100") { $in_version[] = '<option '.$selected.'value="'.$ver.'">'."DataLife Engine v.".$numv[0].$numv[1].".".$numv[2].'</option>'; }
	elseif($numv == "098") { $in_version[] = '<option disabled="disabled"></option><option '.$selected.'value="'.$ver.'">'."DataLife Engine v.".$numv[1].".".$numv[2].'</option>'; }
	elseif($numv == "085") { $in_version[] = '<option disabled="disabled"></option><option '.$selected.'value="'.$ver.'">'."DataLife Engine v.".$numv[1].".".$numv[2].'</option>'; }
	elseif($numv == "075") { $in_version[] = '<option disabled="disabled"></option><option '.$selected.'value="'.$ver.'">'."DataLife Engine v.".$numv[1].".".$numv[2].'</option>'; }
	else { $in_version[] = '<option '.$selected.'value="'.$ver.'">'."DataLife Engine v.".$numv[1].".".$numv[2].'</option>'; }
	if($_POST['hash_version'] == $ver) {
		if(eregi('^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$', $domain_name) != 1) {
		$domain_idn = "<font color=\"#006600\">".punycode_encode($domain_name)."</font>";
		$domain_name = punycode_encode($domain_name); }
		if($numv == "070") { $hash_domain = dle_hash_domain($domain_name); } 
		else { $hash_domain = md5(dle_hash_domain($domain_name).$hash); }
		if($numv >= "112") { $hash_version = "- DataLife Engine v.".$numv[0].$numv[1].".".$numv[2]; } 
		else { $hash_version = "- DataLife Engine v.".$numv[1].".".$numv[2]; }
	}
}

if(strpos(trim($domain_else), 0x20)) { $strpos = 1; }
elseif(strpos(trim($domain_else), "_")) { $strpos = 1; }
elseif(strpos(trim($domain_else), "+")) { $strpos = 1; }
elseif(strpos(trim($domain_else), ",")) { $strpos = 1; }
elseif(strpos(trim($domain_else), "/")) { $strpos = 1; }
elseif(strpos(trim($domain_else), ":")) { $strpos = 1; }
elseif(strpos(trim($domain_else), "@")) { $strpos = 1; }

$tpl->load_template('keygen.tpl');

$tpl->set('{THEME}', $config['http_home_url'].'templates/'.$config['skin']);
$tpl->set('{domain_name}', $domain_else);
if($_SESSION['domain_name']) { $tpl->set('{domain_placeholder}', $_SESSION['domain_name']); } 
else { $tpl->set('{domain_placeholder}', punycode_decode($_SERVER['HTTP_HOST'])); }
$tpl->set('{domain_example}', punycode_decode($_SERVER['HTTP_HOST']));
$tpl->set('{version}', '<option disabled="disabled"></option>'.implode( $in_version ) );

if((isset($domain_idn)) ? $domain_idn : ''){
	$tpl->set( '[idn]', "" );
	$tpl->set( '[/idn]', "" );
} else {
	$tpl->set_block( "'\\[idn\\](.*?)\\[/idn\\]'si", "" );
}

$tpl->set('{domain}', $domain_else);
$tpl->set('{domain_idn}', $domain_idn);
$tpl->set('{hash_version}', $hash_version);
$tpl->set('{hash_domain}', $hash_domain);

if($is_logged){
	$tpl->set_block( "'\\[else_logged\\](.*?)\\[/else_logged\\]'si", "" );
	$tpl->set( '[if_logged]', "" );
	$tpl->set( '[/if_logged]', "" );
} else {
	$tpl->set_block( "'\\[if_logged\\](.*?)\\[/if_logged\\]'si", "" );
	$tpl->set( '[else_logged]', "" );
	$tpl->set( '[/else_logged]', "" );
}

if( !$is_logged ) {
	if ( $config['allow_recaptcha'] ) {

		$tpl->set( '[recaptcha]', "" );
		$tpl->set( '[/recaptcha]', "" );

	$tpl->set( '{recaptcha}', '
<script type="text/javascript">
<!--
var RecaptchaOptions = {
theme: \''.$config['recaptcha_theme'].'\',
lang: \''.$lang['wysiwyg_language'].'\'
};

//-->
</script>
<script type="text/javascript" src="//www.google.com/recaptcha/api/challenge?k='.$config['recaptcha_public_key'].'"></script>' );

		$tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
		$tpl->set( '{code}', "" );

	} else {

		$tpl->set( '[sec_code]', "" );
		$tpl->set( '[/sec_code]', "" );	
		$tpl->set( '{code}', "<span id=\"dle-captcha\"><img src=\"" . $path['path'] . "engine/modules/antibot/antibot.php\" alt=\"{$lang['sec_image']}\" width=\"160\" height=\"80\" /><br /><a onclick=\"reload(); return false;\" href=\"#\">{$lang['reload_code']}</a></span>" );
		$tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
		$tpl->set( '{recaptcha}', "" );

	}
} else {
	$tpl->set( '{code}', "" );
	$tpl->set( '{recaptcha}', "" );
	$tpl->set_block( "'\\[recaptcha\\](.*?)\\[/recaptcha\\]'si", "" );
	$tpl->set_block( "'\\[sec_code\\](.*?)\\[/sec_code\\]'si", "" );
}

if($domain_ltrm == 1 AND $_POST['hash_version'] != "FR000") { $stop = ""; msgbox( $lang['p_info'], $lang_keygen['ok_key']."&nbsp;".$verloons ); }
elseif($_POST['hash_version'] == "FR000") { session_destroy(); header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); }

if($domain_button) {
	if($stop AND !$is_logged) {
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
		msgbox( $lang['all_err_1'], $lang_keygen['error_security'] );
	}  elseif(!$domain_else) {
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
		msgbox( $lang['all_err_1'], $lang_keygen['error_domain_1'] );
	} elseif($strpos == 1) {
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
		msgbox( $lang['all_err_1'], $lang_keygen['error_domain_2'] );
	} else if($_POST['hash_version'] == "FR000") {
		$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
		$tpl->set( '[if]', "" );
		$tpl->set( '[/if]', "" );
		msgbox( $lang['all_err_1'], $lang_keygen['error_version'] );
	} else {
		$tpl->set_block( "'\\[if\\](.*?)\\[/if\\]'si", "" );
		$tpl->set( '[else]', "" );
		$tpl->set( '[/else]', "" );
	}
} else {
	$tpl->set_block( "'\\[idn\\](.*?)\\[/idn\\]'si", "" );
	$tpl->set_block( "'\\[else\\](.*?)\\[/else\\]'si", "" );
	$tpl->set( '[if]', "" );
	$tpl->set( '[/if]', "" );
}

$tpl->copy_template .= <<<HTML
<script language="javascript" type="text/javascript">
<!--
function reload () {

	var rndval = new Date().getTime(); 

	document.getElementById('dle-captcha').innerHTML = '<img src="{$path['path']}engine/modules/antibot/antibot.php?rndval=' + rndval + '" border="0" width="160" height="80" alt="" /><br /><a onclick="reload(); return false;" href="#">{$lang['reload_code']}</a>';

};
//-->
</script>
HTML;

$tpl->compile('content');
$tpl->clear();

?>