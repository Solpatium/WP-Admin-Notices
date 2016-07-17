<?php

    class MU_Admin_Notice extends Admin_Notice {

      public function __construct( $content, $args ) {
        parent::__construct( $content, $args );
      }

      // Overriden
      public static function get_user_notices( $user_id ) {
        $notices = get_user_meta( $user_id, 'multisite_notices', true );
        if( !is_array( $notices ) ){
          $notices = array();
        }
        return $notices;
      }

      // Overriden
      public static function update_user_notices( $user_id, $value ) {
        update_user_meta( $user_id, 'multisite_notices', $value );
      }
    }
