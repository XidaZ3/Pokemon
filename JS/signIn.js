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

function filterChange() {
    select = document.getElementById('filter');
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const content = urlParams.has('content') ? urlParams.get('content'): 0;
    switch(select.value){
        case "0": window.location.replace("contenuti.php?content=".concat(content,"&filter=0")); ;break; //Most recent 
        case "1": window.location.replace("contenuti.php?content=".concat(content,"&filter=1")); ;break; //Most recent 
        case "2": window.location.replace("contenuti.php?content=".concat(content,"&filter=2")); ;break; //Most recent 
        case "3": window.location.replace("contenuti.php?content=".concat(content,"&filter=3")); ;break; //Most recent 
        default: window.location.replace("contenuti.php?content=".concat(content,"&filter=0"));
    }
    return;
};

function popUpDeleteAccount() {
    var id = document.getElementById('id');
    let password = prompt("Inserisci la password per eliminare il tuo account:");
    if (password == null || password == "") {
        alert('Lololo');
    } else {
        window.location.replace("deleteAccount.php?id=".concat(id.value,"&password=",password));
    }
    return;
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function saveUserCookie(){
    email = document.getElementById("email");
    setCookie("username",email.value,365);
}


