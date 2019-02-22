<!DOCTYPE html>

<html>
<head>
    <title> Bird Search </title>
    <?php require 'shared/config.php';
            require 'api_functions.php';
    ?>
    <!--Inser nav, media meta, bootstrap link -->
    
    <meta name= "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
    <link rel="stylesheet" href="shared/nav.css">
    <style>
        
       body{
        background-color: #548687;
}
        
        
        
        
        .infobox{
            
            margin: 1px auto;
            float: left;
            
        }
        
        #info-container{
            
            background-color: #C5E99B;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        
        
        #search{
            background-image: url('img/bg-<?php echo rand(1,8); ?>.jpg');
            background-size: cover;
            background-position:center;
            height: 400px;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        
        #searchbox{
            
            margin-top: 155px;
            margin-bottom: 155px;
        }
        
    
        img{
            border-radius:5px;
            max-width: 100%;
            width: 300px;
        }
        
        @media (min-width: 768px ){
             
        }
        
         @media (min-width: 992px ){
             
             .navbar{
                 height: 60px;
             }
             
             #search{
                 height: 600px;
                 margin-top: 60px;
             }
             
             #searchbox{
                 
                 margin-top: 255px;
                 margin-bottom: 255px;
             }
                           
        } 
    
    
    
    </style>
</head>
  
    
<body>

<!--Navigation-->
    <!--Navigation-->
    <nav class="navbar nav nav-left fixed-top">
        <div class="container-fluid">
           
                <a class="navbar-header nav-link nav" href="main.php"> Home </a>
           
            <ul class="nav">
                <li class="nav-link"> <a href="advanced.php"> Advanced search </a> </li>
            </ul>
        </div> <!-- container-fluid -->
    </nav> <!--navbar-->
    

<!-- Search section -->    
    <div class="container-fluid mx-auto"  id="search">
        <div class="row mx-auto"> 
            <div class="col-12" id="searchbox">
                
                <!-- Search form-->
                <div class="col-xs-12 col-md-6 mx-auto">
                    
                    <form class="d-flex flex-row" action="results.php" method="get">
                        <div class="col-xs-9 col-sm-9 col-md-10 no-padding-rl mx-auto">
                            <input class="col-12 mx-auto form-control" type="text" name="term" >
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-2  no-padding-rl mx-auto">
                            <button type="submit" class="col-12 no-padding-rl mx-auto btn btn-primary">Search </button>
                        </div>
                    </form>
                    
                </div>
                
                <!-- Advanced search -->
                <div class="col-xs-12 col-md-6 mx-auto no-padding-rl flex-row d-flex">
                    <a class="col-11 btn btn-primary mx-auto" role="button"href="advanced.php">Advanced Search </a>
                </div>
                
                
            </div>  <!-- col-12 -->
        </div>  <!-- row -->
    </div>  <!-- container -->
    
    
<!-- Intro section -->  
    
    <div class="container">
        <div class="row mx-auto">
            <div class="col-9 mx-auto">
                <h1 class="text-center"> Hello, Bird!</h1>
                <h4 class="text-center"> Today's random birds! </h4>
            </div>  
        </div>
    </div>
    
<?php   
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno):
            echo $mysqli->connect_errno;
        
        else:
?>   
<!-- Info section --> 
    <div class="container">
        <div class="row mx-auto" id="info-container"> 
            <?php 
                /* Comment out for better performance */
            
                // API takes very long time to find species that has data in ARKive.
                // Improved by only querying for birds that has common name AND alternative names at the same time - more likely that they have data in  ARKive API.
            
                for($i=0; $i<4; $i++) :
                    $query = "SELECT sci_name FROM birds 
                            WHERE alt_name IS NOT NULL
                            AND common_name IS NOT NULL
                            ORDER BY RAND()
                            LIMIT 1;";
                    $res = $mysqli->query($query);   
            ?>
                <div class="infobox">
                    <?php 
                    	/*Commented out as Arkive.org is now closed and the response never returns*/
                    
                        // $row = $res->fetch_assoc();
                        // if(arkiveAPI($row['sci_name'])){
                            
                        // }
                        // else{
                        //     $i--;
                        // }
                    
                    ?>
               </div>
            <?php  endfor; ?>   
          
        </div>
    </div>
    
<?php 
    
    
     $mysqli->close();
    endif;
   
    
    ?>
<!-- footer -->
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-12 text-center"> 
                All images from Arkive.org  <br> All images from Arkive.org will lead to Arkive.org <br>
                Database provided by BirdLifeInternational
            </div>
        </div>
    </div>
    
    <script>
        
    </script>
</body>
</html>