// Function to load a script dynamically
function loadScript(src) {
    var script = document.createElement('script');
    script.src = src;
    script.async = true;
    document.head.appendChild(script);
  }
  
  // Check for elements and load scripts accordingly
  if (document.querySelectorAll("[toast-list]").length > 0) {
    loadScript('assets/libs/toastify-js/src/toastify.js');
  }
  
  if (document.querySelectorAll("[data-provider]").length > 0) {
    loadScript('assets/libs/flatpickr/flatpickr.min.js');
  }
  
  if (document.querySelectorAll("[data-choices]").length > 0) {
    loadScript('assets/libs/choices.js/public/assets/scripts/choices.min.js');
  }
  