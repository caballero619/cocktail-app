function checkLanguage(){
    var drinkID = this.getAttribute("data-id");
    var langTarget = this.getAttribute("data-lang");
    var targetP = document.getElementById("drink"+drinkID).getElementsByClassName('instructions');
   
    for(var i = 0; i< targetP.length; i++){
        if(targetP[i].getAttribute("data-lang") == langTarget){
            targetP[i].classList.remove("visually-hidden");
        }else{
            targetP[i].classList.add("visually-hidden");
        }
    }
    
}

var langToggle =  document.getElementsByClassName('lang-toggle');
window.onload = function(){
    for (var i = 0; i < langToggle.length; i++) {
        langToggle[i].addEventListener('click', checkLanguage, false);
    }
}