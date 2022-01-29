const buttonAddSkill = document.getElementById('buttonAddSkill');
const buttonRemoveSkill = document.getElementById('buttonRemoveSkill');
const listSkills = document.querySelector('.interface-skill-box ul');

let skillRemovingMode = false;

buttonRemoveSkill.addEventListener('click', function () {
    const buttonsRemoveSkills = listSkills.querySelectorAll('img');

    if (skillRemovingMode)
    {
        buttonsRemoveSkills.forEach(button => {
            let newButton = button.cloneNode(true);
            newButton.src = 'public/img/buttonadd.svg';
            newButton.onclick = function (){};
            button.replaceWith(newButton);
        })
        skillRemovingMode = false;
        buttonRemoveSkill.style.filter = "";
    } else
    {
        buttonsRemoveSkills.forEach(button => {
            let newButton = button.cloneNode(true);
            newButton.src = 'public/img/buttonremove.svg';
            newButton.onclick = function(){removeSkill(newButton.parentElement.querySelector('label').innerText)};
            button.replaceWith(newButton);
        })
        skillRemovingMode = true;
        buttonRemoveSkill.style.filter = "brightness(0.25)";
    }
});

buttonAddSkill.addEventListener("click", function() {
    createTempSkill();
});

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
            addSkillToList(skill.skillName);
        });
    });
}

function addSkill(skillName)
{
    const data = {skillname: skillName};
    const sessionid = getCookie('sessionid');
    let responseStatus;

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
        responseStatus = response.status;
    });
    hideLoader();
    return responseStatus;
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

function addSkillToList(skillName)
{
    const template = document.getElementById('skill-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newSkill = listSkills.appendChild(clone);

    newSkill.querySelector('label').innerHTML = skillName;
    if (skillRemovingMode) {
        newSkill.querySelector('img').src = 'public/img/buttonremove.svg';
        newSkill.onclick = function(){removeSkill(skillName)};
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