function getCookie(name) {
    return (name = (document.cookie + ';').match(new RegExp(name + '=.*;'))) && name[0].split(/=|;/)[1];
}

function displayLoader() {
    document.getElementById('loader').style.display = 'flex';
}

function hideLoader() {
    document.getElementById('loader').style.display = 'none';
}
async function getUser() {
    return fetch("/fetchGetUser", {
        method: "GET",
        headers: {
            'sessionid': getCookie('sessionid')
        }
    }).then(function (response) {
        return response.json()
    }).then(function (data) {
        return data[0]
    });
}

async function getUserStats() {
    return fetch("/fetchGetUserStats", {
        method: "GET",
        headers: {
            'sessionid': getCookie('sessionid')
        }
    }).then(function (response) {
        return response.json()
    }).then(function (data) {
        return data
    });
}

function removeEventListeners(obj)
{
    let clone = obj.cloneNode(true);
    obj.parentNode.replaceChild(clone, obj);
    return clone;
}