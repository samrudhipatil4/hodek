<?php require app_path().'/views/header.php'; ?>

<?php if(isset($_GET['BOMId'])){
    $BOM_Id=$_GET['BOMId'];
}else{
    $BOM_Id="";
}
?>
  <div class="main-wrapper">
    <div class="container">

              <div class="row two-col-row mg-bottom-0">
                <div class="col-sm-12">

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="page-heading">
                          <h1>BOM</h1>
                        </div><!--/page-heading-->    
                      </div>
                    </div>

                <?php if(Session::has('message')){

                        echo Session::get('message');

                    }?>
                  <div class="content-wrapper">
                  <intput type="hidden" id="ContentPlaceHolder1_hidBOMId" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <label>
                                Drag Material From List To Treeview
                            </label>
                        </div>
                        
                        <div class="col-md-3">
                            <label>
                                BOM Structure
                            </label>
                            <div>
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                            </div>
                        </div>
                    </div>
                    
                     <div class="form-wrapper" >


                        <div class="row">
                          <div class="col-sm-12">
                            <div class="table-wrapper">
                            <div class="row">
                        <div class="col-md-6">
                            <div>
                                <input name="searchcriteria" type="text" id="SearchCriteria" onkeyup="searchItems();" AutoComplete="off" placeholder="Search Item to drag" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <input id="chkExplore" type="checkbox" name="chkExplore" />
                                Is Explorable
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <span id="ContentPlaceHolder1_lblQuantityRequired" style="display: none; color: Red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="listArea" id="Divlist">
                              
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div id="receiptArea" ondrop="drop(event)" ondragover="allowDrop(event)" 
                                class="rootContainer">
                            </div>
                        </div>
                    </div>
                            
                                <div class="row mg-top">
                                    <div class="col-sm-12">
                                        <!-- <button style="margin-top: 25px;margin-left: 10px;" class="btn flat blue pd-btn pull-right" type="button"  name="AllSubmit" value="doc_saveUser" onclick="SaveData()">Save</button> -->
                                         <input class="btn btn-primary btn-sm pull-right" style="height: 35px;" id="AllSubmit" type="button" onclick="return checkValidation(this.id);" value="Save" />
                                        <a href="<?php echo Request::root().'/BOM/indexData'?>"> 
                                        <input class="btn btn-primary btn-sm pull-right" style="height: 35px;margin-right: 15px;" id="Cancel" type="button" value="Cancel" click="getBomData()"/>
                                        </a>
                                         </div>
                                </div>
                            
                            </div><!--/table-wrapper-->
                          </div>
                        </div>

                        </div><!--/form-warpper-->


                  </div><!--/content-wrapper-->
                </div><!--/s10-->
              </div><!--/row-->
            
      </div><!--/container-->
  </div><!--/main-wrapper-->
<?php require app_path().'/views/footer.php'; ?>
<script>
    
