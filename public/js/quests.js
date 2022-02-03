const listQuests = document.querySelector('#dailyQuestList');
const buttonRemoveQuest = document.querySelector('#buttonRemoveDaily')
const buttonAddQuest = document.querySelector('#buttonAddDaily')

window.onload = function ()
{
    refreshAvatar();
    refreshTopBar();
    refreshQuests();
}

let questRemovingMode = false;

buttonRemoveQuest.addEventListener('click', function () {
    const buttonsRemoveQuests = listQuests.querySelectorAll('img');

    if (questRemovingMode)
    {
        buttonsRemoveQuests.forEach(button => {
            button = removeEventListeners(button)
            if (button.parentElement['finished'])
                button.style.display = 'none';
            button.src = 'public/img/buttoncheck.svg';
            button.addEventListener('click', () => finishQuest(button.parentElement['questName']));
        })
        questRemovingMode = false;
        buttonRemoveQuest.style.filter = "";
    } else
    {
        buttonsRemoveQuests.forEach(button => {
            button = removeEventListeners(button)
            button.src = 'public/img/buttonremove.svg';
            button.style.display = 'block';
            button.addEventListener('click', () => removeQuest(button.parentElement['questName']));
        })
        questRemovingMode = true;
        buttonRemoveQuest.style.filter = "brightness(0.25)";
    }
});

buttonAddQuest.addEventListener("click", function() {
    createTempQuest();
});

function refreshQuests() {
    fetch("/fetchGetQuests", {
        method: "GET",
        headers: {
            'sessionid': getCookie('sessionid')
        }
    }).then(function (response) {
        return response.json();
    }).then(function (quests) {
        listQuests.innerHTML ='';
        quests.forEach(quest => {
            addQuestToList(quest.questName, quest.finished);
        });
    });
}

function addQuestToList(questName, finished)
{
    const template = document.getElementById('daily-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newQuest = listQuests.appendChild(clone);

    newQuest.querySelector('label').innerHTML = questName;

    newQuest['questName'] = questName;
    newQuest['finished'] = finished;

    if (questRemovingMode)
    {
        newQuest.querySelector('img').style.display = "block";
        newQuest.querySelector('img').src = 'public/img/buttonremove.svg';
        newQuest.querySelector('img').addEventListener('click', function (){removeQuest(questName)});
    }
    else if (!newQuest['finished']) {
        newQuest.querySelector('img').style.display = "block";
        newQuest.querySelector('img').src = 'public/img/buttoncheck.svg';
        newQuest.querySelector('img').addEventListener('click', function (){finishQuest(questName)})
    } else {
        newQuest.querySelector('img').style.display = "none";
        newQuest.querySelector('img').src = 'public/img/buttoncheck.svg';
        //newQuest.querySelector('img').addEventListener('click', function(){advSkill(skillName, lastPracticed)});
    }
}

function finishQuest(questName)
{
    const data = {questName: questName};
    const sessionid = getCookie('sessionid');

    displayLoader();
    fetch("/fetchCompleteQuest", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 200) {
            refreshQuests()
            refreshTopBar()
        }
    });
    hideLoader();
}

function removeQuest(questName)
{
    const data = {questName: questName};
    const sessionid = getCookie('sessionid');

    displayLoader();
    fetch("/fetchDeleteQuest", {
        method: "DELETE",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 200)
            refreshQuests()
    });
    hideLoader();
}

function createTempQuest() {
    const template = document.getElementById('tempElement-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newQuest = listQuests.appendChild(clone);
    const newQuestInput = newQuest.querySelector('input');
    newQuestInput.focus();
    newQuest.addEventListener('focusout', function(){
        newQuest.remove();
    });
    newQuestInput.addEventListener('keyup', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            addQuest(newQuestInput.value);
        }
    });
}

function addQuest(questName)
{
    const data = {questName: questName};
    const sessionid = getCookie('sessionid');

    displayLoader();
    fetch("/fetchAddQuest", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 201)
            refreshQuests()
    });
    hideLoader();
}