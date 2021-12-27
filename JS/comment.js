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

function createUserComment() {
    var xhttp;
    var txtAreaCommento=document.getElementById("textCommento");
    if (txtAreaCommento.value == "") {
        txtAreaCommento.setAttribute("placeholder", "Commento vuoto, scrivere prima di pubblicare!");
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var content = document.getElementById("content");
        var creaCommento = document.getElementById("creaCommento");

        var boxRect=document.createElement("div");
        boxRect.setAttribute("class","boxRect hflex");
        
        var avatarBox = document.createElement("div");
        avatarBox.setAttribute("class","avatarBox vflex");

        var avatar = document.createElement("div");
        avatar.setAttribute("class","avatar");
        
        var username = document.createElement("label");
        username.setAttribute("for","username");
        username.innerHTML=getCookie("username");

        var commento = document.createElement("div");
        commento.setAttribute("class","commento vflex");

        var p = document.createElement("p");
        p.innerHTML = txtAreaCommento.value;
        p.setAttribute("class","testo");

        var gestioneCommento = document.createElement("div");
        gestioneCommento.setAttribute("class","gestioneCommento hflex");

        var buttonLike = document.createElement("button");
        buttonLike.innerHTML="Like";
        buttonLike.setAttribute("class", "like unpressed");
        buttonLike.setAttribute("onclick", "likeComment()");

        var buttonDislike = document.createElement("button");
        buttonDislike.innerHTML="Dislike";
        buttonDislike.setAttribute("class", "dislike unpressed");
        buttonDislike.setAttribute("onclick", "dislikeComment()");

        var buttonCancella = document.createElement("button");
        buttonCancella.innerHTML="Cancella";
        buttonCancella.setAttribute("class","cancella");
        var dataCreazione = document.createElement("p");
        dataCreazione.setAttribute("class","dataCreazione");
        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
        dataCreazione.innerHTML=utc;

        gestioneCommento.appendChild(buttonLike);
        gestioneCommento.appendChild(buttonDislike);
        gestioneCommento.appendChild(buttonCancella);
        gestioneCommento.appendChild(dataCreazione);

        commento.appendChild(p);
        commento.appendChild(gestioneCommento);
        
        avatarBox.appendChild(avatar);
        avatarBox.appendChild(username);

        boxRect.appendChild(avatarBox);
        boxRect.appendChild(commento);

        content.insertBefore(boxRect,creaCommento);
      }
    };
   
    xhttp.open("POST", "./PHP/createComment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("comment="+txtAreaCommento.value);
}

function likeComment() {
  var dislike = event.target.nextElementSibling;
  var xhttp;
  var opinion = 0;
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(event.target.getAttribute("class") == "like unpressed")
      {
        event.target.setAttribute("class","like pressed");
        opinion = 1;
        if(dislike.getAttribute("class") =="dislike pressed")
        {
          dislike.setAttribute("class","dislike unpressed");
          opinion = 2;
        }
      }
      else
      {
        event.target.setAttribute("class","like unpressed");
        opinion = -1;
      }
    }
  };
   
  xhttp.open("POST", "./PHP/opinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion);
}

function dislikeComment() {
  var like = event.target.previousElementSibling;
  var xhttp;
  var opinion = 0;
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(event.target.getAttribute("class")=="dislike unpressed")
      {
        event.target.setAttribute("class","dislike pressed");
        opinion = -1;

        if(like.getAttribute("class")=="like pressed")
        {
          like.setAttribute("class","like unpressed");
          opinion = -2;
        }
      }
      else
      {
        event.target.setAttribute("class","dislike unpressed");
        opinion = 1;
      }
    }
  };

  xhttp.open("POST", "./PHP/opinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion);
}