<?php
require_once __DIR__ . "/env.php";
require_once PROJROOT . "/dbConnect.php";
require_once PROJROOT . "/entity/media.php";
require_once PROJROOT . "/entity/tool.php";
require_once PROJROOT . "/entity/project.php";
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE-edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Axel Schwindenhammer - Développeur Web</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <header>
            <nav class="navbar">
                <img
                    src="assets/icons/dev.png"
                    alt="logo developpeur web axel schwindenhammer"
                    class="navbar navbar__logo"
                />
                <div class="navbar navbar__linkBlock">
                    <a class="navbar navbar__link" href="">A Propos</a>
                    <a class="navbar navbar__link" href="#work">Mon Travail</a>
                    <a class="navbar navbar__link" href="#contact">Contact</a>
                </div>
            </nav>
        </header>
        <main>
            <section class="sectionBio">
                <article>
                    <div class="sectionBio sectionBio__profile">
                        <img
                            class="sectionBio sectionBio__img"
                            src="assets/images/profile.jpg"
                            alt="photo de Axel Schwindenhammer"
                        />
                        <h3 class="sectionBio__name">Axel Schwindenhammer</h3>
                        <p>Dévelopeur fullstack junior</p>
                    </div>
                    <div class="sectionBio sectionBio__description">
                        <h2>Bio:</h2>
                        <p>
                            Depuis toujours attiré par le milieu de la tech, j'
                            avance guidé par une curiosité sans fond et une
                            pérsévérance sans failles.<br />
                            Mon esprit d' analyse vient à bout de tous les
                            casses-têtes.
                        </p>
                    </div>
                </article>
            </section>
            <!-- SECTION PROJECTS ------------------>
            <section class="sectionWork" id="work">
            <?php $projects = Project::get3Enabled(); ?>
                <h1 class="sectionWork__title">Mon Travail</h1>
                <div class="sectionWork__eltContainer">
                <?php foreach ($projects as $project): ?>
                    <article class="workElt">
                        <img
                            class="workElt__img"
                            src="<?php echo $project
                              ->getPicture()
                              ->getAbsPath(); ?>"
                            alt="<?php echo $project->getDescriptionShort(); ?> fait par Axel Schwindenhammer"
                        />
                        <div class="workElt__content">
                            <h3 class="workElt__title">
                              <?php echo $project->getName(); ?>
                            </h3>
                            <p class="workElt__description">
                                <?php echo $project->getDescriptionShort(); ?>
                            </p>
                            <a class="workElt__link" href="<?php echo $project->getUrl(); ?>">
                            <?php echo $project->getName(); ?></a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>
            <!--    SECTION TOOLS -------------------------->
            <?php $tools = Tool::getAllEnabled(); ?>
            <section class="sectionTools">
                <div class="sectionTools__container">
                <?php foreach ($tools as $tool): ?>
                    <a href="<?php echo $tool->getUrl(); ?>">
                      <article>
                          <img
                              class="sectionTools__img"
                              src="<?php echo $tool
                                ->getPicture()
                                ->getAbsPath(); ?>"
                              alt="<?php echo $tool->getAltSeo(); ?>"
                              height="80"
                              width="80"
                          />
                          <h3 class="sectionTools__title"><?php echo $tool->getName(); ?></h3>
                      </article>
                    </a>
                <?php endforeach; ?>
                </div>
            </section>
            <section class="sectionContact" id="contact">
                <div class="sectionContact__container">
                    <div class="sectionContact__text">
                        <h3 class="sectionContact__text--title">
                            Travaillons ensemble !
                        </h3>
                        <p>
                            Vous avez un projet ? <br/>
                            Vous souhaitez m' embaucher ?<br/>
                            <br />
                            J' ai hâte de vous lire.
                        </p>
                    </div>
                    <form class="sectionContact__form" action="submit_contact.php" method="post">
                        <div class="sectionContact__form--col">
                            <label
                                for="nom"
                                class="sectionContact__form-inputLabel"
                                >Nom</label
                            >
                            <input
                                class="sectionContact__form-input"
                                type="text"
                                name="nom"
                            />
                            <label
                                for="prenom"
                                class="sectionContact__form-inputLabel"
                                >Prénom</label
                            >
                            <input
                                class="sectionContact__form-input"
                                type="text"
                                name="prenom"
                            />
                            <label
                                for="email"
                                class="sectionContact__form-inputLabel"
                                >E-mail</label
                            >
                            <input
                                class="sectionContact__form-input"
                                type="email"
                                name="email"
                                required
                            />
                        </div>
                        <div class="sectionContact__form--col">
                            <label
                                class="sectionContact__form-inputLabel"
                                for="message"
                                >Votre message</label
                            >
                            <textarea
                                class="sectionContact__form-input sectionContact__form-input--area"
                                id=""
                                name="message"
                                cols="30"
                                rows="5"
                                required
                            ></textarea>
                            <button class="btn sectionContact__form-submitButton" type="submit" >
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer class="footer">
            <a href="https://github.com/ahammer0">Mon github</a>
             <a href="admin/admin.php">Admin</a>
        </footer>
    </body>
</html>
