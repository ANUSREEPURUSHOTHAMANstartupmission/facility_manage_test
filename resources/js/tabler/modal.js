import { Modal } from 'bootstrap';

var modals = [].slice.call(document.querySelectorAll('.alert-dialog'));

modals.map(function(modal) {
  var myModal = new Modal(modal);
  myModal.show();
})