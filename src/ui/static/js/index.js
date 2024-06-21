let profileMenu = document.getElementById("profileMenu")
let navbar = document.getElementById("Navbar")
let isLoggedIn = false
function toggleMenu() {
profileMenu.classList.toggle("open-menu");
}

function SwitchOnline() {
    isLoggedIn = !isLoggedIn
    navbar.classList.toggle('online')
}

console.log(document.cookie.match(/^(.*;)?\s*PHPSESSID\s*=\s*[^;]+(.*)?$/))