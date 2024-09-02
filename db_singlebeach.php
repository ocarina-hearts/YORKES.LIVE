<?php

require"db_connect.php"; 



if($connectToServer)
{

    // Use $_GET to retrieve the 'location' parameter
$cleanParam = isset($_GET['location']) ? preg_replace("/[^a-zA-Z0-9]+/", "", $_GET['location']) : '';


    //echo $cleanParam;

    
	$sql = "SELECT * FROM beaches WHERE name='$cleanParam' ";

	$result = mysqli_query($connectToServer, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {

            //loads variables and sanitises output for XSS attack. 
            $safeName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
            $safeSpeltName = $row['spelt_name'] ;//$row['spelt_name'] //htmlspecialchars($row['spelt_name'], ENT_QUOTES, 'UTF-8');
            $safeBigWriteUp = $row['big_write_up']; //htmlspecialchars($row['big_write_up'], ENT_QUOTES, 'UTF-8');
            $safeHistory =  $row['history'] ;//htmlspecialchars($row['history'], ENT_QUOTES, 'UTF-8');
            $safeSurf = $row['surf']; //htmlspecialchars($row['surf'], ENT_QUOTES, 'UTF-8');
            $safeCamping = $row['camping'] ;//htmlspecialchars($row['camping'], ENT_QUOTES, 'UTF-8');
            $safeAltNames = $row['alt_names'] ;//htmlspecialchars($row['alt_names'], ENT_QUOTES, 'UTF-8');
            $safeAccommodation = $row['accommodation']; //htmlspecialchars($row['accommodation'], ENT_QUOTES, 'UTF-8');
            $safeTitleImage = $row["title_image"];

            $safeInstagram = $row['instagram'];
            $safeGoogleMaps = $row['googlemap'];


            //handles icons
	        $iconsArray = explode(",", $row["icons"]);
	        $iconsOutput = ""; 
	
            for ($i = 0; $i <= count($iconsArray); $i++) {
                
                if ($iconsArray[$i] == "swimming") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-person-swimming display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Swimming Beach' role='img' aria-label='Swimming Beach'></i><p>Swimming Beach</p></div> ";

                } elseif ($iconsArray[$i] == "fishing") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-fish display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Fishing Beach' role='img' aria-label='Fishing Beach'></i><p>Fishing Beach</p></div>";

                } elseif ($iconsArray[$i] == "caravan") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-caravan display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Campground' role='img' aria-label='Campground'></i><p>Campgrounds Close</p></div>";

                } elseif ($iconsArray[$i] == "toilets") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-restroom display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Toilets' role='img' aria-label='Toilets'></i><p>Toilets Avaliable</p></div>";

                } elseif ($iconsArray[$i] == "lookout") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-binoculars display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Lookout / Photographic' role='img' aria-label='Lookout / Photographic'></i><p>Lookout/Photographic</p></div>";

                } elseif ($iconsArray[$i] == "warning") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-triangle-exclamation display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Dangerous Beach' role='img' aria-label='Dangerous Beach'></i><p>Dangerous Beach</p></div>";

                } elseif ($iconsArray[$i] == "vehicle") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-truck-monster display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Vehicle Access'  role='img' aria-label='Vehicle Access'></i><p>4WD Access</p></div>";

                } elseif ($iconsArray[$i] == "surf") {

                    $iconsOutput .= "<div class='col-6'><i class='fa-solid fa-water display-5' data-bs-toggle='tooltip' data-bs-placement='top' title='Surf' role='img' aria-label='Surf'></i><p>Surf Beach</p></div>";
                }		
            }


            //handles what3words locations and iframes/modals
            $w3wnameArray = explode(",", htmlspecialchars($row['w3wname'], ENT_QUOTES, 'UTF-8'));
            $w3wArray = explode(",", htmlspecialchars($row['w3w'], ENT_QUOTES, 'UTF-8'));

            $w3woutput = "";
            
            if (empty($row["w3wname"]) || empty($row["w3w"])) {
                $w3woutput = "This table is empty.";
            } else {

                for ($i = 0; $i < count($w3wArray); $i++) {
            
                $w3woutput .= "
                                <p class='text-center'><b>" . $w3wnameArray[$i]. "</b><br>
                                <a class='text-primary' type='button' data-bs-toggle='modal' data-bs-target='#modal-" . $i. "'>" . $w3wArray[$i]. "</a></p>
                                <div class='modal fade' id='modal-" . $i. "' tabindex='-1' aria-labelledby='" . $w3wnameArray[$i]. "' aria-hidden='true'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='exampleModalLabel'>" . $w3wnameArray[$i]. "</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body '>
                                                        <iframe src='https://map.what3words.com/" . $w3wArray[$i]. "?utm_source=iframe' frameborder='0' style='border:0;width:100%;height:800px;'></iframe>
                                            </div>
                                            <div class='modal-footer text-center'>
                                                <p>" . $w3wnameArray[$i]. "</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                }
             }





            //handles gallery - vars it into big string below. 
            $galleryArray = explode(",", htmlspecialchars($row['gallery'], ENT_QUOTES, 'UTF-8'));
            $linkArray = explode(",", htmlspecialchars($row['gallery_link'], ENT_QUOTES, 'UTF-8'));

	        $galleryOutput = ""; 
            $extraText = "";

            if (count($galleryArray) === 0) {
                $extraText = "We dont have any images for this beach.<br>"; 
            }
            else {

            for ($i = 0; $i < count($galleryArray); $i++) {

                if ($linkArray[$i] != "nul"){
                    $moneySymbol = "<i class='fa-solid fa-tag overflow-hidden' style='position:absolute; bottom:-5px; right:0px; font-size: 33px; color: #98DB4C;'></i>";
                    $link = "<a href='" . $linkArray[$i] . "'>This image can be brought as a print here. - " . $linkArray[$i] . "</a>";

                } else {
                    $moneySymbol = "";
                    $link = "<p>This image isn't for purchase. </p>";
                }

                $galleryOutput .= 
                
                "<div class='col-6 col-md-4 mb-3  grid-item'>
                                    <a type='button' data-bs-toggle='modal' data-bs-target='#Modal-" . $galleryArray[$i]. "'>
                                        <div class='hoverexpand'>
                                            <picture>
                                                <img class='img-fluid' src='./gallery/". $safeName . "/" . $galleryArray[$i]. ".jpg' alt='Image of " . $safeSpeltName . " '>
                                            </picture>
                                            " . $moneySymbol . "
                                        </div>
                                    </a>
                                    <div class='modal fade' id='Modal-" . $galleryArray[$i]. "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog modal-xl'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>" . $safeSpeltName . "</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body '>
                                                    <picture>
                                                        <img class='img-fluid' src='./gallery/". $safeName . "/" . $galleryArray[$i]. ".jpg' alt='Image of " . $safeSpeltName . " '>
                                                    </picture>
                                                </div>
                                                <div class='modal-footer text-center'>
                                                    " . $link . "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";

            }
        }

                    //handles sponsors output
                    require "db_connect.php";

                    if ($connectToServer) {
                        // Use $_GET to retrieve the 'location' parameter
                        $randomId = rand(1, 5);
                        $sql = "SELECT * FROM `sponsors` WHERE `id` = $randomId";
                        $result = mysqli_query($connectToServer, $sql);
                        
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Load variables and sanitize output for XSS attack
                                    $sponsorName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                    $sponsorSpeltName = htmlspecialchars($row['speltname'], ENT_QUOTES, 'UTF-8');
                                    $sponsorWriteUp = htmlspecialchars($row['writeup'], ENT_QUOTES, 'UTF-8');
                                    $sponsorURL = htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8');
                                    $sponsorimg = htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8');
                                }
                                // Output the sanitized sponsor name
                               
                            } else {
                              
                            }
                        } else {
                            // Error executing query
                            echo "Error executing query: " . mysqli_error($connectToServer);
                        }
                        
                        mysqli_close($connectToServer);
                    } else {
                        // Error connecting to the server
                        echo "Error connecting to the database.";
                    }
        
        
                   
                    $sponsorOutput = "      <small>Local Sponsor</small>
                                            <a href='" . $sponsorURL . "' class='stretched-link'></a>
                                            <div class='d-flex justify-content-center '>
                                                <img class='img-fluid pb-3' width='60%' src='./img/sponsors/" . $sponsorimg . ".png'>
                                            </div>
                                            <h3 class='text-center text-uppercase'>" . $sponsorSpeltName . "<span class='text-orange'>.</span></h3>
                                            <p>" . $sponsorWriteUp . "</p>";
        

           echo "    
           <title>YORKES.LIVE | " . $safeSpeltName .  " </title>
           <meta charset='UTF-8'>
           <meta name='description' content='This is " . $safeSpeltName .  " on the sunny Yorke Peninsula. Come learn more about the beach and what it has to offer. Don&apos;t forget to vote for  " . $safeSpeltName .  " . '>
           <meta name='keywords' content='yorkes " . $safeSpeltName .  " yorke peninsula beaches map best surf'>
           <meta name='author' content='Written by D.W. Hills, Length: 1 pages'>
           <meta name='viewport' content='width=device-width, initial-scale=1.0'>
       
           <meta property='og:url' content='https://yorkes.live' />
           <meta property='og:type' content='website' />
           <meta property='og:title' content='Yorkes.Live' />
           <meta property='og:description' content='An interactive map of the Yorke Peninsula&apos;s best beaches. As voted on by you.' />
           <meta property='og:image' content='https://yorkes.live/fb.png' />
       
           <link type='text/css' href='./styles.css' rel='stylesheet' />
       
           <link rel='apple-touch-icon' sizes='180x180' href='./apple-touch-icon.png'>
           <link rel='icon' type='image/png' sizes='32x32' href='./favicon-32x32.png'>
           <link rel='icon' type='image/png' sizes='16x16' href='./favicon-16x16.png'>
           <link rel='manifest' href='/site.webmanifest'>
       
           <!-- MODEL VIEWER -->
           <script type='module' src='https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js'></script>
       
           <!-- BOOTSTRAP CSSs -->
           <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC'
               crossorigin='anonymous'>
       
           <!-- FONTAWESOME -->
           <link href='./fontawesome/css/fontawesome.css' rel='stylesheet'>
           <link href='./fontawesome/css/brands.css' rel='stylesheet'>
           <link href='./fontawesome/css/solid.css' rel='stylesheet'>
       
           <!-- JQUERY -->
           <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
       
       
           <!-- BOOTSTRAP JS -->
           <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM'
               crossorigin='anonymous'>
           </script>
       
       </head>
           
