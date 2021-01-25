
function myfunction(){
    //cache les tous select
  var elements =  document.getElementsByClassName('mois');
  for (var i =0; i<elements.length; i++)
  {
    elements[i].style.visibility="hidden";
    elements[i].style.display="none";

  };
    //recupere l'id du visiteur selectionné et affiche les mois liés
var id = document.getElementById('lstVisiteur').value;
document.getElementById(id).style.visibility="visible";
document.getElementById(id).style.display="block";


}
