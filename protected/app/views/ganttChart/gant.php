
<!doctype html>
<html lang="en-au">
   <head>
        <link rel="stylesheet" href="<?php echo Request::root(); ?>/protected/public/css/gant.css" />
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="http://taitems.github.com/UX-Lab/core/css/prettify.css" />
        <style type="text/css">
            body {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 13px;
                padding: 0 0 50px 0;
            }
            .contain {
                width: 800px;
                margin: 0 auto;
            }
            h1 {
                margin: 40px 0 20px 0;
            }
            h2 {
                font-size: 1.5em;
                padding-bottom: 3px;
                border-bottom: 1px solid #DDD;
                margin-top: 50px;
                margin-bottom: 25px;
            }
            table th:first-child {
                width: 150px;
            }
        </style>
       <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="<?php echo Request::root(); ?>/protected/public/js/jquery.fn.gantt.js"></script>

    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
    <script src="http://taitems.github.com/UX-Lab/core/js/prettify.js"></script>
    <script>
        
        $(function() {
        
          
           "use strict";
            $(".gantt").gantt({
                source: [
                  
        <?php 
         $data=DB::table('apqp_draft_project_plan')
        ->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
        ->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
          ->select('apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description')
          ->where('release_project',1)
          ->where('project_id',$data2)
        ->orderBy('gate_id')
                   ->orderBy('material_id')
          ->get();
          $obj=[];
        foreach($data as $row){
         $obj = array(
          
        'name' => $row->Gate_Description,
        'desc' => $row->act,
        'values' => array(
            array(
                "from" => '/Date('.strtotime($row->activity_start_date).')/', 
                "to" => '/Date('.strtotime($row->activity_end_date).')/', 
                "label" => $row->act,
                "customClass" => "ganttOrange"
            )
        )

    );
    //$objJson = json_encode($obj);

    echo "\n".json_encode($obj).",\n";
        }
        ?> ],
                

                navigate: "scroll",
                scale: "months",
                maxScale: "months",
                minScale: "days",
                itemsPerPage: 40,
                });
                

                 
           
            $(".gantt").popover({
                selector: ".bar",
                title: "I'm a popover",
                content: "And I'm the content of said popover.",
                trigger: "hover"
            });

            prettyPrint();
            

        });

       

    </script>
   </head>
    <body>
         <div class="contain" style="width: 100%;">
            <div class="gantt" ></div>
           <input type="hidden" id="proj_id" value="<?php echo $data2;?>">
        </div>
</body>
</html>