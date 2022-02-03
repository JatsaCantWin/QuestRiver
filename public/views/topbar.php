<!doctype html>
<section class = "top-bar">
        <img class = "logo" src="public/img/logo.svg" alt="Logo">
        <div class = "stats-bar">
            <img class ="avatar" src="public/img/avatarplaceholder.png" alt="Avatar">
            <div class = "flex-column">
                <label id="topBarUsername">&nbsp</label>
                <label id="topBarClass"></label>
                <label id="topBarLevel">Level </label>
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