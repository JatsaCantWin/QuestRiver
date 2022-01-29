<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleCommon.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleStatistics.css">
    <script type="text/javascript" src="./public/js/common.js"></script>
    <script type="text/javascript" src="./public/js/skills.js" defer></script>
    <script type="text/javascript" src="./public/js/statistics.js" defer></script>
    <title>Quest River - Statistics</title>
</head>
<body>
    <section class = "top-bar">
        <img class = "logo" src="public/img/logo.svg" alt="Logo">
        <div class = "stats-bar">
            <img class ="avatar" src="public/img/avatarplaceholder.png" alt="Avatar">
            <div class = "flex-column">
                <label id="topBarUsername">&nbsp</label>
                <label id="topBarClass"></label>
                <label id="topBarLevel">Lvl. </label>
                <div class = "stat-bar">
                    <div class = "level-bar"></div>
                    <label>0/100 XP</label>
                </div>
            </div>
            <div class = "flex-column stats-currency">
                <div>
                    <img src="public/img/money.svg" alt="Gold": >
                    <label class ="label-currency-money-amount">0</label>
                </div>
                <div>
                    <img src="public/img/bill.svg" alt="Gems: ">
                    <label class ="label-currency-bills-amount">0</label>
                </div>
                <div>
                    <img src="public/img/gem.svg" alt="Gems: ">
                    <label class ="label-currency-gems-amount">0</label>
                </div>
            </div>
            <div class = "flex-column stats-bars">
                <div class = "stat-bar">
                    <div class = "health-bar"></div>
                    <label>0/100 HP</label>
                </div>
                <div class = "stat-bar">
                    <div class = "magic-bar"></div>
                    <label>0/100 MP</label>
                </div>
                <div class = "stat-bar">
                    <div class = "stamina-bar"></div>
                    <label>0/100 SP</label>
                </div>
            </div>
            <div class = "stats-buttons">
                <img class ="stat-button" src="public/img/buttonsettings.svg" alt="Settings">
                <form action="logout"><button type="submit"><img class ="stat-button" src="public/img/buttonexit.svg" alt="Exit"></button></form>
            </div>
        </div>
    </section>
    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <span id="buttonCloseAvatarModal" class="grey-button button-close-modal">&times;</span>
            <div>
                <img class = "avatar" src="public/img/avatarplaceholder.png" alt="CurrentAvatar">
                <form action="changeAvatar" method="POST" ENCTYPE="multipart/form-data">
                    <div>
                        <h3>Upload New Avatar</h3>
                        <label class = "modal-messages">
                            <?php
                            if(isset($messages)){
                                foreach($messages as $message){
                                    echo $message;
                                }
                            }
                            ?>
                        </label>
                        <input type="file" name="file">
                        <label>Supported file types: .jpeg, .png</label>
                    </div>
                    <button type="submit" class="blue-button">Upload</button>
                </form>
            </div>
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
                <img src="public/img/avatarplaceholder.png" class="avatar" alt="Avatar">
                <button id="buttonOpenAvatarModal" class="blue-button">Change Avatar</button>
                <script>
                    var modal = document.getElementById("avatarModal");
                    var btn = document.getElementById("buttonOpenAvatarModal");
                    var span = document.getElementById("buttonCloseAvatarModal");
                    btn.onclick = function () {
                        modal.style.display = "flex";
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
                <label>&nbsp</label>
                <label></label>
                <label>Lvl. </label>
                <div class = "stat-bar">
                    <div class = "level-bar"></div>
                    <label>0/100 XP</label>
                </div>
            </div>
            <div class ="flex-column interface-box">
                <label>Attributes:</label>
                <div class="list-attributes">
                    <label>Strength: </label>
                    <label>Dexterity: </label>
                    <label>Constitution: </label>
                    <label>Intelligence: </label>
                    <label>Wisdom: </label>
                    <label>Charisma: </label>
                </div>
            </div>
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Skills:</label>
                    <div>
                        <img class="button-add" id="buttonRemoveSkill" src="public/img/buttonremove.svg" alt="Remove">
                        <img class="button-add" id="buttonAddSkill" src="public/img/buttonadd.svg" alt="Add">
                    </div>
                </div>
                <div class = "interface-skill-box">
                    <ul>
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
    <template id="tempSkill-template">
        <li><input class = "text-input" id="newSkillInput" type="text"></li>
    </template>
    <template id="skill-template">
        <li><label></label><img class="button-add" src="public/img/buttonadd.svg" alt="Adv"></li>
    </template>
    <div id="loader" class="opaque-screen">
        <div class="loader"></div>
    </div>
</body>
</html>