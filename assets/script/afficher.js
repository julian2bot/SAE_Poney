
// script pour affiché les logins/ signIn dans la page d'accueil


document.querySelectorAll('.affichelogin').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); 
        
        event.stopPropagation();  // Empêche la propagation du clic vers l'écouteur global
        afficheLogin()
        closeSignIn();
        // close signIn
    });
});






document.addEventListener('click', function(event) {
    const loginDiv = document.getElementById('login');
    const signInDiv = document.getElementById('signIn');
    console.log("clique" + " " + document.getElementById('login').style.display)
    const bouton = document.querySelectorAll('.affichelogin'); 

    if (!loginDiv.contains(event.target) && loginDiv.style.display === "flex" || !signInDiv.contains(event.target) && signInDiv.style.display === "flex") {
        closeLogin();
        closeSignIn();
    }
});

function afficheLogin(){
    document.getElementById('login').style.display = "flex";
}
function closeLogin() {
    document.getElementById('login').style.display = "none";
    
}


document.querySelectorAll('.afficheSignIn').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); 
        event.stopPropagation();  // Empêche la propagation du clic vers l'écouteur global
        
        console.log("ez");
        afficheSignIn();
        // close signIn
        closeLogin();
    });
});




function afficheSignIn(){
    document.getElementById('signIn').style.display = "flex";
}
function closeSignIn() {
    document.getElementById('signIn').style.display = "none";
    
}