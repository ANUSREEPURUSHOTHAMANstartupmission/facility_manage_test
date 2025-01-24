import Choices from 'choices.js';

var selects = document.querySelectorAll('.select-choice');

selects.forEach(select => {
  new Choices(select, {
    classNames: {
      containerInner: select.className,
      input: 'form-control',
      inputCloned: 'form-control-sm',
      listDropdown: 'dropdown-menu',
      itemChoice: 'dropdown-item',
      activeState: 'show',
      selectedState: 'active',
    },
    shouldSort: false,
    searchEnabled: false,
  });
})

var searchs = document.querySelectorAll('.select-search');

searchs.forEach(select => {
  var url = select.getAttribute('data-route');
  var selected = select.getAttribute('data-selected');

  var choice = new Choices(select, {
    classNames: {
      containerInner: select.className,
      input: 'form-control',
      inputCloned: 'form-control-sm',
      listDropdown: 'dropdown-menu',
      itemChoice: 'dropdown-item',
      activeState: 'show',
      selectedState: 'active',
    },
    shouldSort: false,
    searchEnabled: true,
    placeholder: true,
    placeholderValue: 'Pick Startup record',
  });

  var data = [];

  choice.setChoices(async() => {
    try {
      const items = await fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });

      data = await items.json();

      data = await data.map(function(item) {
        return { value: item.id, label: item.name };
      })

      return data;

    } catch (err) {
      console.error(err);
    }
  }).then(function(instance) {
    if (!selected) {
      instance.setChoiceByValue(data[0].value);
    } else {
      instance.setChoiceByValue(selected);
    }
  });

  select.addEventListener('search', async function(event) {
    var query = event.detail.value
    if (query.length < 2) return;

    choice.setChoices(async() => {
      try {
        const items = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            query: query
          })
        });

        data = await items.json();

        data = await data.map(function(item) {
          return { value: item.id, label: item.name };
        })

        return data;

      } catch (err) {
        console.error(err);
      }
    }, 'value', 'label', true)
  })

})