$(document).ready(function () {
    // $(function () {
var base_url='<?php echo Request::root(); ?>/';
    $.ajax({
        url:base_url+'/BOM/get_material_data',
        type: 'get',
        //called on jquery ajax call success
        success: function (result) {
            
            var idcount = 0;
            $.each(result, function (key, value) {
                idcount++;
                var iDiv = document.createElement('span');
                iDiv.id = "Div" + idcount;
                document.getElementById('Divlist').appendChild(iDiv);
                var newDiv = document.getElementById("Div" + idcount);

                if (value.FLAG == "Assembly") {
                    $(newDiv).append('<i class="assembly"></i>');
                    $(newDiv).append('<h5 class="bomBehindText" > ' + value.MaterialDesc + ' </h5>');
                }
                else {
                    $(newDiv).append('<i class="component2"></i>');
                    $(newDiv).append('<h5 class="bomBehindText"> ' + value.MaterialDesc + ' </h5>');
                }

                $(newDiv).attr("draggable", "true");
                $(newDiv).attr("data-mid", value.id);
                $(newDiv).attr("data-mcode", value.materialCode);
                $(newDiv).attr("data-uomcode", value.UOM);
                $(newDiv).attr("data-description", value.Description);
                $(newDiv).attr("data-flag", value.FLAG);
                $(newDiv).attr("data-bomdtlId", "0");
                $(newDiv).attr("ondragstart", "drag(event)");
                $(newDiv).attr("ondragend", "endDrag(event)");

                $(newDiv).css("display", "block");
            });

        },

        error: function ajaxError(result) {
            alert(result.status + ' : ' + result.statusText);
        }
    });


    $(document).on('click', '.rootContainer li.Parent > span > i', function (e) {
        //('.rootContainer li.parent > div').on('click', function (e) {
        var children = $(this).parent('span').parent('li.Parent').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');

            // $(this).attr('title', 'Expand this branch').find(' > i').addClass('plussign').removeClass('minussign');
            $(this).attr('title', 'Expand this branch').addClass('plussign').removeClass('minussign');
        } else {
            children.show('fast');
            // $(this).attr('title', 'Collapse this branch').find(' > i').addClass('minussign').removeClass('plussign');
            $(this).attr('title', 'Collapse this branch').addClass('minussign').removeClass('plussign');

        }
        e.stopPropagation();
    });

    $(document).on('click', '.rootContainer li > span > b', function (e) {

        $(this).parent('span').parent('li').parent('ul').addClass("deleteUL");
        $(this).parent('span').parent('li').find('ul').addClass("deleteUL");
        // if ($('.rootContainer').has("li").length == 0) {
        // if ($('.rootContainer').has("ul:not(.deleteUL)").length == 0) {
        if ($(".rootContainer").children('ul:not(.deleteUL)').length == 0) {
            $('.rootContainer').attr("ondrop", "drop(event)");
            $('.rootContainer').attr("ondragover", "allowDrop(event)");
        }
        e.stopPropagation();
    });

// if (window.location.href.indexOf('?') > -1) {
//         history.pushState('', document.title, window.location.pathname);
//     }
     //On Modify BOM following transaction will occure  document.getElementById("ContentPlaceHolder1_hidBOMId").value
 var BOMId = GetParameterValues('BOMId');   
        // alert(BOMId);  
        function GetParameterValues(param) {  
            var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');  
            for (var i = 0; i < url.length; i++) {  
                var urlparam = url[i].split('=');  
                if (urlparam[0] == param) {  
                    return urlparam[1];  
                }  
            }  
        }   

    if (BOMId != "") {
      document.getElementById("ContentPlaceHolder1_hidBOMId").value=BOMId;
        document.getElementById("chkExplore").setAttribute("disabled", "disabled");

        var BOMId = BOMId;
        $.ajax({
            type: "post",
            url: base_url+'BOM/BOM_GetById/'+BOMId,
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
            //set explore
            if (value.IsExplorer == "true")
                document.getElementById("chkExplore").setAttribute("checked", "checked");
            $("#ContentPlaceHolder1_hidPrevRevisionNo").val(value.RevisionNumber);
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

            if (MasterItemId == MstrItemId)//if element is direct child of Parent then only add textbox infront of it
            {
                $(cloneelem).append("<b class='deleteNode'></b>");
            }
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

                        var newInputBox = document.createElement('input');
                        newInputBox.type = "text";
                        newInputBox.name = "txtQty" + newLiId;
                        newInputBox.value = Quantity;
                        newInputBox.placeholder = "Enter Quantity";
                        newli.appendChild(newInputBox);
                        $(newInputBox).addClass("qtytext");
                        $(newInputBox).attr('style', 'margin-left: 20px');
                        $(newInputBox).attr('style','width:90px;');
                        $(newInputBox).attr("maxlength", "9");
                        $(newInputBox).attr("onkeypress", "CheckQuantityIsNumber();");
                        $(newInputBox).attr("onkeyup", "checkEmpty(txtQty" + newLiId + ");");
                        $(newInputBox).attr("onblur", "checkEmpty(txtQty" + newLiId + ");");
                        $(newInputBox).attr("ondrop", "return false;");
                        $(newInputBox).css("display", "block");
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
                    $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
                    $(parentul).addClass("Parent").find(' > span > i').attr('title', 'Collapse this branch');
                    var parentli = document.getElementById(parentul.id);
                    if (parentli.childElementCount >= 2) {
                        $(parentli).find('> span > i').removeClass("component");
                        $(parentli).find('> span > i').addClass("minussign");
                    }

                }
            });

        });

    }



  });

