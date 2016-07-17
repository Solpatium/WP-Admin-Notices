<?php
/**
 * Plugin Name: Admin Notices
 * Description: A Wordpress developer's plugin that makes adding notices less painful
 * Version: 1.0.0
 * Author: Jakub Ptak
 *
 * Text Domain: adminnotices
 */

if( !class_exists( 'Admin_Notice' ) ) :

  require_once('class-admin-notice.php');
  require_once('class-multisite-admin-notice.php');

  // MAIN HOOK
  add_action( 'admin_notices', 'add_custom_admin_notices', 20 );
  function add_custom_admin_notices() {

    // ONLY FOR TESTS
    // require_once('tests.php');
    // test_admin_notices();
    $notices = Admin_Notice::get_user_notices( get_current_user_id() );
    $notices = array_merge( $notices, MU_Admin_Notice::get_user_notices( get_current_user_id() ) );

    foreach ( $notices as $notice) {
      $notice = unserialize( $notice );
      $notice->maybe_display();
    }
  }



  function add_user_notice( $user_id, $content, $args = null ) {
    if( $args == null ) $args = array();
    $args['user_id'] = $user_id;
    ( new Admin_Notice( $content, $args ) )->add();
  }

  function add_current_user_notice( $content, $args = null ) {
     if( $args == null ) $args = array();
     add_user_notice( get_current_user_id(), $content, $args );
   }

  function add_users_notice( $users_ids, $content, $args = null ) {
     if( $args == null ) $args = array();
     if( !is_array( $users_ids ) ) {
       throw new InvalidArgumentException( __('IDs should be provided in an array', 'adminnotices') );
     }
     foreach ( $users_ids as $user_id ) {
       add_user_notice( $user_id, $content, $args );
     }
   }

  function mu_add_user_notice( $user_id, $content, $args = null ) {
     if( $args == null ) $args = array();
     $args['user_id'] = $user_id;
     ( new MU_Admin_Notice( $content, $args ) )->add();
   }

  function mu_add_current_user_notice( $content, $args = null ) {
      if( $args == null ) $args = array();
      add_user_notice( get_current_user_id(), $content, $args );
    }

  function mu_add_users_notice( $users_ids, $content, $args = null ) {
      if( $args == null ) $args = array();
      if( !is_array( $users_ids ) ) {
        throw new InvalidArgumentException( __('IDs should be provided in an array', 'adminnotices') );
      }
      foreach ( $users_ids as $user_id ) {
        add_user_notice( $user_id, $content, $args );
      }
  }



endif;

?>
