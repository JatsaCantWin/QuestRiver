<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleCommon.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleStatistics.css">
    <title>Quest River - Statistics</title>
</head>
<body>
    <section class = "top-bar">
        <img class = "logo" src="public/img/logo.svg" alt="Logo">
        <div class = "stats-bar">
            <img class ="avatar" src="public/img/avatarplaceholder.png" alt="Avatar">
            <div class = "flex-column">
                <label>Jourum</label>
                <label>Warrior</label>
                <label>Lvl. 10</label>
                <div class = "stat-bar">
                    <div class = "level-bar"></div>
                    <label>40/100 XP</label>
                </div>
            </div>
            <div class = "flex-column stats-currency">
                <div>
                    <img src="public/img/money.svg" alt="Gold": >
                    <label class ="label-currency-money-amount">130</label>
                </div>
                <div>
                    <img src="public/img/bill.svg" alt="Gems: ">
                    <label class ="label-currency-bills-amount">200</label>
                </div>
                <div>
                    <img src="public/img/gem.svg" alt="Gems: ">
                    <label class ="label-currency-gems-amount">20</label>
                </div>
            </div>
            <div class = "flex-column stats-bars">
                <div class = "stat-bar">
                    <div class = "health-bar"></div>
                    <label>40/100 HP</label>
                </div>
                <div class = "stat-bar">
                    <div class = "magic-bar"></div>
                    <label>40/100 MP</label>
                </div>
                <div class = "stat-bar">
                    <div class = "stamina-bar"></div>
                    <label>40/100 SP</label>
                </div>
            </div>
            <div class = "stats-buttons">
                <img class ="stat-button" src="public/img/buttonsettings.svg" alt="Settings">
                <img class ="stat-button" src="public/img/buttonexit.svg" alt="Exit">
            </div>
        </div>
    </section>
    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <span id="butttonCloseAvatarModal" class="grey-button">&times;</span>
            <h1>UPLOAD NEW AVATAR</h1>
            <form action="changeAvatar" method="POST" ENCTYPE="multipart/form-data">
                <?php
                if(isset($messages)){
                    foreach($messages as $message){
                        echo $message;
                    }
                }
                ?>
                <input type="file" name="file">
                <button type="submit" class="blue-button">send</button>
            </form>
        </div>
    </div>
    <div class = "interface">
        <div class = "interface-buttons">
            <button class = "active-button">Statistics</button>
            <button>Inventory</button>
            <button>Quests</button>
            <button>The Town</button>
        </div>
        <div class = "interface-page">
            <div class = "flex-column interface-stats">
                <img src="public/img/avatarplaceholder.png" alt="Avatar">
                <button id="buttonOpenAvatarModal" class="blue-button">Change Avatar</button>
                <script>
                    var modal = document.getElementById("avatarModal");
                    var btn = document.getElementById("buttonOpenAvatarModal");
                    var span = document.getElementById("butttonCloseAvatarModal");
                    btn.onclick = function () {
                        modal.style.display = "block";
                    }
                    span.onclick = function () {
                        modal.style.display = "none";
                    }
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>
                <label>Jourum</label>
                <label>Warrior</label>
                <label>Lvl. 10</label>
                <div class = "stat-bar">
                    <div class = "level-bar"></div>
                    <label>40/100 XP</label>
                </div>
            </div>
            <div class ="flex-column interface-box">
                <label>Attributes:</label>
                <div class="list-attributes">
                    <label>Strength: 20</label>
                    <label>Dexterity: 20</label>
                    <label>Constitution: 20</label>
                    <label>Intelligence: 20</label>
                    <label>Wisdom: 20</label>
                    <label>Charisma: 20</label>
                </div>
            </div>
            <div class ="interface-box">
                <label>Skills:</label>
                <div class = "interface-skill-box">
                    <ul>
                        <li><label>Cooking</label><img src="public/img/buttonadd.svg" alt="Add"></li>
                        <li><label>Programming</label><img src="public/img/buttonadd.svg" alt="Add"></li>
                        <li><label>Drawing</label><img src="public/img/buttonadd.svg" alt="Add"></li>
                        <li><label>This skill name is deffinitely too long so it needs to be wrapped</label><img src="public/img/buttonadd.svg" alt="Add"></li>
                    </ul>
                </div>
            </div>
            <div class = "interface-box">
                <label>Party:</label>
                <div class = "interface-party-box">

                </div>
            </div>
        </div>
    </div>
</body>
</html>