function allowDrop(ev) {

   
    ev.dataTransfer.dropEffect = effect;
    ev.preventDefault();


}
var effect;

function drag(ev) {

   var base_url='<?php echo Request::root(); ?>/';
    ev.dataTransfer.effectAllowed = "uninitialized";
    ev.dataTransfer.dropEffect = "none";
    effect = "none";

    ev.dataTransfer.setData("text", ev.target.id);
  
    var MasterItemId = ev.target.getAttribute("data-mid");
    var ItemType = ev.target.getAttribute("data-flag");
    var countItems = $('.rootContainer  ul:not(.deleteUL)').length;
    var DetailItemID;
    var result = document.getElementById("ContentPlaceHolder1_lblQuantityRequired");
    if ($('.rootContainer  ul:not(.deleteUL):first > li > span').length <= 0)
    {  DetailItemID = 0;}
    else {
       
        DetailItemID = $('.rootContainer  ul:not(.deleteUL):first > li > span').attr("data-mid");
    }

    if (MasterItemId != DetailItemID || DetailItemID==0) {
        if (countItems == 0) {
            if (ItemType == "Assembly") {
                ev.dataTransfer.effectAllowed = "none";
                $(result).text("Assembly Can not be added at root");
                result.style.display = "";
                effect = "none";
                ev.dataTransfer.dropEffect = "none";
            }
            else {
                ev.dataTransfer.effectAllowed = "all";
                effect = "all";
                // ev.target.removeAttribute('title');

            }
        }
         else {
            // var appurl = $('#pageurl').val();

            // if ($(".rootContainer > ul > li >ul:not(.deleteUL) > li > span[data-mid= " + MasterItemId + " ]").length <= 0)
            //             {
            //                 effect = "all";
            //                 return effect;
            //             }
            //             else {
            //                 effect = "none";
            //                 $(result).text("Already exists in list");
            //                 result.style.display = "";
            //                 return effect;
            //             }
            $.ajax({
                type: "get",
                url: base_url+'BOM/BOM_CheckIsChild/'+MasterItemId+'/'+DetailItemID,
                // data: {},
                contentType: "application/json; charset=utf-8",
                // dataType: "json",
                //  success: OnGetAsyBOMSuccess,
                success: function (response) {
                  
                    if ($.trim(response) == "TRUE") {
                        //ev.dataTransfer.effectAllowed = "none";
                        effect = "none";
                        $(result).text("Assembly contains root");
                        result.style.display = "";
                        return effect;
                    }
                    else {
                        if ($(".rootContainer > ul > li >ul:not(.deleteUL) > li > span[data-mid= " + MasterItemId + " ]").length <= 0) //$(".rootContainer >ul>li >span[data-mid=" + MasterItemId + "]").length <= 0 &&
                        {
                            effect = "all";
                            //  ev.dataTransfer.effectAllowed = "all";
                            return effect;
                        }
                        else {
                            //ev.dataTransfer.effectAllowed = "none";
                            effect = "none";
                            $(result).text("Already exists in list");
                            result.style.display = "";
                            return effect;
                        }
                    }


                },
                failure: function (response) {
                    alert(response.d);
                    return "none";
                },
                error: function (response) {
                    alert(response.d);
                    return "none";
                }
            });
      
        }

    }
    else {
        ev.dataTransfer.effectAllowed = "none";
        effect = "none";
        $(result).text("Already exists in list");
        result.style.display = "";
    }
}


