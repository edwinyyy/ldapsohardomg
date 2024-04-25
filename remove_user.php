<?php

$ldap_dn = "uid=admin,ou=system";
$ldap_password = "secret";
$ldap_con = ldap_connect("ldap://localhost:389");

ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

// Bind to LDAP server
$ldap_bind_result = ldap_bind($ldap_con, $ldap_dn, $ldap_password);

// Check if the bind was successful
if (!$ldap_bind_result) {
    echo "LDAP bind failed...";
} else {
    // Search for the user based on uid
    $ldap_base_dn = "ou=users,ou=system"; // Update with your LDAP base DN
    $search_result = ldap_search($ldap_con, $ldap_base_dn, "(uid=" . $_POST["uid"] . ")");
    $user_entries = ldap_get_entries($ldap_con, $search_result);

    // Check if user was found
    if ($user_entries["count"] == 0) {
        echo "User not found.";
    } else {
        // Get the DN of the user
        $user_dn = $user_entries[0]["dn"];

        // Remove user entry
        $remove_user_result = ldap_delete($ldap_con, $user_dn);

        // Check if user was successfully removed
        if ($remove_user_result) {
            echo "User removed successfully.";
        } else {
            $ldap_error = ldap_error($ldap_con);
            echo "Failed to remove user: $ldap_error";
        }
    }
}

// Close LDAP connection
ldap_close($ldap_con);

?>

