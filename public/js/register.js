const registerForm = document.querySelector("#registerModal form");
const emailInput = registerForm.querySelector('input[name="registerEmail"]');
const passwordInput = registerForm.querySelector('input[name="registerPassword"]');
const confirmPasswordInput = registerForm.querySelector('input[name="registerConfirmPassword"]');
const usernameInput = registerForm.querySelector('input[name="registerUsername"]');
const messagesLabel = registerForm.querySelector('.modal-messages');

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

function markInvalid(element, condition, message)
{
    if (!condition)
    {
        element.classList.add('invalid')
        messagesLabel.innerText = message;
    } else
    {
        element.classList.remove('invalid');
        messagesLabel.innerText = '';
    }
    return void(0);
}

function validateEmail() {
    setTimeout(function (){
        markInvalid(emailInput, isEmail(emailInput.value), 'Invalid email');
    }, 100);
}

function validatePassword() {
    setTimeout(function (){
        const condition = arePasswordsSame(
            passwordInput.value,
            confirmPasswordInput.value
        );
        markInvalid(confirmPasswordInput, condition || confirmPasswordInput.value === "", 'Passwords don\'t match');
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

emailInput.addEventListener("focusout", validateEmail);
confirmPasswordInput.addEventListener("focusout", validatePassword);
confirmPasswordInput.previousElementSibling.previousElementSibling.addEventListener("focusout", validatePassword);
