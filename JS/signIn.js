function check(event) {
    
    var valid = true, error = "", field = "";
    field = document.getElementById("email");
    error = document.getElementById("cemail");
    if(!validateEmail(field.innerHTML)){
        valid = false;
        field.classList.add("erroreCampo");
        error.innerHTML = "Questa email non è valida.\r\n";
        event.preventDefault();
    }else{
        field.classList.remove("erroreCampo");
        error.innerHTML = "";
    }

    return valid;
};

function validateEmail(email) {
  return /^[\w\-\._]+@[\w\-\._]+\.\w{2,10}$/.test(email);
};

function togglePassword() {
    password = document.getElementById('password');
    if(password.type === "password"){
        password.type = "text";
    }else {
        password.type = "password";
    }
};

function clearEmailErrorMessage() {
    emailError = document.getElementById("cemail");
    console.log(emailError);
    if(emailError != null) emailError.innerHTML = "";
    return true;
};

function clearLoginErrorMessage() {
    loginError = document.getElementById("clogin");
    if(loginError != null) loginError.innerHTML = "";
    return true;
};

function clearUsernameErrorMessage() {
    unameError = document.getElementById("cuname");
    if(unameError != null) unameError.innerHTML = "";
    return true;
};

function clearErrorMessages() {
    clearEmailErrorMessage();
    clearLoginErrorMessage();
    clearUsernameErrorMessage();
    return true;
};

function clearLoginFields() {
    email = document.getElementById("email");
    password = document.getElementById("password");
    uname = document.getElementById("uname");
    if(email != null ) email.value = "";
    if(password != null) password.value = "";
    if(uname != null) uname.value = "";
    clearErrorMessages();
    return true;
};



