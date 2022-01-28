const buttonAddSkill = document.getElementById('buttonAddSkill');
const listSkills = document.querySelector('.interface-skill-box ul');

buttonAddSkill.addEventListener("click", function() {
    createTempSkill();
});

function getCookie(name) {
    return (name = (document.cookie + ';').match(new RegExp(name + '=.*;'))) && name[0].split(/=|;/)[1];
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

function addSkillToList(skillName)
{
    const template = document.getElementById('skill-template')

    const clone = template.content.firstElementChild.cloneNode(true);
    const newSkill = listSkills.appendChild(clone);

    newSkill.querySelector('label').innerHTML = skillName;
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

function displayLoader() {
    document.getElementById('loader').style['display'] = 'flex';
}

function hideLoader() {
    document.getElementById('loader').style['display'] = 'none';
}