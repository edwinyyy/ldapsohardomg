<?php

// Function to generate a unique UID
function generateUniqueUid($ldap_con, $ldap_base_dn) {
    // Search for existing users to find the highest UID
    $search_result = ldap_search($ldap_con, $ldap_base_dn, "(uid=*)", ["uid"]);
    $user_entries = ldap_get_entries($ldap_con, $search_result);

    $max_uid = 0;
    // Iterate over existing users to find the highest UID
    for ($i = 0; $i < $user_entries['count']; $i++) {
        $uid = intval($user_entries[$i]['uid'][0]);
        if ($uid > $max_uid) {
            $max_uid = $uid;
        }
    }

    // Increment the highest UID to generate a new UID
    $new_uid = $max_uid + 1;
    return $new_uid;
}

// LDAP connection settings
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
    // Define new user attributes
    $new_uid = generateUniqueUid($ldap_con, "ou=users,ou=system"); // Generate unique UID
    $user_attributes = [
        "cn" => $_POST["username"],
        "sn" => $_POST["lastname"],
        "uid" => $_POST["username"], // Ensure this is unique
        "mail" => $_POST["email"],
        "userPassword" => $_POST["password"],
        // Add other required or optional attributes as needed
    ];

    // Add new user entry
    $ldap_base_dn = "ou=users,ou=system"; // Update with your LDAP base DN
    $add_user_result = ldap_add($ldap_con, "cn=" . $_POST["username"] . "," . $ldap_base_dn, $user_attributes);

    // Check if user was successfully added
    if ($add_user_result) {
        echo "User added successfully with UID: $new_uid";
    } else {
        $ldap_error = ldap_error($ldap_con);
        echo "Failed to add user: $ldap_error";
    }
}

// Close LDAP connection
ldap_close($ldap_con);

?>
