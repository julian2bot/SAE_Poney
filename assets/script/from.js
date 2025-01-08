// gestion des labels dans le formulaires d'accueil (pour ne pas avoir de label et quand on clique sur l'input le label pop pendant que le placeholder disparait)

function afficheLabel(name){    
    document.querySelector('label[for="'+name+'"]').style.visibility = "visible";;
}

function desafficheLabel(name){    
    document.querySelector('label[for="'+name+'"]').style.visibility = "hidden";;
    document.getElementsByName(name).placeholder = "new text";
}
var inputs = document.querySelectorAll('input');
const dico_inputs = {}

inputs.forEach(function(input) {
    input.addEventListener("focus", function() {
        dico_inputs[input.getAttribute('name')] = input.placeholder;
        this.placeholder = "";
    });

    input.addEventListener('click', function() {      
        console.log("Input cliqué: " + this.getAttribute('name'));
        afficheLabel(this.getAttribute('name'));
    });
    
    input.addEventListener("blur", function() {
        // this.placeholder = "UserName"; // Remet le placeholder quand l'input perd le focus (facultatif)

        console.log(input.value)
        if(this.value === ""){
            console.log(dico_inputs)
            console.log("dsf")
            input.placeholder = dico_inputs[input.getAttribute('name')] 
            desafficheLabel(input.getAttribute('name'))
        }
    });

});
