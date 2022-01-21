<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleLogin.css">
    <title>Quest River - Login</title>
</head>
<body>
    <img src="public/img/logo.svg" alt="Logo">
    <form action = "login" method="POST">
        <?php if (isset($messages)) {
            foreach ($messages as $message)
            {
                echo $message;
            }
        }
        ?>
        <input type = "email" name ="email"/>
        <label>Login</label>
        <input type = "password" name ="password"/>
        <label>Password</label>
        <input type = "submit" style = "position: absolute; left: -9999px"/>
    </form>
    <label>Don't have an account?</label>
    <label>Forgot password?</label>
</body>