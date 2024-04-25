<?php

$ldap_dn = "uid=" . $_POST["username"] . ",ou=users,ou=system";
$ldap_password = $_POST["password"];

$ldap_con = ldap_connect("ldap://localhost:389");
ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

if (@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {
    echo "Authenticated";
    // Redirect to the index page
     // Ensure no further code execution after redirect
} else {
    echo "Invalid Credential";
    // Redirect back to index page with authentication failure message
    header("Location: index.php?error=auth_fail");
     // Ensure no further code execution after redirect
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LDAP User Management</title>
    <style>
        body {text-align: center;}
        form {margin: 0 auto;   width: 500px;}
        input {padding: 10px; font-size: 20;}
    </style>
</head>
<body>
    <h1>LDAP User Management</h1>
    <!-- View Users Form -->
    <form id="viewUsersForm" action="view_users.php" method="post">
        <input type="hidden" name="action" value="view">
        <input type="submit" value="View Users">
    </form>
    <!-- Add User Form (Initially Hidden) -->
    <form id="addUserForm" action="add_user.php" method="post" style="display: none;">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="text" name="lastname" placeholder="Lastname" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="hidden" name="action" value="add">
        <input type="submit" value="Add User">
    </form>
    <!-- Remove User Form (Initially Hidden) -->
    <form id="removeUserForm" method="post" action="remove_user.php" style="display: none;">
    <input type="text" name="uid" placeholder="User UID">
    <input type="submit" value="Remove User">
</form>
    <!-- JavaScript to Show/Hide Forms -->
    <script>
        function showForm(formId) {
            document.getElementById(formId).style.display = 'block';
        }
    </script>
    <!-- Buttons to Toggle Forms -->
    <button onclick="showForm('addUserForm')">Add User</button>
    <button onclick="showForm('removeUserForm')">Remove User</button>
</body>
</html>