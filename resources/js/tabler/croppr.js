import Croppr from 'croppr';

var cropprs = document.querySelectorAll('[data-crop]');

cropprs.forEach(croppr => {

  var input = croppr.querySelector('input[type=file]');

  input.addEventListener('change', function() {

    var file = input.files[0];

    let reader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload = function() {

      var img_id = croppr.getAttribute('data-crop');

      var width = parseFloat(croppr.getAttribute('data-width'));
      var height = parseFloat(croppr.getAttribute('data-height'));

      var ratio = height / width;

      console.log(width, height, ratio)

      var old_result = croppr.querySelector("#final_" + img_id);
      if (old_result) {
        croppr.removeChild(old_result);
      }

      var img = document.createElement('img');
      img.src = reader.result;
      img.setAttribute('id', img_id);
      img.setAttribute('class', 'mt-3');
      croppr.appendChild(img);

      var cropprInstance = new Croppr('#' + img_id, {
        aspectRatio: ratio,
        // maxSize: size,
        // startSize: size
      });

      var button = document.createElement('button');
      button.setAttribute('class', 'btn btn-info mt-3');
      button.textContent = "Crop";

      croppr.appendChild(button);

      button.addEventListener('click', function() {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');

        const image = new Image()
        image.src = reader.result;

        var data = cropprInstance.getValue();

        console.log(data);

        // canvas.width = data.width;
        // canvas.height = data.height;
        canvas.width = width;
        canvas.height = height;

        context.drawImage(image, data.x, data.y, data.width, data.height, 0, 0, canvas.width, canvas.height);

        var dataUrl = canvas.toDataURL('image/jpeg');


        var img_result = document.getElementById(croppr.getAttribute('data-target'));
        img_result.value = dataUrl;


        cropprInstance.destroy();
        croppr.removeChild(img);
        croppr.removeChild(button);

        var final_result = document.createElement('img');
        final_result.setAttribute('id', "final_" + img_id);
        final_result.src = dataUrl;
        croppr.appendChild(final_result);

      });


    };

    reader.onerror = function() {
      console.log(reader.error);
    };

  });

});