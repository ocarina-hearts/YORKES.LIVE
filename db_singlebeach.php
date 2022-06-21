<?php

require"db_connect.php"; 

if($connectToServer)
{

    $url = filter_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", FILTER_SANITIZE_URL) ;

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


           echo "    <div id='beachlander' class='bg-rich'>
           <div class='text-light'>
               <div class='row gx-0'>
                   <div class='mainlike-left col-6 bg-rich ' style='position:relative'>
                       <p class='display-4 text-center feed-your-soul ps-4'>" . $row['spelt_name'] . "</p>
                       <div class='vr'></div>
                       <p class='sideways-text lead h-100'>Beach vibes <span class='squish'>-----------------------</span></p>
                   </div>
                   <div class='mainlike-right col-12 col-md-6 bg-rich text-center'>
                        <div class='' style='height: 350px; max-width: 500px; overflow: hidden;'>
                            <picture>
                                <source srcset='./img/big/" . $row["name"]. ".webp'>
                                <img src='./img/big/" . $row["title_image"]. "' class='' width='500px' height='auto' alt='Image of " . $row["spelt_name"]. " '>
                            </picture>
                        </div>
                   </div>
               </div>
               <div class='row'>
                   <div class='col-12 text-center'>
                       <h5 class='h3 feed-your-soul py-2'>Where the sky touches the sea. </h5>
                   </div>
               </div>
           </div>
       </div>

       <div id='bg-waves'></div>

       <div class='container'>
           <div class='row my-3'>
               <div class='col-md-8'>
                   <div class='col-12 border-rich p-3 bg-light h-100'>
                       <h3 class='text-uppercase'>More information about " . $row["spelt_name"] . "</h3>
                       <p>" . $row['write_up'] . "</p>
                       <h3 class='text-uppercase'>History about " . $row["spelt_name"] . "</h3>
                       <p>" . $row['history'] . "</p>
                     
                   </div>
               </div>
               <div class='col-md-4'>
                    <div class='col-12  h-100'>
                        <div class='col-12'>
                            <div class='row text-center py-3 '>
                                    " . $iconsOutput . "
                            </div>
                        </div>
                        <div class='col-12 border-rich bg-light text-center p-3'>
                            <h3 class='text-uppercase'>Alternate names for " . $row["spelt_name"] . "</h3>
                            <p>" . $row['alt_names'] . "</p>
                        </div>
                    </div>
                    
                        
                </div>
           </div> 

         

           <div class='row my-3'>
               <div class='col-6'>
                   <div class='col-12 border-rich bg-light p-3 h-100'>
                       <h3 class='text-center  text-uppercase'>Camping near " . $row["spelt_name"] . "</h3>

                       <ul>
                            " . $row["camping"] . "
                       </ul>
                   </div>
               </div>
               <div class='col-6'>
                   <div class='col-12 border-rich bg-light p-3 h-100'>
                       <h3 class='text-center text-uppercase'>Accomidation near " . $row["spelt_name"] . "</h3>
                       <ul>
                            " . $row["accommodation"] . "
                       </ul>
                   </div>
               </div>
           </div>
           <div class='col-12'>
               <div class='col-12 bg-light border-rich p-3'>
                   <h3 class='text-center text-uppercase'>Surf</h3>
                   <p>" . $row["surf"] . "</p>
               </div>
           </div>
        </div>
        <div class='container-fluid'>
           <div class='col-12'>
               <h3 class='text-center my-3 text-uppercase'>Image Gallery of " . $row["spelt_name"] . "</h3>
           </div>
           <div id='gallery' class='row' data-masonry='{'percentPosition': true }'>
               <div class='col-4 mb-3  grid-item'>
                   <a type='button' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                       <div class='hoverexpand'>
                           <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/orange-tree.jpg' />
                       </div>
                   </a>
                   <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                       <div class='modal-dialog'>
                           <div class='modal-content'>
                               <div class='modal-header'>
                                   <h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>
                                   <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                               </div>
                               <div class='modal-body '>
                                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/orange-tree.jpg'>
                               </div>
                               <div class='modal-footer text-center'>
                                   <a href=''>This image can be brought as a print here</a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/submerged.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/look-out.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/one-world-trade.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/drizzle.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/cat-nose.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/contrail.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/golden-hour.jpg' />
               </div>
               <div class='col-4 mb-3 hoverexpand grid-item'>
                   <img class='img-fluid' src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/flight-formation.jpg' />
               </div>
           </div>
           <h5 class='h3 feed-your-soul py-2 text-center'>Have you taken a photo you would love to <a href='http://yorkes.live/contact'>submit?</a></h5>
        </div>
        <div class='container'>
           <div class='row py-4'>
               <div class='col-md-4 mb-3 order-md-first order-last'>
                   <div class='col-12 text-center border-rich bg-light h-100 py-3'>
                       <h3 class='text-uppercase'>Instagram Posts</h3>
                       " . $row["instagram"] . "
                       <small class='feed-your-soul py-2 text-center'><a href='http://yorkes.live/contact'>Submit</a> your instgram posts to this section.</small>

                   </div>
               </div>
               <div class='col-md-8 mb-3 '>
                   <div class='col-12 text-center border-rich bg-light py-3'>
                       <h3 class='text-uppercase'>Google Map</h3>
                       <img src='' alt='' height='300px' width='400px' class='h-100 w-100 bg-secondary'>
                   </div>
               </div>
           </div>
           <div class='row mb-4'>
               <div class='col-12'>
                   <div class='col-12 border-rich bg-light p-3'>
                       <h3 class='text-center text-uppercase'>Similar Beaches</h3>
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