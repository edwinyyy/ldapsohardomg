<?php
    $ldap_dn = "uid=admin,ou=system";
    $ldap_password = "secret";
    $ldap_con = ldap_connect("ldap://localhost:389");

    ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION,3);

    if (ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {
        echo"Bind Successful!";
    }
    else { 
        echo "Invalid";
        
    }
    

	$ldap_dn = "uid=".$_POST["username"].",dc=example,dc=com";
	$ldap_password = $_POST["password"];
	
	$ldap_con = ldap_connect("ldap.forumsys.com");
	ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

	if(@ldap_bind($ldap_con,$ldap_dn,$ldap_password))
		echo "Authenticated";
	else
		echo "Invalid Credential";
?>