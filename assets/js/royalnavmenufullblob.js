var royalnavmenufullblob = document.querySelector('#royalnavmenufullblobtoggle'); 
var royalnavmenufullblobItems = document.querySelector('#royalnavmenufullbloboverlay');  
var royalnavmenufullblobContainer = document.querySelector('.royalnavmenufullblob-container');  
var royalnavmenufullblobIcon = document.querySelector('.royalnavmenufullblob i');  
function toggleMenu(e) {
    royalnavmenufullblobItems.classList.toggle('open');
    royalnavmenufullblobContainer.classList.toggle('full-menu');
    royalnavmenufullblobIcon.classList.toggle('fa-bars');
    royalnavmenufullblobIcon.classList.toggle('fa-times');    
    // e.preventDefault();
}

if(royalnavmenufullblob){
    royalnavmenufullblob.addEventListener('click', toggleMenu, false);
}
