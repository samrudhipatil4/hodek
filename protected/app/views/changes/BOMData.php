<?php require app_path().'/views/header.php'; ?>

  <div class="main-wrapper">
    <div class="container-fluid">

              <div class="row two-col-row mg-bottom-0">
               
                <div class="col-sm-12">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>BOM Data</h1>
                        </div><!--/page-heading-->
                      </div>
                    </div>

                  <div class="content-wrapper">
                     <div class="form-wrapper" >
                       
                         <div ng-controller="BOMCtrl" ng-init="fetch()">
                        
                                       <div class="row">
                                        <div class="col-sm-6">
                                            <div class="pagination-wrapper">
                                                <ul class="no-lft">
                                                    <li>Page
                                                        <ul class="pagination">
                                                            <li class=""><a href="javascript:void(0)" ng-click="prevPage()"><i class="fa fa-angle-left"></i></a></li>
                                                            <li class="active">
                                                                <div class="select-box">
                                                                    <select class="form-control" ng-model='currentPage' ng-change="setPage(currentPage)">
                                                                        <option ng-repeat="n in range(1,pageCount())" value="<%n%>" ng-selected="n === currentPage"><%n%></option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class=""><a href="javascript:void(0)" ng-click="nextPage()"><i class="fa fa-angle-right"></i></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>

                                                        <ul>
                                                            <li> View </li>
                                                            <li>
                                                                <div class="select-box">
                                                                    <select ng-model="entryLimit" class="form-control">
                                                                        <option>5</option>
                                                                        <option>10</option>
                                                                        <option>20</option>
                                                                        <option>50</option>
                                                                        <option>100</option>
                                                                    </select>

                                                                </div>
                                                            </li>
                                                            <li>per page</li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        Total <span ng-bind="filtered.length"> </span> records found
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <form>
                                                <div class="search-form">
                                                    <input type="text" class="input-search" Placeholder="Refine your results" ng-model="search">

                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="input-group">
                                        <a href="<?php echo Request::root().'/BOM'?>" data-position="bottom" data-delay="50" data-tooltip="Create New BOM">
                                        <button class="btn btn-animate flat blue pd-btn" type="submit" id="create" name="edit">Add New BOM</button></a></td> 
                                                
                                        </div>
                                       </div>
                                    </div>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="table-wrapper">
                                         <table class="striped">
                                             <thead>
                                             <tr>
                                                 <th width="10%">Sr. No.</th>
                                                 <th>Item Code</th>
                                                 <th>Description</th>
                                                 <th>UOM</th>
                                                 <th width="20%">Action</th>
                                             </tr>
                                             </thead>
                                             <tbody>
                                             <tr ng-repeat="record in filtered = (BOMData| filter:search | orderBy : sortType:sortReverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                                                 <td><span ng-bind="$index+1"></td>
                                                 <td><%record.materialCode%></td>
                                                 <td><%record.desc%></td>

                                                 <td><%record.Description%></td>
                                                 <td>
                                                     <table cellpadding="0" cellspacing="0">
                                                         <tr class="border-none">
                                                             <!-- <td style="border:0px !important; font-size:16px;" ><a href="javascript:void(0)" class="" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-pencil"></i> </a></td>   -->
                                                            <td>
                                                            <a href="<?php echo Request::root().'/BOM/edit?&BOMId='?><%record.BOMId%>" data-position="bottom" data-delay="50" data-tooltip="Edit">
                                                            <button class="btn btn-animate flat blue pd-btn" type="submit" id="edit" name="edit">Edit</button></a></td> 
                                                             <div >
                                                               <td>
                                                               <!-- <button class="btn btn-animate flat blue pd-btn" id="remove" click="viewBom()" name="view">View</button> -->
                                                                 <input type="hidden" name="bomId" id="bomId" value="<%record.BOMId%>">
                                                                 <input class="btn btn-animate flat blue pd-btn" id="view" type="button" value="View" onclick="viewBom($(this).closest('td'))"/>
                                                               </td> 
                                                              
                                                             </div>
                                                         </tr>

                                                     </table>
                                                 </td>

                                             </tr>
                                             </tbody>
                                         </table>
                                         <p></p>  <p></p>
                                         
                                     </div>

                                 </div>
                             </div>

                              <!-- <div class="row">
                          <div class="col-sm-2">
                          <div>
                          <label for="dept">Select Page Size</label>
                           <select class="form-control" id="noofrecords" name="noofrecords" ng-model="modelid" ng-change="getBOMRecords()">
                                            <option  value="">--select--</option>
                                            <option  value="10">10</option>
                                            <option  value="20">20</option>
                                            <option  value="30">30</option>
                                            <option  value="40">40</option>
                                            <option  value="50">50</option>
                                        </select>
                           </div></div>
                           <div class="col-sm-8">
                          <div class="input-group">
                             <div class="pagination pagination-centered" ng-show="BOMData.length">
                              <ul class="pagination-controle pagination">
                             
                              <li>
                               <button type="button" class="btn btn-primary"
                                ng-click="prevPage()"> &lt; PREV</button>
                              </li>
                                <li>

                              <span>Page <%curPage%> of <%totalPages%></span>
                              </li>
                               <li>
                              <button type="button" class="btn btn-primary"
                                   
                                    ng-click="nextPage()">NEXT &gt;</button>
                               </li>
                              </ul>
                              </div>
                                                      
                           </div></div>
                          </div> -->
                        </div>
                      
                   
                     </div><!--/form-warpper-->

                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
              <!--  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">BOM</h4>
        </div>
        <div class="modal-body">
          <div id="receiptArea" class="rootContainer"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->
                
                          
                <div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content" style="width:1000px;margin-left: 180px">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridModalLabel">
                                    BOM
                                    </h4>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                <div id="receiptArea" class="rootContainer"></div>
                                    
                            </div>
                            </div>
                           </div>
                          <div class="col-sm-2">
                          </div>
                            <div class="modal-footer">
                                <button type="button" style="margin-right: 110px;height: 35px;" class="btn btn-default" data-dismiss="modal">
                                    Close</button>
                               </div>
                        </div>
                    </div>
                
            </div>
      </div><!--/container-->

  </div><!--/main-wrapper-->

  <?php require app_path().'/views/footer.php'; ?>
