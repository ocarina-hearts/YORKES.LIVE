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

            //handles gallery - vars it into big string below. 
	        $galleryArray = explode(",", $row["gallery"]);
            $linkArray = explode(",", $row["gallery_link"]);
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
                                                "//<source srcset='./gallery/". $row["name"] . "/" . $galleryArray[$i]. ".webp'>
                                                ."<img class='img-fluid' src='./gallery/". $row["name"] . "/" . $galleryArray[$i]. ".jpg' alt='Image of " . $row["spelt_name"] . " '>
                                            </picture>
                                            " . $moneySymbol . "
                                        </div>
                                    </a>
                                    <div class='modal fade' id='Modal-" . $galleryArray[$i]. "' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog modal-xl'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>" . $row["spelt_name"] . "</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body '>
                                                    <picture>
                                                        "//<source srcset='./gallery/". $row["name"] . "/" . $galleryArray[$i]. ".webp'>
                                                        ."<img class='img-fluid' src='./gallery/". $row["name"] . "/" . $galleryArray[$i]. ".jpg' alt='Image of " . $row["spelt_name"]. " '>
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

           echo "    
           <title>YORKES.LIVE | " . $row['spelt_name'] .  " </title>
           <meta charset='UTF-8'>
           <meta name='description' content='This is " . $row['spelt_name'] .  " on the sunny Yorke Peninsula. Come learn more about the beach and what it has to offer. Don&apos;t forget to vote for  " . $row['spelt_name'] .  " . '>
           <meta name='keywords' content='yorkes " . $row['spelt_name'] .  " yorke peninsula beaches map best surf'>
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
$directory = 'gallery/'. $row["name"].'/';
$imageName = 'pano.jpg';

// Check if the image file exists
$imagePath = $directory . $imageName;

if (file_exists($imagePath)) {

    echo "
    <div style=\"background-image: url('./gallery/". $row["name"]."/pano.jpg'); background-position:center; background-size:cover; height: 500px !important; position: relative; z-index: -1;\">
        <p class='sideways-text lead h-100' style='position: absolute; top: 100px; z-index: 1; text-shadow: 0px 0px 5px black, 0px 0px 5px black, 0px 0px 10px black;'>
            <a class='text-white' style='text-decoration: none;' href='./browns/'>Panoramic</a> 
            <span class='squish'>-----------------------</span>
        </p>
    </div>
    
    <div id='bg-wavesUD' class='p-0 m-0' style='margin-top: -80px !important; z-index: 2 !important;'></div>
    <div class='bg-rich'>
        <p class='display-4 text-center feed-your-soul pb-2 text-white m-0'>" . $row['spelt_name'] . "</p>
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
                <p class='display-4 text-center feed-your-soul ps-4'>" . $row['spelt_name'] . "</p>
                <div class='vr'></div>
                <p class='sideways-text lead h-100'>Beach vibes <span class='squish'>-----------------------</span></p>
            </div>
            <div class='mainlike-right col-md-6 bg-rich text-center'>
                <p class='display-4 text-center feed-your-soul ps-4 d-md-none'>" . $row['spelt_name'] . "</p>
                <div class='overflow-hidden'>
                    <picture>
                        <source srcset='./img/big/" . $row["name"]. ".webp'>
                        <img src='./img/big/" . $row["title_image"]. "' class='img-fluid' style='max-width: 400px;' alt='Image of " . $row["spelt_name"]. " '>
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
            <div class='col-12 border-rich p-3 bg-light h-100'>
                <h3 class='text-uppercase py-3'>More information about " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>
                <p>" . $row['big_write_up'] . "</p>
                <h3 class='text-uppercase py-3'>History about " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>
                <p>" . $row['history'] . "</p>

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
                    <h3 class='text-uppercase'>Alternate names for " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>
                    <p>" . $row['alt_names'] . "</p>
                </div>
                <div class='col-12 bg-light border-rich p-3 mt-3'>
                    <h3 class='text-center text-uppercase'>Surf Report<span class='text-orange'>.</span></h3>
                    <p>" . $row["surf"] . "</p>
                </div>
            </div>
        </div>
    </div>


    <div class='row '>
        <div class='col-md-6 my-2'>
            <div class='col-12 border-rich bg-light p-3 h-100'>
                <h3 class='text-center  text-uppercase'>Camping near " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>

                <ul>
                    " . $row["camping"] . "
                </ul>
            </div>
        </div>
        <div class='col-md-6 my-2'>
            <div class='col-12 border-rich bg-light p-3 h-100'>
                <h3 class='text-center text-uppercase'>Accommodation near " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>
                <ul>
                    " . $row["accommodation"] . "
                </ul>
            </div>
        </div>
    </div>

</div>
<div class='container-fluid'>
    <div class='col-12'>
        <h3 class='text-center my-3 text-uppercase'>Image Gallery of " . $row["spelt_name"] . "<span class='text-orange'>.</span></h3>
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
                " . $row["instagram"] . "
                <small class='feed-your-soul py-2 text-center'><a href='http://yorkes.live/contact'>Submit</a> your instgram posts to this section.</small>

            </div>
        </div>
        <div class='col-md-8 mb-3 '>
            <div class='col-12 text-center border-rich bg-light p-0 h-100'>

                " . $row["googlemap"] . "

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