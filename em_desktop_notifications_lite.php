<?php
/**
* Plugin Name: Push Notifications Lite
* Plugin URI: http://pushem.org
* Description: Push Notifications Lite for your Wordpress website (push notifications works throw pushem.org [our common server]). Free licenses for our Envato customers, free 14 days trial.
* Version: 1.0.3
* Author: Emrys Forge
* Author URI: http://emrysforge.com
* License: GPL
*/

/* Plugin Initiate section */
/* End of Plugin Initiate section */

/* Plugin setting section */

function em_desktop_notifications_lite_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=emdn_options">'.__("Settings","emdn").'</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'em_desktop_notifications_lite_settings_link' );

function em_desktop_notifications_lite_add_options_submenu_page() {
     add_submenu_page(
          'options-general.php',
          __( 'Push Notifications Lite Options', 'emdn' ),
          __( 'Push Notifications Lite', 'emdn' ),
          'manage_options',
          'emdn_options',
          'em_desktop_notifications_lite_options_page'
     );
}
add_action( 'admin_menu', 'em_desktop_notifications_lite_add_options_submenu_page' );

function em_desktop_notifications_lite_register_settings() {
     register_setting(
          'emdn_options',
          'emdn_pushem_id'
     );
    register_setting(
          'emdn_options',
          'emdn_pushem_key'
    );
    register_setting(
          'emdn_options',
          'emdn_pushem_source'
    );

    //Getting options
    register_setting( 'emdn_options', 'emdn_pushem_token');
    register_setting( 'emdn_options', 'emdn_pushem_domain');
    register_setting( 'emdn_options', 'emdn_pushem_subdomain');
    register_setting( 'emdn_options', 'emdn_pushem_googleid');
    register_setting( 'emdn_options', 'emdn_pushem_gcmapi');
    register_setting( 'emdn_options', 'emdn_pushem_type');
    register_setting( 'emdn_options', 'emdn_pushem_mode');
    register_setting( 'emdn_options', 'emdn_pushem_widget_show');
}
add_action( 'admin_init', 'em_desktop_notifications_lite_register_settings' );

