<!DOCTYPE html>

<html>
<head>
    <title> Result </title>
    <?php 
    
    require 'shared/config.php'; 
    require 'api_functions.php';
    $page_url = $_SERVER['REQUEST_URI'];
    $page_url = preg_replace('/&page=\d+/', '', $page_url);
    
    ?>
    <!--Inser nav, media meta, bootstrap link -->
    <meta charset="UTF-8">
    <meta name= "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
    <link rel="stylesheet" href="shared/nav.css">
    
    <style>
        body{
            background-color: #548687;
        }
        #result-box{
            
            border-radius: 5px;
        }
        .pagination{
            margin-top: 10px;
        }
        .btm-margin{
            margin-bottom: 80px;
        }
       
        .{
             border-color:cadetblue;
            border-width: 0px;
            border-style:solid;
        }
        img{
            width: 80%;
        }
        table{
            
            width: 100%;
        }
        tbody{
            
            height: 100%;
            width: 100%;
            text-align: center;
        }
        
        th{
            display: none;
        }
        
        tr{
            width: 100%;
            height: 100%;
            display: table;
            
        }
        td{
            font-size: 1.5em;
            vertical-align: middle;
            display:table-cell;
        }
        
        #result-box{
            margin-top: 60px;
        }
        
        .sidebar{
            display: none;
        }
        
        
        
        @media (min-width: 768px ){
            
            .sidebar{
                display: block;
                height: auto; 
                width: 128px;
                position: fixed; 
                z-index: 1; 
                top: 0;
                right: 0; 
                background-color: cornflowerblue;
                overflow-x: hidden;
                margin-top: 90px;
                margin-right: 5px;
                text-align: center;
                padding: 5px;
                
                border-radius: 2px;
                border-style: solid;
                border-width: thin;
                border-color: firebrick;
                
                color: beige;
            }
        }
        @media (min-width: 992px ){
             
              .navbar{
                 height: 60px;
             }
            
            #result-box{
                margin-top: 80px;
            }
            
            .nametext{
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
           
            <ul class="nav">
                
                <li class="nav-link"> <a href="advanced.php"> Advanced search </a> </li>
            </ul>
        </div> <!-- container-fluid -->
    </nav> <!--navbar-->
    
<?php   
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno):
            echo $mysqli->connect_errno;
        
        else:
            $mysqli->set_charset('utf8');

    /* Condition sql */
    
            $where_query = " WHERE 1=1 ";
                
            if(isset($_GET['term']) && !empty($_GET['term'])){
                $where_query .= "AND (common_name LIKE '%". $_GET['term']. "%' 
                                    OR alt_name LIKE '%". $_GET['term']."%') ";
            }
    
            if(isset($_GET['order']) && !empty($_GET['order'])){
                $where_query .= "AND orders.order LIKE '%". $_GET['order']. "%' ";
            }
    
            if(isset($_GET['family']) && !empty($_GET['family'])){
                $where_query .= "AND family.family LIKE '%". $_GET['family']. "%' ";
            }
    
            if(isset($_GET['sci_name']) && !empty($_GET['sci_name'])){
                $where_query .= "AND sci_name LIKE '%". $_GET['sci_name']. "%' ";
            }
            if(isset($_GET['iucn']) && !empty($_GET['iucn'])){
                for($i=0; $i < count($_GET['iucn']); $i++){
                    if($i == 0)
                        $where_query .= "AND (birds.iucn_id = ". $_GET['iucn'][$i]." ";
                    if($i==count($_GET['iucn']) - 1)
                        $where_query .= "OR birds.iucn_id = ". $_GET['iucn'][$i].") ";
                    else
                        $where_query .= "OR birds.iucn_id = ". $_GET['iucn'][$i]." ";
                }
            }
            
    
    /* Pagination PHP */
           // $query = "Select all birds with name like ".$_GET[]." LIMIT 5;"
            $count_query = "SELECT COUNT(*) AS count
                            FROM birds 
                             LEFT JOIN orders
                                ON orders.id = birds.order_id
                            LEFT JOIN family
                                ON family.id = birds.family_id
                            LEFT JOIN IUCN 
                                ON IUCN.id = birds.iucn_id";
            $count_query .= $where_query;
           
            $num_res = $mysqli->query($count_query);
    
    /*      $num_res check       */
            if(!$num_res){
                echo "PHP Error : count query returned null.";
            }
            else{
                $count =  $num_res->fetch_assoc()['count'];
                
            }
    /*    Current Page check      */
            if(!isset($_GET['page'])){
                $page = 1;
            }
            else{
                $page = $_GET['page'];    
            }
            $start_index =  ($page - 1) * NUM_ITEMS;
    
    
    
    
    
    
    /* Search sql */
            
            $search_query = 
                "SELECT bird_id, sci_name, common_name
                        FROM birds
                        LEFT JOIN orders
                            ON orders.id = birds.order_id
                        LEFT JOIN family
                            ON family.id = birds.family_id
                        LEFT JOIN IUCN 
                            ON IUCN.id = birds.iucn_id";
           
            $search_query .= $where_query;
            $search_query .= "LIMIT ". $start_index. " , ". NUM_ITEMS .";";
    
    
            $results = $mysqli->query($search_query);
            
