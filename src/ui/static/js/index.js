const API = 'http://localhost/'

const profileMenu = document.getElementById("profileMenu")
const navbar = document.getElementById("Navbar")
const PostsList = document.getElementById("PostsList")
const applyModal = document.getElementById('applyModal');
const postTemplate = PostsList.children[0]

var userToken = window.localStorage.getItem("userToken")
var selectedJob = null

PostsList.children[0].remove()

window.onload = async function() {
    if(IsAuthenticated()) {
        SwitchOnline();
    }
    let posts = await GetLatestPosts()
    posts = posts.data

    for (let i = 0; i < posts.length; i++) {
        const post = posts[i];
        const el = postTemplate.cloneNode(true)
        
        el.querySelector(".postPosition").innerHTML = post['position']
        el.querySelector(".company").innerHTML = `${post['company']} <span class="location">- ${post['location']}</span>`
        el.querySelector(".posted").innerHTML = `posted ${post['created_at']}`
        el.querySelector(".apply-btn").addEventListener('click', (e) => {
            OpenModal(post['id'])
        })
        el.querySelector(".details-btn").addEventListener('click', (e) => {
            toggleDetails(el)
        })
        el.querySelector(".salary-value").innerHTML = post['salary'] != 0 ? post['salary'] + '$' : 'Confidential'
        el.querySelector(".industry-value").innerHTML = post['industry']
        el.querySelector(".description").innerHTML = post['description']

        PostsList.appendChild(el);
    }
};

function toggleMenu() {
    profileMenu.classList.toggle("open-menu");
}
function IsAuthenticated() {
    return userToken !== null
}
function SwitchOnline() {
    navbar.classList.toggle('online')
}
function redirectToPage(from, to = "index.html") {
    window.location.href = window.location.href.replace(from, to)
}

// post model
function toggleDetails(parent) {
    const details = parent.querySelector('#job-details');
    details.style.display = details.style.display === 'none' || details.style.display === '' ? 'block' : 'none';
  }
  
  function toggleComments(parent) {
    const commentsContainer = parent.querySelector('#comments-container');
    commentsContainer.style.display = commentsContainer.style.display === 'none' || commentsContainer.style.display === '' ? 'block' : 'none';
  }
  
  function OpenModal(id) {
    applyModal.style.display = 'block';
  }
  
  function closeModal() {
    applyModal.style.display = 'none';
  }
  
  window.onclick = function (event) {
    if (event.target == applyModal) {
        applyModal.style.display = 'none';
    }
  };
// calls
async function GetLatestPosts() {
    const response = await fetch(API + 'post/latest', {
        credentials: "same-origin",
        method: "GET"
    })
    return response.json()
}
async function Logout() {
    toggleMenu()
    let formData = new FormData();
    formData.append('Authorization', `Bearer ${userToken}`)
    const response = await fetch(API + 'logout', {
        credentials: "same-origin",
        method: "POST",
        body: formData
    })
    let res = response.json()
    if(res['status'] == false) {
        console.log('logout failed')
        return
    }
    window.localStorage.removeItem('userToken')
    userToken = null
    SwitchOnline(false)
}