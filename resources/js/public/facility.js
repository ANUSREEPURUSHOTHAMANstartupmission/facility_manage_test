import Splide from '@splidejs/splide';

// $(function() {
//   $('.datetimes').daterangepicker({
//       timePicker: true,
//       minDate: moment(),
//       maxDate: moment().add(1, 'month'),
//       "alwaysShowCalendars": true,
//       locale: {
//         format: 'YYYY-MM-DD HH:mm'
//       },
//       "autoApply": true,
//     },
//     function(start, end, label) {
//       $('.datetimes #start').val(start.format('YYYY-MM-DD HH:mm'));
//       $('.datetimes #end').val(end.format('YYYY-MM-DD HH:mm'));

//       $('.datetimes #view').show();
//     });

//   if (window.start_date && window.end_date) {
//     $('.datetimes').data('daterangepicker').setStartDate(window.start_date);
//     $('.datetimes').data('daterangepicker').setEndDate(window.end_date);
//   }

// });

new Splide('.splide', {
  type: 'loop',
  perPage: 4,
  breakpoints: {
    640: {
      perPage: 2,
    },
  }
}).mount();