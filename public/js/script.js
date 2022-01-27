const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="registerEmail"]');
const confirmPasswordInput = form.querySelector('input[name="registerConfirmPassword"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmPassword) {
    return password === confirmPassword;
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
            confirmPasswordInput.previousElementSibling.previousElementSibling.value,
            confirmPasswordInput.value
        );
        markInvalid(confirmPasswordInput, condition || confirmPasswordInput.value === "");
    }, 100);
}

emailInput.addEventListener("focusout", validateEmail)
confirmPasswordInput.addEventListener("focusout", validatePassword)
confirmPasswordInput.previousElementSibling.previousElementSibling.addEventListener("focusout", validatePassword);
