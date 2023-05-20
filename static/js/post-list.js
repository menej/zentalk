
document.addEventListener("DOMContentLoaded", function() {
    let clickableDivs = document.getElementsByClassName("clickable-div");
    for (let i = 0; i < clickableDivs.length; i++) {
        clickableDivs[i].addEventListener("click", function() {
            window.location.href = this.getAttribute("data-url");
        });
    }
})
