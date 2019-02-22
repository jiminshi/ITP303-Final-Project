 <?php 

                /* Basic code structure provided by arkive API doc.
                    Modified so that if the result doesn't return anything it returns false, so that it can be also sued to check if there is data for species input $sci_name in ARKive's database. 
                    
                    Otherwise it echos html tag for the ARKive page for the bird species with scientific name $sci_name. 
                */
                function arkiveAPI($sci_name)
                {
    
                        $quantity = 0;
                        $endpoint = 'https://www.arkive.org/api/'.V1_KEY.'/portlet/latin/'.rawurlencode($sci_name).'/'.$quantity;

                        $results= getFile($endpoint);
                        $decoded = json_decode($results);


                        if ($decoded->error !== null){
                            die("Something is wrong. Maybe the species name did not match our records?");
                        }

                        else if ($decoded->results !== null)
                        {
                            echo($decoded->results[0]);
                            return true;
                        }
                        else
                            return false;
                    }


                /* Code provided by arkive API doc. Handles curl. */
                    function getFile($url)
                    {
                        $myJSON = "";
                        if (function_exists('curl_init')) {
                            $ch=curl_init();
                            curl_setopt($ch,CURLOPT_URL,$url); curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                            $myJSON = curl_exec($ch);



                        } else
                        {
                            $myJSON = file_get_contents($url);
                        }
                        return $myJSON;
                    }

                    
?>