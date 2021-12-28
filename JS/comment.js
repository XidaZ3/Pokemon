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

        if(this.responseText == -1)
        {
          txtAreaCommento.value="Devi loggarti prima di pubblicare!";
        }
        else
        {
          var content = document.getElementById("content");
          var creaCommento = document.getElementById("creaCommento");
          var boxRect = document.createElement("div");
          content.insertBefore(boxRect,creaCommento);
          boxRect.outerHTML = this.responseText;
        }
      }
    };
   
    xhttp.open("POST", "./PHP/createComment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("comment="+txtAreaCommento.value);
}

function likeComment() {
  var dislike = event.target.nextElementSibling;
  var like = event.target;
  var xhttp;
  var opinion = 0;
  var commentid = event.target.parentElement.parentElement.parentElement.getAttribute("id");
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(like.getAttribute("class") == "like unpressed")
      {
        like.setAttribute("class","like pressed");      
        if(dislike.getAttribute("class") =="dislike pressed")
          dislike.setAttribute("class","dislike unpressed");
      }
      else
        like.setAttribute("class","like unpressed");
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

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        if(like.getAttribute("class")=="like pressed")
          like.setAttribute("class","like unpressed");
      }
      else
        dislike.setAttribute("class","dislike unpressed");
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

function dislikeComment() {
  var like = event.target.previousElementSibling;
  var dislike = event.target;
  var xhttp = new XMLHttpRequest();
  var opinion = 0;
  var commentid = event.target.parentElement.parentElement.parentElement.getAttribute("id");

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        if(like.getAttribute("class")=="like pressed")
          like.setAttribute("class","like unpressed");
      }
      else
        dislike.setAttribute("class","dislike unpressed");
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
  var commentid = event.target.parentElement.parentElement.parentElement.getAttribute("id");

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(like.getAttribute("class") == "like unpressed")
      {
        like.setAttribute("class","like pressed");      
        if(dislike.getAttribute("class") =="dislike pressed")
          dislike.setAttribute("class","dislike unpressed");
      }
      else
        like.setAttribute("class","like unpressed");
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

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        if(like.getAttribute("class")=="like pressed")
          like.setAttribute("class","like unpressed");
      }
      else
        dislike.setAttribute("class","dislike unpressed");
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