<?php

$ldap_dn = "uid=admin,ou=system";
$ldap_password = "secret";
$ldap_con = ldap_connect("ldap://localhost:389");

ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

// Bind to LDAP server
ldap_bind($ldap_con, $ldap_dn, $ldap_password);

// Check if the bind was successful
if (!$ldap_con) {
    echo "LDAP bind failed...";
} else {
    // Search for all user entries
    $ldap_base_dn = "ou=users,ou=system"; // Update with your LDAP base DN
    $search_result = ldap_search($ldap_con, $ldap_base_dn, "(objectClass=inetOrgPerson)");
    $user_entries = ldap_get_entries($ldap_con, $search_result);

    // Check if user entries were found
    if ($user_entries === false || $user_entries['count'] == 0) {
        echo "No users found.";
    } else {
        // Output user information
        for ($i = 0; $i < $user_entries['count']; $i++) {
            // Output user attributes if they exist
            if (isset($user_entries[$i]['dn'])) {
                echo "DN: " . $user_entries[$i]['dn'] . "<br>";
            }
            if (isset($user_entries[$i]['cn'][0])) {
                echo "Firstname: " . $user_entries[$i]['cn'][0] . "<br>";
            }
            if (isset($user_entries[$i]['sn'][0])) {
                echo "Surname: " . $user_entries[$i]['sn'][0] . "<br>"; // Added surname
            }
            if (isset($user_entries[$i]['mail'][0])) {
                echo "Email: " . $user_entries[$i]['mail'][0] . "<br>";
            }
            echo "<hr>";
        }
    }

    // Close LDAP connection
    ldap_close($ldap_con);
}

?>
