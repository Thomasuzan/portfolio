<?php
$title_page = 'Mon parcours et compétences en développement web | Portfolio';
$description_page = 'Ma présentation: comment je me suis formé pour devenir développeur web et les connaissances que j\'ai apprises';
?>

<article class="about-us">
  <div class="first-banner about-us__banner">
    <div class="first-banner__image">
      <picture>
        <!-- Image pour les écrans de moins de 575px -->
        <source srcset="assets/img/picture/common/about-hero-mobile.jpg" media="(max-width: 575px)" alt="branche avec des feuilles" />
        <!-- Image par défaut (desktop) -->
        <img src="assets/img/picture/common/about-hero.jpg" width="1920" height="1100" alt="branche avec des feuilles" />
      </picture>
    </div>

    <div class="container container--size-large">
      <h1 class="first-banner__title heading heading--size-large">Apprendre, évoluer
        <br>
        <span>coder</span> sans limite
      </h1>
    </div>
  </div>

  <!-- Presentation with skills -->
  <?php require "../views/elements/presentation.php" ?>

  <section class="container container--size-large">
    <div class="flex about-logo aos-init aos-animate" data-aos="fade-up">
      <a href="https://www.afpa.fr/">
        <img src="assets/img/picture/logo/logo-afpa-min.png" alt="afpa">
      </a>

      <a href="https://openclassrooms.com/fr/">
        <img src="assets/img/picture/logo/openclassrooms-min.jpg" alt="openclassrooms">
      </a>

      <a href="https://grafikart.fr/">
        <img src="assets/img/picture/logo/grafikart-min.png" alt="cube grafikart">
      </a>
    </div>

    <div class="aos-init aos-animate" data-aos="fade-up">
      <h2 class="title-cv">Mon CV</h2>

      <div class="cv-layout d-flex">
        <a class="carousel__item carousel-card" href="assets/cv-thomas-uzan.pdf">
          <img src="assets/img/picture/common/cv-min.jpg" alt="cv de Thomas">
          <span class="carousel-card__bottom">
            <span class="carousel-card__title ">Voir mon CV</span>
            <span class="carousel-card__icon">
              <svg width="29" height="29">
                <use xlink:href="#link-arrow"></use>
              </svg>
            </span>
          </span>
        </a>
      </div>
    </div>
  </section>
</article>