<body data-bs-spy='scroll' data-bs-target='#navbarID'>
<nav id='nav-color' class='navbar fixed-top navbar-expand-sm navbar-dark border-bottom border-3'>

    <a class='navbar-brand text-light' href='./index.php'>
        <h4 id='nav-height' class='d-flex align-content-center flex-wrap'><span id='brandbox' class='align-middle pt-2 ps-4'>YORKES<span class='text-orange'>.</span>LIVE</span></h4>
    </a>
    <button class='navbar-toggler text-light' type='button' data-bs-toggle='collapse' data-bs-target='#navbarID' aria-controls='navbarID' aria-expanded='false'
        aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon '></span>
    </button>
    <div id='navbarID' class='collapse navbar-collapse'>
        <div class='navbar-nav' role=''>
            <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php'><span class='align-middle'>Map</span></a>
            <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php#mainlike'><span class='align-middle'>Beaches</span></a>
            <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php#info'><span class='align-middle'>Info</span></a>
            <a class='nav-link nav-item  nav-text-light ps-2' aria-current='page' href='.index.php#contact'><span class='align-middle'>Contact</span></a>
        </div>
        <ul class='navbar-nav  ms-auto'>
            <li class='nav-item d-flex'>
                <a class='nav-link text-light ' aria-current='page' href='#beaches'>
                    <h4><span id='coins' class='align-middle text-blue p-2 '></span></h4>
