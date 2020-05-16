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
                <h1 class="hero-heading">Osallistumisen pääotsikko</h1>
                <p class="hero-text">
                    Lyhyt kuvaus. Lorem ipsum dolor sit amet, consectetuer adipiscing
                    elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper
                    quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae
                    arcu.
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
    $db = mysqli_connect("localhost", "wordpressuser", "wordpresspassword", "wordpressdb");
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
                    <h2 class="heading">Osallistu kilpailuun!</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed
                        posuere interdum sem. Quisque ligula eros ullamcorper quis,
                        lacinia quis facilisis sed sapien. </p>
                    <p> Mauris varius diam vitae arcu.
                        Sed arcu lectus auctor vitae, consectetuer et venenatis eget
                        velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus.
                        Donec ultricies nisl ut felis, suspendisse potenti. Lorem ipsum
                        ligula ut hendrerit mollis, ipsum erat vehicula risus, eu suscipit
                        sem libero nec erat. Aliquam erat volutpat. </p>
                    <p> Lorem ipsum dolor sit
                        amet, consectetuer adipiscing elit. Sed posuere interdum sem.
                        Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed
                        sapien.
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
                        <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti. Lorem ipsum ligula ut hendrerit mollis, ipsum erat vehicula risus, eu suscipit sem libero nec erat. Aliquam erat volutpat. Sed congue augue vitae neque. Nulla consectetuer porttitor pede. Fusce purus morbi tortor magna condimentum vel, placerat id blandit sit amet tortor. </p>
                        <p>Mauris sed libero. Suspendisse facilisis nulla in lacinia laoreet, lorem velit accumsan velit vel mattis libero nisl et sem. Proin interdum maecenas massa turpis sagittis in, interdum non lobortis vitae massa. Quisque purus lectus, posuere eget imperdiet nec sodales id arcu. Vestibulum elit pede dictum eu, viverra non tincidunt eu ligula. </p>
                        <p>Nam molestie nec tortor. Donec placerat leo sit amet velit. Vestibulum id justo ut vitae massa. Proin in dolor mauris consequat aliquam. Donec ipsum, vestibulum ullamcorper venenatis augue. Aliquam tempus nisi in auctor vulputate, erat felis pellentesque augue nec, pellentesque lectus justo nec erat. Aliquam et nisl. Quisque sit amet dolor in justo pretium condimentum.</p>
                        <p>Vivamus placerat lacus vel vehicula scelerisque, dui enim adipiscing lacus sit amet sagittis, libero enim vitae mi. In neque magna posuere, euismod ac tincidunt tempor est. Ut suscipit nisi eu purus. Proin ut pede mauris eget ipsum. Integer vel quam nunc commodo consequat. Integer ac eros eu tellus dignissim viverra. Maecenas erat aliquam erat volutpat. Ut venenatis ipsum quis turpis. Integer cursus scelerisque lorem. Sed nec mauris id quam blandit consequat. Cras nibh mi hendrerit vitae, dapibus et aliquam et magna. Nulla vitae elit. Mauris consectetuer odio vitae augue.</p>
                        <p>Cras lobortis sem ultrices leo. Donec magna fusce ac ante. Nullam est nisi blandit eget, suscipit vitae posuere quis ante. Quisque vitae tortor tellus feugiat adipiscing. Morbi ac elit et diam bibendum bibendum. </p>



                        <p>Suspendisse id diam, donec adipiscing vulputate metus. Cras pellentesque vestibulum sem. Maecenas ut elit quis nisl vestibulum bibendum. Aenean eu erat quis turpis consequat vehicula. Morbi lacus velit, tristique ut iaculis volutpat in velit. Duis nec mauris et velit mollis aliquam, nullam posuere. Mauris at turpis sit amet dui imperdiet lobortis, proin eu felis.</p>

                        <p>Donec nec dui, in viverra tristique sapien. Suspendisse tincidunt consequat ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut lacinia luctus nunc. Etiam molestie hendrerit risus. Curabitur venenatis risus varius odio. Quisque elit ante, lacinia eget mollis sed, fermentum nec nisl. Nullam volutpat odio dolor tempor posuere. Suspendisse et elit vel sem interdum consequat. Aenean pulvinar nisl vel neque. Morbi mi ac neque ullamcorper dignissim. Nulla suscipit ipsum. Duis adipiscing turpis vitae turpis. In quis nisl ut tincidunt felis sit amet ipsum. Fusce facilisis nam tortor orci, facilisis sit amet accumsan vel, aliquam nec odio. Fusce accumsan libero et nisi. Lorem ipsum pede id faucibus aliquet, diam velit commodo elit, quis ultricies justo metus sit amet metus. Suspendisse interdum nulla sit amet enim. Etiam ultrices fusce nibh. Maecenas sed dolor vitae nisi volutpat commodo. Nulla interdum egestas lectus. Maecenas imperdiet arcu et orci.</p>
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