function em_desktop_notifications_lite_options_page() {
    if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
    
    if (isset($_POST['export']) && $_POST['export'] == 1) {
      em_desktop_notifications_lite_export_old_data();
    }

    if (isset($_POST['destroy']) && $_POST['destroy'] == 1) {
      em_desktop_notifications_lite_destroy_old_data();
    }
    ?>
 
     <div class="wrap">
 
          <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
               <div class="updated fade"><p><strong><?php _e( 'Push Notifications options saved!', 'emdn' ); ?></strong></p></div>
          <?php endif; ?>
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">

                         <form method="post" action="options.php">
                              <?php settings_fields( 'emdn_options' ); ?>
                              <?php $pushem_id = get_option( 'emdn_pushem_id' ); ?>
                              <?php $pushem_key = get_option( 'emdn_pushem_key' ); ?>

                              <table class="form-table">
                                  <tr valign="top">
                                    <p><h3><a href="http://emrysforge.com/product/desktop-push-notifications-wordpress/">Get Advanced Push Notifications Plugin for more functions</a></h3></p>
                                  </tr>
                                   <tr valign="top">
                                   <p><h3><?php _e('Pushem.org account', 'emdn'); ?></h3></p>
                                        <td>
                                            <p>
                                            <label class="label" for="emdn_pushem_id[pushem_id]"><?php _e( 'Pushem.org account ID', 'emdn' ); ?></label>
                                            <input type="text" name="emdn_pushem_id[pushem_id]" value="<?php echo $pushem_id['pushem_id']; ?>">
                                            </p>
                                            
                                            <p>
                                            <label class="label" for="emdn_pushem_key[pushem_key]"><?php _e( 'Pushem.org account API key', 'emdn' ); ?></label>
                                            <input type="text" name="emdn_pushem_key[pushem_key]" value="<?php echo $pushem_key['pushem_key']; ?>">
                                            </p>
                                        </td>
                                    <td>
                                    <p><?php _e('Get ID and API key in your <a href="https://pushem.org/?q=user/account" target="_blank">Pushem.org account page</a>, if you do not have account <a href="https://pushem.org/?q=user/register" target="_blank">CREATE ACCOUNT FOR FREE</a>','emdn'); ?></p>
                                    <p><br /></p>
                                    <p><?php _e('Get more details and pictured INSTRUCTION in our <a href="http://emrysforge.com/documentation/" target="_blank">online documentation</a>','emdn'); ?></p>
                                    </td>
                                    </tr>
                              </table>
                              <input type="submit" class="button-primary" value="<?php _e('Save Account') ?>" />
                              <form method="post" action="options.php">
                              <?php $pushem_source = get_option( 'emdn_pushem_source' ); ?>
                              <?php $pushem_widget_show = get_option( 'emdn_pushem_widget_show' ); ?>
                              <table class="form-table">
                                <tr valign="top">
                                    <td>
                                            <hr>
                                                <?php
                                                    if ( !empty($pushem_id['pushem_id']) && !empty($pushem_key['pushem_key']) ) {
                                                        $url = 'https://pushem.org/api/user/get_license/?uid='.$pushem_id['pushem_id'].'&key='.$pushem_key['pushem_key'];
                                                        $result = file_get_contents($url, false);
                                                        if (!empty($result)) {
                                                            print '<h3>'.$result.'</h3>';
                                                            ?>
                                                            <p><?php _e('To improve you license, you can connect you Pushem.org account with Envato (if you have purchased our plugin on CodeCanyon) <a href="https://pushem.org/?q=user/account" taget="_blank">on your account page</a>. [Your CodeCanyon license will be converted to Pushem.org license of type REGULAR or EXTENDED]','emdn'); ?></p>
                                                            <p><?php _e('You can purchase other type on license if you want to use plugin and service on more websites. <a href="https://pushem.org/#pricing" target="_blank">Choose your license type here</a>', 'emdn');?></p>
                                                            <?php
                                                        } else {
                                                            print '<span style="color:#FA0000">';
                                                            _e('Cannot get pushem.org account with currect ID and API key','emdn');
                                                            print '</span>';
                                                        }
                                                    }
                                                ?>                                            
                                            <hr>
                                            <p><h3><?php _e('Pushem.org source [Edit sources in <a href="https://pushem.org/?q=user">your pushem.org account</a>]', 'emdn'); ?></h3></p>
                                            <p>
                                                <?php
                                                    if ( !empty($pushem_id['pushem_id']) && !empty($pushem_key['pushem_key']) ) {
                                                        $url = 'https://pushem.org/api/sources/get_all/?uid='.$pushem_id['pushem_id'].'&key='.$pushem_key['pushem_key'];
                                                        $result = file_get_contents($url, false);
                                                        
                                                        if (!empty($result)) {
                                                        $result = json_decode($result);
                                                        ?>
                                                        <label class="label" for="emdn_pushem_source[pushem_source]"><?php _e( 'Choose source', 'emdn' ); ?></label>
                                                            <select name="emdn_pushem_source[pushem_source]" id="hide-meta">
                                                            <?php 
                                                            if (!empty($pushem_source['pushem_source'])) {
                                                              $selected = $pushem_source['pushem_source'];
                                                            } else {
                                                              $selected = '';
                                                            }
                                                            ?>
                                                            <?php
                                                            foreach ($result as $key => $value) {
                                                                print $value->id;
                                                                print '<option value="'.$value->id.'" '.selected( $selected, $value->id ).' >'.$value->domain.'</option>';
                                                            }
                                                            ?>
                                                            </select>
                                                        <?php
                                                        } else {
                                                            _e('You need to create least one source in your pushem.org account','emdn');
                                                        }
                                                    }
                                                ?>
                                            </p>

                                            <hr>
                                            <p><h3><?php _e('Advanced options', 'emdn'); ?></h3></p>
                                            <p>
                                              <label class="label" for="emdn_pushem_widget_show[pushem_widget_show]"><?php _e( 'Choose widget visibility', 'emdn' ); ?></label>
                                                <select name="emdn_pushem_widget_show[pushem_widget_show]" id="hide-meta">
                                                  <?php $selected = $pushem_widget_show['pushem_widget_show']; ?>
                                                  <option value="1" <?php selected( $selected, 1 ); ?> >Show Widget</option>
                                                  <option value="0" <?php selected( $selected, 0 ); ?> >Hide Widget</option>
                                                </select>
                                            </p>
                                            <p><?php _e('<i>* For HTTPS sites and Mode:auto (only)</i>', 'emdn'); ?></p>

                                        </td>
                                   </tr>
                              </table>
                              <input type="submit" class="button-primary" value="<?php _e('Update Source') ?>" />
                         </form>
                              
                              <table class="form-table">
                                   <tr valign="top">
                                        <td>
                                            <p><h3><?php _e('Source data', 'emdn'); ?></h3></p>
                                            <p>
                                            <?php
                                                if (!empty($pushem_source['pushem_source']) && !empty($pushem_id['pushem_id']) && !empty($pushem_key['pushem_key']) ) {
                                                    $url = 'https://pushem.org/api/sources/get_by_id/?uid='.$pushem_id['pushem_id'].'&key='.$pushem_key['pushem_key'].'&source='.$pushem_source['pushem_source'];
                                                    $result = file_get_contents($url, false);
                                                    
                                                    if (!empty($result)) {
                                                        $result = json_decode($result);
                                                        
                                                        $token_url = 'https://pushem.org/api/user/get_token/?uid='.$pushem_id['pushem_id'].'&key='.$pushem_key['pushem_key'].'&source='.$pushem_source['pushem_source'];
                                                        $token = file_get_contents($token_url, false);

                                                        update_option( 'emdn_pushem_token', $token );
                                                        update_option( 'emdn_pushem_domain', $result[0]->domain );
                                                        update_option( 'emdn_pushem_subdomain', $result[0]->subdomain );
                                                        update_option( 'emdn_pushem_googleid', $result[0]->google_id );
                                                        update_option( 'emdn_pushem_gcmapi', $result[0]->gcm_api );
                                                        update_option( 'emdn_pushem_type', $result[0]->type );
                                                        update_option( 'emdn_pushem_mode', $result[0]->mode );

                                                        print '<p>Token: <b>'.get_option( 'emdn_pushem_token' ).'</b></p>';
                                                        print '<p>Domain: <b>'.get_option( 'emdn_pushem_domain' ).'</b></p>';
                                                        print '<p>Subdomain: <b>'.get_option( 'emdn_pushem_subdomain' ).'</b></p>';
                                                        print '<p>Google ID: <b>'.get_option( 'emdn_pushem_googleid' ).'</b></p>';
                                                        print '<p>GCM API key: <b>'.get_option( 'emdn_pushem_gcmapi' ).'</b></p>';
                                                        
                                                        $type = get_option( 'emdn_pushem_type' );
                                                        if ($type == 1) {
                                                            $type_txt = 'HTTPS';
                                                        }
                                                        if ($type == 0) {
                                                            $type_txt = 'HTTP';
                                                        }
                                                        print '<p>Security type: <b>'.$type_txt.'</b>&emsp;<span>['.__("Secure type must be the same as your website - HTTP or HTTPS]","emdn").'</span></p>';

                                                        print '<p>Subscription mode: <b>'.get_option( 'emdn_pushem_mode' ).'</b></p>';

                                                        ?>
                                                        <hr>
                                                        <p><h3><?php _e('Widget theming', 'emdn'); ?></h3></p>
                                                        <p><?php _e("If you want to change widget layout, or text on it, please, edit Design section on pushem.org source edit form","emdn"); ?></p>
                                                        <p><a href="https://pushem.org/?q=/node/<?php echo $pushem_source['pushem_source']; ?>/edit" target="_blank" class="button-primary"><?php _e('Edit Currect Source','emdn'); ?></a></p>
                                                        <?php                                                        
                                                    } else {
                                                        _e('You need to press "Update source" button to get settings form pushem.org','emdn');
                                                    }
                                                }
                                            ?>
                                            </p>
                                        </td>
                                    </tr>

                              </table>

                    </div>
               </div>
          </div>
     </div>
<?php
}

/* End of Plugin setting section */

/* Plugin Initate pushem.org (head behaivor) */

add_action ('wp_head','em_desktop_notifications_lite_set_header');

