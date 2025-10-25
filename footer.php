</div> <!-- Close content-wrapper -->
</div> <!-- Close app-content -->
<br>
<br><br><br>
<!-- Footer Section -->
<footer class="footer text-white mt-7" style="
  background-color: #c82333;
  width: calc(100% - 250px); /* Adjust based on sidebar width */
  margin-left: 250px; /* Matches sidebar width */
  padding: 15px 30px;
  box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
  position: fixed;
  bottom: 0;
  left: 0;
  z-index: 1000;
">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
    <div>
      <strong>CrudeCRM 2025</strong> &copy; All rights reserved. 
    </div>
    <div>
      <strong>Made By Yug Patel</strong> 
    </div>
    <ul class="list-inline mb-0 mt-2 mt-md-0">
      <li class="list-inline-item">
        <a class="text-white mx-2" href="index.php" style="text-decoration:none;">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
      </li>
      <li class="list-inline-item">
        <a class="text-white mx-2" href="documentation.php" style="text-decoration:none;">
          <i class="fas fa-book"></i> Documentation
        </a>
      </li>
      <li class="list-inline-item">
        <a class="text-white mx-2" href="#top" onclick="scrollToTop()" style="text-decoration:none;">
          <i class="fas fa-arrow-up"></i> Back to Top
        </a>
      </li>
    </ul>
  </div>
</footer>

<!-- Back to Top Button -->
<button onclick="scrollToTop()" title="Go to top" id="backToTopBtn" style="
  display:none;
  position: fixed;
  bottom: 80px;
  right: 20px;
  z-index: 999;
  font-size: 16px;
  border: none;
  outline: none;
  background-color: #c82333;
  color: white;
  cursor: pointer;
  padding: 10px 14px;
  border-radius: 50%;
  box-shadow: 0 2px 6px rgba(0,0,0,0.3);
">↑</button>

<!-- Scroll to Top Script -->
<script>
  window.onscroll = function() {
    const btn = document.getElementById("backToTopBtn");
    btn.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none";
  }

  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

<!-- Ensure Footer at Bottom -->
<style>
  html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    background-color: #f4f6fb;
  }

  .app-content {
    flex: 1 0 auto;
    display: flex;
    flex-direction: column;
  }

  .content-wrapper {
    flex: 1;
    padding: 20px;
  }

  .footer {
    flex-shrink: 0;
  }

  @media screen and (max-width: 768px) {
    footer.footer {
      margin-left: 0;
      width: 100%;
      text-align: center;
    }
  }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
