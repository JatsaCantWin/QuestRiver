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
const avatarUploadImage = document.querySelector('#avatarModal .avatar');
const avatarUploadInput = document.querySelector('#avatarModal form input');
const avatarUploadButton = document.querySelector('#avatarModal form button');
const avatarUploadMessages = document.querySelector('#avatarModal .modal-messages')

window.onload = function () {
    refreshTopBar();
    refreshStats();
    refreshSkills();
    refreshAvatar();
    attributeButtons.forEach(function (attribute, i) {
        attribute.addEventListener('click', function() {upgradeCharacteristic(attributeNames[i])});
    });
}

let uploaded = false;

avatarUploadInput.onchange = function () {
    const [file] = avatarUploadInput.files;
    const acceptedTypes = ['image/jpeg', "image/png"];
    if (file && acceptedTypes.includes(file['type'])) {
        avatarUploadImage.src = URL.createObjectURL(file);
        uploaded = true;
        avatarUploadMessages.innerText = '';
    } else
    {
        uploaded = false;
        avatarUploadMessages.innerText = 'Unsupported file';
    }
}

avatarUploadButton.onclick = function () {
    if (!uploaded)
    {
        event.preventDefault();
    }
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
        username.innerText = user.username;
    });

    getUserStats().then(function (stats) {
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