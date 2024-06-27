let formulaireContactValide = document.getElementById("envoi_contact");/*Variable Input Submit pour validation du formulaire lors de l'envoi*/


let nomContact = document.getElementById("nomContact");               /*Variable qui prend la valeur de l'Input Text Nom*/
let nomVerifContact = /^[a-zA-Z][a-zA-Z' -]{1,50}$/;            /*Vérifie 1 lettre Min ou Maj, puis lettres Min ou Maj ou apostrophe ou trait d'union*/

let phoneContact = document.getElementById("phoneContact");             
let phoneVerifContact = /^[0-9]{10}$/;
                                                                                    
let demandeContact = document.getElementById("demandeContact");                 
let demandeVerifContact =  /^[a-zA-Z0-9,'-?!: .]{1,300}$/;                             


let requisNomContact = document.getElementById("requisNomContact");           /*Variables pour Message d'erreur ou Valide*/

let requisPhoneContact = document.getElementById("requisPhoneContact"); 

let requisDemandeContact = document.getElementById("requisDemandeContact");


        formulaireContactValide.addEventListener("click", validationContact);     /*Evènement pour la "validation" du Formulaire lors du "click"*/
            
            function validationContact(event)                              /*Fonction qui gère la "validation" de l'évènement (event)*/
           
                
                                 /*NOM (nom)*/   

{
                if (nomContact.validity.valueMissing)                              /*Si "valeur" du champ "nom" est vide*/
                {
                    event.preventDefault();                                 /*Bloque l'envoi du Formulaire*/
                    requisNomContact.textContent = "\u26a0 Ce champ est obligatoire";     /*Affiche message d'erreur*/
                    requisNomContact.style.fontSize = "1.2rem";                      /*Taille de police du message d'erreur*/
                    requisNomContact.style.fontWeight = "normal";
                    requisNomContact.style.color = "red";                              /*Couleur de police du message d'erreur*/ 
                    requisNomContact.style.fontFamily = "helvetica";  
                    nomContact.style.borderColor = "red";         
                }

                else if (nomVerifContact.test(nomContact.value) == false)                 /*Sinon si "valeur" du champ "nom" différent du Format prévu (nomVerif)*/
                {                
                    event.preventDefault();                                                 /*Bloque l'envoi du Formulaire*/
                    requisNomContact.textContent = "\u26a0 Vérifiez l'orthographe du nom";   /*Affiche message d'erreur*/
                    requisNomContact.style.fontSize = "1.2rem";                                    /*Taille de police du message d'erreur*/
                    requisNomContact.style.fontWeight = "normal";
                    requisNomContact.style.color = "orange";                                       /*Couleur de police du message d'erreur*/           
                    requisNomContact.style.fontFamily = "helvetica";
                    nomContact.style.borderColor = "orange";
                    nomContact.placeholder= "sans accents";
                }

                else                                                        /*Sinon "NOM" valide*/
                {
                    requisNomContact.textContent = "\u2713";                       /*Affiche une Coche*/ 
                    requisNomContact.style.fontSize = "1.2rem";                      /*Taille de police de la Coche*/
                    requisNomContact.style.color = "green";                        /*Couleur de la Coche*/
                    requisNomContact.style.fontFamily = "helvetica";
                    requisNomContact.style.fontWeight = "normal";
                    nomContact.style.borderColor = "#980848";
                }

                              
                                /*TELEPHONE (phone)*/


                if (phoneContact.validity.valueMissing)                 
                {
                    event.preventDefault();
                    requisPhoneContact.textContent = "\u26a0 Ce champ est obligatoire";
                    requisPhoneContact.style.fontSize = "1.2rem";
                    requisPhoneContact.style.fontWeight = "normal";
                    requisPhoneContact.style.color = "red";
                    requisPhoneContact.style.fontFamily = "helvetica";
                    phoneContact.style.borderColor = "red";
                }

                else if (phoneVerifContact.test(phoneContact.value) == false)                                      
                {
                    event.preventDefault();
                    requisPhoneContact.textContent = "\u26a0 Ce numéro n'est pas correct";
                    requisPhoneContact.style.fontSize = "1.2rem";
                    requisPhoneContact.style.color = "orange";
                    requisPhoneContact.style.fontWeight = "normal";
                    requisPhoneContact.style.fontFamily = "helvetica";
                    phoneContact.style.borderColor = "orange";
                    phoneContact.placeholder= "ex: 0123456789";
                }

                else
                {
                    requisPhoneContact.textContent = "\u2713";
                    requisPhoneContact.style.fontSize = "1.2rem";
                    requisPhoneContact.style.color = "green";
                    requisPhoneContact.style.fontFamily = "helvetica";
                    requisPhoneContact.style.fontWeight = "normal";
                    phoneContact.style.borderColor = "#980848";
                }

                
                                /*DEMANDE (demande)*/


                if (demandeContact.validity.valueMissing)                 
                {
                    event.preventDefault();
                    requisDemandeContact.textContent = "\u26a0 Ce champ est obligatoire";
                    requisDemandeContact.style.fontSize = "1.2rem";
                    requisDemandeContact.style.color = "red";
                    requisDemandeContact.style.fontWeight = "normal";
                    requisDemandeContact.style.fontFamily = "helvetica";
                    demandeContact.style.borderColor = "red";
                }

                else if (demandeVerifContact.test(demandeContact.value) == false)                                  
                {
                    event.preventDefault();
                    requisDemandeContact.textContent = "\u26a0 Vérifiez l'orthographe";
                    requisDemandeContact.style.fontSize = "1.2rem";
                    requisDemandeContact.style.color = "orange";
                    requisDemandeContact.style.fontWeight = "normal";
                    requisDemandeContact.style.fontFamily = "helvetica";
                    demandeContact.style.borderColor = "orange";
                    demandeContact.placeholder= "Caractères autorisés: (a-A , 0-9 ,': ,.?!)";
                }

                else
                {
                    requisDemandeContact.textContent = "\u2713";
                    requisDemandeContact.style.fontSize = "1.2rem";
                    requisDemandeContact.style.color = "green";
                    requisDemandeContact.style.fontFamily = "helvetica";
                    requisDemandeContact.style.fontWeight = "normal";
                    demandeContact.style.borderColor = "#980848";
                }

}                                                               
    
                                                                /*FIN*/

                                                                