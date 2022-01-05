let darkmode = localStorage.getItem('darkmode');
const darkmodetoggle = document.querySelector('#dark-mode-toggle');

//check if dark omode is enable and turn off, else on

const enabledarkmode = () =>{
    //add class dark mode to body
    document.body.classList.add("darkmode");
    //update darkmode to localstorage
    localStorage.setItem("darkmode" ,"enabled");
    
};

const disabledarkmode = () =>{
    //remove class dark mode to body
    document.body.classList.remove("darkmode");
    //disupdate darkmode to localstorage
    localStorage.setItem("darkmode" ,null);
};

//rimanga anche se aggiorni
if(darkmode === "enabled"){
    enabledarkmode();
}


darkmodetoggle.addEventListener("click", ()=>{
    darkmode = localStorage.getItem("darkmode");
    if(darkmode !== "enabled"){
        enabledarkmode();

    }else{
        disabledarkmode();
    }
})

/*var checkbox = document.querySelector('input[name=theme]');
checkbox.addEventListener('change', function() {
   if(this.checked){
       trans()
       document.documentElement.setAttribute('data-theme', 'dark')
   }
   else{
       trans()
       document.documentElement.setAttribute('data-theme', 'light')
   }
})
let trans=()=>{
   document.documentElement.classList.add('transition');
   window.setTimeout(() => {
       document.documentElement.classList.remove('transition')
   },1000)
}*/

