  var html = $("#inline_content").html();
  var geoloc;
  (function($) {
      var succesful = function(position) {
          var result = ajax_jquery('latlon', 'lat=' + position.coords.latitude + '&lon=' + position.coords.longitude);

      };

      var getLocation = function() {
          navigator.geolocation.getCurrentPosition(succesful, function() {
              alert("Geolocation is not supported by this browser");
          });

          return geoloc;
      };

      getLocation();

      

  })(jQuery);


  var myEfficientFn = debounce(function() {
      var winWidth = $(window).width();
      if(winWidth < 1024) {
          

      } else {
         
      }


  }, 250);

  window.addEventListener('resize', myEfficientFn);