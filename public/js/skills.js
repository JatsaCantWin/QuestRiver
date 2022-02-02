const buttonAddSkill = document.getElementById('buttonAddSkill');
const buttonRemoveSkill = document.getElementById('buttonRemoveSkill');
const listSkills = document.querySelector('.interface-skill-box ul');

let skillRemovingMode = false;

buttonRemoveSkill.addEventListener('click', function () {
    const buttonsRemoveSkills = listSkills.querySelectorAll('img');

    if (skillRemovingMode)
    {
        buttonsRemoveSkills.forEach(button => {
            button = removeEventListeners(button)
            button.src = 'public/img/buttonadd.svg';
            button.addEventListener('click', () => advSkill(button.parentElement['skillName'], button.parentElement['lastPracticed']));
        })
        skillRemovingMode = false;
        buttonRemoveSkill.style.filter = "";
    } else
    {
        buttonsRemoveSkills.forEach(button => {
            button = removeEventListeners(button)
            button.src = 'public/img/buttonremove.svg';
            button.addEventListener('click', () => removeSkill(button.parentElement['skillName']));
        })
        skillRemovingMode = true;
        buttonRemoveSkill.style.filter = "brightness(0.25)";
    }
});

buttonAddSkill.addEventListener("click", function() {
    createTempSkill();
});

function advSkill(skillName, lastPracticed) {
    const data = {skillname: skillName, lastpracticed: lastPracticed};
    const sessionid = getCookie('sessionid');

    fetch("/fetchAdvanceSkill", {
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

function refreshSkills() {
    fetch("/fetchGetSkill", {
        method: "GET",
        headers: {
            'sessionid': getCookie('sessionid')
        }
    }).then(function (response) {
        return response.json();
    }).then(function (skills) {
        document.querySelector('.interface-skill-box ul').innerHTML ='';
        skills.forEach(skill => {
            addSkillToList(skill.skillName, skill.lastPracticed);
        });
    });
}

function addSkill(skillName)
{
    const data = {skillname: skillName};
    const sessionid = getCookie('sessionid');

    displayLoader();
    fetch("/fetchAddSkill", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 201)
            refreshSkills()
    });
    hideLoader();
}

function removeSkill(skillName)
{
    const data = {skillname: skillName};
    const sessionid = getCookie('sessionid');
    let responseStatus;

    displayLoader();
    fetch("/fetchDeleteSkill", {
        method: "DELETE",
        headers: {
            'Content-Type': 'application/json',
            'sessionid': sessionid
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        if (response.status === 200)
            refreshSkills()
        responseStatus = response.status;
    });
    hideLoader();
    return responseStatus;
}

function addSkillToList(skillName, lastPracticed)
{
    const template = document.getElementById('skill-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newSkill = listSkills.appendChild(clone);

    newSkill.querySelector('label').innerHTML = skillName;

    newSkill['skillName'] = skillName;
    newSkill['lastPracticed'] = lastPracticed;

    if (skillRemovingMode) {
        newSkill.querySelector('img').src = 'public/img/buttonremove.svg';
        newSkill.querySelector('img').addEventListener('click',function(){removeSkill(skillName)});
    } else {
        newSkill.querySelector('img').addEventListener('click', function(){advSkill(skillName, lastPracticed)});
    }
}

function createTempSkill() {
    const template = document.getElementById('tempSkill-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newSkill = listSkills.appendChild(clone);
    const newSkillInput = newSkill.querySelector('input');
    newSkillInput.focus();
    newSkill.addEventListener('focusout', function(){
        newSkill.remove();
    });
    newSkillInput.addEventListener('keyup', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            if (addSkill(newSkillInput.value) === 409)
                newSkillInput.classList.add('invalid');
        }
    });
}