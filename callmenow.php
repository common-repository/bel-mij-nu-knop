<?php
/*
	Plugin Name: Bel-Mij-Nu-knop
	Plugin URI: http://wordpress.org/extend/plugins/bel-mij-nu-knop/
	Description: Laat uw Wordpress-bezoekers rechtstreeks met u bellen via een Bel-Mij-Nu-knop op uw website.
	Author: Belcentrale
	Version: 2.0
	Author URI: http://www.belcentrale.nl
*/

// Must be in Wordpress
if (!defined('ABSPATH')) die();

// Install / Activate the plugin, install the default options, if necessary
function callmenow_install() {
	// Plugin options
	$Options = get_option('callmenow_options');
	$Options['enabled']			= '0';
	$Options['special_0']		= '1';
	$Options['special_min']		= '10';
	$Options['special_max']		= '10';
	$Options['special_06']		= '1';
	$Options['special_088']		= '1';
	$Options['special_088']		= '1';
	$Options['special_0800']	= '1';
	add_option('callmenow_options', $Options);
	
	// Widget options
	$Widget = get_option('callmenow_widget');
	$Widget['title']			= 'Telefonisch contact';
	$Widget['description']		= "Wilt u teruggebeld worden?\nWij bellen u direct op!";
	$Widget['cta']				= 'Bel mij nu!';
	add_option('callmenow_widget', $Widget);
}

// Uninstall / Deactivate the plugin, delete the options
function callmenow_uninstall() {
	delete_option('callmenow_options');
	delete_option('callmenow_widget');
}

// Initialisation of the plugin, register options
function callmenow_init() {
	register_setting('callmenow_options', 'callmenow_options');
	register_setting('callmenow_widget', 'callmenow_widget');
}

// Add menu option in admin menu left
function callmenow_menu() {
	add_options_page('Bel-Mij-Nu-knop', 'Bel-Mij-Nu-knop', 'manage_options', 'callmenow', 'callmenow_options');
}

// Add plugin page settings link
function callmenow_plugin_actions($Original) {
	$Links = array();
	$Links[] = '<a href="options-general.php?page=callmenow">'.__('Instellingen', 'callmenow').'</a>';
	return array_merge($Links, $Original);
}

