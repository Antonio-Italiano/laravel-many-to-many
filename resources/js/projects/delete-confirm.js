const deleteForms = document.querySelectorAll('.delete-form');

deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        const hasConfirmed = confirm('sei sicuro di voler cancellare il progetto?');
        if (hasConfirmed) form.submit();
    });
});