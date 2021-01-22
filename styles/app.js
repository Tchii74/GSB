
function myfunction(){
    //
  var elements =  document.getElementsByClassName('toto');
  for (var i =0; i<elements.length; i++)
  {
    elements[i].style.visibility="hidden";
    elements[i].style.display="none";

  };
    //recupere l'id du visiteur selectionné et affiche les mois liés
$id = document.getElementById('Visiteur').value;
document.getElementById($id).style.visibility="visible";
document.getElementById($id).style.display="block";


}
