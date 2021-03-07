<header>
<?php $host = $_SERVER['SERVER_NAME'];
if($host == 'nominate-test.lodge104.net') : ?>

<div class="alert alert-danger" role="alert" style="text-align: center;">
This is a test site for the nomination portal. Please do not use this site. Head to <a href="https://nominate.lodge104.net/">nominate.lodge104.net</a> for the production site.
</div>

<?php else : ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37461006-19"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-37461006-19');
</script>

<?php endif ?>

</header>