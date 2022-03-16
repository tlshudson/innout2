(function () {
  const menuToggle = document.querySelector('.menu-toogle')
  menuToggle.onclick = function (e) {
    const body = document.querySelector('body')
    body.classList.toggle('hide-sidebar')
  }
})()