<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/bootstrap.js"></script> 
<script>

  function viewBom(td) 
    {   
      // $(this).closest('td').find('input[type=hidden]');
      // var id = document.getElementById(this);
      var id=$(td).closest('td').find('input[type=hidden]');
      var bomid=$(id).val();
      var base_url='<?php echo Request::root(); ?>/';

      $.ajax({
            type: "post",
            url: base_url+'BOM/BOM_GetById/'+bomid,
                // data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: OnSuccess,
            failure: function (response) {
                // alert(response);
            },
            error: function (response) {
                // alert(response);
            }
        });
      
    }

    function OnSuccess(response) {
     
      
      var MasterItemId;
        // For displaying Root element
        $.each(response.result1, function (key, value) {
          MasterItemId=value.MstrItemId
            $( ".rootContainer" ).empty();
            //create new ul on document and add it in empty receipt area
            var rootelem = document.getElementById("receiptArea");

            var parentUlCount = 0;
            var Ul = document.createElement('ul');
            var newUlId = "Ul" + parentUlCount;
            Ul.id = newUlId;
            rootelem.appendChild(Ul);
            $("#" + newUlId).attr("data-level", "0");
            //create new li
            var newul = document.getElementById(newUlId)
            var parentLiCount = newul.childElementCount + 1;
            var li = document.createElement('li');
            var newLiId = newUlId + "Li" + parentLiCount;
            li.id = newLiId;

            newul.appendChild(li);
            //create new span and put all information from database in it
            var cloneelem = document.createElement('span');
            $(cloneelem).append("<i></i>");
            //  $(cloneelem).append($(this).find('MstrMaterialCode').text());        commented on 20 dec 2016 for solving IE problem and added following line
            $(cloneelem).append('<h5 class="bomBehindText" > ' + value.MaterialDesc + ' </h5>'); //added on 12 dec 2016
            //commented on 7 oct 2016  $(cloneelem).append("<b class='deleteNode'></b>");

            $(cloneelem).attr("data-mid",value.MstrItemId);
            $(cloneelem).attr("data-mcode",value.MstrMaterialCode);
            $(cloneelem).attr("data-uomcode",value.MstrItmUOM);
            $(cloneelem).attr("data-description",value.MstrItmDesc);
            $(cloneelem).attr("data-bomdtlId",value.BOMId);


            var newli = document.getElementById(newLiId);
            newli.appendChild(cloneelem);

            //commented this on 7 oct 2016   $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
            $(newli).addClass("Parent"); //Added on 13th oct for solving display prblm


            //$(newli).addClass("Parent").find(' > span > i').attr('title', 'Collaps this branch');
            $(newli).find('> span > i').addClass("component");
            $('.rootContainer').removeAttr("ondrop");
            $('.rootContainer').removeAttr("ondragover");

            $("#" + newLiId).children('span').children('h5').attr("ondrop", "drop(event)");
            $("#" + newLiId).children('span').children('h5').attr("ondragover", "allowDrop(event)");
            //commented on 21 dec and added above two line for solving IE issue
            //            $("#" + newLiId).children('span').attr("ondrop", "drop(event)");  
            //            $("#" + newLiId).children('span').attr("ondragover", "allowDrop(event)");
        });

        //For Displaying child Elements
        $.each(response.result2, function (key, value) {
            //get the location where to add element
            var MstrItemId = value.MstrItemId;
            var TobeAddedItemId =value.DtlItemId;
            var Quantity =value.Quantity;
            //create new span and put all information from database in it
            var cloneelem = document.createElement('span');
            $(cloneelem).append("<i></i>");
            //  $(cloneelem).append($(this).find('MaterialCode').text());      commented on 20 dec 2016 for solving IE problem and added following line
            $(cloneelem).append('<h5 class="bomBehindText" > ' +value.MaterialDesc + ' </h5>'); //added on 12 dec 2016

            // if (MasterItemId == MstrItemId)//if element is direct child of Parent then only add textbox infront of it
            // {
            //     $(cloneelem).append("<b class='deleteNode'></b>");
            // }
            $(cloneelem).attr("data-mid", value.DtlItemId);
            $(cloneelem).attr("data-mcode",value.DtlMaterialCode);
            $(cloneelem).attr("data-uomcode",value.DtlItmUOM);
            $(cloneelem).attr("data-description",value.DtlItmDesc);
            $(cloneelem).attr("data-bomdtlId",value.BOMDetailsId);
            $(cloneelem).attr("ondrop", "return false;");

            $("#receiptArea").find('ul span').each(function () {

                //if ($(this).data("mid") == parseInt(MstrItemId) && $(this).parent('li').children("ul").find("li>span[data-mid=" + TobeAddedItemId + "]").length == 0) {//commented on 20 - oct - 2016 to solve display problem 1nd time and added below line in place of it
                //   if ($(this).data("mid") == parseInt(MstrItemId) && $(this).parent('li').children("ul>li").find("span[data-mid=" + TobeAddedItemId + "]").length == 0) { //commented on 20 - oct - 2016 to solve display problem 2nd time and added below line in place of it
                if (($(this).data("mid") == parseInt(MstrItemId)) && ($(this).parent('li').children("ul").find(">li>span[data-mid=" + TobeAddedItemId + "]").length == 0)) {

                    //create new ul

                    var Ul = document.createElement('ul');
                    var parentul = document.getElementById($(this).parent('li').attr('id'));
                    var parentUlCount = $(parentul).children('ul').length + 1;
                    var newUlId = $(this).parent('li').attr('id') + "Ul" + parentUlCount;
                    Ul.id = newUlId;
                    //Append ul
                    $(this).parent('li').append(Ul);
                    $("#" + newUlId).attr("data-level", parseInt($("#" + newUlId).parent().parent().attr("data-level")) + 1);
                    //Create new list item i.e. LI
                    var parentLiCount = $(Ul).children('li').length + 1;

                    var li = document.createElement('li');
                    var newLiId = newUlId + "Li" + parentLiCount;
                    li.id = newLiId;

                    var newul = document.getElementById(newUlId)
                    newul.appendChild(li);

                    var newli = document.getElementById(newLiId);
                    newli.appendChild(cloneelem);

                    //create textbox below each Node
                    if (MasterItemId == MstrItemId)//if element is direct child of Parent then only add textbox infront of it
                    {

                        // var newInputBox = document.createElement('input');
                        // newInputBox.type = "text";
                        // newInputBox.name = "txtQty" + newLiId;
                        // newInputBox.value = Quantity;
                        // newInputBox.placeholder = "Enter Quantity";
                        // newli.appendChild(newInputBox);
                        // $(newInputBox).addClass("qtytext");
                        // $(newInputBox).attr('style', 'margin-left: 20px');
                        // $(newInputBox).attr('style','width:90px;');
                        // $(newInputBox).attr("maxlength", "9");
                        // $(newInputBox).attr("onkeypress", "CheckQuantityIsNumber();");
                        // $(newInputBox).attr("onkeyup", "checkEmpty(txtQty" + newLiId + ");");
                        // $(newInputBox).attr("onblur", "checkEmpty(txtQty" + newLiId + ");");
                        // $(newInputBox).attr("ondrop", "return false;");
                        // $(newInputBox).css("display", "block");
                        // $(newInputBox).attr("ondrop", "return false;");
                        var newInputBox = document.createElement('b');
                        newInputBox.id = "labelQty" + newLiId;
                        $(newInputBox).append(Quantity);
                        newInputBox.placeholder = "Enter Quantity";
                        newli.appendChild(newInputBox);
                        $(newInputBox).addClass("qtytext");
                        $(newInputBox).attr("ondrop", "return false;");
                    }
                    else {
                        var newInputBox = document.createElement('b');
                        newInputBox.id = "labelQty" + newLiId;
                        $(newInputBox).append(Quantity);
                        newInputBox.placeholder = "Enter Quantity";
                        newli.appendChild(newInputBox);
                        $(newInputBox).addClass("qtytext");
                        $(newInputBox).attr("ondrop", "return false;");
                    }

                    //Add image infront of list

                    $(newli).find('> span > i').addClass("component");
                    // $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
                    // $(parentul).addClass("Parent").find(' > span > i').attr('title', 'Collapse this branch');
                    var parentli = document.getElementById(parentul.id);
                    if (parentli.childElementCount >= 2) {
                        $(parentli).find('> span > i').removeClass("component");
                        $(parentli).find('> span > i').addClass("minussign");
                    }

                }
            });

        });
       $('#gridSystemModal').modal('show');
    }
</script>


