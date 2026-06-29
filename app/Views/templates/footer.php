<footer class="footer">
   <div class="container-fluid">
      <nav class="float-left">
         <ul>
         </ul>
      </nav>
      <div class="copyright float-right">
         <?= isset($generalSettings)
            ? esc($generalSettings->copyright)
            : '' ?>
      </div>
   </div>
</footer>