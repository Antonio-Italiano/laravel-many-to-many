//prendiamo gli input che ci interessano
const slugInput = document.getElementById('slug');
const titleInput = document.getElementById('title');

//metto un event listner sul title
titleInput.addEventListener('keypress', () => {
  slugInput.value = titleInput.value.toLowerCase().split(' ').join('-');
});
