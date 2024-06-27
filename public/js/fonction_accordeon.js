function toggleDescription(element) {

    const descriptionId = element.nextElementSibling.getAttribute("id");

    const descriptionElement = document.getElementById(descriptionId);
    
    descriptionElement.style.display = descriptionElement.style.display === "none" ? "block" : "none";
    
}