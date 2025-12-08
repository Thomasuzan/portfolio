<?php
if (isset($_SESSION['success'])): $title_page = 'Demande envoyée ! Échanger sur un projet, contact & collaboration | Portfolio';
elseif (isset($_SESSION['error'])): $title_page = 'Erreur de saisie ! Échanger sur un projet, contact & collaboration | Portfolio';
else: $title_page = 'Échanger sur un projet, contact & collaboration | Portfolio';
endif;
$description_page = 'Pour me contacter';
?>



<article class="contact">
  <section class="contact-section">
    <div class="contact-section__container container container--size-large">

      <!-- Formulaire de contact -->

      <?php require_once ROOT . '/views/elements/form.php' ?>
      
    </div>

    <div class="contact-section__map" id="map" data-aos="fade-up">
      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d22634.31117449751!2d-0.5701202846557529!3d44.83604964593848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1739235684009!5m2!1sfr!2sfr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>
</article>