function em_desktop_notifications_lite_set_header() {
    $type = get_option( 'emdn_pushem_type' );
    if ($type !== FALSE) {
        if ($type == 0) {
            $token = get_option( 'emdn_pushem_token' );
            if ($token !== FALSE) {
                $user = wp_get_current_user();
                    if (isset($user->ID)) {
                          if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
                            foreach ( $user->roles as $role ) $roles[] = urlencode($role);
                            $s = implode(",",$roles);
                            $widget_file = 'https://pushem.org/widget/widget.js?token='.$token.'&site_id='.$user->ID.'&segment='.$s;
                            print '<script src="'.$widget_file.'"></script>';
                          } else {
                            $widget_file = 'https://pushem.org/widget/widget.js?token='.$token.'&site_id='.$user->ID; //site_ID?
                            print '<script src="'.$widget_file.'"></script>';
                          }
                    } else {
                        $widget_file = 'https://pushem.org/widget/widget.js?token='.$token; //site_ID?
                        print '<script src="'.$widget_file.'"></script>';
                    }
            }
        }
        if ($type == 1) {
            $mainfest_file = plugins_url( 'js/sdk/manifest.json.php', __FILE__ );
            print '<link rel="manifest" href="'.$mainfest_file.'">';
            $token = get_option( 'emdn_pushem_token' );
            $widget_show = get_option( 'emdn_pushem_widget_show' );
            if ($token !== FALSE) {
                $user = wp_get_current_user();
                    if (isset($user->ID)) {
                        if ($widget_show['pushem_widget_show'] == 1) {
                          $widget_file = 'https://pushem.org/widget/widget.js?token='.$token.'&site_id='.$user->ID; //site_ID?
                          print '<script src="'.$widget_file.'"></script>';
                        }
                          if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
                            foreach ( $user->roles as $role ) $roles[] = urlencode($role);
                            $s = implode(",",$roles);
                            
                            $pushem_data_array = array( 'swpath' => plugins_url( 'js/sdk/sw.js', __FILE__ ) );
                            
                            $init_file = plugins_url( 'js/sdk/init.js', __FILE__ ).'?token='.$token.'&site_id='.$user->ID.$segments;
                            wp_enqueue_script( 'pushem_init', $init_file );
                            wp_localize_script( 'pushem_init', 'pushem_data', $pushem_data_array );

                            //$init_file = plugins_url( 'js/sdk/init.js', __FILE__ ).'?token='.$token.'&site_id='.$user->ID.'&segment='.$s;
                            //print '<script src="'.$init_file.'"></script>';
                          } else {
                            $pushem_data_array = array( 'swpath' => plugins_url( 'js/sdk/sw.js', __FILE__ ) );
                            
                            $init_file = plugins_url( 'js/sdk/init.js', __FILE__ ).'?token='.$token.'&site_id='.$user->ID;

                            wp_enqueue_script( 'pushem_init', $init_file );
                            wp_localize_script( 'pushem_init', 'pushem_data', $pushem_data_array );

                            //print '<script src="'.$init_file.'"></script>';
                          }
                    } else {
                        if ($widget_show['pushem_widget_show'] == 1) {
                          $widget_file = 'https://pushem.org/widget/widget.js?token='.$token; //site_ID?
                          print '<script src="'.$widget_file.'"></script>';
                        }
                        $pushem_data_array = array( 'swpath' => plugins_url( 'js/sdk/sw.js', __FILE__ ) );
                        
                        $init_file = plugins_url( 'js/sdk/init.js', __FILE__ ).'?token='.$token;
                            
                            wp_enqueue_script( 'pushem_init', $init_file );
                            wp_localize_script( 'pushem_init', 'pushem_data', $pushem_data_array );

                        //print '<script src="'.$init_file.'"></script>';
                    }
            }
        }
    }

}

/* End of Plugin Initate pushem.org (head behaivor) */


/* Plugin Add Notifications behaivor */

function em_desktop_notifications_lite_add ($entity_id, $var, $hook, $var_type) {


if ($var_type != NULL) {

    $args = array(

    'post_type' => 'desktop_notification',

    'meta_query' => array(
        'relation' => 'AND',
            array(
            'key' => 'ac_hook',
            'value' => $hook
            ),
            array(
            'key' => 'ac_var_type',
            'value' => $var_type
            ),
            array (
            'key' => 'ac_var',
            'value' => $var
            )
    )

    );
} else {
    
    $args = array(

    'post_type' => 'desktop_notification',

    'meta_query' => array(
        'relation' => 'AND',
            array(
            'key' => 'ac_hook',
            'value' => $hook
            ),
            array(
            'key' => 'ac_var',
            'value' => $var
            )
    )

    );
}
 
    $query = new WP_Query;
    $dn_list = $query->query($args);

    if ($dn_list != NULL) {
        foreach ($dn_list as $dn) {
            em_desktop_notifications_lite_add_one($dn->ID, $entity_id);
        }
    }
}

function em_desktop_notfications_check_role_condition($dn_id, $user_id) {
  $dn_meta = get_post_meta($dn_id);
  $ac_role_type = $dn_meta["ac_user_con"][0];
  $ac_role_name = $dn_meta["ac_user_con_role"][0];
  $check = FALSE;

    if ( $ac_role_type == 0 || empty($ac_role_type) || empty($ac_role_name) ) {
      $check = TRUE;
    } else {
      if ($ac_role_type == 'wp') {
        $user = get_user_by('id', $user_id);
        if (!empty($user->roles)) {
          foreach ($user->roles as $key => $value) {
            if ($key == $ac_role_name) {
              $check = TRUE;
            }
          }
        }
      }

      if ($ac_role_type == 'um') {
        $user_meta = get_user_meta($user->ID,'role');
          if (!empty($user_meta['role'][0])) {
            if ( $ac_role_name == $user_meta['role'][0] ) {
              $check = TRUE;
            }
          }
      }
    }

  return $check;
}

function em_desktop_notifications_lite_add_one($dn_id, $entity_id) {

    $dn = get_post($dn_id);
    $dn_meta = get_post_meta($dn_id);
    $dn_entity_type = $dn_meta["ac_var"][0];
    $dn_time = $dn_meta["ac_lifetime"][0]*60;

    $decode = em_desktop_notifications_lite_decode($dn_id, $entity_id, $dn_entity_type);

    //GET for anonynous
    if (isset($decode['subid']) && $decode['subid'] != NULL) {
        $pushem_id = get_option( 'emdn_pushem_id' );
        $pushem_key = get_option( 'emdn_pushem_key' );
        $pushem_source = get_option( 'emdn_pushem_source' );
            if ($pushem_id !== FALSE && $pushem_key !== FALSE && $pushem_source !== FALSE) {
                $url = 'https://pushem.org/api/subscribers/get_by_sub_id/?uid='.$pushem_id["pushem_id"].'&key='.$pushem_key["pushem_key"].'&source='.$pushem_source["pushem_source"].'&sub_id='.$decode['subid'];
                $result = file_get_contents($url, false);
                $result = json_decode($result);
                $pushem_sub_ids = $result[0]->id;
            }
    } else {
        //GET for all
        if ( isset($decode['user']) && $decode['user'] == -1 ) {
            $pushem_id = get_option( 'emdn_pushem_id' );
            $pushem_key = get_option( 'emdn_pushem_key' );
            $pushem_source = get_option( 'emdn_pushem_source' );
                if ($pushem_id !== FALSE && $pushem_key !== FALSE && $pushem_source !== FALSE) {
                    $url = 'https://pushem.org/api/subscribers/get_all/?uid='.$pushem_id["pushem_id"].'&key='.$pushem_key["pushem_key"].'&source='.$pushem_source["pushem_source"];
                    $result = file_get_contents($url, false);
                    $result = json_decode($result);
                        if(!empty($result)) {
                            foreach ($result as $key => $value) {
                                $role_condition = em_desktop_notfications_check_role_condition($dn_id,$value->site_id);
                                  if ($role_condition == TRUE) {
                                    $pushem_sub_ids[] = $value->id;
                                  }
                            }
                        }
                    if (!empty($pushem_sub_ids)) {
                        $pushem_sub_ids = implode(',', $pushem_sub_ids);
                    }
                }

        } else {
            //GET for one
            $pushem_id = get_option( 'emdn_pushem_id' );
            $pushem_key = get_option( 'emdn_pushem_key' );
            $pushem_source = get_option( 'emdn_pushem_source' );
                if ($pushem_id !== FALSE && $pushem_key !== FALSE && $pushem_source !== FALSE) {
                    $url = 'https://pushem.org/api/subscribers/get_by_site_id/?uid='.$pushem_id["pushem_id"].'&key='.$pushem_key["pushem_key"].'&source='.$pushem_source["pushem_source"].'&site_id='.$decode['user'];
                    $result = file_get_contents($url, false);
                    $result = json_decode($result);
                        foreach ($result as $key => $value) {
                          $role_condition = em_desktop_notfications_check_role_condition($dn_id,$value->site_id);
                          if ($role_condition == TRUE) {
                            $pushem_sub_ids[] = $value->id;
                          }
                        }
                    if (!empty($pushem_sub_ids)) {
                        $pushem_sub_ids = implode(',', $pushem_sub_ids);
                    }
                }            
        }
    }
    
    //Add notification
    if ( isset($pushem_sub_ids) && !empty($pushem_sub_ids) ) {
        $pushem_id = get_option( 'emdn_pushem_id' );
        $pushem_key = get_option( 'emdn_pushem_key' );
        $pushem_source = get_option( 'emdn_pushem_source' );
        $offset = get_option('gmt_offset');
        $timezone = get_option('timezone_string');
        $current_time = current_time( 'timestamp', $gmt = 1 );
            if ($pushem_id !== FALSE && $pushem_key !== FALSE && $pushem_source !== FALSE) {
                $title = urlencode($decode["title"]);
                $body = urlencode($decode["body"]);
                $tag = urlencode($dn_meta["ac_tag"][0]);
                $url = 'https://pushem.org/api/notifications/add/?uid='.$pushem_id["pushem_id"].'&key='.$pushem_key["pushem_key"].'&source='.$pushem_source["pushem_source"].'&site_id='.$decode['user'].'&title='.$title.'&body='.$body.'&icon='.$decode["icon"].'&link='.$decode["link"].'&tag='.$tag.'&timestamp='.$current_time.'&timezone='.$timezone.'&offset='.$offset.'&subscribers='.$pushem_sub_ids;
                $result = file_get_contents($url, false);
            }
    }
}

