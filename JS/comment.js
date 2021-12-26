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
        username.innerHTML="Username";

        var commento = document.createElement("div");
        commento.setAttribute("class","commento vflex");

        var p = document.createElement("p");
        p.innerHTML = txtAreaCommento.value;

        var gestioneCommento = document.createElement("div");
        gestioneCommento.setAttribute("class","gestioneCommento hflex");

        var buttonLike = document.createElement("button");
        buttonLike.innerHTML="Like";
        var buttonDislike = document.createElement("button");
        buttonDislike.innerHTML="Dislike";
        var buttonCancella = document.createElement("button");
        buttonCancella.innerHTML="Cancella";
        buttonCancella.setAttribute("class","btnCancella");

        gestioneCommento.appendChild(buttonLike);
        gestioneCommento.appendChild(buttonDislike);
        gestioneCommento.appendChild(buttonCancella);

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

