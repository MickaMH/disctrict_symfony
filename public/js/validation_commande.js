let formulaireCommandeValide = document.getElementById("envoi_commande");


let quantite = document.getElementById("quantite");
let quantiteVerif = /^([1-9][0-9]?|100)$/
;

let nom = document.getElementById("nom");
let nomVerif = /^[a-zA-Z][a-zA-Z' -]{1,50}$/;
        
let prenom = document.getElementById("prenom");
let prenomVerif = /^[a-zA-Z][a-zA-Z' -]{1,20}$/;

let mail = document.getElementById("mail");
let mailVerif = /^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
/*let mailVerif = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;*/

let phone = document.getElementById("phone");             
let phoneVerif = /^[0-9]{10}$/;
                                                                                    
let adresse = document.getElementById("adresse");                 
let adresseVerif = /^\d+\s+.+(?=.*\d)(?=.*\d{5})(?=.*[a-zA-Z\s]).*$/;


let requisQuantite = document.getElementById("requisQuantite"); 

let requisNom = document.getElementById("requisNom");
                                                             
let requisPrenom = document.getElementById("requisPrenom");

let requisMail = document.getElementById("requisMail");

let requisPhone = document.getElementById("requisPhone"); 

let requisAdresse = document.getElementById("requisAdresse");



        formulaireCommandeValide.addEventListener("click", validationCommande);
            
            function validationCommande(event)
           
{
// QUANTITE (quantite)


                if (quantite.validity.valueMissing)
                {
                    event.preventDefault();
                    requisQuantite.textContent = "\u26a0";
                    requisQuantite.style.fontSize = "1.2rem";
                    requisQuantite.style.fontWeight = "normal";
                    requisQuantite.style.color = "red";
                    requisQuantite.style.fontFamily = "helvetica";
                    requisQuantite.className = "ms-1 ms-lg-1 mt-3 mt-lg-3";
                    quantite.style.borderColor = "red";
                }

                else if (quantiteVerif.test(quantite.value) == false)                                      
                {
                    event.preventDefault();
                    requisQuantite.textContent = "\u26a0";
                    requisQuantite.style.fontSize = "1.2rem";
                    requisQuantite.style.color = "orange";
                    requisQuantite.style.fontWeight = "normal";
                    requisQuantite.style.fontFamily = "helvetica";
                    quantite.style.borderColor = "orange";
                }

                else
                {
                    requisQuantite.textContent = "\u2713";
                    requisQuantite.style.fontSize = "1.2rem";
                    requisQuantite.style.color = "green";
                    requisQuantite.style.fontFamily = "helvetica";
                    requisQuantite.style.fontWeight = "normal";
                    quantite.style.borderColor = "#980848";
                }


/*NOM (nom)*/   


                if (nom.validity.valueMissing)
                {
                    event.preventDefault();
                    requisNom.textContent = "\u26a0 Ce champ est obligatoire";
                    requisNom.style.fontSize = "1.2rem";
                    requisNom.style.fontWeight = "normal";
                    requisNom.style.color = "red";
                    requisNom.style.fontFamily = "helvetica";  
                    nom.style.borderColor = "red";         
                }

                else if (nomVerif.test(nom.value) == false)
                {                
                    event.preventDefault();
                    requisNom.textContent = "\u26a0 Vérifiez l'orthographe du nom";
                    requisNom.style.fontSize = "1.2rem";
                    requisNom.style.fontWeight = "normal";
                    requisNom.style.color = "orange";        
                    requisNom.style.fontFamily = "helvetica";
                    nom.style.borderColor = "orange";
                    nom.placeholder= "sans accents";
                }

                else
                {
                    requisNom.textContent = "\u2713";
                    requisNom.style.fontSize = "1.2rem";
                    requisNom.style.color = "green";
                    requisNom.style.fontFamily = "helvetica";
                    requisNom.style.fontWeight = "normal";
                    nom.style.borderColor = "#980848";
                }

                
/*PRENOM (prenom)*/
                

                if (prenom.validity.valueMissing)
                {
                    event.preventDefault();
                    requisPrenom.textContent = "\u26a0 Ce champ est obligatoire";
                    requisPrenom.style.fontSize = "1.2rem";
                    requisPrenom.style.fontWeight = "normal";
                    requisPrenom.style.color = "red";
                    requisPrenom.style.fontFamily = "helvetica";
                    prenom.style.borderColor = "red";
                }

                else if (prenomVerif.test(prenom.value) == false)                       
                {
                    event.preventDefault();
                    requisPrenom.textContent = "\u26a0 Vérifiez l'orthographe du prénom";
                    requisPrenom.style.fontSize = "1.2rem";
                    requisPrenom.style.fontWeight = "normal";
                    requisPrenom.style.color = "orange";
                    requisPrenom.style.fontFamily = "helvetica";
                    prenom.style.borderColor = "orange";
                    prenom.placeholder= "sans accents";
                }

                else
                {
                    requisPrenom.textContent = "\u2713";
                    requisPrenom.style.fontSize = "1.2rem";
                    requisPrenom.style.color = "green";
                    requisPrenom.style.fontFamily = "helvetica";
                    requisPrenom.style.fontWeight = "normal";
                    prenom.style.borderColor = "#980848";
                }


/*TELEPHONE (phone)*/


                if (phone.validity.valueMissing)
                {
                    event.preventDefault();
                    requisPhone.textContent = "\u26a0 Ce champ est obligatoire";
                    requisPhone.style.fontSize = "1.2rem";
                    requisPhone.style.fontWeight = "normal";
                    requisPhone.style.color = "red";
                    requisPhone.style.fontFamily = "helvetica";
                    phone.style.borderColor = "red";
                }

                else if (phoneVerif.test(phone.value) == false)                                      
                {
                    event.preventDefault();
                    requisPhone.textContent = "\u26a0 Ce numéro n'est pas correct";
                    requisPhone.style.fontSize = "1.2rem";
                    requisPhone.style.color = "orange";
                    requisPhone.style.fontWeight = "normal";
                    requisPhone.style.fontFamily = "helvetica";
                    phone.style.borderColor = "orange";
                    phone.placeholder= "ex: 0123456789";
                }

                else
                {
                    requisPhone.textContent = "\u2713";
                    requisPhone.style.fontSize = "1.2rem";
                    requisPhone.style.color = "green";
                    requisPhone.style.fontFamily = "helvetica";
                    requisPhone.style.fontWeight = "normal";
                    phone.style.borderColor = "#980848";
                }


/*EMAIL (mail)*/


                if (mail.validity.valueMissing)
                {
                    event.preventDefault();
                    requisMail.textContent = "\u26a0 Ce champ est obligatoire";
                    requisMail.style.fontSize = "1.2rem";
                    requisMail.style.fontWeight = "normal";
                    requisMail.style.color = "red";
                    requisMail.style.fontFamily = "helvetica";
                    mail.style.borderColor = "red";
                }

                else if (mailVerif.test(mail.value) == false)                                  
                {
                    event.preventDefault();                                                 
                    requisMail.textContent = "\u26a0 Cette adresse mail n'est pas valide";
                    requisMail.style.fontSize = "1.2rem";
                    requisMail.style.fontWeight = "normal";
                    requisMail.style.color = "orange";
                    requisMail.style.fontFamily = "helvetica";
                    mail.style.borderColor = "orange";
                    mail.placeholder= "ex: dave.loper@afpa.fr";
                }                               

                else
                {
                    requisMail.textContent = "\u2713";
                    requisMail.style.fontSize = "1.2rem";
                    requisMail.style.color = "green";
                    requisMail.style.fontFamily = "helvetica";
                    requisMail.style.fontWeight = "normal";
                    mail.style.borderColor = "#980848";
                }

                
/*ADRESSE (adresse)*/


                if (adresse.validity.valueMissing)
                {
                    event.preventDefault();
                    requisAdresse.textContent = "\u26a0 Ce champ est obligatoire";
                    requisAdresse.style.fontSize = "1.2rem";
                    requisAdresse.style.color = "red";
                    requisAdresse.style.fontWeight = "normal";
                    requisAdresse.style.fontFamily = "helvetica";
                    adresse.style.borderColor = "red";
                }

                else if (adresseVerif.test(adresse.value) == false)                                  
                {
                    event.preventDefault();
                    requisAdresse.textContent = "\u26a0 Cette adresse n'est pas correcte";
                    requisAdresse.style.fontSize = "1.2rem";
                    requisAdresse.style.color = "orange";
                    requisAdresse.style.fontWeight = "normal";
                    requisAdresse.style.fontFamily = "helvetica";
                    adresse.style.borderColor = "orange";
                    adresse.placeholder= "ex : 1 rue du boulevard 75000 Paris";
                }

                else
                {
                    requisAdresse.textContent = "\u2713";
                    requisAdresse.style.fontSize = "1.2rem";
                    requisAdresse.style.color = "green";
                    requisAdresse.style.fontFamily = "helvetica";
                    requisAdresse.style.fontWeight = "normal";
                    adresse.style.borderColor = "#980848";
                }

}                                                               
    
/*FIN*/

                                                                