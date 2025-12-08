<?php $title_page = 'Login | Portfolio';
$description_page = 'Connexion au back-office';
?>

<style>
    .header--absolute {
        position: relative;
    }
</style>

<div class="login-layout">
    <?php if ($error): ?>
        <div class="alert alert-danger mb-5" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form action="<?= $router->generate('admin_login'); ?>"
        method="post" class="login-form">
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <input type="email" name="email">
                <span class="field__hint">Email</span>
            </label>
        </div>
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <input type="password" name="password">
                <span class="field__hint">Mot de passe</span>
            </label>
        </div>
        <button class="discuss-project__send btn--theme-black btn aos-init" type="submit" data-aos="fade-up">
            <span class="btn__text">Se connecter</span>
            <span class="btn__icon">
                <svg width="19" height="19">
                    <use xlink:href="#link-arrow"></use>
                </svg>
            </span>
        </button>
    </form>
</div>