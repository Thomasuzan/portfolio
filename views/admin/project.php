<?php 
$type = ( $id != '' && $id != 0 ) ? 'edit' : 'add';
$title_page = ( $type == 'add' ) ? 'Ajouter un projet' : 'Modifier le projet';
$description_page = 'Gestion des projets';
?>

<style>
    .header--absolute {
        position: relative;
    }
    label > span {
        display: inline-block;
        font-weight: 500;
        background: #222;
        color: #fff;
        border-radius: 4px;
        padding: 0 1em;
        line-height: 2;
    }
    label input,
    label.field input,
    label textarea,
    label.field textarea {
        padding-top: .75em;
    }
    .btn-thomas {
        color: #007bff;
        display: inline-block;
        padding: .75em 1em;
        border: 1px solid #007bff;
        border-radius: 4px;
        background: #fff;
        margin: 0 1em 2em;
    }
    .btn-thomas-lite {
        color: #007bff;
        display: inline-block;
        padding: .125em .5em;
        border: 1px solid #007bff;
        border-radius: 4px;
        background: #fff;
        margin: 0 1em;
        font-size: .85em;
    }
    .btn-thomas:hover,
    .btn-thomas:focus,
    .btn-thomas-lite:hover,
    .btn-thomas-lite:focus {
        color: #fff;
        background: #007bff;
    }
    p.alert {
        background: #fffe55;
        padding: 1em;
        line-height: 1;
        margin: 0 1em 1em;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<section class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Back-office</h1><br>
        <a href="<?= $router->generate('admin_dashboard') ?>" class="btn-thomas-lite">Retour aux projets</a>
    </div>

    <h2><?php echo $title_page; ?></h2>

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

    <form action="<?php echo $router->generate('save_project'); ?><?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <span>Titre</span><br>
                <input type="text" name="title" value="<?php echo ( isset($_SESSION['title']) ) ? $_SESSION['title'] : $project['title']; ?>">
            </label>
        </div>
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <span>Slug</span><br>
                <input type="text" name="slug" value="<?php echo ( isset($_SESSION['slug']) ) ? $_SESSION['slug'] : $project['slug']; ?>">
            </label>
        </div>
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <span>Description</span><br>
                <textarea name="description"><?php echo ( isset($_SESSION['description']) ) ? $_SESSION['description'] : $project['description']; ?></textarea>
            </label>
        </div>
        <div data-aos="fade-up">
            <label class="discuss-project__field field">
                <span>Contenu</span><br>
                <textarea name="content"><?php echo ( isset($_SESSION['content']) ) ? $_SESSION['content'] : $project['content']; ?></textarea>
            </label>
        </div>
        <div data-aos="fade-up" style="margin-bottom: 60px;background: rgba(255, 255, 255, 1);padding: 1em;border: 1px solid #ccc;border-radius: 4px;">
            <label class="field">
                <span>Visuel</span><br>
                <input type="hidden" name="thumbnail_old" value="<?php echo $project['thumbnail']; ?>">
                <input type="file" name="thumbnail"><br>
                <?php if ( $project['thumbnail'] != '' ) : ?>
                    <a href="/<?php echo $project['thumbnail']; ?>" target="_blank"><img src="/<?php echo $project['thumbnail']; ?>" style="max-height:150px"></a><br>
                    <a href="<?= $router->generate('delete_thumbnail', ['id' => $id]) ?>" class="btn-thomas-lite">Supprimer</a>
                <?php endif; ?>
            </label>
        </div>
        <?php if ( $id > 0 ) : ?>
            <fieldset style="margin-bottom: 60px;border: 1px solid #ccc;padding: 1em;background:rgba(255,255,255,.5)">
                <legend style="border: 1px solid #ccc;padding: 1em;background: #fff">Catégories</legend>
                <?php foreach ( $categories as $category ) : ?>
                    <div data-aos="fade-up">
                        <label>
                            <input type="checkbox" name="categories[]" value="<?php echo $category['id']; ?>" <?php if ( in_array($category['id'], $project['categories']) ) : ?>checked="checked"<?php endif; ?>>
                            &nbsp;<?php echo $category['name']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </fieldset>
            <fieldset style="margin-bottom: 60px;border: 1px solid #ccc;padding: 1em;background:rgba(255,255,255,.5)">
                <legend style="border: 1px solid #ccc;padding: 1em;background: #fff">Détails</legend>
                <p class="alert">
                    <span>* Attention à bien enregistrer avant de supprimer ou créer une ligne « Détail »&nbsp;: </span>
                    <button type="submit" class="btn-thomas-lite">Enregistrer</button>
                </p>
                <?php foreach ( $details as $i => $detail ) : ?>
                    <div data-aos="fade-up" style="display:flex;gap:1em;align-items: flex-end;background: #fff;padding: .5em;margin: 0 1em .7em;border: 1px solid #ccc;">
                        <input type="hidden" name="details[]" value="<?php echo $detail['id']; ?>">   
                        <label class="field">
                            <?php if ( $i==0 ): ?><span>Étiquette</span><br><br><?php endif; ?>
                            <input type="text" name="label_<?php echo $detail['id']; ?>" value="<?php echo $detail['label']; ?>">
                        </label>
                        <label class="field">
                            <?php if ( $i==0 ): ?><span>Valeur</span><br><br><?php endif; ?>
                            <input type="text" name="value_<?php echo $detail['id']; ?>" value="<?php echo $detail['value']; ?>">
                        </label>
                        <label class="field">
                            <?php if ( $i==0 ): ?><span>Ordre</span><br><br><?php endif; ?>
                            <input type="text" name="sort_order_<?php echo $detail['id']; ?>" value="<?php echo $detail['sort_order']; ?>" size="4">
                        </label>
                        <a href="<?= $router->generate('delete_detail', ['id' => $detail['id']]) ?>" class="btn-thomas-lite">Suppr.</a>
                    </div>
                <?php endforeach; ?>
                <p>
                    <a href="<?= $router->generate('add_detail', ['id' => $id]) ?>" class="btn-thomas">Ajouter une ligne « Détail »</a>
                </p>
                <div data-aos="fade-up" style="background: rgba(255, 255, 255, 1);margin: 1em;padding: 1em;border: 1px solid #ccc;border-radius: 4px;">
                    <label class="field">
                        <span>Visuel « Détail »</span><br>
                        <input type="hidden" name="thumbnail_old_details" value="<?php echo $project['thumbnail_details']; ?>">
                        <input type="file" name="thumbnail_details"><br>
                        <?php if ( $project['thumbnail_details'] != '' ) : ?>
                            <a href="/<?php echo $project['thumbnail_details']; ?>" target="_blank"><img src="/<?php echo $project['thumbnail_details']; ?>" style="max-height:150px"></a><br>
                            <a href="<?= $router->generate('delete_thumbnail_details', ['id' => $id]) ?>" class="btn-thomas-lite">Supprimer</a>
                        <?php endif; ?>
                    </label>
                </div>
            </fieldset>
            <fieldset style="margin-bottom: 60px;border: 1px solid #ccc;padding: 1em;background:rgba(255,255,255,.5)">
                <legend style="border: 1px solid #ccc;padding: 1em;background: #fff">Savoir-faire</legend>
                <p class="alert">
                    <span>* Attention à bien enregistrer avant de supprimer ou créer une ligne « Savoir-faire »&nbsp;: </span>
                    <button type="submit" class="btn-thomas-lite">Enregistrer</button>
                </p>
                <?php foreach ( $savoir_faire as $i => $savoir ) : ?>
                    <div data-aos="fade-up" style="display:flex;gap:1em;align-items: flex-end;background: #fff;padding: .5em;margin: 0 1em .7em;border: 1px solid #ccc;">
                        <input type="hidden" name="savoir_faire[]" value="<?php echo $savoir['id']; ?>"> 
                        <label class="field">
                            <?php if ( $i==0 ): ?><span>Savoir-faire</span><br><br><?php endif; ?>
                            <input type="text" name="savoir_faire_value_<?php echo $savoir['id']; ?>" value="<?php echo $savoir['value']; ?>">
                        </label>
                        <label class="field">
                            <?php if ( $i==0 ): ?><span>Ordre</span><br><br><?php endif; ?>
                            <input type="text" name="savoir_faire_sort_order_<?php echo $savoir['id']; ?>" value="<?php echo $savoir['sort_order']; ?>" size="4">
                        </label>
                        <a href="<?= $router->generate('delete_savoir_faire', ['id' => $savoir['id']]) ?>" class="btn-thomas-lite">Suppr.</a>
                    </div>
                <?php endforeach; ?>
                <p>
                    <a href="<?= $router->generate('add_savoir_faire', ['id' => $id]) ?>" class="btn-thomas">Ajouter une ligne « Savoir-faire »</a>
                </p>
                <div data-aos="fade-up" style="margin-left:1em;margin-right:1em;">
                    <label class="discuss-project__field field">
                        <span>Contenu « Savoir-faire »</span><br>
                        <textarea name="content_savoir_faire"><?php echo ( isset($_SESSION['content_savoir_faire']) ) ? $_SESSION['content_savoir_faire'] : $project['content_savoir_faire']; ?></textarea>
                    </label>
                </div>
                <div data-aos="fade-up" style="background: rgba(255, 255, 255, 1);margin: 1em;padding: 1em;border: 1px solid #ccc;border-radius: 4px;">
                    <label class="field">
                        <span>Visuel « Savoir-faire »</span><br>
                        <input type="hidden" name="thumbnail_old_savoir_faire" value="<?php echo $project['thumbnail_savoir_faire']; ?>">
                        <input type="file" name="thumbnail_savoir_faire"><br>
                        <?php if ( $project['thumbnail_savoir_faire'] != '' ) : ?>
                            <a href="/<?php echo $project['thumbnail_savoir_faire']; ?>" target="_blank"><img src="/<?php echo $project['thumbnail_savoir_faire']; ?>" style="max-height:150px"></a><br>
                            <a href="<?= $router->generate('delete_thumbnail_savoir_faire', ['id' => $id]) ?>" class="btn-thomas-lite">Supprimer</a>
                        <?php endif; ?>
                    </label>
                </div>
            </fieldset>
        <?php endif; ?>
        <button class="discuss-project__send btn--theme-black btn aos-init" type="submit" data-aos="fade-up">
            <span class="btn__text"><?php echo (  $id != '' ) ? 'Valider les modifications' : 'Créer le projet'; ?></span>
            <span class="btn__icon">
                <svg width="19" height="19">
                    <use xlink:href="#link-arrow"></use>
                </svg>
            </span>
        </button>
    </form>

    <p>&nbsp;</p>

</section>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.css" />
<script src="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.umd.js"></script>
<script>
const {ClassicEditor,Essentials,Paragraph,Bold,Italic,Link,List,DecoupledEditor,AutoLink,Autosave,BlockQuote,Code,Heading,HorizontalLine,Subscript,Superscript,SourceEditing} = CKEDITOR;
var cfg = {
    licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzI4NDE1OTksImp0aSI6IjcxNmUwMjMyLWI5ZDUtNGM5Ni05MGFlLTk2NmM4MDAxMDVkMSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjcxODFiYzUxIn0.mD8Zal7wm0PnzjjKFJDXMhevyaybmXwNLkF7VS6yt5bPU30OTwE0j6Qmv0xwpHH6fcM4sTeKSa6cAIiwRZARtw', 
    plugins: [AutoLink,Autosave,BlockQuote,Bold,Code,Essentials,Heading,HorizontalLine,Italic,Link,List,Paragraph,Subscript,Superscript,SourceEditing],
    toolbar: {
        items: ['sourceEditing','|','heading','|','bold','italic','subscript','superscript','code','|','horizontalLine','link','blockQuote','|','bulletedList','numberedList'],
        shouldNotGroupWhenFull: false
    },
    heading: {
        options: [
            {model: 'paragraph',title: 'Paragraph',class: 'ck-heading_paragraph'},
            {model: 'heading2',view: 'h2',title: 'Heading 2',class: 'ck-heading_heading2'},
            {model: 'heading3',view: 'h3',title: 'Heading 3',class: 'ck-heading_heading3'},
            {model: 'heading4',view: 'h4',title: 'Heading 4',class: 'ck-heading_heading4'},
            {model: 'heading5',view: 'h5',title: 'Heading 5',class: 'ck-heading_heading5'},
            {model: 'heading6',view: 'h6',title: 'Heading 6',class: 'ck-heading_heading6'}
        ]
    },
};
ClassicEditor.create( document.querySelector( '[name="content"]' ), cfg );
ClassicEditor.create( document.querySelector( '[name="content_savoir_faire"]' ), cfg );
</script>