function em_desktop_notifications_lite_decode($dn_id, $entity_id, $entity_type) {

    $dn = get_post($dn_id);
    $dn_meta = get_post_meta($dn_id);
    $title = $dn->post_title;
    $body = $dn->post_content;

    $current_user = wp_get_current_user();
    $current_user_name = $current_user->display_name;


    switch ($entity_type) {
        case 'post':

            $entity = get_post($entity_id);

            $user = get_userdata($entity->post_author);
            $user_name = $user->display_name;

            $entity_format = get_post_format( $entity->ID );

            $dn->post_title = str_replace("%post_title%", $entity->post_title, $dn->post_title);
            $dn->post_title = str_replace("%post_content%", $entity->post_content, $dn->post_title);
            $dn->post_title = str_replace("%post_author%", $user_name, $dn->post_title);
            $dn->post_title = str_replace("%post_format%", $entity_format, $dn->post_title);
            $dn->post_title = str_replace("%current_user%", $current_user_name, $dn->post_title);

            $title = $dn->post_title;

            $dn->post_content = str_replace("%post_title%", $entity->post_title, $dn->post_content);
            $dn->post_content = str_replace("%post_content%", $entity->post_content, $dn->post_content);
            $dn->post_content = str_replace("%post_author%", $user_name, $dn->post_content);
            $dn->post_content = str_replace("%post_format%", $entity_format, $dn->post_content);
            $dn->post_content = str_replace("%current_user%", $current_user_name, $dn->post_content);

            $body = strip_tags($body);
            $body = substr($dn->post_content, 0, 200);

            if ($dn_meta["ac_target"][0] == "post_author") {
                $dn_user = $user->id;
                
                if ($dn_user == NULL || $dn_user == 0 || $dn_user == '') {
                    $post_meta = get_post_meta($entity_id);
                    $dn_subid = $post_meta["em_dn_subid"][0];
                }
            }

            $dn_icon_url = wp_get_attachment_url( get_post_thumbnail_id($dn_id) );
            if ($dn_icon_url == NULL || $dn_icon_url == '') {
                $icon = wp_get_attachment_url( get_post_thumbnail_id($entity->ID) );
            } else {
                $icon = $dn_icon_url;
            }

            if ($dn_meta["ac_link"][0] == '' || $dn_meta["ac_link"][0] == NULL) {
                $link = esc_url( get_permalink($entity->ID) );
            } else {
                $link = $dn_meta["ac_link"][0];
            }

        break;

        case 'comment':
            
            $comment = get_comment($entity_id);
            $comment_status = wp_get_comment_status($entity_id);
            $comment_author = $comment->comment_author;
            
            $comment_post = get_post($comment->comment_post_ID);
            $comment_post_author = get_userdata($comment_post->post_author);
            $comment_post_author_name = $comment_post_author->display_name;
            $comment_post_format = get_post_format( $comment_post->ID );

            $comment_parent = get_comment($comment->comment_parent);
            $comment_parent_author = $comment_parent->comment_author;

                $dn->post_title = str_replace("%comment_status%", $comment_status, $dn->post_title);
                $dn->post_title = str_replace("%comment_author%", $comment_author, $dn->post_title);
                $dn->post_title = str_replace("%comment_content%", $comment->comment_content, $dn->post_title);

                $dn->post_title = str_replace("%current_user%", $current_user_name, $dn->post_title);

                $dn->post_title = str_replace("%post_title%", $comment_post->post_title, $dn->post_title);
                $dn->post_title = str_replace("%post_content%", $comment_post->post_content, $dn->post_title);
                $dn->post_title = str_replace("%post_author%", $comment_post_author_name, $dn->post_title);
                $dn->post_title = str_replace("%post_format%", $comment_post_format, $dn->post_title);

                $dn->post_title = str_replace("%comment_parent_content%", $comment_parent->comment_content, $dn->post_title);
                $dn->post_title = str_replace("%comment_parent_author%", $comment_parent_author, $dn->post_title);

                    $title = $dn->post_title;

                $dn->post_content = str_replace("%comment_status%", $comment_status, $dn->post_content);
                $dn->post_content = str_replace("%comment_author%", $comment_author, $dn->post_content);
                $dn->post_content = str_replace("%comment_content%", $comment->comment_content, $dn->post_content);

                $dn->post_content = str_replace("%current_user%", $current_user_name, $dn->post_content);

                $dn->post_content = str_replace("%post_title%", $comment_post->post_title, $dn->post_content);
                $dn->post_content = str_replace("%post_content%", $comment_post->post_content, $dn->post_content);
                $dn->post_content = str_replace("%post_author%", $comment_post_author_name, $dn->post_content);
                $dn->post_content = str_replace("%post_format%", $comment_post_format, $dn->post_content);

                $dn->post_content = str_replace("%comment_parent_content%", $comment_parent->comment_content, $dn->post_content);
                $dn->post_content = str_replace("%comment_parent_author%", $comment_parent_author, $dn->post_content);

                    $body = strip_tags($body);
                    $body = substr($dn->post_content, 0, 200);

                    if ($dn_meta["ac_target"][0] == "comment_author") {
                        $dn_user = $comment->user_id;

                        if ($dn_user == NULL || $dn_user == 0 || $dn_user == '') {
                            $comment_meta = get_comment_meta($entity_id);
                            $dn_subid = $comment_meta["em_dn_subid"][0];
                        }
                    }

                    if ($dn_meta["ac_target"][0] == "post_author") {
                        $dn_user = $comment_post->post_author;
                        
                        if ($dn_user == NULL || $dn_user == 0 || $dn_user == '') {
                            $post_meta = get_post_meta($comment_post->ID);
                            $dn_subid = $post_meta["em_dn_subid"][0];
                        }
                    }

                    if ($dn_meta["ac_target"][0] == "parent_comment_author") {
                        $dn_user = $comment_parent->user_id;
                        
                        if ($dn_user == NULL || $dn_user == 0 || $dn_user == '') {
                            $parent_comment_meta = get_comment_meta($comment->comment_parent);
                            $dn_subid = $parent_comment_meta["em_dn_subid"][0];
                        }
                    }

                    $dn_icon_url = wp_get_attachment_url( get_post_thumbnail_id($dn_id) );
                    if ($dn_icon_url == NULL || $dn_icon_url == '') {
                        $icon = wp_get_attachment_url( get_post_thumbnail_id($comment_post->ID) );
                    } else {
                        $icon = $dn_icon_url;
                    }

                    if ($dn_meta["ac_link"][0] == '' || $dn_meta["ac_link"][0] == NULL) {
                        $link = esc_url( get_comment_link($entity_id) );
                    } else {
                        $link = $dn_meta["ac_link"][0];
                    }
        break;

        
        case 'user':

            $acting_user = get_user_by('id', $entity_id);
            $acting_user_name = $acting_user->data->display_name;
            
            $dn->post_title = str_replace("%acting_user%", $acting_user_name, $dn->post_title);
            $dn->post_title = str_replace("%current_user%", $current_user_name, $dn->post_title);
            $title = $dn->post_title;

            $dn->post_content = str_replace("%acting_user%", $acting_user_name, $dn->post_content);
            $dn->post_content = str_replace("%current_user%", $current_user_name, $dn->post_content);
            $body = substr($dn->post_content, 0, 200);

            $icon = $dn_icon_url;
            $link = $dn_meta["ac_link"][0];
        break;

        default:
          $dn->post_title = str_replace("%current_user%", $current_user_name, $dn->post_title);
          $title = $dn->post_title;
          $dn->post_content = str_replace("%current_user%", $current_user_name, $dn->post_content);

          $body = strip_tags($body);
          $body = substr($dn->post_content, 0, 200);
          $dn_icon_url = wp_get_attachment_url( get_post_thumbnail_id($dn_id) );
          $icon = $dn_icon_url;
          $link = $dn_meta["ac_link"][0];
        break;
    }

    if ($dn_meta["ac_target"][0] == 'all' || $dn_meta["ac_target"][0] == 'current_user') {
    switch ($dn_meta["ac_target"][0]) {
        case 'all':
            $dn_user = -1;
        break;

        case 'current_user':
            $dn_user = $current_user->id;
        break;
        
        default:
            # code...
        break;
    }
    }

    if ( !isset($dn_subid) ) {
        $dn_subid = NULL;
    }

    $arr = array('title' => $title, 'body' => $body, 'user' => $dn_user, 'icon' => $icon, 'link' => $link, 'subid' => $dn_subid);

    return $arr;
}