function drop(ev) {
ev.stopPropagation();
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var item = document.getElementById(data);
    var cloneelem = item.cloneNode(true);

    
    //cloneelem.innerHTML = "<img style='background-image:url(../images/plussign.png);height:16px;width:16px;' ></img>" + cloneelem.innerHTML;
    // cloneelem.innerHTML = "<i class='plussign'></i>" + cloneelem.innerHTML +'<b class="deleteNode"></b>';
  //  cloneelem.innerHTML = "<i></i>" + cloneelem.innerHTML + '<b class="deleteNode"></b>';
   cloneelem.innerHTML =  cloneelem.innerHTML + '<b class="deleteNode"></b>';
   if (effect == "all") {
       if (ev.target.className == "rootContainer") {
           var parentUlCount = ev.target.childElementCount + 1;
           var Ul = document.createElement('ul');
           var newUlId = "Ul" + parentUlCount;
           Ul.id = newUlId;

           ev.target.appendChild(Ul);

           var newul = document.getElementById(newUlId)
           var parentLiCount = newul.childElementCount + 1;
           var li = document.createElement('li');
           var newLiId = newUlId + "Li" + parentLiCount;
           li.id = newLiId;

           newul.appendChild(li);

           var newli = document.getElementById(newLiId);
           newli.appendChild(cloneelem);
           $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
           //$(newli).addClass("Parent").find(' > span > i').attr('title', 'Collapse this branch');
           $(newli).find('> span > i').removeClass(); //for removing first applied class
           $(newli).find('> span > i').addClass("component");

           //After first drop make container undroppable and newly created span droppable
           $('.rootContainer').removeAttr("ondrop");
           $('.rootContainer').removeAttr("ondragover");
           $("#" + newLiId).children('span').children('h5').attr("ondrop", "drop(event)");
           $("#" + newLiId).children('span').children('h5').attr("ondragover", "allowDrop(event)");
//           $("#" + newLiId).children('span').attr("ondrop", "drop(event)");
//           $("#" + newLiId).children('span').attr("ondragover", "allowDrop(event)");  commented on 20 dec 2016 and added aabove two lines
           $("#" + newLiId).children('span').removeAttr("ondragstart");
           $("#" + newLiId).children('span').removeAttr("draggable");
       }
       else {

           //create new ul
           var Ul = document.createElement('ul');
           //  var parentul = document.getElementById(ev.target.parentElement.id); changed and replaced with below line on 19 dec2016 for problem in IE
           var parentul = document.getElementById(ev.target.parentElement.parentElement.id);
           var parentUlCount = $(parentul).children('ul').length + 1;
           var newUlId = ev.target.parentElement.parentElement.id + "Ul" + parentUlCount;
           Ul.id = newUlId;
           ev.target.parentElement.parentElement.appendChild(Ul);

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
           var newInputBox = document.createElement('input');
           newInputBox.type = "text";
           newInputBox.id = "txtQty" + newLiId;
           newInputBox.placeholder = "Enter Quantity";
           newli.appendChild(newInputBox);
           // $(newInputBox).addClass("qtytext");
           $(newInputBox).attr('style', 'margin-left: 20px');
           $(newInputBox).attr('style','width:90px;');
           $(newInputBox).attr("maxlength", "9");
           $(newInputBox).attr("onkeypress", "CheckQuantityIsNumber(event);");
           $(newInputBox).attr("onkeyup", "checkEmpty(txtQty" + newLiId + ");");
           $(newInputBox).attr("onblur", "checkEmpty(txtQty" + newLiId + ");");
           $(newInputBox).attr("ondrop", "return false;");
           //Add image infront of list
           $(newli).find('> span > i').addClass("component");

           $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
           $(parentul).addClass("Parent").find(' > span > i').attr('title', 'Collapse this branch');
           var parentli = document.getElementById(parentul.id);
           if (parentli.childElementCount >= 2) {
               $(parentli).find('> span > i').removeClass("component");
               $(parentli).find('> span > i').addClass("minussign");
           }
           var ItemID = item.getAttribute("data-mid");
           callsubbom(ItemID, newLiId);
           $(newInputBox).focus();

       }
   } 
}

