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
    const content = urlParams.has('tipo') ? urlParams.get('tipo'): 0;
    switch(select.value){
        case "0": window.location.replace("contenuti.php?tipo=".concat(content,"&filter=0")); ;break; //Most recent 
        case "1": window.location.replace("contenuti.php?tipo=".concat(content,"&filter=1")); ;break; //Most recent 
        case "2": window.location.replace("contenuti.php?tipo=".concat(content,"&filter=2")); ;break; //Most recent 
        case "3": window.location.replace("contenuti.php?tipo=".concat(content,"&filter=3")); ;break; //Most recent 
        default: window.location.replace("contenuti.php?tipo=".concat(content,"&filter=0"));
    }
    return;
};

function popUpDeleteAccount() {
    var id = document.getElementById('id');
    let password = prompt("Inserisci la password per eliminare il tuo account:");
    if (password == null || password == "") {
        alert('Non hai inserito nessuna password');
    } else {
        console.log(password);
        window.location = "deleteAccount.php?id=".concat(id.value,"&password=",password);
    }
    return;
}

function closePopUp()
{
   document.getElementById("popUpWrapper").remove();
}

function disableAccount(){
  event.preventDefault();
  var popup=document.createElement("div");
  var parentClose = event.target.parentElement;
  popup.setAttribute("id", "popUp");

  var messaggio = document.createElement("p")
  messaggio.setAttribute("id", "messaggio");
  messaggio.innerHTML = "Inserisci la password per disattivare il tuo profilo:";
  var conferma = document.createElement("div");
  conferma.setAttribute("id","confermaDisabilita");
  var password = document.createElement("input");
  password.setAttribute("id", "password");
  password.setAttribute("type", "password");

  var si=document.createElement("button");
  si.setAttribute("onclick","confirmDisable()");
  si.setAttribute("class", "popUpButton");
  si.setAttribute("id", "confermaDisabilita")
  si.innerHTML = "Disabilita";
  var no=document.createElement("button");
  no.setAttribute("onclick","closePopUp()");
  si.setAttribute("class", "popUpButton");
  no.innerHTML = "Annulla";

  conferma.appendChild(messaggio);
  conferma.appendChild(password);
  conferma.appendChild(no);
  conferma.appendChild(si);
  popup.appendChild(conferma);

  var popupWrapper = document.createElement("div");
  popupWrapper.setAttribute("id","popUpWrapper");
  popupWrapper.appendChild(popup);

  parentClose.appendChild(popupWrapper);

}

function confirmDisable(){
    var password = document.getElementById("password").value;
    var id = document.getElementById("id").value;
    if(password != null && password!=""){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location = "profilo.php";
        };
      }
      xhttp.open("POST", "./deleteAccount.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("password="+password+"&id="+id);
      
    }else{
      document.getElementById("messaggio").innerHTML = "Devi prima inserire la password!";
      event.preventDefault();
    }
}

