<?php get_header(); ?>

<?php

/* echo "<pre>";
print_r(get_field("hero_image")["sizes"]["1536x1536"]);
echo "</pre>";
die(); */
?>

<div class="main-container">
    <header>
        <p>PALVELUN TARJOAA <b>KANSALLISTEATTERI</b></p>
    </header>
    <section id="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-heading"><?php the_field("hero_heading"); ?></h1>
                <p class="hero-text">
                    <?php the_field("hero_text"); ?>
                </p>
                <a href="#osallistu" class="hero-cta">OSALLISTU CTA</a>
            </div>
            <div class="hero-image-container">
                <img src="<?php echo get_field("hero_image")["sizes"]["1536x1536"]; ?>" alt="hero-image" class="hero-image" />
            </div>
        </div>
        <div class="background-image-fade"> </div>
    </section>

    <?php
    $db = mysqli_connect("localhost", get_field("db_user"), get_field("db_password"), get_field("db_name"));
    $query = "SELECT * FROM images";

    $data = mysqli_query($db, $query);

    ?>

    <div class="content">
        <section id="kuvat">
            <div class="images">
                <div class="images-heading">
                    <h2 class="heading">Kilpailun kuvat otsikko</h2>
                    <p class="small">Aikaa osallistua ja äänestää 1.2.2020 asti</p>
                </div>
                <div class="images-list">
                    <ul class="item-list">
                        <?php
                        $result = mysqli_fetch_all(
                            $data,
                            $resulttype = MYSQLI_ASSOC
                        );
                        $numberOfPosts = sizeof($result, $mode = COUNT_NORMAL);
                        $numberOfPages = floor($numberOfPosts / 8) + 1;

                        $pageNumber = 1;
                        $result = array_reverse($result, FALSE);

                        if (isset($_POST["page"])) {
                            $pageNumber = $_POST["page"];
                            $_POST = array();
                        }

                        if (isset($_POST["next"])) {
                            $pageNumber = $pageNumber + 1;
                            /*if ($pageNumber >= $numberOfPages) {
                                $pageNumber = $numberOfPages;
                            } */
                            $_POST = array();
                        }

                        $lastIndex = ($pageNumber * 8) - 1; //2*8 -1 = 15 
                        if ($lastIndex < 8) {
                            $lastIndex = 7;
                        }
                        if ($lastIndex > $numberOfPosts - 1) {
                            $lastIndex = $numberOfPosts - 1;
                        }

                        if ($lastIndex <= 7) {
                            $firstIndex = 0;
                        } else {
                            $firstIndex = $pageNumber * 8 - 8;
                        }

                        $postsToShow = [];
                        $tmp = 0;
                        for ($i = $firstIndex; $i <= $lastIndex; $i++) {
                            $postsToShow[$tmp] = $result[$i];
                            $tmp++;
                        }

                        $tmp = 0;

                        foreach ($postsToShow as $row) {
                            echo "<li class=\"list-item\">
                <div class=\"small-img\">
                <img src=" . content_url() . "/uploads/images/" . $row["img"] . " alt=\"404\"/>
                </div>
                <button type=\"button\" class=\"vote-btn\">ÄÄNESTÄ</button>
                <button type=\"button\" class=\"share-btn\">JAA</button>
                <p class=\"item-heading\">" . $row["title"] . "</p>
                <p class=\"item-creator\">" . $row["person_name"] . "</p>
                </li>";
                        } ?>
                    </ul>
                    <div class="numbers">

                        <?php for ($i = 1; $i <= $numberOfPages; $i++) {
                            echo "<form action=\"" . site_url("#kuvat") . "\" method=\"post\">";
                            echo "<input type=\"hidden\" name=\"page\" value=" . $i . "\">";
                            if ($i == $pageNumber) {
                                echo "<span class=\"number current\"> <b>" . $i . "</b> </span>";
                            } else {
                                echo "<button type=\"submit\" class=\"number\"> <b>" . $i . "</b> </button>";
                            }
                            echo "</form>";
                        } ?>
                        <form action=<?php echo "\"" . site_url("#kuvat") . "\""; ?> method="post">
                            <input type="hidden" name="next" />
                            <button class="next number"> <b>Seuraava</b> </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section id="osallistu">
            <div class="participate">
                <div class="left-side">
                    <h2 class="heading"><?php echo the_field("osallistu_heading"); ?></h2>
                    <p>
                        <?php echo the_field("osallistu_text"); ?>
                    </p>
                </div>
                <div class="right-side">
                    <?php if ($bool == true) {
                        echo "<p> kaikki blaa blaa </p>";
                    }; ?>
                    <form method="post" class="form" enctype="multipart/form-data">
                        <p class="label">Kuvan otsikko</p>
                        <input type="text" name="title" id="form-title" />
                        <p class="label">Nimi *</p>
                        <input type="text" name="name" id="form-name" />
                        <p class="label">Sähköposti *</p>
                        <input type="email" name="email" id="form-email" />
                        <br />
                        <button type="button" class="input-file" id="input-file-btn">VALITSE KUVA</button>
                        <input type="file" name="image" id="form-input" class="input-file-hidden" />
                        <p class="file-text" id="file-text">Ei tiedostoa valittuna</p>
                        <div class="accept-tas">
                            <input type="checkbox" name="tas-check" class="tas-check" />
                            <p class="tas-link">Hyväksyn kilpailun <a href="#ehdot">säännöt ja ehdot</a></p>
                        </div>


                        <button type="submit" class="submit-btn" id="submit-btn" name="submit-btn">OSALLISTU</button>
                    </form>
                </div>
            </div>
        </section>
        <script>
            const importButton = document.getElementById("form-input");
            const customButton = document.getElementById("input-file-btn")
            const fileText = document.getElementById("file-text");

            customButton.addEventListener("click", function() {
                importButton.click();
            })

            importButton.addEventListener("change", function() {
                if (importButton.value) {
                    customButton.classList.add("file-loaded");
                    fileText.innerHTML = "Tiedosto: " + importButton.value;
                }
            })
        </script>

        <section id="ehdot">
            <div class="tas">
                <div class="right-side">
                    <h2>Säännöt ja ehdot</h2>
                    <p>
                        Kilpailuaika 1.1.2020-1.2.2020<br />Kilpailun järjestää
                        Kansallisteatteri<br />Lorem ipsum dolor sit amet<br />Yms.
                    </p>
                </div>
                <div class="main-tas">
                    <p>
                        <?php echo the_field("ehdot"); ?>
                    </p>
                </div>
            </div>
        </section>
    </div>
    <footer class="footer">
        <strong>KANSALLISTEATTERI</strong>
    </footer>
</div>
</div>


<?php get_footer(); ?>