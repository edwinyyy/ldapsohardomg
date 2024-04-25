<?php
// Check if there's an error message
if (isset($_GET['error']) && $_GET['error'] == 'auth_fail') {
    echo "<p>Authentication failed. Please check your username and password.</p>";
}
?>
<html>
</head<><style>
    body {text-align: center;}
    form {margin: 0 auto;   width: 500px;}
    input{ padding: 10px; font-size: 20;}
</style></head>
</body>
<h1>Fuck this project</h1>
<form action="Auth_test.php" method="post">
    <input type = "text" name= "username" /><br>
    <input type = "password" name= "password" /><br>
    <input type = "submit" name= "Login" /><br>
</form>
</body>
</html>
    