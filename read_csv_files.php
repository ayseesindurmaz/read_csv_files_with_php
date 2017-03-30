<?php
include 'dbConfig.php';

            /*  This code page created for creating a table in a database with the name of the csv file and its columns, 
            than insertiıng the values from csv to our just created table.  */  
            /*  I am going to continue that code stack to improve by getting files from html file selection    */

            $tableAndFileName="";
            $csvFile = fopen($tableAndFileName.".csv", 'r');
            $amountOfError=0;
            
            //skip first line
            $firstline=fgetcsv($csvFile);
            $numcols = count($firstline);

            $sqlToCreateTheTable = "CREATE TABLE ".$tableAndFileName." (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
                ";
            $sqlInsertInto="INSERT INTO ".$tableAndFileName." (";


            for ($i=0; $i < $numcols; $i++) { 
                $sqlToCreateTheTable.=",".$firstline[$i]." VARCHAR(500)";
                if ($numcols-$i==1) {
                    $sqlInsertInto.=$firstline[$i].") VALUES ('";
                }else{
                    $sqlInsertInto.=$firstline[$i].",";
                }
                
            }

            $sqlInsertIntoCopy=$sqlInsertInto;
                $sqlToCreateTheTable.=")";

            if ($db->query($sqlToCreateTheTable) === TRUE) {
                echo "Table ".$tableAndFileName." Created Successfully.!";
                //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){

                    $sqlInsertInto=$sqlInsertIntoCopy;
                    for ($i=0; $i < $numcols; $i++) { 
                        if ($numcols-$i==1) {
                            if (strpos($line[$i], '\'') !== false) {
                                $sqlInsertInto.=str_replace('\'',"\'",$line[$i])."')";
                            }else{
                                $sqlInsertInto.=$line[$i]."')";
                            }
                            
                        }else{
                            if (strpos($line[$i], '\'') !== false) {
                                $sqlInsertInto.=str_replace('\'',"\'",$line[$i])."','";
                            }else{
                                $sqlInsertInto.=$line[$i]."','";
                            }
                        }
                        
                    }
                    
                    
                        
                    if ($db->query($sqlInsertInto) === TRUE) {

                    }else {
                        $amountOfError++;   
                        echo "Error: " . $sqlInsertInto . "<br>" . $db->error;   
                    }
                    

                    
                    
            }
            if ($amountOfError==0) {
                echo "Insertion Operation is Fully Complated.!";
                # code...
            }
            } else {
                 echo "Error creating table: " . $db->error;
            }


            
            //close opened csv file
            fclose($csvFile);


?>