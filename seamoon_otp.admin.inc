<?php
/**
 * @file
 * Admin forms and pages.
 */
 
 
/**
 * Seamoon OTP config form
 */
function seamoon_otp_admin_config(&$form_state) {
  drupal_set_title(t('Seamoon OTP'));
  
  $form = array();
  
  //$form['#tree'] = TRUE;
  
  $form['seamoon_otp'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Configuration'),
    '#collapsible'   => FALSE,
  );

  $form['seamoon_otp']['seamoon_otp_active'] = array(
    '#title'         => t('Activate Seamoon OTP Key Login'),
    '#description'   => t('Activate the Seamoon OTP security function.'),
    '#type'          => 'checkboxes',
    '#options' => array('1' => t('Enable')),
    '#default_value' => variable_get('seamoon_otp_active', 0),
  );

  $form['seamoon_otp']['seamoon_otp_switch_off'] = array(
    '#title'         => t('Pairing optional or mandatory?'),
    '#description'   => t('Switch off the normal login and activate the mandatory Seamoon OTP Key security for role users below.'),
    '#type'          => 'radios',
    '#options' => array('optional' => t('Optional'), 'mandatory' => t('Mandatory')),
    '#default_value' => variable_get('seamoon_otp_switch_off', 0),
  );

  $form['seamoon_otp']['seamoon_otp_url_formlogin'] = array(
    '#title'         => t('URL to redirect users after correct pairing'),
    '#description'   => t('Leave empty for Homepage'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_url_formlogin', _SEAMOON_OTP_URL_FORMLOGIN),
  );

  $form['seamoon_otp']['seamoon_otp_login_redir'] = array(
    '#title'         => t('URL to redirect users after correct login'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_login_redir', FALSE),
  );
  
  $form['seamoon_otp']['seamoon_otp_roles'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Seamoon OTP Roles'),
    '#collapsible'   => TRUE,
    '#collapsed'   => TRUE,
  );

  $form['seamoon_otp']['seamoon_otp_roles']['seamoon_otp_roles'] = array(
    '#title'         => t('Support for roles'),
    '#description'   => t('Switch off the normal login and activate the mandatory Seamoon OTP Key security.'),
    '#type'          => 'checkboxes',
    '#options' => _seamoon_otp_get_roles('all'),
    '#default_value' => variable_get('seamoon_otp_roles', array()),
  );
  
  $form['seamoon_otp']['seamoon_otp_brand'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Seamoon OTP Key\'s name'),
    '#collapsible'   => TRUE,
    '#collapsed'   => TRUE,
  );

  $form['seamoon_otp']['seamoon_otp_brand']['seamoon_otp_name'] = array(
    '#title'         => t('Brand\'s name of Seamoon OTP Key (singular)'),
    '#description'   => t('Personalize the name of Seamoon OTP Key term.'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_name', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_brand']['seamoon_otp_name_plur'] = array(
    '#title'         => t('Brand\'s name of Seamoon OTP Key (plural)'),
    '#description'   => t('Personalize the name of Seamoon OTP Key term.'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_name_plur', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_brand']['seamoon_otp_name_sing_short'] = array(
    '#title'         => t('Brand\'s name of Seamoon OTP Key (short singular)'),
    '#description'   => t('Personalize the name of Seamoon OTP Key term.'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_name_sing_short', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_brand']['seamoon_otp_name_plur_short'] = array(
    '#title'         => t('Brand\'s name of Seamoon OTP Key (short plural)'),
    '#description'   => t('Personalize the name of Seamoon OTP Key term.'),
    '#type'          => 'textfield',
  '#size'          => 30, 
  '#maxlength'     => 64, 
    '#default_value' => variable_get('seamoon_otp_name_plur_short', FALSE),
  );
  
  $form['seamoon_otp']['seamoon_otp_texts'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Seamoon OTP Pages texts'),
    '#collapsible'   => TRUE,
    '#collapsed'   => TRUE,
  );

  $form['seamoon_otp']['seamoon_otp_texts']['seamoon_otp_intro'] = array(
    '#title'         => t('Introduction'),
    //'#description'   => t(''),
    '#type'          => 'textarea',
    '#rows'          => 2,
    '#default_value' => variable_get('seamoon_otp_intro', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_texts']['seamoon_otp_des_pair'] = array(
    '#title'         => t('Description of pair phase'),
    //'#description'   => t(''),
    '#type'          => 'textarea',
    '#rows'          => 2,
    '#default_value' => variable_get('seamoon_otp_des_pair', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_texts']['seamoon_otp_confirm_pair'] = array(
    '#title'         => t('Confirmation of pair phase'),
    '#type'          => 'textarea',
    '#rows'          => 2,
    '#default_value' => variable_get('seamoon_otp_confirm_pair', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_texts']['seamoon_otp_login_intro'] = array(
    '#title'         => t('Introductions on otp key login page'),
    '#type'          => 'textarea',
    '#rows'          => 2,
    '#default_value' => variable_get('seamoon_otp_login_intro', FALSE),
  );

  $form['seamoon_otp']['seamoon_otp_texts']['seamoon_otp_login_des'] = array(
    '#title'         => t('Description fieldset on otp key login page'),
    '#type'          => 'textarea',
    '#rows'          => 2,
    '#default_value' => variable_get('seamoon_otp_login_des', FALSE),
  );
  
  return system_settings_form($form);

}


/**
 * Seamoon config form submit
 */
function seamoon_otp_admin_config_validate($form, &$form_state) {

  //print_r($form);
  //print_r($form_state); exit;
}


/**
 * Seamoon config form submit
 */
function seamoon_otp_admin_config_submit($form, &$form_state) {

  return system_settings_form_submit($form, $form_state);
  
}


/**
 * Seamoon list keys associated
 */
function seamoon_otp_list_keys() {

  drupal_set_title(t('Seamoon OTP keys'));
  
  $how_many_per_page = 50;
  
  $query = "SELECT * FROM {users},{seamoon_otp_users} WHERE {seamoon_otp_users}.uid = {users}.uid ORDER BY {seamoon_otp_users}.uid ASC";

  $results = pager_query($query, $how_many_per_page);
  
  $header = array(
        t('UID'), 
        t('Name'), 
        t('Serial Number ID'), 
        t('Paired'),
        t('Authentication'),
        t('Actions'),
      );
  
  $auth_types = array(
  '1' => t('Static passwords + dynamic password Authentication'),
  '2' => t('Dynamic password Authentication'),
  '3' => t('Static passwords Authentication'),
  '4' => t('Windows Domain Authentication'),
  );
  
  $attributes = array( 'width' => '75%', 'align' => 'center', 'border' => '2' );
  
  $rows = array();
  
  while ($quote = db_fetch_array($results)) {

    $time = date('d M Y H:i', $quote['time']);

    $url_user = drupal_get_path_alias( 'user/' . $quote['uid'] );
    $name     = '<a href="' .  base_path() . $url_user . '">' . $quote['name'] . '</a>';
    
    $auth_type = $auth_types[$quote['auth_method']];
    
    $url_del = base_path() . 'admin/user/seamoon_otp/key/' . $quote['kid'] . '/delete';

    $delete = '<a href="' . $url_del . '">' . t('Delete') .'</a>';

    $rows[] = array($quote['uid'], $name, $quote['serial_number'], $time, $auth_type, $delete);

  }
  
  if (count($rows)) {

  $html.= theme('table', $header, $rows, $attributes);

  $html.= theme('pager', NULL, $how_many_per_page);

  } else {

  $html.= t('No keys found');
  
  }

  return $html;

}


/**
 * Seamoon delete pairing form
 */
function seamoon_otp_del_pair_confirm_form($form_state) {
  
  //you can pass variables here if need be
  $form['kid'] = array(
    '#type' => 'value',
    '#value' => arg(4),
  );
  $form['action'] = array(
    '#type' => 'value',
    '#value' => arg(5),
  );
 
  //you can set a redirect if needed
  $form['#redirect'] = 'admin/user/seamoon_otp/listkey';
 
  return confirm_form($form,
    t('Are you sure you want erase this pairing?'), //message title
    isset($_GET['destination']) ? $_GET['destination'] : 'admin/user/seamoon_otp/listkey', //redirect if cancelled
    t('Click Delete if you are sure.'), //message description
    t('Delete'), //confirm button text
    t('Cancel') //cancel button text
  );

}


/**
 * Seamoon delete pairing confirm_form_submit
 */
function seamoon_otp_del_pair_confirm_form_submit($form, &$form_state) {
  
  $kid = $form_state['values']['kid'];
  $action = $form_state['values']['action'];
  $confirm = $form_state['values']['confirm'];
  
  if ( $action == 'delete' && $confirm == '1' && !empty($kid) ) {
  
    $query = db_query("DELETE FROM {seamoon_otp_users} WHERE kid = %d", $kid);
    
    if ( $query ) {

      // In case of error mysql query
      drupal_set_message( t('Pairing removed.' ), 'status' );

    } else {

      // In case of error mysql query
      drupal_set_message( t('Some troubles with deleting pairing. Please, try again.'), 'error' );

    }
  
  }
  
}