</a>
<img id='' class='me-4' src='img/shakawhite.png' width='45px' height='45px' alt='Shaka Icon'>
</li>
</ul>

</div>
</nav>";




//this script sees if there is a image called pano in the gallery folder. if not use the default image.
$directory = 'gallery/'. $safeName .'/';
$imageName = 'pano.jpg';

// Check if the image file exists
$imagePath = $directory . $imageName;

if (file_exists($imagePath)) {

    echo "
    <div style=\"background-image: url('./gallery/". $safeName ."/pano.jpg'); background-position:center; background-size:cover; height: 500px !important; position: relative; z-index: -1;\">
        <p class='sideways-text lead h-100' style='position: absolute; top: 100px; z-index: 1; text-shadow: 0px 0px 5px black, 0px 0px 5px black, 0px 0px 10px black;'>
            <a class='text-white' style='text-decoration: none;' href='./browns/'>Panoramic</a> 
            <span class='squish'>-----------------------</span>
        </p>
    </div>
    
    <div id='bg-wavesUD' class='p-0 m-0' style='margin-top: -80px !important; z-index: 2 !important;'></div>
    <div class='bg-rich'>
        <p class='display-4 text-center feed-your-soul pb-2 text-white m-0'>" . $safeSpeltName . "</p>
    </div>
    <div id='bg-waves' class='m-0 p-0' style='margin-top: -5px !important; z-index: 3 !important;'></div>
    ";
    


} else {
echo "
<div id='navbumper' class='bg-rich' style='height: 120px'></div>
<div id='navbumper' class='bg-rich' style='height: 120px'></div>
<div id='beachlander' class='bg-rich'>
    <div class='text-light'>
        <div class='row gx-0'>
            <div class='mainlike-left col-6 bg-rich d-none d-sm-none d-md-block ' style='position:relative'>
                <p class='display-4 text-center feed-your-soul ps-4'>" . $safeSpeltName . "</p>
                <div class='vr'></div>
                <p class='sideways-text lead h-100'>Beach vibes <span class='squish'>-----------------------</span></p>
            </div>
            <div class='mainlike-right col-md-6 bg-rich text-center'>
                <p class='display-4 text-center feed-your-soul ps-4 d-md-none'>" . $safeSpeltName . "</p>
                <div class='overflow-hidden'>
                    <picture>
                        <source srcset='./img/big/" . $safeName . ".webp'>
                        <img src='./img/big/" . $safeTitleImage . "' class='img-fluid' style='max-width: 400px;' alt='Image of " . $safeSpeltName . " '>
                    </picture>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-12 text-center'>
                <h5 class='h3 feed-your-soul py-2'>Where the sky touches the sea<span class='text-orange'>.</span> </h5>
            </div>
        </div>
    </div>
</div>

<div id='bg-waves'></div>";


}





