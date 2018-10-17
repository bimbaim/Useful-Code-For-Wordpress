
<?php
/**
 * Check user has specific role
 *
 * @param string $role
 * @param int $user_id
 * @return bool
 * To use it
 * $has_role = is_user_has_role("author", 10);
 * if($has_role)
 * {
 * //The user has the "author" role
 * }
 */
function is_user_has_role( $role, $user_id = null ) {
    if ( is_numeric( $user_id ) ) {
        $user = get_userdata( $user_id );
    }
    else {
        $user = wp_get_current_user();
    }
    if ( !empty( $user ) ) {
        return in_array( $role, (array) $user->roles );
    }
    else
    {
    	return false;
    }
}

?>
