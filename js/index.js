import '../sass/main.scss' // stupid.

const $burger = document.querySelector('#toggle-nav')
const $nav = document.querySelector('#main-nav')

$burger.onclick = function() {
  $burger.classList.toggle('is-active')
  $nav.classList.toggle('is-active')
}
