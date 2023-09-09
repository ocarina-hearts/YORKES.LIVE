<!doctype html>
<html lang="en">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-659MYBSRDE"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-659MYBSRDE');
    </script>



    <!-- START OF PHP  -->

    <?php include "db_singlebeach.php" ?>

    <!-- END OF PHP -->

    <div id="bg-wavesUD" class="p-0 m-0">

    </div>

    <!-- FOOTER -->
    <div id="footer" class="bg-rich text-light mt-0">
        <footer class="text-center text-lg-start bg-teal charleston">

            <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom border-orange">
                <div class="me-5 d-none d-lg-block">
                    <span>Social Social networks might be something in the future.</span>
                </div>
                <div class="d-flex">
                    <p class="me-4 text-blue fake-anchor" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook Coming Soon."><i class="fab fa-facebook-f fa-2xl" role="img"
                            aria-label="Facebook link coming soon"></i></p>
                    <p class="me-4 text-blue fake-anchor" data-bs-toggle="tooltip" data-bs-placement="top" title="Google Coming Soon."><i class="fab fa-google fa-2xl" role="img"
                            aria-label="Google link coming soon"></i></p>
                    <p class="me-4 text-blue fake-anchor" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram Coming Soon."><i class="fab fa-instagram fa-2xl" role="img"
                            aria-label="Instagram link coming soon"></i></p>
                    <a class="me-4 text-blue fake-anchor" href="https://github.com/DaveWestbury" data-bs-placement="top" title="Github Link"><i class="fab fa-github fa-2xl" role="img"
                            aria-label="Github coming soon"></i></a>
                </div>

            </section>

            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <div class="row">
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto text-center mb-4">
                            <h4 class="text-uppercase">

                                YORKES<span class="text-orange">.</span>LIVE
                            </h4>
                            <p>
                                Thank you for taking the time to look through this website and arrive at the end. I
                                appreciate you!
                            </p>
                            <img class="" src="./img/cobranding-ondark-mono.png" height='100px' alt="SA Great!">
                        </div>

                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
                            <!-- Links -->
                            <h5 class="text-uppercase fw-bold mb-4">
                                Info
                            </h5>

                            <a class="text-light" href="https://yorkepeninsula.com.au/surfing">Surf - YP Tourism</a><br>
                            <a class="text-light" href="https://en.wikipedia.org/wiki/Shaka_sign">Wikipedia - Shaka Handsign</a>


                        </div>

                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                Useful links
                            </h6>
                            <p>
                                <a href="#landing" class="text-light">Top</a><br>
                                <a href="privacy-policy-yorkes.pdf" class="text-light">Yorkes Live Privacy Policy</a><br>
                                <a href="https://policies.google.com/technologies/partner-sites?hl=en-GB&gl=uk" class="text-light">Google Analytics Privacy Policy</a>
                            </p>

                        </div>

                    </div>
                </div>
            </section>

            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.09);">
                <a class="text-light" style="  font-family: Arial, Helvetica, sans-serif;" href="http://westburydigital.com.au">W E S T B U R Y . D I G I T A L</a>
            </div>

        </footer>


    </div> <!--  END FOOTER -->




    <script>
    //LOGO BOUNCE
    var atPageTop = true;
    var scroll = 0;
    let throttleTimer;

    const throttle = (callback, time) => {
        if (throttleTimer) return;
        throttleTimer = true;
        setTimeout(() => {
            callback();
            throttleTimer = false;
        }, time);

    }

    const logobounce = () => {

        //console.log("fired");
        scroll = parseInt($(window).scrollTop()); //current scroll position

        if (scroll > 0 && (atPageTop == true)) {
            // $("#nav-height").animate({
            //     'height': '50px'
            // }, 100)
            $("#nav-color").animate({
                'min-height': '80px'
            }, 100)
            $("#nav-color").animate({
                'background-color': 'rgb(3, 25, 38, 1)'
            }, 100)
            $("#brandbox").delay(100).effect("bounce", {
                times: 3
            })
            atPageTop = false;

        } else if (scroll == 0) {
            // $("#nav-height").animate({
            //     'height': '120px'
            // }, 100)
            $("#nav-color").animate({
                'min-height': '120px'
            }, 100, )
            $("#nav-color").animate({
                'background-color': 'rgb(3, 25, 38, .7)'
            }, 100)
            $("#brandbox").delay(100).effect("bounce", {
                times: 3
            })
            atPageTop = true;
        }
    }
    window.addEventListener("scroll", () => {
        throttle(logobounce, 250);
    });
    </script>

    <script>
    // // init Masonry
    // var $grid = $('.grid').masonry({
    //     itemSelector: '.grid-item',
    //     percentPosition: true,
    //     columnWidth: '.grid-sizer'
    // });
    // // layout Masonry after each image loads
    // $grid.imagesLoaded().progress(function() {
    //     $grid.masonry();
    // });
    </script>


    <!-- JQUERY UI -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.1/jquery-ui.min.js"></script>

    <!-- masonry for pinterest columns -->
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D"
        crossorigin="anonymous" async></script>

    <script>
    var $grid = $('#gallery').imagesLoaded(function() {
        $grid.masonry({
            itemSelector: '.grid-item'
        });
    });
    </script>


    <script>
    //intialise tooltips (must be after min.js)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    </script>

</body>

</html>