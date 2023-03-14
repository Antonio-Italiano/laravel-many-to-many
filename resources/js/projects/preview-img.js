//prendo un placeholder
const placeholder = 'https://marcolanci.it/utils/placeholder.jpg';

//PRENDO ELEMENTI DAL DOM
const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('image-preview');

//EVENTO AL CAMBIO DEL CARICAMENTO DEL FILE
imageInput.addEventListener('change', () => {

    //controllo se ho caricato un file
    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();
        reader.readAsDataURL(imageInput.files[0]);

        //quando è pronto il dato
        reader.onload = e => { //e sta per evento //onload sta per AddEventListner
            imagePreview.src = e.target.result;  //.src corrisponde a setAttribute('src'. parametro)
        }

    } else imagePreview.src = placeholder;

});