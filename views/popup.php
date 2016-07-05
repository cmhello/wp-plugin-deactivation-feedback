<div id="wpdf-popup-<?php echo esc_attr( $this->get_plugin_slug( $this->plugin ) ); ?>" class="wpdf-hide">

  <h2 class="wpdf-title">If you have a moment, please let us know why you are deactivating (optional):</h2>

  <div class="wpdf-choices">

    <form action="<?php echo admin_url( 'plugins.php' ); ?>" class="wpdf-submit-choice">

      <?php $this->elements->render( 'radio', array(
        'id'      => 'wpdf-choice',
        'name'    => 'wpdf-choice',
        'options' => $this->choices,
        'label'   => ''
      ) ); ?>

      <?php $this->elements->render( 'text', array(
        'id'    => 'wpdf-extra',
        'name'  => 'wpdf-extra',
        'label' => '',
        'class' => 'widefat wpdf-hide'
      ) ); ?>

    </form>

  </div>

  <div class="buttons">

    <a href="#" class="button btn-sub">Skip &amp; Deactivate</a>

    <a href="#" class="button button-primary btn-cancel">Cancel</a>

  </div>

</div>
