<?php
/**
 * @file
 * User pages.
 */

/**
 * Seamoon Keys page form
 */
function seamoon_otp_key_pair_form($form_value) {
  // Define global variables
  global $user, $seamoon_otp_conf;

  drupal_add_css(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.css');
  drupal_add_js(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.js');

  drupal_set_title(t('!name - Pair your digital key', array('!name' => variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT) ) ) );

  // Get pairing modality
  $pairing = variable_get('seamoon_otp_pairing', FALSE);

  $form['seamoon_otp_key_pair'] = array(
    '#type'          => 'fieldset',
    '#title'         => variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT),
    '#prefix'        => '<p>' . t( variable_get('seamoon_otp_intro', SEAMOON_OTP_INTRO) ) . '</p>',
    '#description'   => '<p>' . t( variable_get('seamoon_otp_des_pair', SEAMOON_OTP_DESCRIPTION) ) . '</p>',
    '#collapsible'   => FALSE,
  );
  
  $form['seamoon_otp_key_pair']['username'] = array(
    '#type' => 'textfield', 
    '#title' => t('Username'), 
    '#value' => $user->name, 
    '#size' => 30, 
    '#maxlength' => 256, 
    '#disabled' => TRUE,
  );
  
  $form['seamoon_otp_key_pair']['uid'] = array(
    '#type' => 'textfield', 
    '#title' => t('User ID'), 
    '#value' => $user->uid, 
    '#size' => 30, 
    '#maxlength' => 12, 
    '#disabled' => TRUE,
  );
  
  $form['seamoon_otp_key_pair']['serial_number'] = array(
    '#type' => 'textfield', 
    '#title' => t('Serial Number Key'), 
    '#size' => 15, 
    '#maxlength' => 9, 
    '#required' => TRUE,
    '#description' => '<span></span>',
  );
  
  $form['seamoon_otp_key_pair']['otp_code'] = array(
    '#type' => 'textfield', 
    '#title' => t('Key code'), 
    '#size' => 15, 
    '#maxlength' => 7, 
    '#required' => TRUE,
  );

  $form['seamoon_otp_key_pair']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Send and pair your key'),
    '#suffix' => ($pairing == 'mandatory') ? '<a href="'. drupal_get_path_alias('logout') .'" class="close">' . t('Close') . '</a>' : '',
  );
  
  $form['#suffix'] = ($pairing == 'mandatory') ? '<div id="seamoon-otp-key-overlay"></div>' : '';
  
  return $form;
}


/**
 * Seamoon Key page form validate
 */
function seamoon_otp_key_pair_form_validate($form, &$form_state) {
  // Define global variables
  global $user, $language;

  // Set errors variable
  $errors = null;
  
  // Serial Number from user form
  $sn_fid = $form['seamoon_otp_key_pair']['serial_number'];
  $sn_nam = $sn_fid['#title'];
  $sn_val = $form_state['values']['serial_number'];
  
  $otp_key = $form['seamoon_otp_key_pair']['otp_code'];
  $otp_nam = $otp_key['#title'];
  $otp_val = preg_replace('/\s+/', '', $form_state['values']['otp_code']);
    
  // Validate SN field
  if ( !empty($sn_val) ) {

    if ( !is_numeric($sn_val) ) {
        form_error($sn_fid, t('You must enter only numbers in %s field.', array('%s' => $sn_nam)) );
        $errors+=1;
    }

    if ( strlen($sn_val) < 9 ) {
        form_error($sn_fid, t('You must enter a %s field correctly.', array('%s' => $sn_nam)) );
        $errors+=1;
    }
  }
  
  // Validate otp fields
  if ( !empty($otp_val) && ( strlen($otp_val) < 3 || !is_numeric($otp_val) ) ) {
    form_error($otp_key, t('You must enter a %s field correctly.', array('%s' => $otp_nam)) );
    $errors+=1;
  }
  
  // CHECK if serial key exist in database of serial keys
  $sn_exist = seamoon_otp_check_sn_exist($sn_val);

  if ( !empty($sn_val) && isset($sn_exist->serial_number) && $sn_exist->serial_number != $sn_val ) {
    form_error($sn_fid, t('The %field inserted is not correct.', array('%field' => $sn_nam)) );
    $errors+=1;
  }
    
  // CHECK if serial key is already associated in database with an user
  $sn_associated = seamoon_otp_check_sn_pair_exist($sn_val);

  if ( !empty($sn_val) && isset($sn_associated->serial_number) && $sn_associated->serial_number == $sn_val ) {
    form_error($sn_fid, t('The %field inserted it\'s already associated with an account.', array('%field' => $sn_nam)) );
    $errors+=1;
  } 

  // CHECK if the new association serial_key|sn_info is valid using the 
  // seamoon API
  if (is_null($errors)) {

    // Require the Seamoon PHP SDK only in certain case
    require_once dirname(__FILE__) . '/phpsdk/seamoonapi.php';

    $key = new seamoonapi();

    // Serial Key Info from query sql
    $sn_key = isset($sn_exist->serial_number_key) ? $sn_exist->serial_number_key : '';

    // Serial Number Key validation
    $result = $key->passwordsyn($sn_key, $otp_val);

    dpm($result);

    // 
    if( strlen($result) < 3 ) {
        form_error($otp_key, t('The %field inserted is not correct.', array('%field' => $otp_nam)) );
    } else {
        // Make a variable for submit process
        $form_state['values']['#sn_key'] = $sn_key;
    }

  }
  
  return $form;
}


