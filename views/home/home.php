<?php

$title_page = 'Développeur web front-end et back-end | Portfolio';
$description_page = 'Bienvenue sur mon portfolio de développeur front-end et back-end';
//phpinfo();
?>

<section class="hero">

<div class="hero__bg __js_parallax">
  <picture>
    <!-- Image pour les écrans de moins de 800px -->
    <source srcset="<?= BASE_URL ?>/assets/img/picture/home/thomas-hero-mobile3.jpg" media="(max-width: 575px)">
    <!-- Image par défaut (desktop) -->
    <img src="<?= BASE_URL ?>/assets/img/picture/home/thomas-hero.jpg" width="1920" height="1080" alt="Thomas Uzan">
  </picture>
</div>

  <div class="hero__container container container--size-large">
    <header class="hero__header">
      <div class="container container--size-large">
        <h1 class="hero__title">Développement web <span lang="en">full stack</span>
          <span>avec passion et professionnalisme</span>
        </h1>

        <a class="hero__more arrow-link arrow-link-hero" href="<?= $router->generate('about') ?>">
          <span class="arrow-link__text">à-propos</span>
          <span class="arrow-link__icon">
            <svg width="75" height="75">
              <use xlink:href="#link-arrow"></use>
            </svg>
          </span>
        </a>
      </div>

    </header>
    <div class="hero__content">
      <div class="hero__vertical vertical-logo">
        <div class="vertical-logo__layer vertical-logo__layer--yellow">
          <img height="150"
            src="<?= BASE_URL ?>/assets/img/picture/logo/logo-header-no-bg.png" alt="thomas uzan écrit en vertical">
        </div>

        <div class="vertical-logo__layer vertical-logo__layer--black">
          <img height="150"
            src="<?= BASE_URL ?>/assets/img/picture/logo/logo-header-no-bg.png" alt="thomas uzan écrit en vertical">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Presentation with skills -->

<?php require_once ROOT . '/views/elements/presentation.php' ?>

<section class="works">
  <div class="works__container container container--size-large">
    <header class="works__header">
      <div class="row">
        <div class="col-8" data-aos="fade-up">
          <h2 class="works__title">
            <span>Découvrez</span>Mes projets
          </h2>
        </div>

        <div class="col-4 text-md-right" data-aos="fade-up">
          <a class="works__more arrow-link--white arrow-link" href="<?= $router->generate('projects') ?>" title="Mes projets">
            <span class="arrow-link__text">Voir tout</span>
            <span class="arrow-link__icon">
              <svg width="75" height="75">
                <use xlink:href="#link-arrow"></use>
              </svg>
            </span>
          </a>
        </div>
      </div>

    </header>
    <div class="works__carousel carousel swiper-container __js_carousel" data-aos="fade-up">
      <div class="carousel__navigation">
        <button class="carousel__btn carousel__btn--prev" type="button"><abbr title="Précédent">Préc</abbr></button>
        <button class="carousel__btn carousel__btn--next" type="button"><abbr title="Suivant">Suiv</abbr></button>
      </div>

      <div class="swiper-wrapper">
        <a class="carousel__item carousel-card swiper-slide" href="<?= $router->generate('project') ?>citations" title="Projet « Citations »">
          <img src="<?= BASE_URL ?>/assets/img/picture/single-project/citations-min.jpg" width="662" height="510" alt="Projet « Citations »">
          <span class="carousel-card__bottom">
            <span class="carousel-card__title">Citations</span>
            <span class="carousel-card__icon">
              <svg width="29" height="29">
                <use xlink:href="#link-arrow"></use>
              </svg>
            </span>
          </span>
        </a>

        <a class="carousel__item carousel-card swiper-slide" href="<?= $router->generate('project') ?>telethon" title="Projet « Téléthon »">
          <img src="<?= BASE_URL ?>/assets/img/picture/common/portfolio-section/telethon.jpg" width="662" height="510" alt="Projet « Téléthon »">
          <span class="carousel-card__bottom">
            <span class="carousel-card__title">Téléthon</span>
            <span class="carousel-card__icon">
              <svg width="29" height="29">
                <use xlink:href="#link-arrow"></use>
              </svg>
            </span>
          </span>
        </a>

        <a class="carousel__item carousel-card swiper-slide" href="<?= $router->generate('project') ?>meteo" title="Projet « Application météo »">
          <img src="<?= BASE_URL ?>/assets/img/picture/common/portfolio-section/meteo-min.jpg" width="662" height="510" alt="Projet « Application météo »">
          <span class="carousel-card__bottom">
            <span class="carousel-card__title">Météo</span>
            <span class="carousel-card__icon">
              <svg width="29" height="29">
                <use xlink:href="#link-arrow"></use>
              </svg>
            </span>
          </span>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="contact-section">
  <div class="contact-section__container container container--size-large">
   
  <!-- Formulaire de contact -->

    <?php require_once ROOT . '/views/elements/form.php' ?>
  </div>
</section>

