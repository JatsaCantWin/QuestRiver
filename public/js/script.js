const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="registerEmail"]');
const passwordInput = form.querySelector('input[name="registerPassword"]');
const confirmPasswordInput = form.querySelector('input[name="registerConfirmPassword"]');
const usernameInput = form.querySelector('input[name="registerUsername"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmPassword) {
    return password === confirmPassword;
}

function isFieldEmpty(field)
{
    return field.value === "";
}

function markInvalid(element, condition) {
    !condition ? element.classList.add('invalid') : element.classList.remove('invalid');
    return void(0);
}

function validateEmail() {
    setTimeout(function (){
        markInvalid(emailInput, isEmail(emailInput.value));
    }, 100);
}

function validatePassword() {
    setTimeout(function (){
        const condition = arePasswordsSame(
            passwordInput.value,
            confirmPasswordInput.value
        );
        markInvalid(confirmPasswordInput, condition || confirmPasswordInput.value === "");
    }, 100);
}

function validateForm() {
    //event.preventDefault();
    if (!isFieldEmpty(emailInput))
    {
        return false;
    }
    if (!isFieldEmpty(usernameInput))
    {
        return false;
    }
    if (!isFieldEmpty(passwordInput))
    {
        return false;
    }
    if (!isEmail(emailInput.value))
    {
        return false;
    }
    if (!arePasswordsSame(passwordInput.value, confirmPasswordInput.value))
    {
        return false;
    }

    return true;
}

//form.addEventListener("submit", validateForm);
emailInput.addEventListener("focusout", validateEmail);
confirmPasswordInput.addEventListener("focusout", validatePassword);
confirmPasswordInput.previousElementSibling.previousElementSibling.addEventListener("focusout", validatePassword);
