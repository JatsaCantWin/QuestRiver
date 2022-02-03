const topBarUsername = document.getElementById('topBarUsername');
const topBarClass = document.getElementById('topBarClass');
const topBarLevel = document.getElementById('topBarLevel');
const topBarXPBars = document.querySelectorAll('.level-bar');
const topBarMoney = document.querySelector('.label-currency-money-amount');
const topBarBills = document.querySelector('.label-currency-bills-amount');
const topBarGems = document.querySelector('.label-currency-gems-amount');
const topBarHealthBar = document.querySelector('.health-bar');
const topBarMagicBar = document.querySelector('.magic-bar');
const topBarStaminaBar = document.querySelector('.stamina-bar');

function refreshTopBar() {
    getUser().then(function(user) {
        topBarUsername.innerText = user.username;
    });

    getUserStats().then(function (stats) {
        topBarClass.innerText = "";
        topBarLevel.innerText = "Level " + stats.level;
        topBarXPBars.forEach(bar => {
            bar.style.width = stats.xp + '%';
            bar.nextElementSibling.innerText = stats.xp + "/100 XP";
        })
        topBarMoney.innerText = stats.gold;
        topBarBills.innerText = stats.bills;
        topBarGems.innerText = stats.gems;
        topBarHealthBar.style.width = stats.health + "%";
        topBarHealthBar.nextElementSibling.innerText = stats.health + "/100 HP";
        topBarMagicBar.style.width = stats.magic + "%";
        topBarMagicBar.nextElementSibling.innerText = stats.magic + "/100 MP";
        topBarStaminaBar.style.width = stats.stamina + "%";
        topBarStaminaBar.nextElementSibling.innerText = stats.stamina + "/100 SP";
    });
}

function refreshAvatar()
{
    const avatars = document.querySelectorAll('.avatar');

    getUser().then(function (user) {
        avatars.forEach(avatar => {
            avatar.src = 'public/uploadedAvatars/'+user.email+'.png?' + Date.now().toString();
        })
    });
}