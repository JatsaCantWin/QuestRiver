<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleCommon.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleLogin.css">
    <script type="text/javascript" src="./public/js/register.js" defer></script>
    <title>Quest River - Login</title>
</head>
<body>
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span id="buttonCloseRegisterModal" class="grey-button button-close-modal">&times;</span>
            <div>
                <form action="register" method="POST" ENCTYPE="multipart/form-data">
                    <h3>Sign Up</h3>
                    <label class = "modal-messages">
                        <?php
                        if(isset($registerMessages)){
                            foreach($registerMessages as $message){
                                echo $message;
                            }
                        }
                        ?>
                    </label>
                    <input class = 'text-input' type = "email" name ="registerEmail"/>
                    <label>E-mail</label>
                    <input class = 'text-input' type = "password" name ="registerPassword"/>
                    <label>Password</label>
                    <input class = 'text-input' type = "password" name ="registerConfirmPassword"/>
                    <label>Confirm Password</label>
                    <input class = 'text-input' name ="registerUsername"/>
                    <label>Username</label>
                    <button type="submit" class="blue-button">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
    <img src="public/img/logo.svg" alt="Logo">
    <form action = "login" method="POST">
        <?php if (isset($messages)) {
            foreach ($messages as $message)
            {
                echo $message;
            }
        }
        ?>
        <input class = 'text-input' type = "email" name ="email"/>
        <label>E-mail</label>
        <input class = 'text-input' type = "password" name ="password"/>
        <label>Password</label>
        <input type = "submit" class="hidden-button">
    </form>
    <label id="buttonOpenRegisterModal" class="grey-button">Don't have an account?</label>
    <script>
        var modal = document.getElementById("registerModal");
        var btn = document.getElementById("buttonOpenRegisterModal");
        var span = document.getElementById("buttonCloseRegisterModal");
        btn.onclick = function () {
            modal.style.display = "flex";
        }
        span.onclick = function () {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <label class="grey-button">Forgot password?</label>
</body>