<!DOCTYPE html>

<html>
<head>
   <title> Advanced Search </title>
    <?php require 'shared/config.php' ?>
    <!--Inser nav, media meta, bootstrap link -->
    
    <meta name= "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="shared/nav.css">
    
    <style>
    
        .formbox{
            margin-top: 60px;
        }
     
        
        .form-sheet{
            margin: auto;
        }
        
        .box-item{
            margin: 3px;
            float: left;
        }
        
        h1{
            font-size: 1.3em;
        }
        
        
        @media (min-width: 768px ){
            
            
            h1{
                font-size: 1.5em;
            }
        }
        
         @media (min-width: 992px ){
             
              .navbar{
                 height: 60px;
             }
             
             
             .formbox{
                margin-top: 10%;    
             }
             
             h1{
                 font-size: 2em;
             }               
        } 
        
       
    
    
    </style>
</head>
      
<body>
  <!--Navigation-->
    <nav class="navbar nav nav-left fixed-top">
        <div class="container-fluid">
           
                <a class="navbar-header nav-link nav" href="main.php"> Home </a>
           
        </div> <!-- container-fluid -->
    </nav> <!--navbar-->
    
<!--Search form -->
    
    <div class="container formbox">
        
            <div class="row">
                <div class="col-12">
                    <h1> Advanced Bird Search </h1>
                </div>
            </div>
    </div>
    
    <div class="container">
            <div class="row">
                <form class="form-sheet col-md-9 col-xs-12 col-s-12" action="results.php" method="get">
                    
                    <!--input: name -->
                    <label for="term" class="no-padding-bt col-sm-12 col-xs-12 col-md-3  col-form-label" for="term">Bird name</label>
                    <div class="form-group col-9">
                      <input type="text" class="form-control" id="term" name="term">
                    </div>
                    
                    <!--input: order -->
                    <label for="order" class="no-padding-bt col-sm-12 col-xs-12 col-md-3   col-form-label"> Order </label>
                    <div class="form-group col-9">
                        <input type="text" class="form-control"id="order" name="order">
                    </div>
                    
                    <!--input: family-->
                    <label for="family" class="no-padding-bt col-sm-12 col-xs-12 col-md-3   col-form-label"> Family </label>
                    <div class="form-group col-9">
                        <input type="text" class="form-control" id="family" name="family">
                    </div>
                    
                    <!--input: scientific name-->
                    <label for="sci-name" class="no-padding-bt col-sm-12 col-xs-12 col-md-3   col-form-label"> Scientific name </label>
                    <div class="form-group col-9">
                        <input type="text" class="form-control" id="sci-name"  name="sci-name">
                    </div>
                    
                    <!--input: IUCN rating -->
                     <label for="iucn" class="no-padding-bt col-sm-12 col-xs-12 col-md-3   col-form-label"> IUCN Red List </label>
                    <div class="form-group col-9">
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="8"> LC </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="10"> NT </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="11"> VU </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="5"> EN </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="1"> CR </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="6"> EW </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="7"> EX </div>
                        <div class="box-item"> <input name="iucn[]" type="checkbox" value="4"> NR/DD </div>
                    </div>
                    <div class="clearfloat"> </div>
                    <button type="submit" class="box-item btn btn-primary">Submit</button>
                </form>
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
</body>