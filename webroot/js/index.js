function clignotement(){ 
if (document.getElementById("inscription").style.display=="block") 
document.getElementById("inscription").style.display="none"; 
else 
document.getElementById("inscription").style.display="block"; 
} 
// mise en place de l appel régulier de la fonction toutes les 0.5 secondes 
setInterval("clignotement()", 1000); 