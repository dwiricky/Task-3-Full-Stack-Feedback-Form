<script src="{{ asset("assets/js/admin/core/popper.min.js")}}"></script>
<script src="{{ asset("assets/js/admin/core/bootstrap.min.js")}}"></script>
<script src="{{ asset("assets/js/admin/plugins/perfect-scrollbar.min.js")}}"></script>
<script src="{{ asset("assets/js/admin/plugins/smooth-scrollbar.min.js")}}"></script>
<script src="{{ asset("assets/js/admin/plugins/chartjs.min.js")}}"></script>
<script>
  var a = document.getElementById("sidenav-main");
  var b = document.getElementById("showsidenav");
  var s = document.getElementById("iconsettings");
  var ss = document.getElementById("settingsmenu");
  var z = window.innerWidth;
  if (z > 1200) {
      a.style.display = "block";
    } else {
      a.style.display = "none";
    }
  window.addEventListener("resize", function() {
    var c = window.innerWidth;
    if (c > 1200) {
      ss.style.display = "block";
    } else {
      ss.style.display = "none";
    }
  })
  window.addEventListener("resize", function() {
    var c = window.innerWidth;
    if (c > 1200) {
      a.style.display = "block";
    } else {
      a.style.display = "none";
    }
  })
  if (b.onclick = function() {
      if (a.style.display === "none") {
      a.style.display = "block";
    } else {
      a.style.display = "none";
    }
  })  
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset("assets/js/admin/material-dashboard.min.js")}}"></script>