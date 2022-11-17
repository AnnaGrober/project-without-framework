import './../style.css'
import './modules/registration'
import {Registration} from "./modules/registration";

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

    Registration.registration(user).then(() => {
        name.value = '';
        email.value = '';
        password.value = '';
        signupButton.disabled = false;
    });

}

form.addEventListener('submit', submitFormHandler);