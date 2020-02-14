<?php

// DataLife Engine Hash Domain
// Final Release 3.0
// by coollink, kicker
// This product is distributed free of charge

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

$version = "3.0"; // версия сборки

if( $member_id['user_group'] != 1 ) {
	msg( "error", $lang['addnews_denied'], $lang['db_denied'] );
}


if ( file_exists( DLEPlugins::Check(ROOT_DIR . '/language/' . $selected_language . '/hashdomain.lng') ) ) {
	require_once (DLEPlugins::Check(ROOT_DIR . '/language/' . $selected_language . '/hashdomain.lng'));
}

if($config['version_id'] < 13.0) { msg( "error", $lang['addnews_denied'], $lang_hash['hash_module_version'] ); }

if(!file_exists(ENGINE_DIR . '/data/dbhash.php')) { msg( "error", $lang['addnews_denied'], $lang_hash['hash_module_update_admin'] ); }

function showRow($title = "", $description = "", $field = "", $class = "") {
	echo "<tr>
       <td class=\"col-xs-6 col-sm-6 col-md-7\"><div class=\"media-heading text-semibold\">{$title}</div><span class=\"text-muted text-size-small hidden-xs\">{$description}</span></td>
       <td class=\"col-xs-6 col-sm-6 col-md-5\">{$field}</td>
       </tr>";
}

function makeCheckBox($name, $selected) {

	$selected = $selected ? "checked" : "";

	return "<input class=\"switch\" type=\"checkbox\" name=\"{$name}\" value=\"1\" {$selected}>";

}

