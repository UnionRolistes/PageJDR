function updateSliderText(){
    //Update du texte correspondant au slider du nombre de joueurs
        range.noUiSlider.on("update", function(values, handle){
            txt=document.getElementById("nbTxt");
            //console.log(values);
            values[0] = parseInt(values[0], 10);
            values[1] = parseInt(values[1], 10);
            //console.log(values);

            //On met à jour l'input caché qui sert à l'envoi des données :
            nbJoueurs=document.getElementById("nbJoueurs");

            if (values[0]==values[1])
            {
                if (values[0]==1){
                    txt.innerHTML="1 joueur"; //Pour le cas où on a qu'un seul joueur 
                    nbJoueurs.value="1 joueur";
                }
                else{
                    txt.innerHTML=values[0] + " joueurs";
                    nbJoueurs.value=values[0] + " joueurs";
                }              
            }
            else if (values[0]==1)
            {
                txt.innerHTML="Moins de " +values[1]+" joueurs";
                nbJoueurs.value="Moins de " +values[1]+" joueurs";
            }
            else{
                txt.innerHTML="Entre "+values[0]+" et "+values[1]+" joueurs";
                nbJoueurs.value="Entre "+values[0]+" et "+values[1]+" joueurs";
            }
        })
}