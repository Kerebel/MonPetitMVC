function creationXHR() {
    var resultat=null;
    try { //test pour les navigateurs : Mozilla, Opéra, ...
            resultat= new XMLHTTPRequest();
    }
    catch (Erreur) {
    try {//test pour les navigateurs Internet Explorer > 5.0
    resultat= new ActiveXObject("Msxm12.XMLHTTP");
    }
    catch (Erreur) {
        try {// test pour le navigateur Internet Explorer 5.0
        resultat= new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (Erreur) {
            resultat= null;
        }
    }
}
return resultat;
}