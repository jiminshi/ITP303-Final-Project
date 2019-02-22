<!DOCTYPE html>

<html>
<head>
    <title> Detail </title>
     <?php require 'shared/config.php' ?>
    <!--Inser nav, media meta, bootstrap link -->
    
    <meta name= "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/nav.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <style>
        iframe, #iframe-container{
            
            width: 100%;
        }
        #details{
            
            margin-top:60px
            
        }
        
        #taxonomy{
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        #refer{
            margin-bottom: 30px;
        }
        
        #back{
            margin-bottom: 50px;
        }
        
        h1{
            margin: 5px;
        }
        
        @media (min-width: 992px ){
             
              .navbar{
                 height: 60px;
             }
            
            #details{
                margin-top: 70px;
            }
        }
      
        
    </style>
</head>
    
<body>
   <!--Navigation-->
    <nav class="navbar nav nav-left fixed-top">
        <div class="container-fluid">
           
                <a class="navbar-header nav-link nav" href="main.php"> Home </a>
           
            <ul class="nav">
                <li class="nav-link"> <a href="advanced.php"> Advanced search </a> </li>
            </ul>
        </div> <!-- container-fluid -->
    </nav> <!--navbar-->
    
 
    
<!--Details section-->    
<div class="container mx-auto" id="details">
    <div class="row mx-auto">
        <div class="mx-auto col-12">
            
<?php   
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->connect_errno):
        echo $mysqli->connect_errno;

else:
    $mysqli->set_charset('utf8');

    if(!isset($_GET['bird_id']) || empty($_GET['bird_id'])):

        echo "<h1> Something went very wrong! </h1><br> <h4> Inadequate route. </h4>";
    
    else :
        $query = 
          "SELECT sci_name, orders.order, family.family, common_name, family_eng.family_eng_name, IUCN.IUCN 
            FROM birds
            LEFT JOIN orders 
                ON orders.id = birds.order_id 
            LEFT JOIN family 
                ON family.id = birds.family_id 
            LEFT JOIN family_eng
                ON family_eng.id = birds.family_eng_id
            LEFT JOIN IUCN 
                ON IUCN.id = birds.iucn_id 
            WHERE bird_id = ".
            $_GET['bird_id']. ";";
    
       $result = $mysqli->query($query);
       if(!isset($result) || empty($result) || $result->num_rows == 0):
            echo "<h1> Something went very wrong! </h1><br> <h4> Bird id doesn't exist. </h4>";
        else:
            if($row = $result->fetch_assoc()) :
              
?>
            
       
            <h1> <?php 
                if(isset($row['common_name']) && !empty($row['common_name']))
                    echo  $row['common_name']; 
                else{
                    echo "<em>".$row['sci_name']."</em>"; 
                }
                
                ?></h1>
            <div class="col-12" id="iframe-container">
              <div id="arkiveIframe" class="mx-auto">

              </div>
            </div>
            
            
            <div class="col-12" id="taxonomy">
                <ul>
                    <li>Scientific name: <?php
                        echo " ".$row['sci_name'];
                        ?> </li>
                    <li> Order: <?php
                        echo " ".$row['order']
                        ?> </li>
                    <li> Family: <?php
                        echo " ".$row['family']
                        ?> </li>
                    <li> Common Names: <?php
                        echo " ".$row['common_name']
                        ?></li>
                    <li> Belongs to <?php
                        echo " ".$row['family_eng_name']." group."
                        ?></li>
                    <li> IUCN rating: <?php
                        echo " ".$row['IUCN']
                        ?> </li>
                </ul>
            </div>
            
            
            
            <div class="col-12" id="refer">
                <h5> Find out more on </h5>
                <a href="https://www.arkive.org/explore/species?q=<?php echo $row['sci_name']; ?>" border="0"><img src="//www.arkive.org/images/logos_external/arkive_black_trans_150.png" border="0" width="150" height="49" alt="Arkive – Endangered species photos, videos and facts" title="Arkive - A unique collection of thousands of videos, images and fact-files illustrating the world's species." /></a>
                
                <a href = "http://datazone.birdlife.org/species/results?thrlev1=&thrlev2=&kw=<?php echo $row['sci_name']; ?>&fam=0&gen=0&spc=&cmn=&reg=0&cty=0"> <img src="http://www.birdlife.org/sites/default/files/logo_0.png"width="150"></a>
            </div>
            
            <div class="col-3" id="back">
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-primary"> Back to search </a>
            </div>
            
        </div>
    </div>
</div>    
    
    
    
  
    <!-- footer -->
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-12 text-center"> 
                All images from Arkive.org <br>All images from Arkive.org will lead to Arkive.org <br>
                Database provided by BirdLifeInternational
            </div>
        </div>
    </div>
    
    
    
    <script type="text/javascript">
        
    //Arkive API
        var arkiveApiKey = "<?php echo API_KEY; ?>";
   
        var arkiveApiSpeciesName = "<?php
            echo $row['sci_name'];
        ?>"
        var winwidth = $(window).width();
        
        
        var arkiveApiWidth = 550;
        var arkiveApiHeight = 500;
        
        if(winwidth > 1200){
            arkiveApiWidth = 1000;
            arkiveApiHeight= 580;
            
        }
        else if( winwidth > 992){
            arkiveApiWidth = 800;
            arkiveApiHeight= 550;
            
        }else if( winwidth > 768){
            arkiveApiWidth = 550;
            arkiveApiHeight = 500;
            
        }else{
            arkiveApiWidth = 350;
            arkiveApiHeight= 300;
            
        }
        
        
        var arkiveEndpoint = "https://api.arkive.org/v2/embedScript/species/scientificName/" + arkiveApiSpeciesName +"?key=" + arkiveApiKey + "&mtype=all&w="+arkiveApiWidth+"&h=" + arkiveApiHeight+"&tn=0&text=0&callback=arkiveEmbedCallback";
        
        function arkiveEmbedCallback(data) {
            var iframeCreation = '<iframe id="frame" name="widget" src ="#"' + 'width="100%"' +'height="100%"' +'frameborder="no"></iframe>';
            var iframe = window.location.protocol + "//" + (data.results[0].url);

        if (data.error != 'null') {
            document.getElementById("arkiveIframe").innerHTML = iframeCreation;
            var iframeAttr = parent.document.getElementById("frame");
            iframeAttr.height = arkiveApiHeight;
            iframeAttr.width = arkiveApiWidth + 22;
            iframeAttr.src = iframe;

        }

    }
        
 (function () {
        function async_load() {
            var s = document.createElement('script'); 
            s.type = 'text/javascript';
            s.async = true;
            s.src = arkiveEndpoint;
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }
        if (window.attachEvent)
        {
            window.attachEvent('onload', async_load);
        }
        else{
            window.addEventListener('load', async_load, false);
            
            var placeholder = document.createElement('img');
            placeholder.src = "http://303.itpwebdev.com/~jiminshi/project/img/placeholder.png";
            
            var container = document.getElementById('arkiveIframe');
            
            container.appendChild(placeholder);
        }
        
    })();        
        

    </script>   
    
     <?php
                    endif;
                endif;
            endif;
            $mysqli->close();
        endif;
    ?> 
</body>
</html>