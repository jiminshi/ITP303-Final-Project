<?php
/*

This file sets up the DB from .csv file editted to fit the use of this project, from the original excel sheet file provided by the Bird Life International that keeps record of 13027 species of birds. 

The original .csv file extracted from BLI provided excel sheet does the following:
    1. It removes unnecessary data such as taxonomical authorities etc. 
    2. It formats the sheet so that it can be imported to the MyPHPadmin database right away. 
    
The following php code changes all VARCHAR columns that need to be normalized (order, family, family_eng, IUCN- has to be editted before running the code to right table/column name. currently set to IUCN) into INT id value corresponding to the foreign key tables. 

ISSUES: 
1. The following code modified about 800 rows each time it was executed. To modify all the rows you have to refresh the page several times. 

2. When normalizing the family and family_eng columns it somehow unions some of the families. 
    ->ISSUE found: Oos were integrated to Hoos, Hornbills were integrated to Thornbills.  


Finally, to finish the modification, MySQL Workbench was used to query following line:

    "ALTER TABLE birds MODIFY column_name INT;"

which could be done on this code as well.

The credential is commented out for now since if this page is run it will possibly modify the database. 

SQL version of the database included in the database folder.


FIX:
    All null data were originally stored as '' rather than NULL.
    Query statement: 
        UPDATE birds SET common_name = NULL WHERE common_name LIKE '';
        UPDATE birds SET alt_name = NULL WHERE alt_name LIKE ''; 
*/
?>

<!DOCTYPE html>
<html>
    <body>
<?php 
    require 'config.php';
    
 //   $mysqli =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME );

     if( $mysqli->connect_errno){
        echo "error";
    }else{
      //Select all orders 
        $o_sql = "SELECT * FROM IUCN;";
        $orders = $mysqli->query($o_sql);
     
       while($row = $orders->fetch_assoc()){

                $str = $mysqli->real_escape_string($row['IUCN']);
           
                $sql = "SELECT * FROM birds 
                    WHERE IUCN_id LIKE '". $str."';";
               
                $results = $mysqli->query($sql);
            
       
               while($row2 = $results->fetch_assoc()){
                   
                   $sql_u = "UPDATE birds
                    SET IUCN_id = ". $row['id']
                       ." WHERE bird_id = "
                       .$row2['bird_id']
                       .";";
                  
                   $mysqli->query($sql_u);
               } 
           
       }
       
    $mysqli->close();
    }
?>
        </body>
</html>