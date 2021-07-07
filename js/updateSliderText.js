function updateSliderText(){
    //Update du texte correspondant au slider du nombre de joueurs
        range.noUiSlider.on("update", function(values, handle){
            txt=document.getElementById("nbTxt");
            //console.log(values);
            values[0] = parseInt(values[0], 10);
            values[1] = parseInt(values[1], 10);
            //console.log(values);
            if (values[0]==values[1])
            {
                txt.innerHTML=values[0] + " joueurs";
            }
            else if (values[0]==1)
            {
                txt.innerHTML="Moins de " +values[1]+" joueurs"
            }
            else{
                txt.innerHTML="Entre "+values[0]+" et "+values[1]+" joueurs"
            }
        })
        try
        {
            document.getElementById("desc").value = localStorage.getItem("text");
        }
        catch(e)
        {
        }
    }