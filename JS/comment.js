function createUserComment() {
    var xhttp = new XMLHttpRequest();
    var txtAreaCommento=document.getElementById("textCommento");
    if (txtAreaCommento.value == "") {
        txtAreaCommento.setAttribute("placeholder", "Commento vuoto, scrivere prima di pubblicare!");
        return;
    }
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

        if(this.responseText == -1)
          txtAreaCommento.setAttribute("placeholder", "Devi loggarti prima di pubblicare!");
        else
        {
          var content = document.getElementById("content");
          var creaCommento = document.getElementById("creaCommento");
          var boxRect = document.createElement("div");
          content.insertBefore(boxRect,creaCommento);
          boxRect.outerHTML = this.responseText;
        }
        txtAreaCommento.value="";
      }
    };
   
    xhttp.open("POST", "./PHP/createComment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("comment="+txtAreaCommento.value);
}

function likeComment() {
  var dislike = event.target.nextElementSibling;
  var like = event.target;
  var xhttp = new XMLHttpRequest();
  var opinion = 0;
  var commentid = event.target.parentElement.parentElement.parentElement.getAttribute("id");
  var karmaTag = document.getElementById("karmacommento".concat(commentid.substring(2)));

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(like.getAttribute("class") == "like unpressed")
      {
        like.setAttribute("class","like pressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) +1;
        if(dislike.getAttribute("class") =="dislike pressed"){
          dislike.setAttribute("class","dislike unpressed");
          karmaTag.innerText = parseInt(karmaTag.innerText) +1;
        }
          
      }
      else{
        like.setAttribute("class","like unpressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) -1;
      }
        
    }
  };
   
  if(like.getAttribute("class")=="like unpressed")
    opinion = 1;
  else
    opinion = 0;

  xhttp.open("POST", "./PHP/opinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion+"&commentid="+commentid);
}

function dislikeComment() {
  var like = event.target.previousElementSibling;
  var dislike = event.target;
  var xhttp = new XMLHttpRequest();
  var opinion = 0;
  var commentid = event.target.parentElement.parentElement.parentElement.getAttribute("id");
  var karmaTag = document.getElementById("karmacommento".concat(commentid.substring(2)));

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) -1;
        if(like.getAttribute("class")=="like pressed"){
          like.setAttribute("class","like unpressed");
          karmaTag.innerText = parseInt(karmaTag.innerText) -1;
        }
          
      }
      else{
        dislike.setAttribute("class","dislike unpressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) +1;
      }
        
    }
  };

  if(dislike.getAttribute("class")=="dislike unpressed")
    opinion = -1;
  else
    opinion = 0;

  xhttp.open("POST", "./PHP/opinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion+"&commentid="+commentid);
}


function likeContenuto(){
  var dislike = event.target.nextElementSibling;
  var like = event.target;
  var xhttp = new XMLHttpRequest();
  var opinion = 0;
  var contenutoid = event.target.parentElement.getAttribute("id");
  var karmaTag = document.getElementById("kc".concat(contenutoid.substring(2)));
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(like.getAttribute("class") == "like unpressed")
      {
        like.setAttribute("class","like pressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) +1;
        if(dislike.getAttribute("class") =="dislike pressed"){
          karmaTag.innerText = parseInt(karmaTag.innerText) +1;
          dislike.setAttribute("class","dislike unpressed");
        }
          
      }
      else{
        like.setAttribute("class","like unpressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) -1;
      }
        
    }
  };
   
  if(like.getAttribute("class")=="like unpressed")
    opinion = 1;
  else
    opinion = 0;

  xhttp.open("POST", "./PHP/contentOpinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion);
}

function dislikeContenuto(){
  var like = event.target.previousElementSibling;
  var dislike = event.target;
  var xhttp = new XMLHttpRequest();;
  var opinion = 0;
  var contenutoid = event.target.parentElement.getAttribute("id");
  var karmaTag = document.getElementById("kc".concat(contenutoid.substring(2)));
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) -1;
        if(like.getAttribute("class")=="like pressed"){
          karmaTag.innerText = parseInt(karmaTag.innerText) -1;
          like.setAttribute("class","like unpressed");
        }
          
      }
      else{
        dislike.setAttribute("class","dislike unpressed");
        karmaTag.innerText = parseInt(karmaTag.innerText) +1;
      }
        
    }
  };

  if(dislike.getAttribute("class")=="dislike unpressed")
    opinion = -1;
  else
    opinion = 0;

  xhttp.open("POST", "./PHP/contentOpinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion);
}

function deleteComment(){
  var popup=document.createElement("div");
  var parentClose = event.target.parentElement;
  popup.setAttribute("id", "popUp");
  popup.innerHTML = "Sei sicuro di voler cancellare il tuo commento?";

  var conferma = document.createElement("div");
  conferma.setAttribute("id","confermaCancella");
  var si=document.createElement("button");
  si.setAttribute("onclick","confirmDelete()");
  si.innerHTML = "Sì";
  var no=document.createElement("button");
  no.setAttribute("onclick","closePopUp()");
  no.innerHTML = "No";

  conferma.appendChild(si);
  conferma.appendChild(no);
  popup.appendChild(conferma);

  var popupWrapper = document.createElement("div");
  popupWrapper.setAttribute("id","popUpWrapper");
  popupWrapper.appendChild(popup);

  parentClose.appendChild(popupWrapper);
}

function confirmDelete(){
  var xhttp = new XMLHttpRequest();
  var comment = event.target.parentElement.parentElement.parentElement.parentElement.parentElement;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      comment.remove();
      closePopUp();
    };
  }
  xhttp.open("POST", "./PHP/deleteComment.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("commentid="+comment.getAttribute("id"));
}

function closePopUp()
{
   document.getElementById("popUpWrapper").remove();
}