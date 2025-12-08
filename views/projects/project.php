<?php

$title_page = isset($project['title']) ? $project['title'] . ' | Portfolio' : 'Un projet | Portfolio';
$description_page = isset($project['description']) ? $project['description'] : 'Description d\'un projet';
?>

<style>
  .header--absolute {
    position: relative;
  }
</style>

<article class="single-project">
  <div class="single-project__container container container--size-large">
    <div class="single-project__hero row">
      <div class="single-project__hero-image col-12 col-md-6 col-lg-7 col-xxl-6">
        <img src="/<?= htmlspecialchars($project['image_url']) ?>" width="785" height="747" alt="<?= htmlspecialchars($project['title']) ?>">
      </div>
      <div class="single-project__hero-main col-12 col-md-6 col-lg-5 col-xxl-6 order-md-first">
        <h1 class="single-project__title">
          <span><?= htmlspecialchars($project['title']) ?></span>
        </h1>
        <div class="single-project__icon">
          <svg width="75" height="75">
            <use xlink:href="#link-arrow"></use>
          </svg>
        </div>
        <div class="single-project__hero-text">
          <?php echo htmlspecialchars_decode($project['content']) ?>
        </div>
      </div>
    </div>

    <?php if (count($project['details']) > 0) : ?>
      <section class="meta">
        <div class="row">
          <div class="col-12 col-lg-4" data-aos="fade-up">
            <div class="meta__image">
              <img src="/<?= htmlspecialchars($project['thumbnail_details']) ?>" alt="<?= htmlspecialchars($project['title']) ?> ">
            </div>
          </div>
          <div class="col-12 col-lg-8">
            <div class="meta__info">
              <?php $i = 0;
              foreach ($project['details'] as $label => $detail) : $i++; ?>
                <div class="meta__info-item" data-aos="fade-up">
                  <span>
                    <span class="num"><?php echo sprintf("%02d", $i); ?>.</span>
                    <?php echo $label ?>
                  </span>
                  <span><?php echo $detail ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
      </section>
    <?php endif; ?>

    <?php if (count($project['details']) > 0) : ?>
      <section class="services-section single-project__services">
        <div class="row services-section__main">
          <div class="col-12 col-xxl-3" data-aos="fade-up">
            <div class="services-section__text">
              <?php echo htmlspecialchars_decode($project['content_savoir_faire']) ?>
            </div>
          </div>
          <div class="col-12 col-xxl-9 services-section__right">
            <h2 class="services-section__title" data-aos="fade-up">Savoir-faire appris</h2>
            <div class="services-section__image">
              <div class="services-section__menu">
                <ul class="services-section__list">
                  <?php foreach ($project['savoir_faire'] as $savoir_faire) : ?>
                    <li class="services-section__item" data-aos="fade-up">
                      <span class="services-section__link"><?php echo $savoir_faire ?><span>
                          <svg width="24" height="23">
                            <use xlink:href="#link-arrow2"></use>
                          </svg>
                        </span>
                      </span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <img src="/<?= htmlspecialchars($project['thumbnail_savoir_faire']) ?>" alt="<?= htmlspecialchars($project['title']) ?> ">
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <section class="project-other">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="project-other__image" data-aos="fade-up">
            <img src="assets/img/picture/single-project/3.jpg" alt="">
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="project-other__image project-other__image--small" data-aos="fade-up">
            <img src="assets/img/picture/single-project/4.jpg" alt="">
            <div class="project-other__text" data-aos="fade-up">Alienum phaedrum torquatos nec eu, detr periculis ex, nihil expetendis in mei. Mei an pericula euripidis hinc partem ei est.</div>
          </div>
        </div>
      </div>
    </section>
    <div class="single-project__next" data-aos="fade-up">

      <div class="single-project__next" data-aos="fade-up" style="display: flex; justify-content: space-between; width: 100%;">
        <div>
          <a href="<?= $router->generate('project', ['slug' => $prevProject['slug']]) ?>">
            <svg width="104" height="86" style="transform: rotate(180deg);" class="arrow-left">
              <use xlink:href="#arrow-right"></use>
            </svg>
            <abbr id="previous" title="Précédent">Préc</abbr>
          </a>
        </div>
        <div>
          <a href="<?= $router->generate('project', ['slug' => $nextProject['slug']]) ?>">
            <abbr id="next" title="Suivant">Suiv</abbr>
            <svg width="104" height="86" class="arrow-right">
              <use xlink:href="#arrow-right"></use>
            </svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</article>