echo "
<div class='container'>
    <div class='row my-3'>
        <div class='col-md-8'>
            <div class='col-12 border-rich p-3 bg-light h-100 clearfix'>
                <h3 class='text-uppercase py-3'>More information about " . $safeSpeltName . "<span class='text-orange'>.</span></h3>
                <p>" . $safeBigWriteUp . "</p>
                <h3 class='text-uppercase py-3'>History about " . $safeSpeltName . "<span class='text-orange'>.</span></h3>
                <p>" . $safeHistory. "</p>
                <small class='p-0 m-0 float-end'><a class='text-secondary' href='./index.php#contact' data-bs-toggle='tooltip' data-bs-placement='top' title='Take me to contact page.'>Not Correct? Something to add?</a></small>
            </div>
        </div>
        <div class='col-md-4'>
            <div class='col-12'>
                <div class='col-12'>
                    <div class='row text-center py-3 '>
                        " . $iconsOutput . "
                    </div>
                </div>
                <div class='col-12 border-rich bg-light text-center p-3'>
                    <h3 class='text-uppercase'>Alternate names for " . $safeSpeltName . "<span class='text-orange'>.</span></h3>
                    <p>" . $safeAltNames . "</p>
                </div> 
                <div class='col-12 bg-light border-rich p-3 mt-3  position-relative'>
                    <p>" . $sponsorOutput . "</p>
                </div>
                <div class='col-12 bg-light border-rich p-3 mt-3'>
                    <h3 class='text-center text-uppercase'>Surf Report<span class='text-orange'>.</span></h3>
                    <p>" . $safeSurf . "</p>
                </div>
                <div class='col-12 bg-light border-rich p-3 mt-3 clearfix'>
                    <h3 class='text-center text-uppercase'>What3Words Locations<span class='text-orange'>.</span></h3>
                    <p class='text-center'>" . $w3woutput . "</p>
                    <p>Beach Locations can be confusing, <a href='https://what3words.com/about'>What3Words</a> is the perfect way to show locations in a very simple but precise way.</p>
                    <small class='p-0 m-0 float-end'><a class='text-secondary' href='./index.php#contact' data-bs-toggle='tooltip' data-bs-placement='top' title='Take me to contact page.'>Not Correct?</a></small>

                
                
                </div>
            </div>
        </div>
    </div>


    <div class='row '>
        <div class='col-md-6 my-2'>
            <div class='col-12 border-rich bg-light p-3 h-100'>
                <h3 class='text-center  text-uppercase'>Camping near " . $safeSpeltName . "<span class='text-orange'>.</span></h3>

                <ul>
                    " . $safeCamping. "
                </ul>
            </div>
        </div>
        <div class='col-md-6 my-2'>
            <div class='col-12 border-rich bg-light p-3 h-100'>
                <h3 class='text-center text-uppercase'>Accommodation near " . $safeSpeltName . "<span class='text-orange'>.</span></h3>
                <ul>
                    " . $safeAccommodation . "
                </ul>
            </div>
        </div>
    </div>

