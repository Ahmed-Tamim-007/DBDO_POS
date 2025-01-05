<script src="{{asset('admin_css/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin_css/vendor/popper.js/umd/popper.min.js')}}"> </script>
<script src="{{asset('admin_css/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin_css/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
<script src="{{asset('admin_css/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('admin_css/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('admin_css/js/charts-home.js')}}"></script>
<script src="{{asset('admin_css/js/charts-custom.js')}}"></script>
<script src="{{asset('admin_css/js/front.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Datatables -->
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('.datatable');
</script>


<!-- Theme Changer -->
<script>
    $(document).ready(function () {
      function updateButtonIcon() {
        if ($('#light-theme').prop('disabled')) {
          $('#theme-toggle i').removeClass('fa-sun').addClass('fa-moon');
        } else {
          $('#theme-toggle i').removeClass('fa-moon').addClass('fa-sun');
        }
      }

      // Toggle theme and icon when the button is clicked
      $('#theme-toggle').click(function () {
        $('#light-theme').prop('disabled', function (_, val) { return !val });
        $('#dark-theme').prop('disabled', function (_, val) { return !val });

        // Update the button icon
        updateButtonIcon();

        // Save the theme preference
        const currentTheme = $('#light-theme').prop('disabled') ? 'dark' : 'light';
        localStorage.setItem('theme', currentTheme);
      });

      // Load saved theme preference on page load
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'dark') {
        $('#light-theme').prop('disabled', true);
        $('#dark-theme').prop('disabled', false);
      }

      // Set the correct icon on page load
      updateButtonIcon();
    });
</script>