function callsubbom(ItemID, newLiId) {
var base_url='<?php echo Request::root(); ?>/';
    $.ajax({
        type: "GET",
        // url: "../ERP/BOM.aspx/BOM_GETAssemblyBOM_OnDrop",
        url: base_url+'BOM/BOM_GETAssemblyBOM_OnDrop/'+ItemID,
        // data: '{ItemID: ' + ItemID + '}',
        contentType: "application/json; charset=utf-8",
        
        //  success: OnGetAsyBOMSuccess,
        success: function (response) {
          // alert(response);
            OnGetAsyBOMSuccess(response,newLiId);
        },
        failure: function (response) {
            alert(response);
        },
        error: function (response) {
            alert(response);
        }
    });
}

function OnGetAsyBOMSuccess(response, newLiId) {

    // var xmlDoc = $.parseXML(response.d);
    // var xml = $(xmlDoc);
    // var BOMChild = xml.find("AssemblyBOM");
    
    $.each(response, function (key, value) {
        //get the location where to add element
        // alert(value.DtlItemId);exit();
        var TobeAddedItemId =value.DtlItemId; //$(this).find('ItemId').text();
        var MstrItemId =value.MstrItemId; //$(this).find('MstrItemId').text();
        var Quantity =value.Quantity; //$(this).find('Quantity').text();
        //create new span and put all information from database in it
        var cloneelem = document.createElement('span');
        $(cloneelem).append("<i></i>");
        $(cloneelem).append(value.DtlMaterialCode);//$(this).find('MaterialCode').text()
        //  $(cloneelem).append("<b class='deleteNode'></b>");
        $(cloneelem).attr("data-mid",value.DtlItemId);//$(this).find('ItemId').text()
        $(cloneelem).attr("data-mcode", value.DtlMaterialCode);
        $(cloneelem).attr("data-uomcode",value.DtlItmUOM);//$(this).find('UOM').text()
        $(cloneelem).attr("data-description",value.DtlItmDesc);//$(this).find('Descriptions').text()
        $(cloneelem).attr("data-bomdtlId",value.BOMDetailsId);//$(this).find('BOMDtlId').text()

        $("#" + newLiId).find('span').each(function () {
            if ($(this).data("mid") == parseInt(MstrItemId) && $(this).parent('li').children("ul").find(">li>span[data-mid=" + TobeAddedItemId + "]").length == 0) {
          //  if ($(this).data("mid") == parseInt(MstrItemId) && $(this).parent('li').children("ul").find("li>span[data-mid=" + TobeAddedItemId + "]").length == 0) {  commented on 22/12/2016
                //create new ul
                var Ul = document.createElement('ul');
                var parentul = document.getElementById($(this).parent('li').attr('id'));
                var parentUlCount = $(parentul).children('ul').length + 1;
                var newUlId = $(this).parent('li').attr('id') + "Ul" + parentUlCount;
                Ul.id = newUlId;
                //Append ul
                $(this).parent('li').append(Ul);
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
                var newInputBox = document.createElement('b');
                //  newInputBox.type = "text";
                // newInputBox.name = "labelQty" + newLiId;
                newInputBox.id = "labelQty" + newLiId;
                //newInputBox.value = Quantity;
                $(newInputBox).append(Quantity);
                newInputBox.placeholder = "Enter Quantity";
                newli.appendChild(newInputBox);
                $(newInputBox).addClass("qtytext");

                //$(newInputBox).attr("onkeypress", "CheckQuantityIsNumber();");


                //Add image infront of list
                $(newli).find('> span > i').addClass("component");
                $(newli).addClass("Parent").find(' > span > b').attr('title', 'Delete This Branch');
                $(parentul).addClass("Parent").find(' > span > i').attr('title', 'Collapse this branch');
                var parentli = document.getElementById(parentul.id);
                if (parentli.childElementCount >= 2) {
                    $(parentli).find('> span > i').removeClass("component");
                    $(parentli).find('> span > i').addClass("minussign");
                }

            }
        });

    });

}

function ValidateDrop(ev) {
    ev.preventDefault();

  //  var data = event.dataTransfer.getData("text");
   
}

function endDrag(event) {

    var result = document.getElementById("ContentPlaceHolder1_lblQuantityRequired");
    $(result).text("");
    result.style.display = "none";
}