/**
 * Seamoon Key page form submit
 */
function seamoon_otp_key_pair_form_submit($elements, &$form_state, $form_id = NULL) {
  // Define global variables    
  global $language, $user;

  // Serial Number from user form
  $sn_fid = $elements['seamoon_otp_key_pair']['serial_number'];
  $sn_nam = $sn_fid['#title'];
  $sn_val = $form_state['values']['serial_number'];

  $otp_key = $elements['seamoon_otp_key_pair']['otp_code'];
  $otp_nam = $otp_key['#title'];
  $otp_val = preg_replace('/\s+/', '', $form_state['values']['otp_code']);
    
  $sn_key = $form_state['values']['#sn_key'];
  
  // Store the new Serial Number Key validated in sql table
  $sn_key_new = $sn_key;
  $queryUpdSnKey = db_query("UPDATE {seamoon_otp_sn} SET serial_number_key = '%s' WHERE {seamoon_otp_sn}.serial_number = '%d';", array('%s' => $sn_key_new, '%d' => $sn_val) );

  // if updating of sn key is good, continue with pair user to the otp key code
  if ($queryUpdSnKey) {

    $uid = $user->uid;
    $serial_number = $sn_val;
    $auth = 1;
    $time = time();

    $data = (object) array('', 'uid' => $uid, 'serial_number' => $serial_number, 'auth_method' => $auth, 'time' => $time);
    
    $queryInsSnUser = drupal_write_record('seamoon_otp_users', $data );
    
    // In case of insert row error
    if ( !$queryInsSnUser )
        drupal_set_message( t('Some troubles with %field pairing. Please, try again.', array('%field' => $sn_nam)), 'error' );

  } else {

    // In case of error mysql query
    drupal_set_message( t('Some troubles with %field inserted. Please, try again.', array('%field' => $otp_nam)), 'error' );

  }

}


/**
 * Seamoon Key page form
 */
function seamoon_otp_key_paired($form_state) {
  // Define global variables  
  global $language;

  drupal_add_css(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.css');
  drupal_add_js(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.js');

  drupal_set_title(t('!name - Paired correctly', array('!name' => variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT))));
  
  $brand_name_sing_short = variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT);
  $seamoon_otp_confirm_pair = variable_get('seamoon_otp_confirm_pair', SEAMOON_OTP_CONFIRM_PAIR);
  $seamoon_otp_paired_redir = variable_get('seamoon_otp_paired_redir', seamoon_otp_paired_redir);
    
  $lang = $language->language;
  
  $msg = drupal_get_messages();
  
  // in case of old error messages from hook_submit, transfer user again on
  // the first page of key pair
  if ( !empty( $msg ) ) {
    drupal_set_message( t('Some troubles. Please, try again.'), 'error' );
    drupal_goto('otp_key');
  }
  
  // If no errors exist, logout the user
  watchdog('user', 'Session closed for %name.', array('%name' => $user->name));

  // Destroy the current session:
  session_destroy();
  $null = NULL;
  user_module_invoke('logout', $null, $user);

  // Load the anonymous user
  $user = drupal_anonymous_user();      

  // If no errors exist, continue with page confirmation
  $type = 'key';
  $title = t('Confirmation');

  if ( !empty($seamoon_otp_confirm_pair) ) {
    
    $content.= '<p class="big">' . $seamoon_otp_confirm_pair . '</p>';
  
  }
  
  $login = base_path() . $seamoon_otp_paired_redir;
  
  $content.= '<p class="medium">' . t('Now, you can <a href="!login">login</a> again, to try the security login with Key.', array('!login' => $login)) . '</p>';

  $content.= t('');

  return theme('otp_key_paired', $type, $title, $content);

}


/**
* Implementation of hook_theme() for seamoon_otp_theme without tpl
*/
/*function theme_otp_key_paired($text, $origin) {

    $output = '<div id="philquotes-text">'. t($text) .'</div><div id="philquotes-origin">'. t($origin) .'</div>';

    return $output;

}*/


/**
 * Seamoon Keys page login form
 */
