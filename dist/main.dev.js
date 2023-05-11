"use strict";

var hamburger = document.getElementById('hamburger');
var nav = document.getElementsByClassName('nav')[0];
hamburger.addEventListener('click', function (event) {
  nav.classList.toggle('menu-active');
});
nav.addEventListener('mouseleave', function () {
  nav.classList.remove('menu-active');
});
var torlesModal = document.getElementById('torlesModal');
var hatter = document.getElementsByClassName('modal-hatter')[0];
var btnYes = document.getElementById('btn-yes');

function openTorlesModal() {
  torlesModal.classList.add("open-Modal");
  hatter.style.display = 'block';
}

function closeModal() {
  torlesModal.classList.remove("open-Modal");
  hatter.style.display = 'none';
}

function sorTorles(id) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'torles.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      console.log(xhr.responseText);
      closeModal();
      location.reload();
    }
  };

  xhr.send('id=' + id);
}

btnYes.addEventListener('click', function () {
  var id = document.getElementById('torolt-termek-id').value;
  sorTorles(id);
});
/* const modositoModalID = document.getElementById('modositoModal');
function modositoModal(){
    torlesModal.classList.add("open-Modal");
    hatter.style.display = 'block';
} */

function openModositoModal(id) {
  parseInt(document.getElementById(id)); //Az adatok lekérdezése az azonosító alapján

  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      var adatok = JSON.parse(xhr.responseText);
      document.getElementById('modosito-id').value = adatok[0].id;
      document.getElementById('ISBN').value = adatok[0].ISBN;
      document.getElementById('cim').value = adatok[0].cim;
      document.getElementById('mu_tipusa').value = adatok[0].mu_tipusa;
      document.getElementById('ar').value = adatok[0].ar;
      document.getElementById('szerzo').value = adatok[0].szerzo;
      document.getElementById('mufaj').value = adatok[0].mufaj;
      document.getElementById('szinopszis').value = adatok[0].szinopszis;
      document.getElementById('kiadas_datum').value = adatok[0].kiadas_datum;
      var modal = document.getElementById('modositoModal');
      modal.classList.add('open-Modal');
      hatter.style.display = 'block';
      console.log(adatok);
      console.log(xhr);
    }
  };
  /* xhr.open('POST', "modaladatok.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('id=' + id); */


  xhr.open("GET", "modaladatok.php?id=" + id, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send();
}

var modositoMModal = document.getElementById('modositoModal');

function closeMModal() {
  modositoMModal.classList.remove("open-Modal");
  hatter.style.display = 'none';
}

var ujTermekModal = document.getElementById('ujTermekModal');

function openUjTermekModal() {
  ujTermekModal.classList.add('open-Modal');
  hatter.style.display = 'block';
}

function closeUModal() {
  ujTermekModal.classList.remove('open-Modal');
  hatter.style.display = 'none';
}
/* const products = [
    {
        id: 1,
        title: "A túlsó part",
        type: "Regény",
        price: 3290,
        author: "Magyari András",
        style: "Történelmi",
        cover: "a_hid.png",
    },
    {
        id: 2,
        title: "A következő nap",
        type: "Regény",
        price: 3590,
        author: "Szép Annamária",
        style: "Kaland, túlélés",
        cover: "a_kovetkezo_nap.png",
    },
    {
        id: 3,
        title: "A mező hangjai",
        type: "Verses kötet",
        price: 3290,
        author: "Deák Ágoston",
        style: "Lírai",
        cover: "a_mezo_hangjai.png",
    },
    {
        id: 4,
        title: "Báthory",
        type: "Regény",
        price: 2590,
        author: "Magyari András",
        style: "Thriller",
        cover: "bathory.png",
    },
    {
        id: 5,
        title: "Csodaszarvas",
        type: "Regény",
        price: 5290,
        author: "Kovács Réka",
        style: "Kaland, fantasy",
        cover: "csodaszarvas.png",
    },
    {
        id: 6,
        title: "Emese álma",
        type: "Regény",
        price: 4290,
        author: "Kovács Réka",
        style: "Fantasy",
        cover: "emese_alma.png",
    },
    {
        id: 7,
        title: "Fekete sereg",
        type: "Képregény",
        price: 3290,
        author: "Sörétes Dénes",
        style: "Sötét fantasy, kaland",
        cover: "fekete_sereg.png",
    },
    {
        id: 8,
        title: "Magyar királyok",
        type: "Regény",
        price: 6290,
        author: "Magyari András",
        style: "Történelmi",
        cover: "magyar_kiralyok.png",
    },
    {
        id: 9,
        title: "Pilvax",
        type: "Képregény",
        price: 3290,
        author: "Sörétes Dénes",
        style: "Detektív",
        cover: "pilvax.png",
    },
    {
        id: 10,
        title: "S lőn világosság",
        type: "Regény",
        price: 4290,
        author: "Horváth Lilla",
        style: "Sötét fantasy",
        cover: "s_lon_vilagossag.png",
    },
    {
        id: 11,
        title: "Szechenyi",
        type: "Képregény",
        price: 3590,
        author: "Sörétes Dénes",
        style: "Detektív, thriller",
        cover: "szechenyi.png",
    },
]

const productsSection = document.getElementById('card-products')

products.forEach(product => {
    productsSection.innerHTML += `<div class="card-products m-2 p-3">
    <h2 class="m-1 p-1">${product.title}</h2> 
    <img class="m-1 p-1" src="./img/${product.cover}">
    <h3 class="m-1 p-1">${product.author}</h3>
    <p class="m-1 p-1">${product.style}</p>
    <p class="m-1 p-1">${product.price} FT</p>
</div>`
}) */