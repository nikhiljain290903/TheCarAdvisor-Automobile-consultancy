document.addEventListener('DOMContentLoaded', () => {
    filterCars('5L-10L', document.querySelector('.filter-options button.active'));
  });



  function filterCars(priceRange) {
    // Get all car items
    const cars = document.querySelectorAll('.car-item');

    // Show or hide cars based on the selected price range
    cars.forEach(car => {
      if (car.getAttribute('data-price') === priceRange) {
        car.style.display = 'block';  // Show the car
      } else {
        car.style.display = 'none';  // Hide the car
      }
    });
  }

  // Default filter - Show 5L-10L cars by default on page load
  document.addEventListener('DOMContentLoaded', () => {
    filterCars('5L-10L'); // Show default cars
  });