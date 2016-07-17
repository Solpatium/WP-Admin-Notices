<?php

    /* TEST INFO
    *  -first page view after launching test - you should see both all types of notices with "delete this notice" and the close button for both multisite and single site
    *  -you shouldn't be able to see notices with buttons on the page refresh or on other site - they should be displayed just once
    *  -you shouldn't be able to see single site notices on the site you didn't
    *  -clicking "delete this notice" on any single site notice should delete it forever
    *  -cliking "delete this notice" on any multisite notice should delete it from both sites
    */


    function test_admin_notices() {
      $args = array(
        'user_id' => get_current_user_id(),
        'type' => 'info',
        'place' => 'all',
        'display' => 'once'
      );

      foreach ( array( 'once', 'until_closed' ) as $display ) {
        foreach ( Admin_Notice::get_types() as $type ) {
          $args['type'] = $type; $args['display'] = $display;
          ( new Admin_Notice( "Single site | Type: $type, Display: $display", $args ) )->add();
        }
      }

      foreach ( array( 'once', 'until_closed' ) as $display ) {
        foreach ( Admin_Notice::get_types() as $type ) {
          $args['type'] = $type; $args['display'] = $display;
          ( new MU_Admin_Notice( "Multisite | Type: $type, Display: $display", $args ) )->add();
        }
      }
    }
