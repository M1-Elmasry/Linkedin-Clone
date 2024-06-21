const API = 'http://localhost/'

const mainEl = document.getElementById("MainBody")
const loginEl = document.getElementById("LoginForm")
const ErrBox = document.getElementById("ErrorBox")

//console.log(document.cookie.match(/^(.*;)?\s*PHPSESSID\s*=\s*[^;]+(.*)?$/))
// helpers
function SwitchForms() {
    ErrBox.innerHTML = ''
    mainEl.classList.toggle('registering')
    return false
}
function redirectToPage(from, to = "index.html") {
    window.location.href = window.location.href.replace(from, to)
}
function HandleErrors(errs) {
    ErrBox.innerHTML = ''
    if(Array.isArray(errs)) {
        for(err of errs) {
            ErrBox.innerHTML += '<p>' + err + '<?p>'
        }
        return
    }
    ErrBox.innerHTML+= '<p>' + errs + '<?p>'
}
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
// calls
async function OnLogin(e) {
    e.preventDefault()
    let formData = new FormData(e.target);
    formData.append("Authorization", `Bearer ${window.localStorage.getItem("userToken")}`)
    const response = await fetch(API + 'login', {
        credentials: "same-origin",
        method: "POST",
        body: formData
    })
    res = await response.json()

    if(!res['status']) {
        HandleErrors(res['data'])
        return
    }
    window.localStorage.setItem("userToken", res['data'])

    //redirectToPage("login.html");
}

async function OnRegister(e) {
    e.preventDefault()

    let formData = new FormData(e.target);
    if(!formData.has("is_recruiter")) {
        formData.append("is_recruiter", false);
    }
    const response = await fetch(API + 'register', {
        method: "POST",
        body: new URLSearchParams(formData),
    })
    res = await response.json()

    if(!res['status']) {
        HandleErrors(res['data'])
        return
    }

    redirectToPage("login.html");
}