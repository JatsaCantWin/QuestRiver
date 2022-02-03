<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/styleCommon.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleQuests.css">
    <script type="text/javascript" src="./public/js/common.js"></script>
    <script type="text/javascript" src="./public/js/topBar.js" defer></script>
    <script type="text/javascript" src="./public/js/quests.js" defer></script>
    <title>Quest River - Statistics</title>
</head>
<body>
    <?php include ('topbar.php')?>
    <div class = "interface-buttons">
        <form action = "statistics"><button class = "grey-button" type="submit">Statistics</button></form>
        <form><button class = "grey-button" type="submit">Inventory</button></form>
        <button class = "active-button">Quests</button>
        <form><button class = "grey-button" type="submit">The Town</button></form>
    </div>
    <div class = "interface">
        <div class = "interface-page">
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Monsters:</label>
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
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Daily Quests:</label>
                    <div>
                        <img class="button-add" id="buttonRemoveDaily" src="public/img/buttonremove.svg" alt="Remove">
                        <img class="button-add" id="buttonAddDaily" src="public/img/buttonadd.svg" alt="Add">
                    </div>
                </div>
                <div class = "interface-list-box">
                    <ul id="dailyQuestList">
                    </ul>
                </div>
            </div>
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Quests:</label>
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
            <div class ="interface-box">
                <div class ="interface-box-header">
                    <label>Inn</label>
                </div>
                <div class ="interface-prompt-box">
                    <label>Resting at an Inn, will pause HP loss. Useful if you want to take a break.</label>
                    <form action="toggleRest"><button class="blue-button" type="submit">Pause damage</button></form>
                </div>
            </div>
        </div>
    </div>
    <template id="tempElement-template">
        <li><input class = "text-input" id="newElementInput" type="text"></li>
    </template>
    <template id="daily-template">
        <li><label></label><img class="button-add" src="public/img/buttoncheck.svg" alt="Adv"></li>
    </template>
    <div id="loader" class="opaque-screen">
        <div class="loader"></div>
    </div>
</body>
</html>