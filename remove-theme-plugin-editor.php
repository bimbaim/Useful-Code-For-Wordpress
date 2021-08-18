<php

/**
 * Removes theme editor.
 */
function wpdocs_remove_menus(){
   	remove_submenu_page( 'themes.php', 'theme-editor.php' );
  	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
}
add_action( 'admin_menu', 'wpdocs_remove_menus', 999 );

function admin_page_theme_editor_manipulation(){
	global $pagenow;
	// echo $pagenow;
	if ($pagenow == 'theme-editor.php' || $pagenow == 'plugin-editor.php') {
		wp_redirect( admin_url( '/?action=editor-restricted-access' ) );
        exit;
	}
}

add_action('admin_init', 'admin_page_theme_editor_manipulation');

function file_editor_restricted_notice() {
	global $pagenow;
	
	if ($pagenow == 'index.php' && $_REQUEST['action'] == 'editor-restricted-access') {
	    ?>
	    <div class="error notice is-dismissible">
	        <p><?php _e( 'Access to file editors has been restricted!, please contact your web developer.', 'whello' ); ?></p>
	    </div>
	    <?php
	}
}
add_action( 'admin_notices', 'file_editor_restricted_notice' );