if(DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php')) {
	include_once (DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php'));
} else {
	include_once (ENGINE_DIR . '/data/dbhash.php');
}

function last_micro() {
	global $dbhash;
	$version = array_keys($dbhash);
	return $version[0];	
}

function search($dest) {
	global $dbhash;
	$i = 1;
	foreach($dbhash as $version => $hash) {
		$i++;
		if($dest == $hash) {
			return $version;
		}
	}
}


function last($var, $num) {
	
	global $dbhash;
	
	if(!$num == true) {
		
		$version = array_keys($dbhash);
		$version = eregi_replace("([^0-9])", "", $version[0]);
		return $version[0].$version[1].".".$version[2];
		
	} else {
		
		$array = array('100','098','097','096','095',
					   '094','093','092','090','085',
					   '083','082','080','075','073',
					   '072','070');
					   
		$version = eregi_replace("([^0-9])", "", $var);
		if(array_search($version, $array)) { return $version[1].".".$version[2]; } 
		else { return $version[0].$version[1].".".$version[2]; }
		
	}
	
}

function makeDropDown($options, $name, $selected) {
	$output = "<select class=\"uniform\" name=\"$name\">\r\n";
	foreach ( $options as $value => $description ) {
		$output .= "<option value=\"$value\"";
		if( $selected == $value ) {
			$output .= " selected ";
		}
		$output .= ">$description</option>\n";
	}
	$output .= "</select>";
	return $output;
}

function select_hash($name) {
	global $dbhash;
	global $settings;
	$output = "<select class=\"uniform\" name=\"$name\">\r\n";
	foreach ( $dbhash as $version => $hash ) {
		$output .= "<option value=\"$version\"";
		if( $settings['select_actual'] == $version ) {
			$output .= " selected ";
		}
		$output .= ">DataLife Engine v.".last($version, true)."</option>\n";
	}
	$output .= "</select>";
	return $output;
}

function v_hash() {
	global $dbhash;
	$i = 0;
	foreach ( $dbhash as $version => $hash ) {
		$i++;
		$output[] = "<tr><td class=\"text-nowrap\">".$i."</td><td class=\"text-nowrap\">DataLife Engine v.".last($version, true)."</td><td style=\"word-break: break-all;\">".$version." / ".$hash."</td></tr>";
	}
	return implode( "\n", $output );
}

function west($name, $value) {
	$value = trim(strip_tags(stripslashes( $value )));
	$value = htmlspecialchars( $value, ENT_QUOTES, $config['charset']);
	$value = preg_replace( $find, $replace, $value );
		
	$name = trim(strip_tags(stripslashes( $name )));
	$name = htmlspecialchars( $name, ENT_QUOTES, $config['charset'] );
	$name = preg_replace( $find, $replace, $name );
	
	$value = str_replace( "$", "&#036;", $value );
	$value = str_replace( "{", "&#123;", $value );
	$value = str_replace( "}", "&#125;", $value );
	$value = str_replace( ".", "", $value );
	$value = str_replace( '/', "", $value );
	$value = str_replace( chr(92), "", $value );
	$value = str_replace( chr(0), "", $value );
	$value = str_replace( '(', "", $value );
	$value = str_replace( ')', "", $value );
	$value = str_ireplace( "decode", "dec&#111;de", $value );
	
	$name = str_replace( "$", "&#036;", $name );
	$name = str_replace( "{", "&#123;", $name );
	$name = str_replace( "}", "&#125;", $name );
	$name = str_replace( ".", "", $name );
	$name = str_replace( '/', "", $name );
	$name = str_replace( chr(92), "", $name );
	$name = str_replace( chr(0), "", $name );
	$name = str_replace( '(', "", $name );
	$name = str_replace( ')', "", $name );
	$name = str_ireplace( "decode", "dec&#111;de", $name );	
}

if( $action == "save" ) {

	if( $_REQUEST['user_hash'] == "" or $_REQUEST['user_hash'] != $dle_login_hash ) {
		
		die( "Hacking attempt! User not found" );
	
	}

	$save_con = $_POST['save_con'];

	$find = array();
	$replace = array();
	
	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";
	
	$save_con1 = $save_con;
	$save_con2 = $dbhash;
	
	if(DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php')) {
		$handler = fopen( DLEPlugins::Check(ENGINE_DIR . '/data/dbhash.php'), "w" );
		fwrite( $handler, "<?PHP \n\n// DataLife Engine Hash Domain\n// Final Release {$version}\n// by coollink vs kicker\n// This product is distributed free of charge\n\n\$version = '{$version}';\n\n\$settings = array (\n\n" );
		foreach ( $save_con1 as $name => $value ) {
			
			west($name, $value);
			
			fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
		
		}
		fwrite( $handler, ");\n\n" );
		fwrite( $handler, "\n\n//База hash ключей\n\n\$dbhash = array(\n\n" );
		foreach ( $save_con2 as $name => $value ) {
			
			west($name, $value);
			
			fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
		
		}
		
		fwrite( $handler, ");\n\n?>" );
		fclose( $handler );
	}
	
	$handler = fopen( ENGINE_DIR . '/data/dbhash.php', "w" );
	
	fwrite( $handler, "<?PHP \n\n// DataLife Engine Hash Domain\n// Final Release {$version}\n// by coollink vs kicker\n// This product is distributed free of charge\n\n\$version = '{$version}';\n\n\$settings = array (\n\n" );
	foreach ( $save_con1 as $name => $value ) {
		
		west($name, $value);
		
		fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
	
	}
	fwrite( $handler, ");\n\n" );
	fwrite( $handler, "\n\n//База hash ключей\n\n\$dbhash = array(\n\n" );
	foreach ( $save_con2 as $name => $value ) {
		
		west($name, $value);
		
		fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
	
	}
	
	fwrite( $handler, ");\n\n?>" );
	fclose( $handler );
	
	clear_cache();
	
	if (function_exists('opcache_reset')) {
		opcache_reset();
	}
	
	msg( "success", $lang['opt_sysok'], $lang['opt_sysok_1'], "?mod=keygen" );
}

$mps = v_hash();
echoheader( "<i class=\"fa fa-globe position-left\"></i><span class=\"text-semibold\">{$lang_hash['adm_title_mini']}</span>", $lang_hash['adm_title']  );

echo <<<HTML
<form action="?mod=keygen&action=save" name="conf" id="conf" method="post">
<div class="panel panel-flat">
  <div class="panel-body">
    {$lang['vconf_title']}
  </div>
  <div class="table-responsive">
  <table class="table table-striped"><tr>
HTML;

showRow( $lang_hash['title'], $lang_hash['description'], "<input type=\"text\" class=\"form-control\" name=\"save_con[home_title]\" value=\"{$settings['home_title']}\">", "white-line" );
showRow( $lang_hash['adm_captcha_title'], $lang_hash['adm_captcha_desc'], makeCheckBox( "save_con[captcha]", "{$settings['captcha']}"));
showRow( $lang_hash['adm_sel1_title'], $lang_hash['adm_sel1_desc'], makeCheckBox( "save_con[select_br]", "{$settings['select_br']}"));
showRow( $lang_hash['adm_sel2_title'], $lang_hash['adm_sel2_desc'], makeCheckBox( "save_con[select_optgroup]", "{$settings['select_optgroup']}"));
showRow( $lang_hash['adm_sel3_title'], $lang_hash['adm_sel3_desc'], select_hash('save_con[select_actual]'));

showRow( $lang_hash['adm_download_title'], $lang_hash['adm_download_desc'], makeCheckBox( "save_con[download]", "{$settings['download']}"));

echo <<<HTML
</table></div></div>
<div style="margin-bottom:30px;">
<input type="hidden" name="user_hash" value="{$dle_login_hash}" />
<button type="submit" class="btn bg-teal btn-raised position-left"><i class="fa fa-floppy-o position-left"></i>{$lang['user_save']}</button>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    {$lang_hash['adm_title_ver']}
  </div>
  <div class="table-responsive">
    <table class="table table-xs table-striped table-hover">
      <thead>
      <tr>
        <th width="50">ID</th>
        <th>{$lang_hash['adm_name_desc']}</th>
        <th>{$lang_hash['adm_name_out']}</td>
      </tr>
      </thead>
	  <tbody>
	  {$mps}
HTML;
echo <<<HTML
</tbody></table>

	</div>
</div>
<div style="margin-bottom:30px;">
<input type="hidden" name="user_hash" value="{$dle_login_hash}" />
<button type="submit" class="btn bg-teal btn-raised position-left"><i class="fa fa-floppy-o position-left"></i>{$lang['user_save']}</button>
</div>
</form>
HTML;

echofooter();
?>