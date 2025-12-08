<?php

// Détermine si on est sur la page d'accueil
$page = basename($_SERVER['REQUEST_URI']);

// Sur Home, l'id sera id="home-contact-form"
$formId = ($page === '' || $page === 'home') ? 'home-contact-form' : 'contact-form';
?>


<div id="<?= $formId ?>" class="row">
  <div class="contact-section__main col-12 col-md">
    <h2 class="contact-section__title" data-aos="fade-up">Contact</h2>
    <address class="contact-section__address" data-aos="fade-up">
      Ville <br> 33000, Bordeaux
    </address>
    <div class="contact-section__link" data-aos="fade-up">
      <a href="tel:+33670172223">06 70 17 22 23</a>
    </div>
    <div class="contact-section__link" data-aos="fade-up">
      <a href="mailto:thomasuzanpro@gmail.com">thomasuzanpro@gmail.com</a>
    </div>
    <ul class="contact-section__social" data-aos="fade-up">
      <li>
        <a href="https://linkedin.com/in/thomas-uzan-2470a3319">LinkedIn</a>
      </li>
      <li>
        <a href="https://github.com/Thomasuzan">Github</a>
      </li>
    </ul>
  </div>

  <div class="col-12 col-md">
    <div class="discuss-project discuss-project--no-padding contact-section__aside">
      <div class="discuss-project__wrapper" data-aos="fade-up">
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php echo $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); // Pour éviter qu'il apparaisse plusieurs fois 
            ?>
          </div>

        <?php elseif (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); // Pour éviter qu'il apparaisse plusieurs fois 
            ?>
          </div>
        <?php endif; ?>

        <div class="discuss-project__title" data-aos="fade-up">Me contacter</div>
        <form id="contact-form" action="/contact/send" method="post" enctype="multipart/form-data">

          <!-- Champ caché qui fournit au ContactController l'origine de la page du formulaire -->
          <input type="hidden" name="origin" value="<?= ($formId === 'home-contact-form') ? 'home' : 'contact'; ?>">

          <div class="row justify-content-between gx-0">
            <div class="discuss-project__field-wrapper col-12 col-md-6" data-aos="fade-up">
              <label class="discuss-project__field field">
                <input type="text" name="name"
                  <?php if (isset($_SESSION['name'])): echo ' value="' . $_SESSION['name'] . '"';
                  endif; ?>>
                <span class="field__hint">Nom</span>
              </label>
            </div>
            <div class="discuss-project__field-wrapper col-12 col-md-6" data-aos="fade-up">
              <label class="discuss-project__field field">
                <input type="email" name="email"
                  <?php if (isset($_SESSION['email'])): echo ' value="' . $_SESSION['email'] . '"';
                  endif; ?>>
                <span class="field__hint">Email</span>
              </label>
            </div>
            <div class="col-12" data-aos="fade-up">
              <label class="discuss-project__field discuss-project__field--textarea field">
                <textarea name="message" id="message">
                  <?php if (isset($_SESSION['message'])): echo $_SESSION['message'];
                  endif; ?>
                </textarea>
                <span class="field__hint">Message</span>
              </label>
            </div>
            <div class="discuss-project__bottom col-12">
              <div class="discuss-project__file file-upload w-100" data-aos="fade-up">
                <label class="file-upload__label">
                  <span class="file-upload__icon">
                    <svg width="16" height="16">
                      <use xlink:href="#paper-clip"></use>
                    </svg>
                  </span>
                  <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                    <span class="file-upload__text">Joindre un fichier</span>
                  </div>
                  <input class="visually-hidden" type="file" name="file">
                  <div id="file-preview"></div>
                  <button type="button" id="remove-file" style="min-width: auto; padding: 12px 16px;" class="btn-sm btn--theme-black">
                  <span class="btn__text">Supprimer</span>
                  </button>
                </label>
                <p>Fichiers autorisés : jpg, jpeg, png, pdf, doc, docx</p>
                <p>Taille maximale 5 Mo</p>
                <div class="form-check mt-5 mb-3">
                  <input class="form-check-input" type="checkbox" name="rgbd" id="rgbd">
                  <label class="form-check-label" for="rgbd">
                    J'accepte de communiquer les données ci-dessus dans le but d'être recontacté(e).
                  </label>
                </div>
                <!-- Champ caché qui contiendra une clé de validation envoyée par Google -->
                <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                <button class="discuss-project__send btn--theme-black btn"
                  type="submit" data-aos="fade-up">
                  <span class="btn__text">Envoyer</span>
                  <span class="btn__icon">
                    <svg width="19" height="19">
                      <use xlink:href="#link-arrow"></use>
                    </svg>
                  </span>
                </button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=6LdYIPIqAAAAAN0dj0CMmfwsNgaSq9H5Vhmc3-mH"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let pageAction = "default"; // Valeur par défaut

    // Détecter si le formulaire est sur home ou contact
    if (window.location.pathname.includes("home")) {
      pageAction = "homepage";
    } else if (window.location.pathname.includes("contact")) {
      pageAction = "contactpage";
    }

    grecaptcha.ready(function() {
      grecaptcha.execute('6LdYIPIqAAAAAN0dj0CMmfwsNgaSq9H5Vhmc3-mH', {
        action: pageAction
      }).then(function(token) {
        let recaptchaInput = document.getElementById('recaptchaResponse');
        if (recaptchaInput) {
          recaptchaInput.value = token;
        }
      });
    });
  });

  // Gérer l’affichage et la suppression du fichier sélectionné
  document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.querySelector('input[name="file"]');
    const previewContainer = document.getElementById("file-preview");
    const removeButton = document.getElementById("remove-file");

    fileInput.addEventListener("change", function(event) {
      if (fileInput.files.length > 0) {
        previewContainer.textContent = fileInput.files[0].name;
        // removeButton.style.display = "inline-block";
      }
    });

    removeButton.addEventListener("click", function() {
      fileInput.value = "";
      previewContainer.textContent = "";
    });
  });

</script>