// Edit options page
function callmenow_options() {
	// User must have permissions
	if (!current_user_can('manage_options'))  {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	// Load original options from database
	$Original = $Options = get_option('callmenow_options');
	// Check if form was submitted
	if (isset($_POST['callmenow_submit'])) {
		$Options['enabled']			= strip_tags(stripslashes($_POST['enabled']));
		$Options['phone']			= strip_tags(stripslashes($_POST['phone']));
		$Options['special_0']		= strip_tags(stripslashes($_POST['special_0']));
		$Options['special_min']		= strip_tags(stripslashes($_POST['special_min']));
		$Options['special_max']		= strip_tags(stripslashes($_POST['special_max']));
		$Options['special_06']		= strip_tags(stripslashes($_POST['special_06']));
		$Options['special_08']		= strip_tags(stripslashes($_POST['special_08']));
		$Options['special_09']		= strip_tags(stripslashes($_POST['special_09']));
		$Options['special_foreign']	= strip_tags(stripslashes($_POST['special_foreign']));
		$Options['hostname']		= strip_tags(stripslashes($_POST['hostname']));
		$Options['username']		= strip_tags(stripslashes($_POST['username']));
		$Options['password']		= strip_tags(stripslashes($_POST['password']));
		$Options['extension']		= strip_tags(stripslashes($_POST['extension']));
		add_option('callmenow_options', $Options);
	}
	// Check if any options have changed
	if ($Original != $Options) {
		$Original = $Options;
		update_option('callmenow_options', $Options);
	}
	// Prepare list of PBX-servers
	$PBX['82.150.141.187'] = array('name' => 'login.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.182'] = array('name' => 'pbx2.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.183'] = array('name' => 'pbx3.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.184'] = array('name' => 'pbx4.belcentrale.nl', 'version' => 3);
	$PBX['82.150.141.188'] = array('name' => 'pbx5.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.95']  = array('name' => 'pbx6.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.97']  = array('name' => 'pbx7.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.91']  = array('name' => 'pbx8.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.99']  = array('name' => 'pbx9.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.254'] = array('name' => 'pbx10.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.98']  = array('name' => 'pbx11.belcentrale.nl', 'version' => 3);
	$PBX['82.150.141.201'] = array('name' => 'pbx12.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.189'] = array('name' => 'pbx13.belcentrale.nl', 'version' => 2);
	$PBX['82.150.143.21']  = array('name' => 'pbx14.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.93']  = array('name' => 'pbx15.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.94']  = array('name' => 'pbx16.belcentrale.nl', 'version' => 2);
	$PBX['82.150.141.185'] = array('name' => 'pbx17.belcentrale.nl', 'version' => 3);
	$PBX['82.150.141.191'] = array('name' => 'pbx18.belcentrale.nl', 'version' => 3);
	// Load extra files
	wp_register_style('callmenow', plugins_url('callmenow_admin.css', __FILE__));
	wp_enqueue_style('callmenow');
	wp_register_script('callmenow', plugins_url('callmenow_admin.js', __FILE__));
	wp_localize_script('callmenow', 'callmenow', array('ajax' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('callmenow_nonce'), 'openingstijden' => $Options['openingstijden'], 'base_url' => plugins_url('', __FILE__)));
	wp_enqueue_script('callmenow');
	// Output HTML
	?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2>Belcentrale Bel-Mij-Nu-knop</h2>
		<p>De Bel-Mij-Nu-knop voor Wordpress stelt u, als Belcentrale klant, in staat om in no-time uw <strong>telefonische bereikbaarheid</strong> te verbeteren.<br />Bezoekers van uw website kunnen voortaan <strong>direct</strong> met u in contact komen, door hun telefoonnummer op uw website in te voeren.<br />De <strong>Call-API koppeling</strong> met onze PBX-server maakt het mogelijk om direct een gesprek op te starten.</p>
		<form method="post">
		<?php wp_nonce_field('update-options'); ?>
		<h3>Algemene instellingen</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="enabled">Bel-Mij-Nu-knop:</label></th>
				<td>
					<select id="enabled" name="enabled">
						<option value="0"<?php echo ($Original['enabled'] == '0') ? ' selected="selected"' : '';?>>Uitgeschakeld</option>
						<option value="1"<?php echo ($Original['enabled'] == '1') ? ' selected="selected"' : '';?>>Ingeschakeld</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="phone">Uw telefoonnummer:</label></th>
				<td>
					<input type="text" name="phone" id="phone" value="<?php echo $Original['phone'];?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Telefoonnummers toestaan:</th>
				<td>
					Minimaal <input type="text" size="2" name="special_min" id="special_min" value="<?php echo $Original['special_min'];?>" /> tekens, maximaal <input type="text" size="2" name="special_max" id="special_max" value="<?php echo $Original['special_max'];?>" /> tekens<br />
					<input type="checkbox" value="1" name="special_0" id="special_0"<?php echo ($Original['special_0'] == '1') ? ' checked="checked"' : '';?> /> <label for="special_0">Begint met '0'</label><br />
					<input type="checkbox" value="1" name="special_06" id="special_06"<?php echo ($Original['special_06'] == '1') ? ' checked="checked"' : '';?> /> <label for="special_06">06-nummers</label><br />
					<input type="checkbox" value="1" name="special_08" id="special_08"<?php echo ($Original['special_08'] == '1') ? ' checked="checked"' : '';?> /> <label for="special_08">08-nummers</label><br />
					<input type="checkbox" value="1" name="special_09" id="special_09"<?php echo ($Original['special_09'] == '1') ? ' checked="checked"' : '';?> /> <label for="special_09">09-nummers</label><br />
					<input type="checkbox" value="1" name="special_foreign" id="special_foreign"<?php echo ($Original['special_foreign'] == '1') ? ' checked="checked"' : '';?> /> <label for="special_foreign">Buitenlandse nummers</label><br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Widget actief:</th>
				<td>
					<?php if (is_active_widget('callmenow_widget') == false) { ?>
					Nee, <a href="widgets.php">activeren</a>
					<?php } else { ?>
					Ja, <a href="widgets.php">widgets</a>
					<?php } ?>
				</td>
			</tr>
		</table>
		<h3>Call-API gegevens</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="hostname">PBX-server:</label></th>
				<td>
					<select id="hostname" name="hostname">
						<option value="" disabled="disabled" selected="selected">Snelkeuze PBX-server</option>
						<?php foreach ($PBX as $IP => $PBXarr) { ?>
							<option value="<?php echo $IP. "|" .$PBXarr[version];?>"<?php echo (substr($Original['hostname'], 0, -2) == $IP) ? ' selected="selected"' : '';?>><?php echo $PBXarr[name];?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="username">Call-API gebruikersnaam<br/>of App ID/key:</label></th>
				<td>
					<input type="text" name="username" id="username" value="<?php echo $Original['username'];?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="password">Call-API wachtwoord<br/>of App secret:</label></th>
				<td>
					<input type="text" name="password" id="password" value="<?php echo $Original['password'];?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="extension">Extensie:</label></th>
				<td>
					<input type="text" name="extension" id="extension" value="<?php echo $Original['extension'];?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"></th>
				<td>
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="callmenow_options" />
					<input class="button-primary" type="submit" name="callmenow_submit" value="<?php _e('Save Changes');?>" />
				</td>
			</tr>
		</table>
		<h3>Openingstijden <img id="openingstijden_loader" src="<?php echo plugins_url('loader.gif', __FILE__);?>" /></h3>
		<div id="openingstijden">
			<div id="current"></div>
			<hr />
			<div id="add">
				<div class="days">
					<?php
					// Output the days to be selected
					$Days = array('Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat', 'Zon');
					for ($i=0; $i<7; $i++) {
						echo '<span id="'.$i.'" class="dayclicker day notselected pointer">'.$Days[$i].'</span>';
					}
					?>
				</div>
				<label for="start">Van:</label>
				<select name="start" id="start">
					<?php
					// Output times from 0-23h with steps of 15 min
					for ($h=0; $h < 24; $h++) {
						if (strlen($h) == 1) {
							$h = '0'.$h;
						}
						for ($m=0; $m < 60; $m+=15) {
							if (strlen($m) == 1) {
								$m = $m.'0';
							}
							echo '<option value="'.$h.$m.'">'.$h.' : '.$m.'</option>';
						}
					}
					?>
				</select>
				<label for="end">Tot:</label>
				<select name="end" id="end">
					<?php
					// Output times from 0-23h with steps of 15 min
					for ($h=0; $h < 24; $h++) {
						if (strlen($h) == 1) {
							$h = '0'.$h;
						}
						for ($m=0; $m < 60; $m+=15) {
							if (strlen($m) == 1) {
								$m = $m.'0';
							}
							echo '<option value="'.$h.$m.'">'.$h.' : '.$m.'</option>';
						}
					}
					?>
				</select>
				<input type="button" class="button-primary" id="add_time" name="add_time" value="Toevoegen" />
			</div>
		</div>
		<h3>Uitleg</h3>
		<p><strong>Hoe wordt het gesprek in gang gezet?</strong></p>
		<ol>
			<li>De bezoeker voert zijn/haar telefoonnummer in de widget in</li>
			<li>Het telefoonnummer wordt gevalideerd aan de hand van uw 'Telefoonnummers toestaan' opties</li>
			<li>De configuratie van uw plugin wordt gecontroleerd</li>
			<li>De door u ingevoerde openingstijden worden gecontroleerd</li>
			<li>De verbinding met onze PBX-server en uw Call-API rechten worden gecontroleerd</li>
			<li>De bezoeker wordt eerst gebeld</li>
			<li>Zodra de bezoeker de telefoon opneemt, wordt uw telefoonnummer gebeld</li>
		</ol>
		<p><strong>Bent u reeds klant van Belcentrale?</strong><br />Bij onze support-afdeling kunt u de Call-API gegevens van uw PBX-centrale opvragen. U kunt onze support-afdeling bereiken via het e-mailadres <a href="mailto:support@belcentrale.nl">support@belcentrale.nl</a> of via het freeform contactformulier in het online control panel op <a href="http://www.belcentrale.nl">www.belcentrale.nl</a>.</p>
		<p><strong>Bent u geen klant van Belcentrale?</strong><br />Met een gratis testaccount van Belcentrale kunt u vrijblijvend op uw eigen tempo kennis maken met de kwaliteit, betrouwbaarheid en flexibiliteit van onze diensten. U kunt een gratis testaccount aanvragen op onze website, <a href="http://www.belcentrale.nl/voip/index.jsp?p=probeer">www.belcentrale.nl</a>.</p>
		</form>
	</div>
<?php
}

// Widget initialisation
function callmenow_widget_init() {
	// Check for required functions
	if (!function_exists('register_sidebar_widget'))
		return;
		
	// Widget front-end view
	function callmenow_widget($Arguments) {
		$Widget = get_option('callmenow_widget');
		global $Options;
		$Options = get_option('callmenow_options');
		if ($Options['enabled'] == 0) {
			return;
		}
		wp_register_style('callmenow', plugins_url('callmenow.css', __FILE__));
		wp_enqueue_style('callmenow');
		wp_register_script('callmenow', plugins_url('callmenow.js', __FILE__));
		wp_localize_script('callmenow', 'callmenow', array('ajax' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('callmenow_nonce')));
		wp_enqueue_script('callmenow');
		echo $Arguments['before_widget'];
		if (!empty($Widget['title'])) {
			echo $Arguments['before_title'].$Widget['title'].$Arguments['after_title'];
		}
		?>
		<form name="callmenow_form" id="callmenow_form" method="post">
			<div id="callmenow_content">
				<span id="callmenow_description"><?php echo nl2br($Widget['description']);?></span>
				<input type="text" name="callmenow_phone" id="callmenow_phone" value="" />
				<div id="callmenow_loader"><img src="<?php echo plugins_url('loader.gif', __FILE__);?>" /></div>
				<div id="callmenow_error"></div>
				<input type="submit" id="callmenow_submit" name="callmenow_submit" value="<?php echo $Widget['cta'];?>" />
			</div>
		</form>
		<?php
		echo $Arguments['after_widget'];
	}
	
	// Widget back-end view
	function callmenow_widget_control() {
		$Original = $Widget = get_option('callmenow_widget');
		if (isset($_POST['callmenow_widget_submit'])) {
			$Widget['title']		= strip_tags(stripslashes($_POST['title']));
			$Widget['description']	= strip_tags(stripslashes($_POST['description']));
			$Widget['cta']			= strip_tags(stripslashes($_POST['cta']));
			add_option('callmenow_widget', $Widget);
		}
		// Check if any options have changed
		if ($Original != $Widget) {
			$Original = $Widget;
			update_option('callmenow_widget', $Widget);
		}
		?>
		<div class="widget-content">
			<p>
				<label for="title">Titel:</label>
				<input type="text" class="widefat" name="title" id="title" value="<?php echo $Original['title'];?>" />
			</p>
			<p>
				<label for="description">Omschrijving:</label>
				<textarea name="description" id="description" class="widefat" style="text-align: center;"><?php echo $Original['description'];?></textarea>
			</p>
			<p>
				<label for="cta">Call-to-action:</label>
				<input type="text" class="widefat" name="cta" id="cta" value="<?php echo $Original['cta'];?>" />
			</p>
			<p>
				<a href="options-general.php?page=callmenow">Instellingen</a>
			</p>
			<input type="hidden" name="callmenow_widget_submit" value="submit" />
		</div>
		<?php
	}
	
	wp_register_sidebar_widget('callmenow_widget', 'Bel-Mij-Nu', 'callmenow_widget', array('description' => 'Een Bel-Mij-Nu-knop voor uw Wordpress website'));
	wp_register_widget_control('callmenow_widget', 'Bel-Mij-Nu', 'callmenow_widget_control');
}

$Options = '';

function callmenow_ajax() {
	if (!wp_verify_nonce($_POST['nonce'], 'callmenow_nonce' )) {
		$Return['message'] = 'Ongeldige nonce-sleutel';
	} else {
		$Phone = preg_replace('/\D/', '', $_POST['phone']);
		global $Options;
		$Options['Plugin'] = get_option('callmenow_options');
		$Options['Widget'] = get_option('callmenow_widget');
		if ($Options['Plugin']['enabled'] == '0') {
			$Return['message'] = 'Deze plugin is tijdelijk uitgeschakeld';
		} elseif (strlen($Phone) < $Options['Plugin']['special_min']) {
			$Return['message'] = 'Uw telefoonnummer moet minimaal '.$Options['Plugin']['special_min'].' tekens bevatten';
		} elseif (strlen($Phone) > $Options['Plugin']['special_max']) {
			$Return['message'] = 'Uw telefoonnummer mag maximaal '.$Options['Plugin']['special_max'].' tekens bevatten';
		} elseif ($Options['Plugin']['special_0'] == '1' && substr($Phone, 0, 1) != '0') {
			$Return['message'] = 'Uw telefoonnummer moet met een \'0\' beginnen';
		} elseif ($Options['Plugin']['special_06'] == '' && substr($Phone, 0, 2) == '06') {
			$Return['message'] = 'Uw telefoonnummer mag niet met \'06\' beginnen';
		} elseif ($Options['Plugin']['special_08'] == '' && substr($Phone, 0, 2) == '08') {
			$Return['message'] = 'Uw telefoonnummer mag niet met \'08\' beginnen';
		} elseif ($Options['Plugin']['special_09'] == '' && substr($Phone, 0, 2) == '09') {
			$Return['message'] = 'Uw telefoonnummer mag niet met \'09\' beginnen';
		} elseif ($Options['Plugin']['special_foreign'] == '' && substr($Phone, 0, 2) == '00') {
			$Return['message'] = 'Uw telefoonnummer mag niet met \'00\' beginnen';
		} elseif (
				!isset($Options['Plugin']['hostname']) ||
				!isset($Options['Plugin']['username']) ||
				!isset($Options['Plugin']['password']) ||
				!isset($Options['Plugin']['extension']) ||
				!isset($Options['Plugin']['phone']) ||
				$Options['Plugin']['hostname'] == '' ||
				$Options['Plugin']['username'] == '' ||
				$Options['Plugin']['password'] == '' ||
				$Options['Plugin']['extension'] == '' ||
				$Options['Plugin']['phone'] == ''
		) {
			$Return['message'] = 'Deze plugin is niet geconfigureerd';
		} else {			
			$Time = date('Hi', time()+(get_option('gmt_offset')*60*60));
			$Open = false;
			if (count($Options['Plugin']['openingstijden']) == 0) {
				$Open = true;
			} else {
				foreach($Options['Plugin']['openingstijden'] as $Rule) {
					foreach($Rule[0] as $Day) {
						if ($Day == (date('N')-1) && $Rule[1] < $Time && $Rule[2] > $Time) {
							$Open = true;
						}
					}
				}
			}
			if ($Open == false ) {
				$Return['message'] = 'Wij zijn op dit moment niet telefonisch bereikbaar';
			} else {	
				$First = $Phone;
				$Second = $Options['Plugin']['phone'];

				// Check if PBX server is version 3
				if (substr($Options['Plugin']['hostname'], -1) == 3) {
					
					require_once('lib.php');
					require_once('cURLRequest.php');
					
					// Fetch token
					$token = getToken();
	
					$headers = array(
					   'Content-type' => 'application/json',
					   'Authorization' => $token
					);
					
					// Initialize the cURL request
					$reqUrl = 'https://'.substr($Options['Plugin']['hostname'], 0, -2).'/uapi/phoneCalls/@me/simple';
					$request = new cURLRequest();
					$request->setMethod(cURLRequest::METHOD_POST);
					$request->setHeaders($headers);
					
					$jsonRequest = array(
						'extension' => $Options['Plugin']['extension'],             // Number of the extension configured to run with CallMeButton
						'phoneCallView' => array(
							array(
								'source' => array($Second), 						// Number of the extension configured to run with CallMeButton
								'destination' => $First,	             	 		// The phone number entered in the form field.
							))
					);
					$request->setBody(json_encode($jsonRequest));
					
					// Receive the response in JSON format
					$response = $request->sendRequest($reqUrl);
					
					$Return['message'] = 'Wij bellen u zo spoedig mogelijk';
				// PBX server is version 2
				} else {
					// keeps loading
					$Response['test'] = simplexml_load_file('https://'.substr($Options['Plugin']['hostname'], 0, -2).'/callapi/251/Test/CallPermission?Account='.$Options['Plugin']['username'].'&PassSHA256='.hash('sha256', $Options['Plugin']['password']).'&ExtensionNumber='.$Options['Plugin']['extension']);
					if (isset($Response['test']->Exception->Status)) {
						$Return['message'] = 'Er heeft zich een fout voorgedaan: '.$Response['test']->Exception->Status;
					} elseif (isset($Response['test']->Answer->Status) && $Response['test']->Answer->Status = '200') {
						$Response['call'] = simplexml_load_file('https://'.substr($Options['Plugin']['hostname'], 0, -2).'/callapi/handler.php?_version=251&_resource=Call&_method=MakeCall&WaitForPickup=15&Account='.$Options['Plugin']['username'].'&PassSHA256='.hash('sha256', $Options['Plugin']['password']).'&ExtensionAccount='.$Options['Plugin']['extension'].'&PhoneNumberToCall='.$Second.'&FromNumber='.$First);
						if (isset($Response['call']->Answer->Status) && $Response['call']->Answer->Status == '200') {
							$Return['message'] = 'Wij bellen u zo spoedig mogelijk';
						}
					}
				}
			}
		}
	}
	if (!isset($Return['message'])) {
		$Return['message'] = 'Er heeft zich een onvoorziene fout voorgedaan';
	}
	echo json_encode($Return);
	exit();
}

function callmenow_admin_ajax() {
	if (!wp_verify_nonce($_POST['nonce'], 'callmenow_nonce' )) {
		$Return['message'] = 'Ongeldige nonce-sleutel';
	} elseif (!current_user_can('manage_options'))  {
		$Return['message'] = 'Onvoldoende rechten';
	} else {
		// Load original options from database
		$Original = $Options = get_option('callmenow_options');
		$Options['openingstijden'] = $_POST['openingstijden'];
		add_option('callmenow_options', $Options);
		// Check if any options have changed
		if ($Original != $Options) {
			$Original = $Options;
			update_option('callmenow_options', $Options);
		}
		$Return['message'] = 'Opgeslagen';
	}
	if (!isset($Return['message'])) {
		$Return['message'] = 'Er heeft zich een onvoorziene fout voorgedaan';
	}
	echo json_encode($Return);
	exit();
}

// Add actions
add_action('plugin_action_links_'.plugin_basename(__FILE__), 'callmenow_plugin_actions');
add_action('admin_menu', 'callmenow_menu');
add_action('admin_init', 'callmenow_init');
add_action('widgets_init', 'callmenow_widget_init');
add_action('wp_ajax_callmenow_ajax', 'callmenow_ajax');
add_action('wp_ajax_nopriv_callmenow_ajax', 'callmenow_ajax');
add_action('wp_ajax_callmenow_admin_ajax', 'callmenow_admin_ajax');
add_action('wp_ajax_nopriv_callmenow_admin_ajax', 'callmenow_admin_ajax');
register_activation_hook(__FILE__, 'callmenow_install');
register_deactivation_hook(__FILE__, 'callmenow_uninstall');