<?php

require"db_connect.php"; 

if($connectToServer)
{

    $url = filter_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", FILTER_SANITIZE_URL);
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $cleanParam = preg_replace("/[^a-zA-Z0-9]+/", "", $params['location']);


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

           echo "    <div id='beachlander' class='bg-rich'>
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

       <div id='bg-waves'></div>

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
           <div id='gallery' class='row' data-masonry='{'percentPosition': true }'>

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
                                <a href='https://yorkes.live/beach.php?location=flahertys'><span class='fw-bold'>Flaherty's Beach</span> - Beautiful big open beach perfect for pulling up a chair under your 4WD awning.</a>
                           </li>
                           <li>
                                <a href='https://yorkes.live/beach.php?location=browns'><span class='fw-bold'>Brown's Beach</span> - Deep in Dhilba Guuranda-Innes National Park fantastic beach for fishing and walking.</a>
                           </li>
                           <li>
                                <a href='https://yorkes.live/beach.php?location=shell'><span class='fw-bold'>Shell Beach</span> - Grab the kids and check out Shell Beach perfect camping near by.</a>
                           </li>
                           <li>
                                <a href='https://yorkes.live/beach.php?location=troubridge'><span class='fw-bold'>Troubridge</span> - Keep out of the wind and maybe catch a wave.</a>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
       </div>";


    
        }
    } else {
        echo "<h3 class='p-4'>ERROR:</h3><p class='ps-4'>There is something wrong with the URL or the database. <a href='./index.php'>Try this link.</a></p>";
    }
        
        mysqli_close($connectToServer);
    }

?>