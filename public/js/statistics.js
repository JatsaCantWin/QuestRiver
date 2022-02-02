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
const username = document.querySelector('.interface-stats label');
const characterClass = username.nextElementSibling;
const level = characterClass.nextElementSibling;
const listAttributes = document.querySelector('.list-attributes');
const strength = listAttributes.querySelector('label');
const dexterity = strength.parentElement.nextElementSibling.querySelector('label');
const constitution = dexterity.parentElement.nextElementSibling.querySelector('label');
const intelligence = constitution.parentElement.nextElementSibling.querySelector('label');
const wisdom = intelligence.parentElement.nextElementSibling.querySelector('label');
const charisma = wisdom.parentElement.nextElementSibling.querySelector('label');
const attributeButtons = listAttributes.querySelectorAll('img');
const attributeNames = ["Strength", "Dexterity", "Constitution", "Intelligence", "Wisdom", "Charisma"];

window.onload = function () {
    refreshStats();
    refreshSkills();
    refreshAvatar();
    attributeButtons.forEach(function (attribute, i) {
        attribute.addEventListener('click', function() {upgradeCharacteristic(attributeNames[i])});
    });
}

function upgradeCharacteristic(attributeName) {
    const data = {attributeName: attributeName};
    const sessionid = getCookie('sessionid');

    fetch("/fetchAdvanceAttribute", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 200)
            refreshStats()
    });
}

function refreshStats() {
    getUser().then(function(user) {
        topBarUsername.innerText = user.username;
        username.innerText = user.username;
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
        characterClass.innerText = "";
        level.innerText = "Level " + stats.level;
        strength.innerText = "Strength: " + stats.strength;
        dexterity.innerText = "Dexterity: " + stats.dexterity;
        constitution.innerText = "Constitution: " + stats.constitution;
        intelligence.innerText = "Intelligence: " + stats.intelligence;
        wisdom.innerText = "Wisdom: " + stats.wisdom;
        charisma.innerText = "Charisma: " + stats.charisma;
        if (stats.upgrades > 0)
        {
            attributeButtons.forEach(attribute => {
                attribute.style.display = 'block';
            });
        } else
        {
            attributeButtons.forEach(attribute => {
                attribute.style.display = 'none';
            })
        }
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