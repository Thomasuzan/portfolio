<?php

$title_page = isset($project['title']) ? $project['title'] . ' | Portfolio' : 'Un projet | Portfolio';
$description_page = isset($project['description']) ? $project['description'] : 'Description d\'un projet';
?>

<style>
  .header--absolute {
    position: relative;
  }

  /* Section 1 : Hero - Alignement en bas */
  .single-project__hero {
    display: flex;
    align-items: flex-end;
  }

  .single-project__hero-image img {
    width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  }

  /* Section 2 : Meta - Image même hauteur que texte */
  .meta {
    margin: 5rem 0;
  }

  .meta .row {
    display: flex;
    align-items: stretch;
  }

  .meta__image {
    height: 100%;
    display: flex;
    align-items: center;
  }

  .meta__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  }

  .meta__info {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  /* Section 3 : Savoir-faire - Image plus grande */
  .services-section.single-project__services {
    background: transparent;
    padding: 4rem 0;
  }

  .services-section__image {
    position: relative;
  }

  .services-section__image img {
    width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  }

  .services-section__menu {
    position: relative;
    background: transparent;
  }

  /* Responsive */
  @media (max-width: 991px) {
    .single-project__hero {
      align-items: center;
    }

    .single-project__hero-image {
      margin-bottom: 2rem;
    }

    .meta__image {
      margin-bottom: 2rem;
    }

    .meta__image img {
      height: auto;
      object-fit: contain;
    }
  }
</style>

<article class="single-project">
  <div class="single-project__container container container--size-large">
    
    <!-- Section 1 : -->
    <div class="single-project__hero row">
      <div class="single-project__hero-image col-12 col-md-6 col-lg-7">
        <img src="/<?= htmlspecialchars($project['image_url']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
      </div>
      <div class="single-project__hero-main col-12 col-md-6 col-lg-5 order-md-first">
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
      <!-- Section 2 : -->
      <section class="meta">
        <div class="row">
          <div class="col-12 col-lg-6" data-aos="fade-up">
            <div class="meta__image">
              <img src="/<?= htmlspecialchars($project['thumbnail_details']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
            </div>
          </div>
          <div class="col-12 col-lg-6">
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
        </div>
      </section>
    <?php endif; ?>

    <?php if (count($project['details']) > 0) : ?>
      <!-- Section 3 : -->
      <section class="services-section single-project__services">
        <div class="row services-section__main">
          <div class="col-12 col-lg-4" data-aos="fade-up">
            <h2 class="services-section__title">Savoir-faire appris</h2>
            <div class="services-section__text">
              <?php echo htmlspecialchars_decode($project['content_savoir_faire']) ?>
            </div>
            <div class="services-section__menu">
              <ul class="services-section__list">
                <?php foreach ($project['savoir_faire'] as $savoir_faire) : ?>
                  <li class="services-section__item" data-aos="fade-up">
                    <span class="services-section__link"><?php echo $savoir_faire ?>
                      <span>
                        <svg width="24" height="23">
                          <use xlink:href="#link-arrow2"></use>
                        </svg>
                      </span>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="col-12 col-lg-8" data-aos="fade-up">
            <div class="services-section__image">
              <img src="/<?= htmlspecialchars($project['thumbnail_savoir_faire']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

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