function checkEmpty(thisTextbox) {

    var TextBox1 = thisTextbox.value; //document.getElementById(thisTextbox).value;

    var result = document.getElementById("ContentPlaceHolder1_lblQuantityRequired");

    if (TextBox1 == "" || parseInt(TextBox1) <= 0) {

        $(result).text("Please Enter Quantity");
        result.style.display = "";
//        thisTextbox.style.borderColor = "red";
        $(thisTextbox).css({ "border-color": "red"})

        $('#AllSubmit').attr("disabled", "disabled");
        thisTextbox.focus();
        return false;
    }
    else {

        result.style.display = "none";
        $('#AllSubmit').removeAttr('disabled');
        // thisTextbox.style.borderColor = "black";
        //   document.getElementById($(thisTextbox).attr('id')).style.borderColor = "black";
        $(thisTextbox).css({"border-color":"black","border-width":"1px"})
        //  thisTextbox.style.borderWidth = "1px";
      //  document.getElementById($(thisTextbox).attr('id')).style.borderWidth = "1px";

        return true;

    }
}

function CheckQuantityIsNumber(event) {

    if ((event.keyCode < 48 || event.keyCode > 57)) {
        event.returnValue = false;
    }
}

function searchItems() {

    //----------------------------------search code -------------------------------------------
    var textboxtext;

    var base_url='<?php echo Request::root(); ?>/';
     //   var key = e.keyCode;
        var txtValue;
//        if (key != 40 && key != 38 && key != 13 && key != 18) // Down key
//        {
            txtValue = $('[id*="SearchCriteria"]').val();
         //   textboxtext += txtValue;
            $.ajax({
                type: "get",
                contentType: "application/json; charset=utf-8",
                url:base_url+'/BOM/get_Item_data',
                data: {search:txtValue},
                dataType: "json",
                success: function (result) {
                    $("#Divlist").empty();
                    var idcount = 0;
                    $.each(result, function (key, value) {
                        idcount++;
                        var iDiv = document.createElement('span');
                        iDiv.id = "Div" + idcount;
                        document.getElementById('Divlist').appendChild(iDiv);
                        var newDiv = document.getElementById("Div" + idcount);

                        if (value.FLAG == "Assembly") {
                            $(newDiv).append('<i class="assembly"></i>');
                            $(newDiv).append('<h5 class="bomBehindText" > ' + value.MaterialDesc + ' </h5>');
                        }
                        else {
                            $(newDiv).append('<i class="component2"></i>');
                            $(newDiv).append('<h5 class="bomBehindText" > ' + value.MaterialDesc + ' </h5>');
                        }
                        $(newDiv).attr("draggable", "true");
                        $(newDiv).attr("data-mid", value.id);
                        $(newDiv).attr("data-mcode", value.materialCode);
                        $(newDiv).attr("data-uomcode", value.UOM);
                        $(newDiv).attr("data-description", value.Description);
                        $(newDiv).attr("data-flag", value.FLAG);
                        $(newDiv).attr("data-bomdtlId", "0");
                        $(newDiv).attr("ondragstart", "drag(event)");
                        $(newDiv).attr("ondragend", "endDrag(event)");

                        $(newDiv).css("display", "block");
                    });

                },

                error: function ajaxError(result) {
                    alert(result.status + ' : ' + result.statusText);
                }
            });
       // }
 
    //---------------------------------------end search code -----------------------------------

}

function checkValidation() {

        if (checkEmptyTextboxesOnSave() == "true") {
            SaveData();
   }
   else
   {return false;}
}

function checkEmptyTextboxesOnSave() {
var a;
$('.rootContainer input[type="text"]').each(function () {

    if ($(this).parent('li').parent('ul:not(.deleteUL)').find('input').val()!='') {
        var TextBox1 = $(this).parent('li').parent('ul:not(.deleteUL)').find('input').val(); //document.getElementById(thisTextbox).value;

        var result = document.getElementById("ContentPlaceHolder1_lblQuantityRequired");

        if (TextBox1 == "" || parseInt(TextBox1) <= 0) {

            $(result).text("Please Enter Quantity");
            result.style.display = "";
            (this).style.borderColor = "red";

            $('#AllSubmit').attr("disabled", "disabled");
            (this).focus();
            a = "false";
            return false;
        }
        else {

            result.style.display = "none";
            $('#AllSubmit').removeAttr('disabled');
            (this).style.borderColor = "black";
            (this).style.borderWidth = "1px";
            a = "true";
            return true;

        }
    }
    else {
        a = "false";
        return false;
    }
});
return a;
}

