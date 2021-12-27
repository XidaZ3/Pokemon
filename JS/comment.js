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
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(like.getAttribute("class") == "like unpressed")
      {
        like.setAttribute("class","like pressed");
        opinion = 1;
        if(dislike.getAttribute("class") =="dislike pressed")
        {
          dislike.setAttribute("class","dislike unpressed");
          opinion = 2;
        }
      }
      else
      {
        like.setAttribute("class","like unpressed");
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
  var dislike = event.target;
  var xhttp;
  var opinion = 0;
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(dislike.getAttribute("class")=="dislike unpressed")
      {
        dislike.setAttribute("class","dislike pressed");
        opinion = -1;

        if(like.getAttribute("class")=="like pressed")
        {
          like.setAttribute("class","like unpressed");
          opinion = -2;
        }
      }
      else
      {
        dislike.setAttribute("class","dislike unpressed");
        opinion = 1;
      }
    }
  };

  xhttp.open("POST", "./PHP/opinion.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("opinion="+opinion);
}