?>  
    
<!--Result section -->    
<div class="container-fluid " id="result-box"> 
    <div class="row ">
        <!--Result meta -->
        <div class="col-12 col-md-8 col-lg-8 col-xl-8  mx-auto" id="result-meta">
            <?php echo $count." "; ?> 
         results returned. <br> 
        Showing 
            <?php 
                if($count == 0){
                    echo 0;
                }else
                echo  $start_index + 1; ?> 
        to 
            <?php
                if(($start_index + NUM_ITEMS) > $count)
                    echo $count;
                else
                    echo ($start_index + NUM_ITEMS);
            ?> 
        results out of  
            <?php echo $count; ?>  
        results.
        </div>
        
    </div>
    
    <!--Results pagination-->
    <div class="col-12">
				<nav >
					<ul class="pagination  justify-content-center" style="border-color: black">
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url.'&page=1'; ?>"> 1 </a>
						</li>
						<li class="page-item ">
							<a class="page-link" href="
                        <?php 
                            if($page > 1){
                                echo $page_url.'&page='.($page-1); }
                            else {
                                echo $page_url.'&page='.'1';
                            }                           ?>"> ← </a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="<?php echo $page_url.'&page='.$page; ?>"> <?php echo $page; ?></a>
						</li>
						<li class="page-item ">
							<a class="page-link" href="<?php 
                            if($page < ceil($count/NUM_ITEMS)){
                                echo $page_url.'&page='.($page+1); }
                            else {
                                echo $page_url.'&page='.(ceil($count/NUM_ITEMS));
                            }   ?>">→</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url.'&page='.(ceil($count/NUM_ITEMS)); ?>"><?php 
                                 if($count == 0){
                                    echo 1;
                                }else
                                echo ceil($count/NUM_ITEMS); ?></a>
						</li>
					</ul>
				</nav>
    </div> <!-- .col -->

</div>    
     <!--Results-->
    <div class="row " style="border-color:red">
        <div class="col-12 col-md-8 col-lg-8 col-xl-8  mx-auto" style="border-color:blue">
            <table>
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    
                        while($row = $results->fetch_assoc()) : 
                                
                    ?>
                    <tr>
                        <td scope="row">
                            <?php
                               
                              if(arkiveAPI($row['sci_name'])):
                                    
                                
                              else:     
                            ?>
                                    <a href="details.php?bird_id=<?php echo $row['bird_id']; ?>"> 
                                    <img src='http://303.itpwebdev.com/~jiminshi/project/img/placeholder.png'>
                                    </a>
                            <?php
                                endif;
                            ?>
                        </td>
                        <td>
                            <a href="details.php?bird_id=<?php
                                echo $row['bird_id'];
                                      
                                ?>">
                             <?php 
                                if(isset($row['common_name']) && !empty($row['common_name']))
                                    echo $row['common_name'];
                                else
                                    echo "<em>" . $row['sci_name']. "</em>";
                                ?> 
                            </a>
                        </td>
                    </tr>
                    
                    <?php 
                    
                    endwhile; ?>
                   
                </tbody>
            
            
            </table>
            
        </div>
    </div>
        
  <div class="col-12">
				<nav >
					<ul class="pagination btm-margin  justify-content-center" style="border-color: black">
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url.'&page=1'; ?>"> 1 </a>
						</li>
						<li class="page-item ">
							<a class="page-link" href="
                        <?php 
                            if($page > 1){
                                echo $page_url.'&page='.($page-1); }
                            else {
                                echo $page_url.'&page='.'1';
                            }                           ?>"> ← </a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="<?php echo $page_url.'&page='.$page; ?>"> <?php echo $page; ?></a>
						</li>
						<li class="page-item ">
							<a class="page-link" href="<?php 
                            if($page < ceil($count/NUM_ITEMS)){
                                echo $page_url.'&page='.($page+1); }
                            else {
                                echo $page_url.'&page='.(ceil($count/NUM_ITEMS));
                            }   ?>">→</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url.'&page='.(ceil($count/NUM_ITEMS)); ?>"><?php 
                                 if($count == 0){
                                    echo 1;
                                }else
                                echo ceil($count/NUM_ITEMS); ?></a>
						</li>
					</ul>
				</nav>
    </div> <!-- .col -->
   
<?php
    $mysqli->close();
    endif;
    ?>
    
<!--Fixed sidebar-->
<div class="sidebar">
    <p> Find out more! </p>
    <a href="http://www.arkive.org"> <img src="//www.arkive.org/images/logos_external/arkive_black_trans_150.png" width="100%"> </a><br>
    <a href="http://www.birdlife.org"><img src="http://www.birdlife.org/sites/default/files/logo_0.png" width="100%"></a> <br>
    <a href="//www.iucnredlist.org/"> <img src="img/IUCN_Red_List.png" width="20%"> </a>
    
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
</html>