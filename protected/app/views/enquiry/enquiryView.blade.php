<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<?php require app_path().'/views/apqp_header1.php'; ?>
<style>
table, th, td {
    
     padding: 5px 3px 5px 8px;
}
/*body {font-family: "Lato", sans-serif;}*/

/ Style the tab /
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/ Style the buttons inside the tab /

div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/ Change background color of buttons on hover /
div.tab button:hover {
    background-color: #ddd;
}

/ Create an active/current tablink class /
div.tab button.active {
    background-color: #ccc;
}

/ Style the tab content /
.tabcontent {
    display: none;
    padding: 100px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
</head>
<body>
    <div class="page-heading">
      <h1 class="border-none">View Enquiry</h1>
      <button style="margin-top: -40px;margin-left: 150px;" class="btn btn-animate flat blue pd-btn  view_btn" type="submit" id="pdf">PDF Download</button>
      <a style="margin-top: -40px;margin-left: 100px;" class="btn btn-animate flat blue pd-btn" id="excel_url" href="">Excel Download</a>
    </div>
    <form method="get" role="form" action="" class="col-sm-12 myform" name="enquiryform" files = true id="enquiryform"  parsley-validate='' novalidate=' ' enctype="multipart/form-data">
      <div style="margin-top: -40px;margin-left: 1100px;">
    <div class="btn-wrap">
      <div class="col-sm-8">
        <select name='enquiry' id="enquiry" rows='5'  code='{$id}' class='select2'  required></select>
      </div>
      <button class="tablinks btn btn-primary btn-sm" id="view"><a href="#view_btn">View</a></button>
    </div>
    </div>
</form>
<div class="seprator"></div>
<div class="row mg-bottom-0">
  <div class="col-sm-12">
      <section class="report-wrapper" id="enquiry_view_id"></section>
  </div>
</div>

<script type="text/javascript">
    var base_url='<?php echo Request::root(); ?>/';

     $.ajax({
         url:base_url+'getEnq',
         type:'post',
         data:{},
         success:function(data){
             $("#enquiry").html(data);
         }
     });

   $("#view").click(function(evt){
          var enquiry =$("#enquiry").val();
          if(enquiry == ''){
            alert('Select enquiry');
            }else{       
          evt.preventDefault();
            $.ajax({
                    url:base_url+'SearchEnquiry',
                    type: 'POST',
                    data:new FormData($("#enquiryform")[0]),
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:"HTML",
                    beforeSend: function(){
                     $("#fade").show();
                    },
                    success: function (data) {
                         $("#enquiry_view_id").html('');
                         $("#enquiry_view_id").html(data);
                    }
                
                 });
              }
       });
   $("#pdf").click(function(evt){
          var enquiry =$("#enquiry").val(); 
          if(enquiry == ''){
            alert('Select enquiry');
            }else{       
          evt.preventDefault();
            $.ajax({
                    url:base_url+'enquiryPDFDownload',
                    type: 'POST',
                    data:new FormData($("#enquiryform")[0]),
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:"HTML",
                    beforeSend: function(){
                     $("#fade").show();
                    },
                    success: function (data) {
                         $("#fade").html('');
                         $("#downloadfile").html(data);
                         var str_array = data.split('/');
                         var file_name = str_array[1];
                         var link = document.createElement('a');
                          link.href = data;
                          link.download = file_name;
                          link.dispatchEvent(new MouseEvent('click'));
                    }
                 });
              }
       });
  

    $('#enquiry').change(function(){
        sel = $(this).val();
        var newUrl="{{ url('/') }}/enquiry/excel/"+sel;
        $('#excel_url').attr("href", newUrl);
    });
</script>
</body>
</html>