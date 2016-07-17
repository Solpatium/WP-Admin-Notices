<?php
  /*
  * Template used to display notice.
  */
?>

<div class="notice notice-<?php echo $type ?> <?php if( $dismissible ) echo 'is-dismissible';?>">
  <p>
    <?php echo $content; ?>
  </p>
  <?php if( $dismissible == true ) : ?>
    <button class="notice-dismiss">
      <span class="screen-reader-text">
        <?php _e('Dismiss this note', 'adminnotices'); ?>
      </span>
    </button>
  <?php else : ?>
    <p class="notice-delete-wraper">
      <a class="notice-delete" href="<?php echo $url ?>"><?php _e('Delete this notice', 'adminnotices'); ?></a>
    </p>
  <?php endif; ?>
</div>
