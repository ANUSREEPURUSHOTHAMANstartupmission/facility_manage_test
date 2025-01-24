var deleteForms = document.querySelectorAll('table form.destroy-action');

deleteForms.forEach(form => {
  var deleteButton = form.querySelector('button[data-confirm]');

  deleteButton.addEventListener('click', function(e) {
    e.preventDefault();

    var message = deleteButton.dataset.confirm;
    if (message && confirm(message)) {
      form.submit();
    }

  });

});