function SaveData() {
  var base_url='<?php echo Request::root(); ?>/';
    var result = document.getElementById("ContentPlaceHolder1_lblQuantityRequired");
   
    // check whether there is item/ BOm to save
   if ($(".rootContainer > ul > li > ul:not(.deleteUL)").length > 0) { //Commented this line on 15 dec 2016 becase condition  was not working  on Internet Explorer and was working on chrome browser
    //if ($(".rootContainer").children().length > 0 && $(".rootContainer").children('ul:not(.deleteUL)').length > 0) {  //Added this line in place of above on 15 dec 2016 because above condition  was not working  on Internet Explorer and was working on chrome browser
     $("#AllSubmit").attr("disabled", "disabled");
        var BOMid = "0";
        if ($("#ContentPlaceHolder1_hidBOMId").val() != "")
            BOMid = $("#ContentPlaceHolder1_hidBOMId").val();
        else
            BOMid = "0";

        var itemId = $('.rootContainer > ul:not(.deleteUL) > li > span').data('mid');
        var UOM = $('.rootContainer > ul:not(.deleteUL) > li > span').data('uomcode');
        var desc = $('.rootContainer > ul:not(.deleteUL) > li > span').data('description');
        var isExplore = $("#chkExplore").prop('checked') ? 1 : 0;
        // var isExplore ="0";
        var PrevRevNo = "0";
        // if ($("#ContentPlaceHolder1_hidPrevRevisionNo").val() != "")
        //     PrevRevNo = $("#ContentPlaceHolder1_hidPrevRevisionNo").val();
        // else
        //     PrevRevNo = "0";

        var master = [];
        master.push({
            BOMid: BOMid,
            itemId: itemId,
            UOM: UOM,
            desc: desc,
            isExplore: isExplore,
            PrevRevNo: PrevRevNo
        });

        var detail = [];
        var Delete;
        $('.rootContainer > ul:not(.deleteUL) > li > ul').each(function () {
            var ctr = 2;

            if ($(this).hasClass('deleteUL')) {
                Delete = 1
            }
            else
            { Delete = 0 }

            var BOMDtlid = $(this).find('li > span').data('bomdtlid');
            var itemId = $(this).find('li > span').data('mid');
            var description = $(this).find('li > span').data('description');
            var uom = $(this).find('li > span').data('uomcode');
            var qty = $(this).find('li > input[type="text"]').val();


            detail.push({
                BOMDtlid: BOMDtlid,
                itemId: itemId,
                uom: uom,
                description: description,
                qty: qty,
                deleted: Delete
            });
        });


        var serialized = JSON.stringify(detail);
        var serializedMaster = JSON.stringify(master);
        $.ajax({
            type: "POST",
            url: base_url+'BOM/saveData',
            // dataType: "json",
            data:{master:serializedMaster,detail:serialized},
            // data: "{'data':'" + serialized + "', 'master':'" + serializedMaster + "'}",
            //                data: "{data:'" + serialized + "'}",
            // contentType: "application/json; charset=utf-8",
            success: function (data) {
             
                if (data == 1) {
                  // alert(data);exit();
                    // if (window.location.href.indexOf('?') > -1) {
                    //  history.pushState('', document.title, window.location.pathname);
                    // }
                    // location.reload();
                    window.location.href = base_url+'BOM/indexData';
                }
                else {
                    $("#ContentPlaceHolder1_lblMessage").text(data.d);
                    $("#btnShowPopup").click();
                    $('#btnAddRow').removeAttr('disabled');
                    $('#ContentPlaceHolder1_AllSubmit').removeAttr('disabled');
                }

                // 

            }
        });
        $(result).text("");
        result.style.display = "none";
    }
    else {
      
        $(result).text("Please Add Nodes");
        result.style.display = "";
    }
}

</script>