/* End of Plugin Add Notifications behaivor */


/* Plugin Notifications interface */

add_action( 'init', 'em_desktop_notifications_lite_register_post_type' );
 
function em_desktop_notifications_lite_register_post_type() {
 
    $labels = array( 
    'name'               => __( 'Push Notifications', 'emdn' ),
    'singular_name'      => __( 'Push Notification', 'emdn' ),
    'add_new'            => _x( 'Add New Push Notification', '${4:Name}', 'emdn' ),
    'add_new_item'       => __( 'Add New Push Notification', 'emdn}' ),
    'edit_item'          => __( 'Edit Push Notification', 'emdn' ),
    'new_item'           => __( 'New Push Notification', 'emdn' ),
    'view_item'          => __( 'View Push Notification', 'emdn' ),
    'search_items'       => __( 'Search Push Notification', 'emdn' ),
    'not_found'          => __( 'No Push Notifications found', 'emdn' ),
    'not_found_in_trash' => __( 'No Push Notifications found in Trash', 'emdn' ),
    'parent_item_colon'  => __( 'Parent Push Notification name:', 'emdn' ),
    'menu_name'          => __( 'Push Notifications', 'emdn' ),
    );
 
    $args = array( 
    'labels'              => $labels,
    'hierarchical'        => true,
    'description'         => 'description',
    'taxonomies'          => array( 'desktop_notifications_categories' ),
    'public'              => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'         => 'dashicons-welcome-view-site',
    'show_in_nav_menus'   => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'has_archive'         => true,
    'query_var'           => true,
    'can_export'          => true,
    'rewrite'             => true,
    'capability_type'     => 'post', 
    'supports'            => array( 
                  'title', 'editor', 'thumbnail'
                ),
    );
 
    register_post_type( 'desktop_notification', $args );

    flush_rewrite_rules();
}

add_action( 'init', 'em_desktop_notifications_lite_taxonomies', 0 );