function seamoon_otp_key_login_form($form_value) {
  // Define global variables    
  global $user;

  drupal_add_css(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.css');
  drupal_add_js(drupal_get_path('module', 'seamoon_otp') .'/seamoon_otp.js');

  drupal_set_title(t('!name - Login with your digital key', array('!name' => variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT))));

  $form['#suffix'] = '<div id="seamoon-otp-key-overlay"></div>';

  $form['seamoon_otp_login_key'] = array(
    '#type'          => 'fieldset',
    '#title'         => variable_get('seamoon_otp_name_sing_short', SEAMOON_OTP_NAME_SING_SHORT),
    '#prefix'        => '<p>' . t( variable_get('seamoon_otp_login_intro', SEAMOON_OTP_LOGIN_INTRO) ) . '</p>',
    '#description'   => '<p>' . t( variable_get('seamoon_otp_login_des', SEAMOON_OTP_LOGIN_DESCRIPTION) ) . '</p>',
    '#collapsible'   => FALSE,
  );
  
  $form['seamoon_otp_login_key']['otp_code'] = array(
    '#type' => 'textfield', 
    '#title' => t('Key code'), 
    '#default_value' => $form_value['post']['otp_code'], 
    '#size' => 15, 
    '#maxlength' => 7, 
    '#required' => TRUE,
  );

  $form['seamoon_otp_login_key']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Login'),
    '#suffix' => '<a href="/logout" class="close">' . t('Close') . '</a>',
  );
  
  return $form;

}


/**
 * Seamoon Key page login form validate
 */
function seamoon_otp_key_login_form_validate($form, &$form_state) {
  // Define global variables    
  global $user, $language;

  // Set errors variable
  $errors = null;
    
  $otp_key = $form['seamoon_otp_login_key']['otp_code'];
  $otp_nam = $otp_key['#title'];
  $otp_val = preg_replace('/\s+/', '', $form_state['values']['otp_code']);
  
  // Validate otp fields
  if ( !empty($otp_val) && ( strlen($otp_val) < 3 || !is_numeric($otp_val) ) ) {
    form_error($otp_key, t('You must enter a %s field correctly.', array('%s' => $otp_nam)) );
    $errors+=1;
  }
  
  // CHECK if the new association serial_key|sn_info is valid using the
  // seamoon API
  if (is_null($errors)) {

    // Require the Seamoon PHP SDK only in certain case
    require_once dirname(__FILE__) . '/phpsdk/seamoonapi.php';

    $key = new seamoonapi();
    
    // Serial Key Info from query sql
    $sn_info = seamoon_otp_get_user_sn_info($user->uid);
    $sn_kid = isset($sn_info->serial_number) ? $sn_info->serial_number : null;
    $sn_key = isset($sn_info->serial_number_key) ? $sn_info->serial_number_key : null;

    // Serial Number Key validation
    $result = $key->passwordsyn($sn_key, $otp_val);

    if( strlen($result) < 3 ) {
    
        form_error($otp_key, t('The %field inserted is not correct.', array('%field' => $otp_nam)) );
    
    } else {
    
        $sn_key_new = $result;

        // Make a variable for submit process
        $form_state['values']['#sn_kid'] = $sn_kid;
        $form_state['values']['#sn_key'] = $sn_key_new;

    }

  }
  
  return $form;

}

/**
 * Seamoon Key page form submit
 */
function seamoon_otp_key_login_form_submit($elements, &$form_state, $form_id = NULL) {
  // Define global variables    
  global $language, $user;

  $lang = $language->language;
  
  // Serial Number from user form
  $sn_kid = $form_state['values']['#sn_kid'];
  $sn_key = $form_state['values']['#sn_key'];
  
  // OTP
  $otp_key = $elements['seamoon_otp_login_key']['otp_code'];
  $otp_nam = $otp_key['#title'];
  
  // Store the new Serial Number Key validated in sql table
  $queryUpdSnKey = db_query("UPDATE {seamoon_otp_sn} SET serial_number_key = '%s' WHERE {seamoon_otp_sn}.serial_number = '%d';", array('%s' => $sn_key, '%d' => $sn_kid) );
  
  // if updating of sn key is good, transferring user on page logged
  if ($queryUpdSnKey) {
    
    // Set cookie to store in the cookie that the user is connected correctly
    setcookie('seamoon_otp_key_logged', 'Y', time() + ini_get('session.cookie_lifetime'), ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure') == '1');
    
    // Reset nocache_otp cookie
    if (isset($_COOKIE['nocache_otp'])) {
        setcookie('nocache_otp', "", time() - 86400, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure') == '1');
    }
    
    // Take URL redirection from settings
    $url_redir = variable_get('seamoon_otp_login_redir', '');
    
    // Check alias from url_redir
    $alias = !empty($url_redir) ? $url_redir : '';
    
    // Autologin to the sport website
    $autologin = drupal_get_path_alias($alias, $lang);
    
    drupal_goto($autologin);

  } else {

    // In case of error mysql query
    drupal_set_message( t('Some troubles with %field inserted. Please, try again.', array('%field' => $otp_nam)), 'error' );

  }
}
