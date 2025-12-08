<?php

$title_page = 'Projets web, maquettage, intégration et back-end | Portfolio';
$description_page = 'Présentation de mes projets web et réalisations. Maquettage, intégration HTML, CSS, Javascript et projets back-end';
//test pour savoir si generate() recupère bien le slug
//$url = $router->generate('project', ['slug' => 'mon-slug-test']);
//var_dump($url);
?>


<section class="portfolio-section">
  <div class="portfolio-section__container container container--size-large">
    <h1 class="heading heading--size-large blog-grid__title">Projets</h1>

    <!-- Filter news-->

    <div class="filter blog-grid__filter">
      <button class="filter__item filter__item--active __js_filter-btn" type="button" data-filter="*">Tout</button>
      <button class="filter__item __js_filter-btn" type="button" data-filter=".__js_1">Maquettage</button>
      <button class="filter__item __js_filter-btn" type="button" data-filter=".__js_2">Front-end</button>
      <button class="filter__item __js_filter-btn" type="button" data-filter=".__js_3">Back-end</button>
    </div>
    <h1 class="visually-hidden">Projets</h1>
    <ul class="portfolio-section__grid __js_portfolio-section-masonry">

      <?php
      $index = 0;
      foreach ($projects as $project) :
        $index++;

        // Déterminer la classe en fonction de la position (répétition tous les 4 projets)
        $position = ($index - 1) % 4; // Cycle de 4 projets (0, 1, 2, 3)
        $class = '';

        // Application des classes selon la position
        if ($position == 2) { // Projet 3 (index 2) = Vertical
          $class = 'project-preview--vertical';
        } elseif ($position == 3) { // Projet 4 (index 3) = Large horizontal
          $class = 'portfolio-section__item--two-thirds';
        }
        // Construction des classes de catégorie
        $category_classes = '';
        foreach ($project['categories'] as $category) {
          $category_classes .= ' __js_' . $category;
        }
      ?>
        <li class="portfolio-section__item __js_masonry-item <?= $category_classes ?> <?= $class ?>">
          <a class="project-preview project-preview--elastic <?= $class ?>"
            href="<?= $router->generate('project', ['slug' => $project['slug']]); ?>">
            <span class="project-preview__image">
              <img src="<?= $project['image_url']; ?>" alt="<?= $project['title'] ?>">
            </span>
            <span class="project-preview__bottom">
              <span class="project-preview__title" title="<?= $project['title']; ?>"><?= $project['title']; ?></span>
              <span class="project-preview__icon">
                <svg width="24" height="23">
                  <use xlink:href="#link-arrow2"></use>
                </svg>
              </span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>