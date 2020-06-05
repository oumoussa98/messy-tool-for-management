
// Get the modal
var modal = document.getElementById('popupdiv');
var modal2 = document.getElementById('popupForm');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        modal2.style.display = "none";
        window.scrollTo(0, 0);
    }
}

window.onbeforeunload = function () {
  window.scrollTo(0, 0);
};