</div>
<div class='container-fluid'>
    <div class='col-12'>
        <h3 class='text-center my-3 text-uppercase'>Image Gallery of " . $safeSpeltName . "<span class='text-orange'>.</span></h3>
    </div>
    <div id='gallery' class='row' data-masonry='{' percentPosition': true }'>

        " . $galleryOutput . "

    </div>
</div>
<h5 class='h3 feed-your-soul py-2 text-center'>" . $extraText . "Have you taken a photo you would love to <a href='http://yorkes.live/contact'>submit?</a></h5>
</div>
<div class='container'>
    <div class='row py-4'>
        <div class='col-md-4 mb-3 order-md-first order-last'>
            <div class='col-12 text-center border-rich bg-light h-100 py-3' style='min-height: 600px;'>
                <h3 class='text-uppercase'>Instagram Posts<span class='text-orange'>.</span></h3>
                " . $safeInstagram. "
                <small class='feed-your-soul py-2 text-center'><a href='http://yorkes.live/contact'>Submit</a> your instgram posts to this section.</small>

            </div>
        </div>
        <div class='col-md-8 mb-3 '>
            <div class='col-12 text-center border-rich bg-light p-0 h-100'>

                " . $safeGoogleMaps . "

            </div>
        </div>
    </div>
    <div class='row mb-4'>
        <div class='col-12'>
            <div class='col-12 border-rich bg-light p-3'>
                <h3 class='text-center text-uppercase'>Similar Beaches<span class='text-orange'>.</span></h3>
                <p class='text-center'>If you liked this beach, you might also like these. </p>
                <ul>
                    <li>
                        <a href='https://yorkes.live/flahertys'><span class='fw-bold'>Flaherty's Beach</span> - Beautiful big open beach perfect for pulling up a chair
                            under your 4WD awning.</a>
                    </li>
                    <li>
                        <a href='https://yorkes.live/browns'><span class='fw-bold'>Brown's Beach</span> - Deep in Dhilba Guuranda-Innes National Park fantastic beach for
                            fishing and walking.</a>
                    </li>
                    <li>
                        <a href='https://yorkes.live/shell'><span class='fw-bold'>Shell Beach</span> - Grab the kids and check out Shell Beach perfect camping near by.</a>
                    </li>
                    <li>
                        <a href='https://yorkes.live/troubridge'><span class='fw-bold'>Troubridge</span> - Keep out of the wind and maybe catch a wave.</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>";



}
} else {
echo "
<title>YORKES.LIVE</title>
<meta charset='UTF-8'>
<meta name='description' content='Come learn more about these beaches and what they have to offer.'>
<meta name='keywords' content='yorkes yorke peninsula beaches map best surf'>
<meta name='author' content='Written by D.W. Hills, Length: 1 pages'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<meta property='og:url' content='https://yorkes.live' />
<meta property='og:type' content='website' />
<meta property='og:title' content='Yorkes.Live' />
<meta property='og:description' content='An interactive map of the Yorke Peninsula&apos;s best beaches. As voted on by you.' />
<meta property='og:image' content='https://yorkes.live/fb.png' />

<link type='text/css' href='./styles.css' rel='stylesheet' />

<link rel='apple-touch-icon' sizes='180x180' href='./apple-touch-icon.png'>
<link rel='icon' type='image/png' sizes='32x32' href='./favicon-32x32.png'>
<link rel='icon' type='image/png' sizes='16x16' href='./favicon-16x16.png'>
<link rel='manifest' href='/site.webmanifest'>

<!-- MODEL VIEWER -->
<script type='module' src='https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js'></script>

<!-- BOOTSTRAP CSSs -->
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC'
    crossorigin='anonymous'>

<!-- FONTAWESOME -->
<link href='./fontawesome/css/fontawesome.css' rel='stylesheet'>
<link href='./fontawesome/css/brands.css' rel='stylesheet'>
<link href='./fontawesome/css/solid.css' rel='stylesheet'>

<!-- JQUERY -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>


<!-- BOOTSTRAP JS -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM'
    crossorigin='anonymous'>
</script>

</head>

<body class='d-flex flex-column min-vh-100' data-bs-spy='scroll' data-bs-target='#navbarID'>
    <nav id='nav-color' class='navbar fixed-top navbar-expand-sm navbar-dark border-bottom border-3'>

        <a class='navbar-brand text-light' href='./index.php'>
            <h4 id='nav-height' class='d-flex align-content-center flex-wrap'><span id='brandbox' class='align-middle pt-2 ps-4'>YORKES<span class='text-orange'>.</span>LIVE</span></h4>
        </a>
        <button class='navbar-toggler text-light' type='button' data-bs-toggle='collapse' data-bs-target='#navbarID' aria-controls='navbarID' aria-expanded='false'
            aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon '></span>
        </button>
        <div id='navbarID' class='collapse navbar-collapse'>
            <div class='navbar-nav' role=''>
                <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php'><span class='align-middle'>Map</span></a>
                <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php#mainlike'><span class='align-middle'>Beaches</span></a>
                <a class='nav-link nav-item nav-text-light ps-2' aria-current='page' href='./index.php#info'><span class='align-middle'>Info</span></a>
                <a class='nav-link nav-item  nav-text-light ps-2' aria-current='page' href='.index.php#contact'><span class='align-middle'>Contact</span></a>
            </div>
            <ul class='navbar-nav  ms-auto'>
                <li class='nav-item d-flex'>
                    <a class='nav-link text-light ' aria-current='page' href='#beaches'>
                        <h4><span id='coins' class='align-middle text-blue p-2 '><?php include 'db_getCoins.php'?></span></h4>
</a>
<img id='' class='me-4' src='img/shakawhite.png' width='45px' height='45px' alt='Shaka Icon'>
</li>
</ul>

</div>
</nav>
<div id='navbumper' class='bg-rich' style='height: 120px'></div>
<h3 class='p-4'>ERROR:</h3>
<p class='ps-4'>There is something wrong with the URL or the database. <a href='./index.php'>Try this link.</a></p>";
}

mysqli_close($connectToServer);
}

?>