function em_desktop_notifications_lite_taxonomies() {
    register_taxonomy(
        'desktop_notifications_categories',
        'desktop_notification',
        array(
            'labels' => array(
                'name' => 'Push Notifications categories',
                'add_new_item' => 'Add New Push Notification category',
                'new_item_name' => "New Push Notification category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}

function em_desktop_notifications_lite_metaboxes( ) {

   add_meta_box('postlinkdiv', __('Set url user go to click on Desktop Notification'), 'em_desktop_notifications_lite_metaboxes_link_html', 'desktop_notification', 'normal', 'high');
   
   add_meta_box('postfunctiondiv', __('Choose event to send Desktop Notification'), 'em_desktop_notifications_lite_metaboxes_html', 'desktop_notification', 'normal', 'high');

   add_meta_box('posthelpdiv', __('Triggers list'), 'em_desktop_notifications_lite_metaboxes_help_html', 'desktop_notification', 'normal', 'low');

}
add_action( 'add_meta_boxes_desktop_notification', 'em_desktop_notifications_lite_metaboxes' );


function em_desktop_notifications_lite_metaboxes_link_html() {
        global $post;
        
        $custom = get_post_custom($post->ID);

        $ac_link = isset($custom["ac_link"][0])?$custom["ac_link"][0]:'';

        echo '<input type="text" id="ac_link" name="ac_link" value="'.$ac_link.'" size="60" />';

        _e('<br /><span class="description">Left epmty to let user go to post or user url, or print link in format "http://emrysforge.com" to make regirection to any url</span>');
}

function em_desktop_notifications_lite_metaboxes_help_html() {
    _e('<p><strong>Triggers </strong>are very powerful instrument, that allow you to replace notifications content with dynamic data, like user name, posh title, content and ect. <a href="http://emrysforge.com/documentation/push-notification-triggers/">Read more about triggers here</a> <strong>Not all triggers are allowed in Lite Version. <a href="http://emrysforge.com/product/desktop-push-notifications-wordpress/">Get "advanced" version to use them</a></strong></p>
      <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Object/Plugin</th>
      <th scope="col">Action</th>
      <th scope="col">Triggers - description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Post</td>
      <td>All actions</td>
      <td>
      <p>%post_title% - Post title</p>

      <p>%post_content% - Post body</p>

      <p>%post_author% - &nbsp;Display name of author&nbsp;<strong>(for authorized authors only)</strong></p>

      <p>%post_format% - Format of post (link, quote, ect.)</p>

      <p>%current_user% - User who see notification dispaly name</p>

      <p><strong>*IF &quot;Featured image&quot; is empty gets featured image of post</strong></p>

      <p><strong>** IF &quot;Link&quot; is empty gets link to&nbsp;post</strong></p>
      </td>
    </tr>
    <tr>
      <td>Comment</td>
      <td>All actions</td>
      <td>
      <p>%comment_status% - display comment status (&quot;approve&quot;, ect.)</p>

      <p>%comment_author% - comment author display name&nbsp;<strong>(for authorized authors only)</strong></p>

      <p>%comment_content% - text of comment</p>

      <p>%comment_parent_content% - if comment is answer for another comment print parent comment text, else print nothing</p>

      <p>%comment_parent_author% -&nbsp;if comment is answer for another comment print parent comment display author name, else print nothing</p>

      <p>As in posts before (for post associated with comment):</p>

      <p>%post_title%</p>

      <p>%post_content%</p>

      <p>%post_author% <strong>(for authorized authors only)</strong></p>

      <p>%post_format%</p>

      <p>%current_user%</p>

      <p><strong>*IF &quot;Featured image&quot; is empty gets featured image of associated post</strong></p>

      <p><strong>** IF &quot;Link&quot; is empty gets link to comment</strong></p>
      </td>
    </tr>
    <tr>
      <td>User</td>
      <td>All actions</td>
      <td>
      <p>%acting_user% -&nbsp;user associated with action</p>

      <p>%current_user% - user who see notification</p>
      </td>
    </tr>
    <tr>
      <td>Time/schedule</td>
      <td>All actions</td>
      <td>%current_user% - user who see notification</td>
    </tr>
    <tr>
      <td>Push on DN publish</td>
      <td>All actions</td>
      <td>%current_user% - user who see notification</td>
    </tr>
  </tbody>
</table>

<p><strong>*Please, remember that content text of notification cannot be to long, it would be automaticaly trimmed to 200 symbols</strong></p>

<p><strong>** Most of %triggers% can be used even content was created by anonymous user (like post, comment or order mage by unregistered user). Triggers, that cannot be used for anonymous author have special mark in the list</strong></p>

');
}

function em_desktop_notifications_lite_metaboxes_html() {
    global $post;
    $custom = get_post_custom($post->ID);
    
    $ac_var = isset($custom["ac_var"][0])?$custom["ac_var"][0]:'';
    $ac_var_type = isset($custom["ac_var_type"][0])?$custom["ac_var_type"][0]:'';
    $ac_hook = isset($custom["ac_hook"][0])?$custom["ac_hook"][0]:'';
    $ac_target = isset($custom["ac_target"][0])?$custom["ac_target"][0]:'';

    $ac_user_con = isset($custom["ac_user_con"][0])?$custom["ac_user_con"][0]:'';
    $ac_user_con_role = isset($custom["ac_user_con_role"][0])?$custom["ac_user_con_role"][0]:'';

    $ac_var_list  = array('post' => 'Post', 'comment' => 'Comment', 'user' => 'User');

    $ac_hook_list  = array(
        0 => array('hook' => 'publish_post', 'name' => 'Post publish', 'parents' => 'post' ),
        1 => array('hook' => 'post_updated', 'name' => 'Post updated', 'parents' => 'post' ),
        2 => array('hook' => 'wp_trash_post', 'name' => 'Post trashed', 'parents' => 'post' ),
        3 => array('hook' => 'comment_new_pub', 'name' => 'New comment published', 'parents' => 'comment' ),
        4 => array('hook' => 'comment_new_unpub', 'name' => 'New comment saved not published', 'parents' => 'comment' ),
        5 => array('hook' => 'comment_approve', 'name' => 'Comment approved', 'parents' => 'comment' ),
        6 => array('hook' => 'comment_spam', 'name' => 'Comment set as spam', 'parents' => 'comment' ),
        7 => array('hook' => 'trash_comment', 'name' => 'Comment trashed', 'parents' => 'comment' ),
        8 => array('hook' => 'wp_login', 'name' => 'User login', 'parents' => 'user' ),
        9 => array('hook' => 'user_register', 'name' => 'User register', 'parents' => 'user' )
    );

    $ac_target_list  = array(
        0 => array('target' => 'all', 'name' => 'All', 'parents' => 'publish_post post_updated wp_trash_post comment_new_pub comment_new_unpub comment_approve comment_spam trash_comment wp_login user_register' ),
        1 => array('target' => 'current_user', 'name' => 'Current user', 'parents' => 'publish_post post_updated wp_trash_post comment_new_pub comment_new_unpub comment_approve comment_spam trash_comment wp_login user_register' ),
        2 => array('target' => 'post_author', 'name' => 'Post author', 'parents' => 'publish_post post_updated wp_trash_post comment_new_pub comment_new_unpub comment_approve comment_spam trash_comment' ),
        3 => array('target' => 'comment_author', 'name' => 'Comment author', 'parents' => 'comment_new_pub comment_new_unpub comment_approve comment_spam trash_comment' ),
        4 => array('target' => 'parent_comment_author', 'name' => 'Parent comment author', 'parents' => 'comment_new_pub comment_new_unpub comment_approve comment_spam trash_comment' )
    );

    $ac_var_list['push_on_publish'] = 'Send on publish this Push Notification';
    $ac_hook_list[] = array( 'hook' => 'publish_DN', 'name' => 'When this post status is published', 'parents' => 'push_on_publish' );
    $ac_target_list[] = array( 'target' => 'all', 'name' => 'All', 'parents' => 'publish_DN' );

    $args = array(
        'public'   => true
    );

    $ac_var_list['time_schedule'] = 'Time/schedule';

    $ac_hook_list[] = array( 'hook' => 'every_1', 'name' => 'Every minute', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_2', 'name' => 'Every 2 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_3', 'name' => 'Every 3 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_5', 'name' => 'Every 5 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_7', 'name' => 'Every 7 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_10', 'name' => 'Every 10 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_15', 'name' => 'Every 15 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_20', 'name' => 'Every 20 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_30', 'name' => 'Every 30 minutes', 'parents' => 'time_schedule' );
    $ac_hook_list[] = array( 'hook' => 'every_60', 'name' => 'Every 60 minutes', 'parents' => 'time_schedule' );

    $ac_target_list[] = array( 'target' => 'all', 'name' => 'All', 'parents' => 'every_1 every_2 every_3 every_5 every_7 every_10 every_15 every_20 every_30 every_60' );


    $output = 'objects';
    $operator = 'and';

    $post_types = get_post_types( $args, $output, $operator ); 

    foreach ($post_types as $key =>$value) {
        if ($key != 'desktop_notification') {
            if ($key != 'attachment') {
                $ac_var_type_list[$key] = $post_types[$key]->labels->name;
            }
        }
    }

    echo '<select id="ac_var" name="ac_var">';  
    foreach ($ac_var_list as $var => $var_name) {
        if (!empty($ac_var) && $ac_var == $var) {
            echo '<option value="'.$var.'" selected="selected">'.$var_name.'</option>';
        } else {
            echo '<option value="'.$var.'">'.$var_name.'</option>';
        }
    }
    echo '</select>';

    echo '<select id="ac_var_type" name="ac_var_type">';  
    foreach ($ac_var_type_list as $var_type => $var_type_name) {
        if (!empty($ac_var_type) && $ac_var_type == $var_type ) {
            echo '<option value="'.$var_type.'" selected="selected" class="post comment">'.$var_type_name.'</option>';
        } else {
            echo '<option value="'.$var_type.'" class="post comment">'.$var_type_name.'</option>';
        }
    }
    echo '</select>';

    echo '<select id="ac_hook" name="ac_hook">';  
    foreach ($ac_hook_list as $key => $value) {
        if (!empty($ac_hook) && $ac_hook == $value['hook'] ) {
            echo '<option value="'.$value["hook"].'" selected="selected" class="'.$value['parents'].'">'.$value["name"].'</option>';
        } else {
            echo '<option value="'.$value["hook"].'" class="'.$value['parents'].'">'.$value["name"].'</option>';
        }
    }
    echo '</select>';

    echo '<select id="ac_target" name="ac_target">';  
    foreach ($ac_target_list as $key => $value) {
        if (!empty($ac_target) && $ac_target == $value['target']) {
            echo '<option value="'.$value["target"].'" selected="selected" class="'.$value['parents'].'">'.$value["name"].'</option>';
        } else {
            echo '<option value="'.$value["target"].'" class="'.$value['parents'].'">'.$value["name"].'</option>';
        }
    }
    echo '</select>';


    /* User condition */

    _e('<br /><span class="description">Choose event to show current Desktop Notification. Selectors above [Object]:[Type of object]:[Action to call notification]:[User to call notification for]. <b>!IMPORTANT!</b> For more actions get our "advanced" version of plugin with Woocommerce, BuddyPress, Ultimate Member, Anonymous posters support. <a href="http://emrysforge.com/product/desktop-push-notifications-wordpress/">View details here</a></span>');

    if (is_admin()) {
        $em_dn_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
        wp_enqueue_script('em_dn_chain', $em_dn_plugin_url.'/js/jquery.chained.min.js',array('jquery'));
        wp_enqueue_script('em_dn_chain_settings', $em_dn_plugin_url.'/js/em_dn_chained_settings.js',array('jquery', 'em_dn_chain'));
    }
}

function em_desktop_notifications_lite_save_post() {
    if(empty($_POST)) return;
    
    global $post;

    $desktop_notification = $post;
    
    update_post_meta($desktop_notification->ID, "ac_var", $_POST["ac_var"]);

    update_post_meta($desktop_notification->ID, "ac_var_type", $_POST["ac_var_type"]);

    update_post_meta($desktop_notification->ID, "ac_hook", $_POST["ac_hook"]);

    update_post_meta($desktop_notification->ID, "ac_target", $_POST["ac_target"]);

    update_post_meta($desktop_notification->ID, "ac_audio", $_POST["ac_audio"]);

    update_post_meta($desktop_notification->ID, "ac_link", $_POST["ac_link"]);

    update_post_meta($desktop_notification->ID, "ac_user_con", 0);

}
add_action( 'save_post_desktop_notification', 'em_desktop_notifications_lite_save_post' );

/* End of Plugin Notifications interface */



/* Plugin add_actions table for system events */
add_action('save_post_desktop_notification', 'em_desktop_notifications_lite_dn_publish', 10, 2);

function em_desktop_notifications_lite_dn_publish( $ID, $post ) {
    $var = get_post_meta($ID, 'ac_var', true);
    if ( $var == 'push_on_publish' && get_post_status($ID) == "publish") {
        em_desktop_notifications_lite_add_one($ID, $ID);
    }
}

add_action('transition_post_status','em_desktop_notifications_lite_publish_post', 10, 3);
function em_desktop_notifications_lite_publish_post($new_status, $old_status, $post) {
    if ( $new_status == 'publish' && $new_status != $old_status) {
        em_desktop_notifications_lite_add($post->ID, 'post', 'publish_post', get_post_type($post->ID));
    }
}

add_action('post_updated','em_desktop_notifications_lite_post_updated', 10, 1); 
function em_desktop_notifications_lite_post_updated($ID) {
    em_desktop_notifications_lite_add($ID, 'post', 'post_updated', get_post_type($ID));
}

add_action('wp_trash_post','em_desktop_notifications_lite_wp_trash_post', 10, 1); 
function em_desktop_notifications_lite_wp_trash_post($ID) {
    em_desktop_notifications_lite_add($ID, 'post', 'wp_trash_post', get_post_type($ID));
}


add_action('comment_post','em_desktop_notifications_lite_comment_post', 10, 2); 
function em_desktop_notifications_lite_comment_post($comment_ID,$comment_approved) {
    $comment = get_comment($comment_ID);
    $comment_status = wp_get_comment_status($comment_ID);
    $comment_post_id = $comment->comment_post_ID;
    if ($comment_approved == 1) {
        em_desktop_notifications_lite_add($comment_ID, 'comment', 'comment_new_pub', get_post_type($comment_post_id));
    } else {
        em_desktop_notifications_lite_add($comment_ID, 'comment', 'comment_new_unpub', get_post_type($comment_post_id));
    }
}

add_action('trash_comment','em_desktop_notifications_lite_trash_comment', 10, 1); 
function em_desktop_notifications_lite_trash_comment($comment_id) {
    $comment = get_comment($comment_id);
    $comment_post_id = $comment->comment_post_ID;
    em_desktop_notifications_lite_add($comment_id, 'comment', 'trash_comment', get_post_type($comment_post_id));
}

add_action('wp_set_comment_status','em_desktop_notifications_lite_wp_set_comment_status', 10, 2);
function em_desktop_notifications_lite_wp_set_comment_status($ID, $status) {
    $comment = get_comment($ID);
    $comment_post_id = $comment->comment_post_ID;
    if ($status == 'approve') {
        em_desktop_notifications_lite_add($ID, 'comment', 'comment_approve', get_post_type($comment_post_id));
    }
    if ($status == 'spam') {
        em_desktop_notifications_lite_add($ID, 'comment', 'comment_spam', get_post_type($comment_post_id));
    }
}

add_action('user_register','em_desktop_notifications_lite_user_register', 10, 1);
function em_desktop_notifications_lite_user_register($user_id) {
    em_desktop_notifications_lite_add($user_id, 'user', 'user_register', NULL);
}

add_filter('wp_login','em_desktop_notifications_lite_wp_login', 10, 2);
function em_desktop_notifications_lite_wp_login($user_login, $user) {
    em_desktop_notifications_lite_add($user->data->ID, 'user', 'wp_login', NULL);
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_1_min' );
function em_desktop_notifications_lite_cron_add_1_min( $schedules ) {
    $schedules['em_dn_1_min'] = array(
        'interval' => 60 * 1,
        'display' => 'Every 1 minute'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_2_min' );
function em_desktop_notifications_lite_cron_add_2_min( $schedules ) {
    $schedules['em_dn_2_min'] = array(
        'interval' => 60 * 2,
        'display' => 'Every 2 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_3_min' );
function em_desktop_notifications_lite_cron_add_3_min( $schedules ) {
    $schedules['em_dn_3_min'] = array(
        'interval' => 60 * 3,
        'display' => 'Every 3 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_5_min' );
function em_desktop_notifications_lite_cron_add_5_min( $schedules ) {
    $schedules['em_dn_5_min'] = array(
        'interval' => 60 * 5,
        'display' => 'Every 5 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_7_min' );
function em_desktop_notifications_lite_cron_add_7_min( $schedules ) {
    $schedules['em_dn_7_min'] = array(
        'interval' => 60 * 7,
        'display' => 'Every 7 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_10_min' );
function em_desktop_notifications_lite_cron_add_10_min( $schedules ) {
    $schedules['em_dn_10_min'] = array(
        'interval' => 60 * 10,
        'display' => 'Every 10 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_15_min' );
function em_desktop_notifications_lite_cron_add_15_min( $schedules ) {
    $schedules['em_dn_15_min'] = array(
        'interval' => 60 * 15,
        'display' => 'Every 15 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_20_min' );
function em_desktop_notifications_lite_cron_add_20_min( $schedules ) {
    $schedules['em_dn_20_min'] = array(
        'interval' => 60 * 20,
        'display' => 'Every 20 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_30_min' );
function em_desktop_notifications_lite_cron_add_30_min( $schedules ) {
    $schedules['em_dn_30_min'] = array(
        'interval' => 60 * 30,
        'display' => 'Every 30 minutes'
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'em_desktop_notifications_lite_cron_add_60_min' );
function em_desktop_notifications_lite_cron_add_60_min( $schedules ) {
    $schedules['em_dn_60_min'] = array(
        'interval' => 60 * 60,
        'display' => 'Every 60 minutes'
    );
    return $schedules;
}

add_action('wp', 'em_desktop_notifications_lite_1_activation');
function em_desktop_notifications_lite_1_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_1' ) ) {
        wp_schedule_event( time(), 'em_dn_1_min', 'em_desktop_notifications_lite_addon_time_schedule_event_1');
    }
}

add_action('wp', 'em_desktop_notifications_lite_1_activation');
function em_desktop_notifications_lite_2_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_2' ) ) {
        wp_schedule_event( time(), 'em_dn_2_min', 'em_desktop_notifications_lite_addon_time_schedule_event_2');
    }
}

add_action('wp', 'em_desktop_notifications_lite_3_activation');
function em_desktop_notifications_lite_3_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_3' ) ) {
        wp_schedule_event( time(), 'em_dn_3_min', 'em_desktop_notifications_lite_addon_time_schedule_event_3');
    }
}

add_action('wp', 'em_desktop_notifications_lite_5_activation');
function em_desktop_notifications_lite_5_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_5' ) ) {
        wp_schedule_event( time(), 'em_dn_5_min', 'em_desktop_notifications_lite_addon_time_schedule_event_5');
    }
}

add_action('wp', 'em_desktop_notifications_lite_7_activation');
function em_desktop_notifications_lite_7_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_7' ) ) {
        wp_schedule_event( time(), 'em_dn_7_min', 'em_desktop_notifications_lite_addon_time_schedule_event_7');
    }
}

add_action('wp', 'em_desktop_notifications_lite_10_activation');
function em_desktop_notifications_lite_10_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_10' ) ) {
        wp_schedule_event( time(), 'em_dn_10_min', 'em_desktop_notifications_lite_addon_time_schedule_event_10');
    }
}

add_action('wp', 'em_desktop_notifications_lite_15_activation');
function em_desktop_notifications_lite_15_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_15' ) ) {
        wp_schedule_event( time(), 'em_dn_15_min', 'em_desktop_notifications_lite_addon_time_schedule_event_15');
    }
}

add_action('wp', 'em_desktop_notifications_lite_20_activation');
function em_desktop_notifications_lite_20_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_20' ) ) {
        wp_schedule_event( time(), 'em_dn_20_min', 'em_desktop_notifications_lite_addon_time_schedule_event_20');
    }
}

add_action('wp', 'em_desktop_notifications_lite_30_activation');
function em_desktop_notifications_lite_30_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_30' ) ) {
        wp_schedule_event( time(), 'em_dn_30_min', 'em_desktop_notifications_lite_addon_time_schedule_event_30');
    }
}

