<?php


    class Admin_Notice {

      // Fot who notice should be displayed
      protected $user_id;

      // "all" - on every page
      // [page_name] on page of given name
      // [post_id] on editing post of given id
      protected $place;

      // "once" - user doesn't have to click close to delete notice - it shows up just once
      // "until_closed" - notice shows up until the close button is pressed
      protected $display;

      // "success" - green
      // "error"   - red
      // "warning" - orange
      // "info"    - blue
      // "blank"   - no color
      protected $type;

      // Notice's content
      protected $content;

      public function __construct( $content, $args ) {
        if( !is_string( $content ) ) {
          throw new InvalidArgumentException( __('Notice content should be a string!', 'adminnotices') );
        }

        $defaults = array(
        	'user_id' => get_current_user_id(),
        	'type' => 'info',
        	'place' => 'all',
        	'display' => 'once'
        );

        $args = wp_parse_args( $args, $defaults );

        $this->content = $content;
        $this->user_id = $args['user_id'];
        $this->type = $args['type'];
        $this->place = $args['place'];
        $this->display = $args['display'];
      }

      public static function get_user_notices( $user_id ) {
        $notices = get_user_option( 'notices', $user_id );
        if( !is_array( $notices ) ){
          $notices = array();
        }
        return $notices;
      }

      // Use this only if you know what you are doing
      public static function update_user_notices( $user_id, $value ) {
        update_user_option( $user_id, 'notices', $value );
      }

      public static function get_types() {
        return apply_filters( 'notice_types', array( 'success', 'error', 'warning', 'info', 'blank' ) );
      }

      public static function delete_all_user_notices( $user_id ) {
        static::update_user_notices( $user_id, null );
      }

      public function maybe_display() {
        if( $this->is_being_deleted() ) {
          $this->delete();
          return;
        }
        if( $this->should_be_displayed() ) {
          $this->display();
          if( $this->display === 'once' ) {
            $this->delete();
          }
        }
      }

      public function add() {
        $notices =  static::get_user_notices( $this->user_id );
        $notices[$this->get_id()] = serialize( $this );
        static::update_user_notices( $this->user_id, $notices );
      }

      public function delete() {
        $notices =  static::get_user_notices( $this->user_id );
        unset( $notices[$this->get_id()] );
        static::update_user_notices( $this->user_id, $notices );
      }

      public function get_id() {
        return md5( $this->display . $this->content . $this->user_id . $this->place );
      }

      protected function is_being_deleted() {
        return ( isset( $_GET['delete_notice'] ) && $_GET['delete_notice'] === $this->get_id() );
      }

      protected function should_be_displayed() {

        // Post edit
        if( is_int( $this->place ) ) {
          return ( $_GET['action'] == 'edit' && $_GET['post'] == $this->place );
        }
        // Specific page
        elseif ( is_string( $this->place ) && $this->place != 'all' ) {
          $screen = get_current_screen();
          return ( $screen->id === $this->place );
        }
        // All
        else {
          return true;
        }
      }

      protected function display() {
        $type = $this->type;
        $content = $this->content;
        $url = add_query_arg( array( 'delete_notice' => $this->get_id() ) );
        $dismissible = ( $this->display === 'once' );
        include( 'template-notice.php' );
      }

    }
