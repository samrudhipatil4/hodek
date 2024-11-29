<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">

    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans',sans-serif; font-weight: normal; margin:0 auto;font-size:10px;">


<table style="width:80%;margin-bottom:40px;border:1px solid #000;">

    
</table>



<div class="summary-table report-wrapper scrollbarX">

    <table class="striped" style="border:1px solid #000;">
        <thead style="border-bottom:1px solid #000">
        <tr class="tr-bdr">
            <th width="10" style="border-right:1px solid #000">Sr. No.</th>
            <th width="30" style="border-right:1px solid #000">User Name</th>
            <th width="110" style="border-right:1px solid #000">User Invloved In</th>
        </tr>
 <?php if(sizeof($data)>0){

                        $i=1;
                        foreach($data as $sheet){ ?>
                         <tr border="1">
                         <td><?php echo $i;?></td>
                         <td><?php echo $sheet['username'][0]->first_name." ".$sheet['username'][0]->last_name.'<br>'; ?>
                       </td>
                         <td>
                        <?php  if(!empty($sheet['userTask'])){ 
                            echo $sheet['userTask'][0]['cmNoSearch'].'  '.$sheet['userTask'][0]['message'].'<br>';
                        }
                         if(!empty($sheet['projectManager'])){
                         foreach( $sheet['projectManager'] as $key){ 
                            echo 'Project Manager For Project  '.$key->project_code.'<br>';
                             }
                             }
                             if(!empty($sheet['custCommrep'])){ 
                                 foreach( $sheet['custCommrep'] as $key){ 
                            echo 'Customer Communication Representative For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['custCommApp'])){ 
                                  foreach( $sheet['custCommApp'] as $key){ 
                            echo 'Customer Communication Approval Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['docVer'])){ 
                                 foreach( $sheet['docVer'] as $key){ 
                            echo 'Document Verifier For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['finalApproval'])){ 
                                  foreach( $sheet['finalApproval'] as $key){ 
                            echo 'Final Approval Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                             if(!empty($sheet['projectMasterCFT'])){ 
                                 foreach( $sheet['projectMasterCFT'] as $key){ 
                            echo 'CFT Member For Project  '.$key->project_code.'<br>';
                             }
                         }
                         if(!empty($sheet['docverifyconfig'])){ 
                                
                            echo 'document verifier in Document Verifier Master<br>';
                           
                         }
                         
                         if(!empty($sheet['riskAppForSeries'])){ 
                                 
                            echo 'Overall Risk Approval Member in Document Verifier Master <br>';
                             
                         }
                         if(!empty($sheet['CFTRepresentative'])){ 
                                 
                            echo 'CFT Team Representative in CFT Team Representative Master<br>';
                             
                         }
                         if(!empty($sheet['custComm'])){ 
                                
                            echo 'Customer Communication Document Upload Member in  Customer Communication Management Master <br>';
                             
                         }
                         if(!empty($sheet['custCommapp'])){ 
                                
                            echo 'Customer Communication Approval in  Customer Communication Management Master <br>';
                            
                         }
                        ;?></td>
                         
                      </tr>
                        <?php $i++;} }?>
        </tbody>
       

    </table>

</body>
</html>