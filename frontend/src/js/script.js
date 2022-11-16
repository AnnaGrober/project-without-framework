import './../style.css'

const form = document.getElementById('signupForm');
const name = form.querySelector('#signupName');
const email = form.querySelector('#signupEmail');
const password = form.querySelector('#signupPassword');
const signupButton = form.querySelector('#signupButton');

function submitFormHandler(event) {
    event.preventDefault();
    console.log(name.value);
    const user = {
        name:     name.value.trim(),
        email:    email.value.trim(),
        password: password.value.trim(),
    };
    signupButton.disabled = true;

    //axios send //

    name.value = '';
    email.value = '';
    password.value = '';
    signupButton.disabled = false;
}

form.addEventListener('submit', submitFormHandler);