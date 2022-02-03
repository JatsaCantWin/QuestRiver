<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleCommon.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleStatistics.css">
    <script type="text/javascript" src="./public/js/common.js"></script>
    <script type="text/javascript" src="./public/js/topBar.js" defer></script>
    <script type="text/javascript" src="./public/js/skills.js" defer></script>
    <script type="text/javascript" src="./public/js/statistics.js" defer></script>
    <title>Quest River - Statistics</title>
</head>
<body>
    <?php include ('topbar.php')?>
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
    <div class = "interface-buttons">
        <button class = "active-button">Statistics</button>
        <form><button class="grey-button" type="submit">Inventory</button></form>
        <form action = "quests"><button class="grey-button" type="submit">Quests</button></form>
        <form><button class="grey-button" type="submit">The Town</button></form>
    </div>
    <div class = "interface">
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
                <label>Level </label>
                <div class = "stat-bar">
                    <div class = "level-bar"></div>
                    <label>0/100 XP</label>
                </div>
            </div>
            <div class ="flex-column interface-box">
                <label>Attributes:</label>
                <ul class="list-attributes">
                    <li><label>Strength: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                    <li><label>Dexterity: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                    <li><label>Constitution: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                    <li><label>Intelligence: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                    <li><label>Wisdom: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                    <li><label>Charisma: </label><img class="button-add button-advance-characteristic" src="public/img/buttonadd.svg" alt="Adv"></li>
                </ul>
            </div>
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Skills:</label>
                    <div>
                        <img class="button-add" id="buttonRemoveSkill" src="public/img/buttonremove.svg" alt="Remove">
                        <img class="button-add" id="buttonAddSkill" src="public/img/buttonadd.svg" alt="Add">
                    </div>
                </div>
                <div class = "interface-list-box">
                    <ul>
                    </ul>
                </div>
            </div>
            <div class = "interface-box">
                <label>Party:</label>
                <div class = "interface-prompt-box">

                </div>
            </div>
        </div>
    </div>
    <template id="tempSkill-template">
        <li><input class = "text-input" id="newElementInput" type="text"></li>
    </template>
    <template id="skill-template">
        <li><label></label><img class="button-add" src="public/img/buttonadd.svg" alt="Adv"></li>
    </template>
    <div id="loader" class="opaque-screen">
        <div class="loader"></div>
    </div>
</body>
</html>