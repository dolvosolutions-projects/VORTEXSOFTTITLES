  </div><!-- end .adm-content -->
</div><!-- end .adm-main -->

<script>
// Sidebar toggle for mobile
const sidebar = document.getElementById('adminSidebar');
document.querySelectorAll('.adm-mobile-toggle').forEach(btn => {
  btn.addEventListener('click', () => sidebar.classList.toggle('open'));
});
// Close on outside click (mobile)
document.addEventListener('click', e => {
  if (window.innerWidth < 1024 && sidebar && !sidebar.contains(e.target) && !e.target.closest('.adm-mobile-toggle')) {
    sidebar.classList.remove('open');
  }
});
</script>
</body>
</html>