add_action('wp', 'em_desktop_notifications_lite_60_activation');
function em_desktop_notifications_lite_60_activation() {
    if ( ! wp_next_scheduled( 'em_desktop_notifications_lite_addon_time_schedule_event_60' ) ) {
        wp_schedule_event( time(), 'em_dn_60_min', 'em_desktop_notifications_lite_addon_time_schedule_event_60');
    }
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_1', 'em_desktop_notifications_lite_addon_time_schedule_1_function');
function em_desktop_notifications_lite_addon_time_schedule_1_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_1', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_2', 'em_desktop_notifications_lite_addon_time_schedule_2_function');
function em_desktop_notifications_lite_addon_time_schedule_2_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_2', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_3', 'em_desktop_notifications_lite_addon_time_schedule_3_function');
function em_desktop_notifications_lite_addon_time_schedule_3_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_3', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_5', 'em_desktop_notifications_lite_addon_time_schedule_5_function');
function em_desktop_notifications_lite_addon_time_schedule_5_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_5', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_7', 'em_desktop_notifications_lite_addon_time_schedule_7_function');
function em_desktop_notifications_lite_addon_time_schedule_7_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_7', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_10', 'em_desktop_notifications_lite_addon_time_schedule_10_function');
function em_desktop_notifications_lite_addon_time_schedule_10_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_10', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_15', 'em_desktop_notifications_lite_addon_time_schedule_15_function');
function em_desktop_notifications_lite_addon_time_schedule_15_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_15', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_20', 'em_desktop_notifications_lite_addon_time_schedule_20_function');
function em_desktop_notifications_lite_addon_time_schedule_20_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_20', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_30', 'em_desktop_notifications_lite_addon_time_schedule_30_function');
function em_desktop_notifications_lite_addon_time_schedule_30_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_30', NULL);
}

add_action('em_desktop_notifications_lite_addon_time_schedule_event_60', 'em_desktop_notifications_lite_addon_time_schedule_60_function');
function em_desktop_notifications_lite_addon_time_schedule_60_function() {
    em_desktop_notifications_lite_add(NULL, 'time_schedule', 'every_60', NULL);
}

/* End of Plugin add_actions table for system events */