var masterApp = angular.module('myApp1',['ui.bootstrap', 'chart.js','kendo.directives']);

var appurl = $('#pageurl').val();

masterApp.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);

masterApp.directive('file', function () {
    return {
        scope: {
            file: '='
        },
        link: function (scope, el, attrs) {
            el.bind('change', function (event) {
                var files = event.target.files;
                var file = files[0];
                scope.file = file ? file.name : undefined;
                scope.$apply();
            });
        }
    };
});

masterApp.directive('ngConfirmClick', [
    function () {
        return {
            priority: 1,
            terminal: true,
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.ngClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    }])
masterApp.directive('match',
    function () {
        return {
            require: 'ngModel',
            restrict: 'A',
            scope: {
                match: '='
            },
            link: function (scope, elem, attrs, ctrl) {
                scope.$watch(function () {
                    var modelValue = ctrl.$modelValue || ctrl.$$invalidModelValue;
                    return (ctrl.$pristine && angular.isUndefined(modelValue)) || scope.match === modelValue;
                }, function (currentValue) {
                    ctrl.$setValidity('match', currentValue);
                });
            }
        };
    });

masterApp.directive('validFile', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attrs, ngModel) {
            el.bind('change', function () {
                scope.$apply(function () {
                    ngModel.$setViewValue(el.val());
                    ngModel.$render();
                });
            });
        }
    }
});

masterApp.controller('DatepickerDemoCtrl', function ($scope) {

    $scope.open = function($event) {
        $scope.status.opened = true;
    };

    $scope.setDate = function(year, month, day) {
        $scope.dt = new Date(year, month, day);
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy','dd/MM/yyyy', 'shortDate'];
    $scope.format = $scope.formats[3];

    $scope.status = {
        opened: false
    };


    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 2);
    $scope.events =
        [
            {
                date: tomorrow,
                status: 'full'
            },
            {
                date: afterTomorrow,
                status: 'partially'
            }
        ];

    $scope.getDayClass = function(date, mode) {
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i=0;i<$scope.events.length;i++){
                var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    };
});

masterApp.controller('DatepickerDemoCtrl1', function ($scope) {
    $scope.today = function() {
        $scope.dt = new Date().getTime();
    };
    $scope.today();

    $scope.clear = function () {
        $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
        return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    };
//********************changes done by sonu ie commented toggle for bdate in professional tab
    //$scope.toggleMin = function() {
    //  $scope.minDate = $scope.minDate ? null : new Date();
    // };
    // $scope.toggleMin();

    $scope.open = function($event) {//alert();
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['yyyy/MM/dd', 'shortDate'];
    $scope.format = $scope.formats[0];
});

masterApp.directive('calendar', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attr, ngModel) {
            $(el).datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (dateText) {
                    scope.$apply(function () {
                        ngModel.$setViewValue(dateText);
                    });
                }
            });
        }
    };
})


masterApp.directive('datepicker', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link : function (scope, element, attrs, ngModelCtrl) {
            $(function(){
                element.datepicker({
                    dateFormat:'dd/mm/yy',
                    onSelect:function (date) {
                        scope.$apply(function () {
                            ngModelCtrl.$setViewValue(date);
                        });
                    }
                });
            });
        }
    }
});

masterApp.directive("datepicker1", function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, elem, attrs, ngModelCtrl) {
            var updateModel = function (dateText) {
                scope.$apply(function () {
                    ngModelCtrl.$setViewValue(dateText);
                });
            };
            var options = {
                dateFormat: "dd/mm/yy",
                minDate:0,
                onSelect: function (dateText) {
                    updateModel(dateText);
                }
            };
            elem.datepicker(options);
        }
    }
});


masterApp.directive('jqdatepicker', function () {//alert();
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, elem, attrs, ngModelCtrl) {
            var updateModel = function (dateText) {
                scope.$apply(function () {
                    ngModelCtrl.$setViewValue(dateText);
                });
            };
            var options = {
                 dateFormat: "dd.mm.yy",
                minDate:0,
                onSelect: function (dateText) {
                    updateModel(dateText);
                }
            };
            elem.datepicker(options);
        }
    }
});
 
masterApp.directive('loading',   ['$http' ,function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.show();
                    }else{
                        elm.hide();
                    }
                });
            }
        };

    }]);

masterApp.directive('myUpload', [function () {
        return {
            restrict: 'AE',
            link: function (scope, elem, attrs) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    scope.oldimage = e.target.result;
                    scope.$apply();
                }
                elem.on('change', function () {
                    
                //    alert(reader.readAsDataURL(elem[0].files[0]));
                    reader.readAsDataURL(elem[0].files[0]);
                });
            }
        };
    }]);

/*  Pie chart controller */

masterApp.controller("PieCtrl1", function ($scope,$http) {
   
    $http
                    .get(appurl + 'changes/get_chart1')
                    .success(function(data, status, headers, config) {
                     
                      $scope.labels = data.name;
              // alert(JSON.stringify($scope.labels));
                   
                         $scope.values = data.val; 
                        
                                               

                    });
});

masterApp.controller("PieCtrl2", function ($scope,$http) {
   $http
                    .get(appurl + 'changes/get_chart2')
                    .success(function(data, status, headers, config) {
                      
                      $scope.labels = data.name;                    
                      $scope.values = data.val; 
                       
                    });
});


masterApp.controller("BarCtrl", function ($scope,$http) {


    $http
        .get(appurl + 'changes/get_chart3')
        .success(function(data1, status, headers, config) {

            $scope.labels = data1.name;
            $scope.data = [data1.val];
            $scope.values = data1.val;


            $scope.series = ['Series A'];
        });


});


masterApp.controller('CtrlView', function($scope,$http){


    $http
        .get(appurl + 'changes/assigned_task_to_me')
        .success(function(data, status, headers, config) {
            $scope.assignedtaskstome=data[0];

        })



 $scope.dosearch = function(requestForm,search) {
       // $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {
            
         /*   var year1=$scope.search.searchid;
           // alert(year1);return
                    
            //  alert(year1.split("/")[2]);
                 //   year1=year1.split("-")[0]
                 $scope.search.id=year1.split("/")[2];
     
            var data={};
            data = $scope.search;
        

            $http
                    .post(appurl + 'view_search_result', data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Your Search Records.', 'success');
                    $scope.search = '';
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();
                    $scope.showReport = true;
                    $scope.summeries=data['userjobs'];
                    $scope.parts=data['parts'];
                   //  alert(JSON.stringify($scope.parts));


            }).error(function(data, status, headers, config) {
            });
            */
        }
    };
   
  $scope.dosearch1 = function(requestForm,search){
    $scope.showReport = true;
  };
    $scope.status = {
        isFirstOpen: true,
        oneAtATime: true
    };

    $scope.summeryReport=function(year1){


       // var year1=$scope.search.searchid;
        // alert(year1);return

        //  alert(year1.split("/")[2]);
        //   year1=year1.split("-")[0]


        var id=year1.split("-")[2];

      //  alert(id);

       // var data={};
      //  data = $scope.search;


        $http
            .get(appurl + 'view_search_result/'+id)
            .success(function(data, status, headers, config) {

              //  $.simplyToast('Your Search Records.', 'success');
                $scope.showReport = true;
                $scope.summeries=data['userjobs'];
                $scope.parts=data['parts'];
                //$scope.before_after=data;
               // $scope.risksdatas1=data['risks'];

             //   alert(data['risks'].length);
               //  alert(JSON.stringify($scope.before_after));
            });
        /*$http
            .get(appurl + 'view_risk_asses_data/'+id)
            .success(function(data, status, headers, config) {
                $scope.risksdatas1=data;
            });
        */

        $http
            .get(appurl + 'changes/fetch_dep_team/'+id)
            .success(function(data, status, headers, config) {

                $scope.team_members=data;
            });

        $http
            .get(appurl + 'changes/get_allRisk_assessment_approval/'+id)
            .success(function(data, status, headers, config) {

                $scope.risksdatas1=data;
            });




    }



});

/* Date picker controller */
masterApp.controller("datePicker", function ($scope) {

    $scope.today = function() {
        $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function () {
        $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
        return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    };

    $scope.toggleMin = function() {
        $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();
    $scope.maxDate = new Date(2020, 5, 22);

    $scope.open = function($event) {
        $scope.status.opened = true;
    };

    $scope.setDate = function(year, month, day) {
        $scope.dt = new Date(year, month, day);
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];

    $scope.status = {
        opened: false
    };

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 2);
    $scope.events =
        [
            {
                date: tomorrow,
                status: 'full'
            },
            {
                date: afterTomorrow,
                status: 'partially'
            }
        ];

    $scope.getDayClass = function(date, mode) {
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i=0;i<$scope.events.length;i++){
                var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    };

});

masterApp.directive("datepicker", function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, elem, attrs, ngModelCtrl) {
            var updateModel = function (dateText) {
                scope.$apply(function () {
                    ngModelCtrl.$setViewValue(dateText);
                });
            };
            var options = {
                dateFormat: "dd/mm/yy",
                onSelect: function (dateText) {
                    updateModel(dateText);
                }
            };
            elem.datepicker(options);
        }
    }
});
masterApp.controller('updateInitSheetCtrl', function($scope,$http,$location,$window){

    $scope.updatesheet = {
        selected: '1'
    };

    $scope.cancel = function(updateform) {
        $scope.newReocord1=false;

        $scope.risks = '';
        $scope.risks_new = '';

        $scope.updateform.$setPristine();
        $scope.updateform.$setUntouched();

    };

    $scope.UpdateRecord = function(updaterisksheet,id,r_id){//alert();

        if (updaterisksheet.$invalid) {
            $scope.invalidSubmitAttempt = true;

            return;
        } else {


            var data = {};
            $scope.risks.request_id = r_id;

            data = $scope.risks;

            if (data.team_member == 0) {

                alert("Please Select Team Member");


            } else {


                $http
                    .post(appurl + 'changes/add_dep_team/'+id, data)
                    .success(function (data, status, headers, config) {
                        $scope.fetch1(id);

                        $scope.risks.cost = "";
                        $scope.newReocord1 = false;

                      //  $scope.updaterisksheet.$setPristine();
                      //  $scope.updaterisksheet.$setUntouched();

                    }).error(function (data, status, headers, config) {
                });
            }
        }

    };



    $scope.newReocord1 = false;

    $scope.EditRecord = function(index,id) {

        $scope.newReocord1 = true;

        $http
            .get(appurl + 'changes/fetch_table_data/' + id)
            .success(function (data, status, headers, config) {
                $scope.risks = data[0];

              //  alert(JSON.stringify($scope.risks));
                $scope.risks_new = data;


            }).error(function (data, status, headers, config) {
        });



    };

    $http
        .get(appurl + 'changes/assigned_task_to_me')
        .success(function(data, status, headers, config) {
            $scope.assignedtaskstome=data[0];

        })




                /*    $scope.add_customer=function(customer_id,request_id,department_id)
                    {

                        $scope.updatesheet.request_id=request_id;
                        $scope.updatesheet.customer_id=customer_id;
                        $scope.updatesheet.department_id=department_id;

                        var data={};

                        data = $scope.updatesheet;

                       // alert(JSON.stringify(data));exit;

                        $http
                            .post(appurl + 'changes/add_dep_team', data)
                            .success(function(data, status, headers, config) {

                              //  if(data==1) {
                                    $scope.fetch(request_id);

                                    $scope.visibleTable= true;

                              //  }else{

                               //     $.simplyToast('Department Already Added to List.', 'warning');

                             //   }
//



                            }).error(function(data, status, headers, config) {
                        });




                    }*/

                   $scope.fill_team_member = function(d_id){
                    if (d_id !== '') {
                    $http
                    .get(appurl + 'changes/fill_team/'+ d_id)
                    .success(function(data, status, headers, config) {  // alert(JSON.stringify(data));                  
                         $scope.teamMembers=data;
                       
                    });
                  }
               };


                $scope.visibleTable= true;
                $scope.fetch = function(id){

                    $http
                        .get(appurl + 'get_request_info_by_id/'+id)
                        .success(function(data, status, headers, config) {
                            $scope.cmno=data;


                        });

                    $http
                        .get(appurl + 'get_request_info_by_id_for_status/'+id)
                        .success(function(data, status, headers, config) {
                            $scope.status=data;


                        });


                     };

                        $scope.fetch1 = function(id){



                            $http
                                .get(appurl + 'changes/department1/'+id)
                                .success(function(data, status, headers, config) {

                                    $scope.availableOptions=data;

                                });


                        };
                         
//==============================================================================
    $scope.reloadRoute = function() {
        $window.location.reload();
    }

   $scope.records=[];
   $scope.AddRecord = function(updaterisksheet,r_id){

     if (updaterisksheet.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

           $scope.updatesheet.request_id=r_id;
         
            var data={};
            
            data = $scope.updatesheet;

            $http
                    .post(appurl + 'changes/add_dep_team/'+r_id, data)
                    .success(function(data, status, headers, config) {

                        if(data==1) {
                            $scope.fetch1(r_id);

                            $scope.visibleTable= true;



                        }else{


                            $.simplyToast('Department Already Added to List.', 'warning');
                          //  $scope.reloadRoute();

                        }
                    

                   

            }).error(function(data, status, headers, config) {
            });
      }
   };

   //====================================================================================
   //
   //Function to delete records in update initial sheet for departments and team members 
   //
   //====================================================================================
 $scope.DelRecord = function(index,id) {
          
                   
            $http
                    .delete(appurl+'changerequest/changes/' +id)
                    .success(function(data, status, headers, config) {
                       
                        $scope.records.splice(index, 1);// for hide deleted data
                    }).error(function(data, status, headers, config) {
            });
        };
 


  //====================================================================================
   //
   //Function to delete records in update initial sheet for departments and team members 
   //
   //====================================================================================
 $scope.addinitial_info_sheet = function(updatesheetForm,r_id,id) {
        $scope.submitted= true;
        $scope.progress=false;
        if (updatesheetForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

            /*

            complete all design member code goes here

             */
            $http
                .get(appurl + 'changes/check_department_sheet_to_user_status/'+r_id+'/'+id)
                .success(function(data1, status, headers, config) {

                    if(data1==0){

                        $.simplyToast('Please Add all Team-Members.', 'warning');

                    }else{

          $scope.progress=true;
            $scope.isDisabled=true;
          
            $scope.updatesheet.request_id=r_id;
           // $scope.updatesheet.currentTime=$('#currentTime').val();
         
            var data={};
            
            data = $scope.updatesheet;

                       // alert(JSON.stringify(data));exit;


            $http
                    .post(appurl + 'changes/add_initial_info_sheet/'+id, data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Mail Sent successfully.', 'success');

                    
                    $scope.progress=false;
                    $scope.isDisabled=false;
                    $scope.currentTime="";
                    $scope.stock="";
                    $scope.updatesheetForm.$setPristine();
                    $scope.updatesheetForm.$setUntouched();
                    $scope.submitted= false;

                        location.href = appurl + 'dashboard';




                    }).error(function(data, status, headers, config) {
            });
                    }


                });


        }
 };

})


masterApp.controller('CtrlCommDecision', function($scope){

  $scope.customers=[];

  $scope.AddRecord = function(){

    $scope.visibleTable= true;

    $scope.customers.push(
      {
        'description': $scope.description,
        'decisions':$scope.decision,
        'responsibility':'If YES Blocked for Approval, If NO it must be blank'
      })
    $scope.description = '';
  };

  $scope.DelRecord = function(name){
      var index = -1;
      var comArr = eval( $scope.customers );

      for( var i = 0; i < comArr.length; i++ ) {
        if( comArr[i].name === name ) {
        index = i;
        break;
        }
      }
    $scope.customers.splice( index, 1 );
  };

});
//============================================================
//
//            Filter for Risk assessment sheet  
//
//============================================================
masterApp.filter('Applicability', function () {
  return function (items) {
   if(items==2){
    return 'NO'
   }else if(items==1){
    return 'YES'
   }else{
    return 'NO'
   }
  };
});



masterApp.filter('Closerfiler', function () {
    return function (items) {
        if(items==20){
            return 'closed'
        }else if(items==21){
            return 'open'
        }else if(items==22){
            return 'cancelled'
        }else{
            return '--'
        }
    };
});

masterApp.filter('STAPFLT', function () {
    return function (items) {
        if(items==1){
            return 'Approved'
        }else if(items==2){
            return 'Pending'
        }else{
            return '--'
        }
    };
});


//===============================================================================
//
//            Filter for Activities completion Status monitoring for file status
//
//===============================================================================
masterApp.filter('filestatus', function () {
    return function (items) {
        if(items==''){
            return 'Pending'
        }else if(items==1){
            return 'Uploaded'
        }
    };
});
//============================================================
//
//            Filter for Update Risk analysis sheet  
//
//============================================================
masterApp.filter('statusfilter', function () {
  return function (items) {
      if(items==0){
          return '--'
      }else if(items==2){
    return 'Complete'
   }else if(items==1){
    return 'Incomplete'
   }else{
    return '--'
   }
  };
});

masterApp.filter('decision_filter', function () {
    return function (items) {
        if(items==1){
            return 'Yes'
        }else{
            return 'No'
        }
    };
});

masterApp.controller('CtrlRiskAnalysis1', function($scope,$http){


    $scope.get_info=function(id){
        $http
            .get(appurl + 'get_request_info_by_id/'+id)
            .success(function(data, status, headers, config) {
                $scope.cmno=data;


            });

        $http
            .get(appurl + 'get_request_info_by_id_for_status/'+id)
            .success(function(data, status, headers, config) {
                $scope.status=data;


            });

    }

})

// update risk analysis sheet
masterApp.controller('CtrlRiskAnalysis', function($scope,$http){

    $scope.risks={selected:1}
    $scope.risks={applicability:1}


   // risks.applicability

        $scope.get_info=function(id){


            $http
                .get(appurl + 'changes/add_risk_admin_sheet_to_user/'+id)
                .success(function(data, status, headers, config) {
                    $scope.tasks=data;


                });



        }

   //====================================================================================
   //
   //            Function to delete records in update risk assessment sheet 
   //
   //====================================================================================
 $scope.DelRecord = function(index,id) {
          if(confirm("Are you sure to delete this Record")){
     $http
                    .post(appurl+'changes/delete_table_data/' +id)
                    .success(function(data, status, headers, config) {
                       
                        $scope.tasks.splice(index, 1);// for hide deleted data
                    }).error(function(data, status, headers, config) {
            });
    }
                   
            
};

    $scope.open = {};
    $scope.isDisabled1 = false;
    $scope.risks=[];
    $scope.UpdateRecord = function(updateform,id,r_id){
      //  $scope.risks.currentTime=$('#currentTime').val();
        if (updateform.$invalid) {
           // $scope.risks.currentTime=$('#currentTime').val();

           // alert($scope.risks.currentTime);
            $scope.invalidSubmitAttempt = true;

            return;
        } else {
            var data = {};
          //  $scope.risks.currentTime=$('#currentTime').val();

            data = $scope.risks;
           // alert(JSON.stringify(data));exit;


            $http
                .post(appurl + 'changes/update_table_record/' + id, data)
                .success(function (data, status, headers, config) {

                    $scope.fetch(r_id);

                    $scope.risks.target_date = "";
                    $scope.risks.reason = "";
                    $scope.risks.description = "";
                    $scope.risks.applicability = "";
                    $scope.risks.responsibility = "";
                    $scope.risks.cost = "";
                    $scope.newReocord1 = false;
                    $scope.isDisabled1 = true;
                   // $scope.updateform.$setPristine();
                   // $scope.updateform.$setUntouched();
                   // $scope.isDisabled = false;
                   // $scope.btnLabel = "Add New Record";


                }).error(function (data, status, headers, config) {
            });
        }

    };

   //====================================================================================
   //
   //            Function to delete records in update risk assessment sheet 
   //
   //====================================================================================
 $scope.isDisabled = false; 
 $scope.EditRecord = function(index,id) {

             $scope.newReocord1 = true;
             $scope.isDisabled = true;
             $scope.newReocord = false;
             $scope.isDisabled1 = false;


             $http
                 .get(appurl + 'changes/edit_table_data/' + id)
                 .success(function (data, status, headers, config) {
                     $scope.risks = data;
                    // $scope.risks = data[0].;
                   // alert(JSON.stringify( $scope.risks));

                 }).error(function (data, status, headers, config) {
             });



        };
 $scope.cancel = function(updateform) {
         $scope.newReocord1=false;
         $scope.isDisabled = false; 
         $scope.newReocord=false;  
         $scope.isDisabled1 =false;
     $scope.risks.target_date = "";
     $scope.risks.reason = "";
     $scope.risks.description = "";
     $scope.risks.applicability = "";
     $scope.risks.responsibility = "";
     $scope.risks.cost = "";
     $scope.newReocord1 = false;
     $scope.isDisabled1 = true;
     // $scope.isDisabled = false;
     // $scope.btnLabel = "Add New Record";
    // $scope.updateform.$setPristine();
   //  $scope.updateform.$setUntouched();
            
        };

    //========X=============X============X=============X=============  
    
    
 //==============================================================================
 //
 //
 //
 //==============================================================================

//==============================================================
//
//Function to fetch HOD Department
//
//==============================================================
   // var id="2"//Hod department Id

    $http
        .get(appurl + 'changes/getdepartment/4')
        .success(function(data, status, headers, config) {

            $scope.hoddepartments=data;


        });


     $http
        .get(appurl + 'changes/get_risk_subdepartment')
        .success(function(data, status, headers, config) {

            $scope.risk_subdepartments=data;


        });
  //====================X======X======X=========================




                $scope.tasks=[];
                $scope.selected = 'Yes';


                $scope.visibleTable= true;

                $scope.fetch = function(r_id){

                    $http
                        .get(appurl + 'changes/add_risk_admin_sheet_to_user/'+r_id)
                        .success(function(data, status, headers, config) {
                            $scope.tasks=data;


                        });
      };
                         
//==============================================================================
                       



  $scope.btnLabel= "Add New Record";

  $scope.btnToggle =function(){
      $scope.newReocord =! $scope.newReocord;

      if($scope.newReocord == true){
        $scope.btnLabel= "Close Form";
      }else{
        $scope.btnLabel= "Add New Record";
      }
  };

  $scope.appFunction = function(){

  };

});

masterApp.controller('CtrlRiskAnalysisADD', function($scope,$http,$location){

    $scope.risk = {
        selected: '1'
    };

    $scope.records=[];
//==============================================================================

    $scope.AddRecord = function(addform,risk,r_id){

        if (addform.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {


            $scope.risk = risk;
            $scope.risk.request_id = r_id;
            $scope.risk.currentTime=$('#currentTime').val();
            var data = {};

            data = $scope.risk;

            $http
                .post(appurl + 'changes/update_risk_info_sheet', data)
                .success(function (data, status, headers, config) {
                    $scope.fetch();

                    $scope.visibleTable = true;
                    $scope.tasks.push({
                        riskAssessment: $scope.description,
                        applicability: $scope.selected,
                        action: $scope.reason,
                        responsibility: $scope.responsibility,
                        data: $scope.target_date,
                        cost: $scope.cost
                    })
                    $scope.risk.currentTime = "";
                    $scope.risk.reason = "";
                    $scope.risk.description = "";
                    $scope.risk.selected = "";
                    $scope.risk.responsibility = "";
                    $scope.risk.cost = "";
                    $scope.risk.risk_sub_dep = "";
                    $scope.submitted = false;
                    $scope.newReocord1 = false;
                    $scope.btnLabel = "Add New Record";
                    $scope.btnToggle();
                    $scope.updaterisksheet.$setPristine();
                    $scope.updaterisksheet.$setUntouched();

                }).error(function (data, status, headers, config) {
            });
        }

    };


})


masterApp.controller('CtrlRiskAnalysisAll', function($scope,$http,$location){
    $scope.isDisabled = false;
    $http
        .get(appurl + 'changes/get_hod_by_user_dep')
        .success(function(data, status, headers, config) {

            $scope.hod=data[0];


        });

  /*  $http
        .get(appurl + 'changes/get_hod_by_dep')
        .success(function(data, status, headers, config) {
            $scope.deps=data[0];

        });*/
    $scope.update_risk_sheet = function(updaterisksheet,r_id,id){
        $scope.isDisabled = false;
        if (updaterisksheet.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

            $http
                .get(appurl + 'changes/check_risk_admin_sheet_to_user_status/'+r_id+'/'+id)
                .success(function(data1, status, headers, config) {
                    //$scope.tasks=data;
                    if(data1==0){

                        $.simplyToast('Please complete all Risk Assessment Points.', 'warning');

                    }else{

                        $scope.isDisabled = true;
                        var Approval_Authority=$('#Approval_Authority').val();

                        $http
                            .get(appurl + 'changes/add_update_risk_analysis/'+r_id+'/'+id+'/'+Approval_Authority)
                            .success(function(data, status, headers, config) {
                                $scope.isDisabled = true;
                                $.simplyToast('Mail Sent successfully.', 'success');
                                location.href = appurl + 'dashboard';

                            }).error(function(data, status, headers, config) {
                        });
                    }


                });


        }
    };

})



/* Login Form Controller */



/* RootController Form Controller */

masterApp.controller('RootCtrl', ['$scope', '$http','$location','$window',
  function($scope,$http,$location,$window) {

//==================================== Login =========================================

     $scope.getlogo = function(){

                    $http
                    .get(appurl + 'user/dashboardlogo')
                    .success(function(data, status, headers, config) {
                      
                         $scope.logo=data[0];
                      //    alert(JSON.stringify($scope.logo));
                    });



          };

           $scope.getlogo();

}])



	
		
  masterApp.directive('myTask',function(){
    return{
      restirct:'AE',
      transclude: true,
      scope: true,
      replace:true,
      //priority:1,
      scope: {
                value: '=ngModel',
                 rate: '=rate',


                },
      template:'<span class="<%class%>"><%name%></span>',
      link:function(scope,ele,attr){ 
      
      var status=scope.rate;
     

          if(status==1){
          
          scope.class="re-initiated";
          scope.name="Initiated";

  
            }else if(status==2){
                    scope.class="accepted";
                    scope.name="Accepted";

            }
            else if(status==3){
                    scope.class="rejected";
                    scope.name="Rejected";

            }
            else if(status==4){
                    scope.class="re-initiated";
                    scope.name="Reinitiated";

            }
              else if(status==5){
                    scope.class="re-initiated";
                    scope.name="Drafted";

            }


          
        }

      }

    })



		
  masterApp.directive('myCmNo',function(){
    return{
      restirct:'AE',
      transclude: true,
      scope: true,
      replace:true,
      priority:1,
      scope: {
				value: '=ngModel',
				 type: '=type',
				 year: '=year',
				 rid: '=rid',
                status:'=status',


			},
      template:'<span><%name%></span>',
      link:function(scope,ele,attr) {

          //	  alert(scope.rid);
          if (scope.status == 1 || scope.status == 5) {

              scope.name = "---/----/--";
          } else {

              var str = attr.type;
            //  alert(str);
              console.log(str, str + " more");


           //   alert(ele.val("value = "+attr.value));


          var status1 = scope.type;

           //  alert(ele.val(attr.year));
          var status2 = ele.val(attr.year);

          var year1 = status2.split(" ")[0];
          year1 = year1.split("-")[0]


          // alert(status.charAt(0));
          // alert(year1);

          scope.name = status1.charAt(0) + "CM/" + year1 + "/" + scope.rid;

      }
          
        }

      }

    })



masterApp.directive('myCmNoSearch',function(){
    return{
        restirct:'AE',
        transclude: true,
        scope: true,
        replace:true,
        priority:1,
        scope: {
            value: '=ngModel',
            type: '=type',
            year: '=year',
            rid: '=rid',
            status:'=status',


        },
        template:'<a href="<%url%>views?searchid=<%name%>" class="" data-position="bottom" data-delay="50" data-tooltip="View Record"><i class="fa fa-eye"></i></a>',

        link:function(scope,ele,attr) {




                var status1 = scope.type;
                var status = scope.year;

                var year1 = status.split(" ")[0];
                year1 = year1.split("-")[0]


                // alert(status.charAt(0));
                // alert(year1);
               scope.url=appurl;

                scope.name = status1.charAt(0) + "CM-" + year1 + "-" + scope.rid;

        }

    }

})

masterApp.directive('myDate',function(){
    return{
      restirct:'AE',
      transclude: true,
      scope: true,
      replace:true,
      priority:1,
      scope: {
				value: '=ngModel',
				// type: '=type',
				 year: '=year',
				// rid: '=rid',


			},
      template:'<span><%name%></span>',
      link:function(scope,ele,attr) {
         // alert(attr.year);


          if (scope.year == undefined) {
             // alert(scope.year);
              scope.name = '---';
          } else {
              var status = scope.year;

              var year1 = status.split(" ")[0];
              year1 = year1.split("-");


              // alert(status.charAt(0));
              // alert(year1);

              scope.name = year1[1] + "." + year1[2] + "." + year1[0];
          }
      }

      }

    })

/*

masterApp.controller('ForgetpassCtrl', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {

//==================================== To send password =========================================
    $scope.passwordRequest = function(user_form) {

        if(user_form.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        }else{
                 
                  //  return true;
                }
    }

         $scope.getlogo = function(){//alert();

                    $http
                    .get(appurl + 'user/logo')
                    .success(function(data, status, headers, config) {
                      
                         $scope.logo=data[0].logo_image;
                          alert(JSON.stringify($scope.logo));
                    });
          };

           $scope.getlogo();
   
}])*/


masterApp.controller('ResetpassCtrl', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {



//==================================== Reset Form validation =========================================
    $scope.resetpassword = function(user_form) {//alert();

        if(user_form.$invalid) {
           
            $scope.invalidSubmitAttempt = true;
            return;
        }else{
                    return true;
                }
    }





            /* $scope.getlogo = function(){

                    $http
                    .get(appurl + 'user/logo')
                    .success(function(data, status, headers, config) {
                      
                         $scope.logo=data[0].logo_image;
                      //    alert(JSON.stringify($scope.logo));
                    });
          };

           $scope.getlogo();*/
   
}])



masterApp.directive("select2", function($timeout, $parse) {
    return {
        restrict: 'A',
        require: 'ngModel',
        allowClear: true,
        scope: {
            'selectWidth': '@',
            'ngModel': '='
        },
        link: function(scope, element, attrs) {
            console.log(attrs);
            $timeout(function() {
                element.select2();
                element.select2Initialized = true;
            });

            var refreshSelect = function() {
                if (!element.select2Initialized) return;
                $timeout(function() {
                    element.trigger('change');
                });
            };

            var recreateSelect = function () {
                if (!element.select2Initialized) return;
                $timeout(function() {
                    element.select2('destroy');
                    element.select2();
                });
            };

            scope.$watch(attrs.ngModel, refreshSelect);

            if (attrs.ngOptions) {
                var list = attrs.ngOptions.match(/ in ([^ ]*)/)[1];
                // watch for option list change
                scope.$watch(list, recreateSelect);
            }

            if (attrs.ngDisabled) {
                scope.$watch(attrs.ngDisabled, refreshSelect);
            }
        }
    };
});

//==================================Change request controller=========================================
masterApp.controller('changereqCtrl',function($scope,$http,$location) {

    $scope.isDisabled = false;

                   $http
                    .get(appurl + 'changes/change_stage')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changestage=data;
                                                  

                    });

                    $http
                        .get(appurl + 'changes/get_hod_by_user_dep')
                        .success(function(data, status, headers, config) {

                            $scope.hod=data[0];


                        });



                    $http
                    .get(appurl + 'changes/customers')
                    .success(function(data, status, headers, config) {
                      
                         $scope.customers=data;

                    });


                 $scope.getfunction = function(){

                    $http
                    .get(appurl + 'changes/department')
                    .success(function(data, status, headers, config) {
                      
                         $scope.departments=data;
                       //  alert(JSON.stringify($scope.departments));
                         angular.copy($scope.departments, $scope.copy);                             

                    });
                     };
                    // var id="2"//Hod department Id

                      $http
                    .get(appurl + 'changes/getdepartment/4')
                    .success(function(data, status, headers, config) {
                      
                         $scope.hoddepartments=data;

                                                   

                    });

                    $http
                    .get(appurl + 'changes/getchangetype')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changetype=data;
                       });
                    //For Dynamic Change Type
                    $scope.fill_customer_name = function(id){ 

						   
                   
                          if(id=="3"){
                          
                           $scope.hideoption='hide';
                           

                         }else
                         {

                          $scope.hideoption='show';
                         }

                                                   

                     };

                      $scope.fill_sub_department = function(d_id){
                        if (d_id !== '') {
                    $http
                    .get(appurl + 'changerequest/changes/'+ d_id)
                    .success(function(data, status, headers, config) {                     
                        
                         if(data.length){
							 
                                $scope.sub_dep=true;
                                $scope.sub_departments=data;
                          

                         }else{						
                                $scope.sub_dep=false;
                          
                         }
                    });
                  }
                     };

                    //  To fetch plancode data

                    $http
                    .get(appurl + 'changes/plantcode')
                    .success(function(data, status, headers, config) {
                      
                         $scope.plantcodes=data;
                         //alert(JSON.stringify($scope.plantcodes));
                                                   

                    });

        $http
            .get(appurl + 'changes/parts_list')
            .success(function(data, status, headers, config) {

                $scope.parts=data;
                //alert(JSON.stringify($scope.plantcodes));


            });

                     //  To fetch Changepurpose data
                      

                    $http
                    .get(appurl + 'changes/purposechange')
                    .success(function(data, status, headers, config) {
                      
                         $scope.purposechange=data;
                       //  alert(JSON.stringify($scope.purposechange));
                                                   

                    });
                  



                     $scope.getfunction(); //function calls on-page load
                     // $scope.getfunction1(); //function calls on-page load


    $scope.array = [];
    $scope.array_ = angular.copy($scope.array);
   

    $scope.update = function () {
        if ($scope.array.toString() !== $scope.array_.toString()) {
            return "Changed";
        } else {
            return "Not Changed";
        }
    };
     $scope.selection=[];
     $scope.selection1=[];
   
    // toggle selection for a given employee by name
    $scope.toggleSelection = function toggleSelection(employeeName,id) {
      var idx = $scope.selection.indexOf(employeeName);
       var idx1 = $scope.selection.indexOf(id);


      // is currently selected
      if (idx > -1) {
        $scope.selection.splice(idx, 1);
        $scope.selection1.splice(idx1, 1);
      }
      // is newly selected
      else {
        //$scope.selection.push(employeeName);
         $scope.selection.splice(0, 0, employeeName);
         $scope.selection1.splice(0, 0, id);
      }
    };
//====================================================================

    

    //================================================================//

$scope.reset=function(){
                    $scope.progress=false;
                    $scope.purpose1_selection='';
                    $scope.selection='';
                    $scope.request = '';
                    $scope.fields = '';
                
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();
                    $scope.submitted= false;

}

    /* Dynamic fiels for adding services */
    $scope.fields = [{ extNumber: '', extName: ''}];

    $scope.add = function () {
        $scope.fields.push({extNumber: "", extName: ""});
        console.log($scope.fields);
    };
    $scope.remove = function (index) {
        $scope.fields.splice(index,1);
        console.log($scope.fields);
    };
        
          
 $scope.addRequest = function(requestForm,type,customer_id,customer_id1,change_type) {

    // alert(customer_id);

     $scope.submitted= true;
      if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;


     /*else if(customer_id==undefined || customer_id==undefined) {//alert("inside");

          if(customer_id!='' || customer_id1!=''){//alert("in first");

              alert("Please Select Customer Name");

              return false;
          }*/
              /*else if(customer_id1!='' && change_type!="3"){

              alert("Please Select Customer Name");

              return false;
          }*/


   /*  }if(customer_id1==undefined) {//alert("inside");

         if(customer_id1!='' && customer_id==undefined){alert("in second");

             alert("Please Select Customer Name");

             return false;
         }else{


         }*/


      }else {$scope.isDisabled = true;
            if($scope.request.changeType=="3"){

                $scope.request.multi_user=$scope.request.customer_id;


            }else
            {

                $scope.request.multi_user=$scope.request.customer_id1;
            }


            $scope.request.multi_part=$scope.fields;
          $scope.request.multi_purpose=$scope.request.changerequest_purpose;

            $scope.request.Approval_Authority=$('#Approval_Authority').val();
            $scope.request.dt=$('#startdate_status').val();

            var data={};
            $scope.request.type=type;
            data = $scope.request;

           // alert(JSON.stringify(data));exit;

            $http
                    .post(appurl + 'changes/addrequest', data)
                    .success(function(data, status, headers, config) {

                   // $.simplyToast('Your Change Request is submited successfully.', 'success');
                     
                    $scope.progress=false;
                    $scope.submitted= false;
		            $scope.request = '';
                    $scope.fields = '';
                    $scope.purpose1_selection='';
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();

                    $scope.isDisabled = true;




                    location.href = appurl + 'dashboard';


            }).error(function(data, status, headers, config) {
            });
        }
    };

     $scope.addRequest1 = function(requestForm,type) {

        $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {
          $scope.progress=true;
      
          $scope.request.multi_part=$scope.fields;
         
          $scope.request.multi_purpose=$scope.purpose1_selection1;
         if($scope.selection1!=""){
            $scope.request.multi_user=$scope.selection1;
          }else{
          $scope.request.multi_user=$scope.request.customer_id1;

          }
    
            var data={};
            $scope.request.type=type;
            data = $scope.request;
           

            $http
                    .post(appurl + 'changes/addrequest', data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Your Change Request is Drafted successfully.', 'success');

                    
                    $scope.progress=false;
                

                    $scope.request = '';
                    $scope.fields = '';
                
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();
                    $scope.submitted= false;
                        location.href = appurl + 'dashboard';



            }).error(function(data, status, headers, config) {
            });
        }
    };


   
})
/*masterApp.directive('dropdownMultiselect', function () {
    return {
        restrict: 'E',
        scope: {
            model: '=',
            options: '=',
            pre_selected: '=preSelected',
            dropdownTitle: '@'
        },
        template: "<div class='btn-group' data-ng-class='{open: open}'>" +
        "<button class='btn btn-small'><%dropdownTitle%></button>" +
        "<button class='btn btn-small dropdown-toggle' data-ng-click='open=!open;openDropDown()'><span class='caret'></span></button>" +
        "<ul class='dropdown-menu scrollable-menu' aria-labelledby='dropdownMenu'>" +
        "<li><input type='checkbox' data-ng-change='checkAllClicked()' data-ng-model=checkAll> Check All</li>" +
        "<li class='divider'></li>" +
        "<li data-ng-repeat='option in options'> <input type='checkbox' data-ng-change='setSelectedItem(option.id)' ng-model='selectedItems[option.id]'><%option.changerequest_purpose%></li>" +
        "</ul>" +
        "</div>",
        controller: function ($scope) {
            $scope.selectedItems = {};
            $scope.checkAll = false;

            init();

            function init() {alert(JSON.stringify($scope.pre_selected));
                console.log('init function');
                for (var i = 0; i < $scope.pre_selected.length; i++) {
                    $scope.model.push($scope.pre_selected[i].id);
                    $scope.selectedItems[$scope.pre_selected[i].id] = true;
                }
                if ($scope.pre_selected.length == $scope.options.length) {
                    $scope.checkAll = true;
                }
            }

            $scope.openDropDown = function () {
                console.log('hi');
            }

            $scope.checkAllClicked = function () {
                if ($scope.checkAll) {
                    selectAll();
                } else {
                    deselectAll();
                }
            }

            function selectAll() {
                $scope.model = [];
                $scope.selectedItems = {};
                angular.forEach($scope.options, function (option) {
                    $scope.model.push(option.id);
                });
                angular.forEach($scope.model, function (id) {
                    $scope.selectedItems[id] = true;
                });
                console.log($scope.model);
            };

            function deselectAll() {
                $scope.model = [];
                $scope.selectedItems = {};
                console.log($scope.model);
            };

            $scope.setSelectedItem = function (id) {
                var filteredArray = [];
                if ($scope.selectedItems[id] == true) {
                    $scope.model.push(id);
                } else {
                    filteredArray = $scope.model.filter(function (value) {
                        return value != id;
                    });
                    $scope.model = filteredArray;
                    $scope.checkAll = false;
                }
                console.log(filteredArray);
                return false;
            };
        }
    }
});*/
/*
masterApp.directive('dropdownMultiselect', function(){
    return {
        restrict: 'E',
        scope:{
            model: '=',
            options: '=',
            pre_selected: '=preSelected'
        },
        template: "<div class='btn-group' data-ng-class='{open: open}'>"+
        "<button class='btn btn-small'>Select</button>"+
        "<button class='btn btn-small dropdown-toggle' data-ng-click='open=!open;openDropdown()'><span class='caret'></span></button>"+
        "<ul class='dropdown-menu' aria-labelledby='dropdownMenu'>" +
        "<li><a data-ng-click='selectAll()'><i class='icon-ok-sign'></i>  Check All</a></li>" +
        "<li><a data-ng-click='deselectAll();'><i class='icon-remove-sign'></i>  Uncheck All</a></li>" +
        "<li class='divider'></li>" +
        "<li data-ng-repeat='option in options'> <a data-ng-click='setSelectedItem()'><%option.name%><span data-ng-class='isChecked(option.id)'></span></a></li>" +
        "</ul>" +
        "</div>" ,
        controller: function($scope){

            $scope.openDropdown = function(){
                $scope.selected_items = [];
                for(var i=0; i<$scope.pre_selected.length; i++){
                 $scope.selected_items.push($scope.pre_selected[i].id);
                }
            };

            $scope.selectAll = function () {
                $scope.model = _.pluck($scope.options, 'id');
                console.log($scope.model);
            };
            $scope.deselectAll = function() {
                $scope.model=[];
                console.log($scope.model);
            };
            $scope.setSelectedItem = function(){
                var id = this.option.id;
                if (_.contains($scope.model, id)) {
                    $scope.model = _.without($scope.model, id);
                } else {
                    $scope.model.push(id);
                }
                console.log($scope.model);
                return false;
            };
            $scope.isChecked = function (id) {
                if (_.contains($scope.model, id)) {
                    return 'icon-ok pull-right';
                }
                return false;
            };
        }
    }
});*/
masterApp.directive('dropdownMultiselect', function () {
    return {
        restrict: 'E',
        scope: {
            model: '=',
            options: '=',
        },
        template:"<div class='' data-ng-class='{open: open}'>" +
        "<button class='btn btn-small'>Select...</button>" +
        "<button class='btn btn-small dropdown-toggle'data-ng-click='openDropdown()'><span class='caret'></span></button>" +
        "<ul class='dropdown-menu' aria-labelledby='dropdownMenu'>" +

        "<li data-ng-repeat='option in options'><a data-ng-click='toggleSelectItem(option)'> <span data-ng-class='getClassName(option)'aria-hidden='true'></span> <%option.changerequest_purpose%></a></li>" +
        "</ul>" +
        "</div>",

        controller: function ($scope) {
            $scope.openDropdown = function () {
                $scope.open = !$scope.open;
            };

            $scope.selectAll = function () {
                $scope.model = [];
                angular.forEach($scope.options, function (item, index) {
                    $scope.model.push(item.id);
                });
            };

            $scope.deselectAll = function () {
                $scope.model = [];
            };

            $scope.toggleSelectItem = function (option) {//alert(JSON.stringify(option.id));
                var intIndex = -1;

                angular.forEach($scope.model, function (item, index) {
                    if (item == option.id) {
                        intIndex = index;
                    }
                });

                if (intIndex >= 0) {
                    $scope.model.splice(intIndex, 1);
                }
                else {
                    $scope.model.push(option.id);
                }
            };

            $scope.getClassName = function (option) {
                var varClassName = 'glyphicon glyphicon-remove red';
                angular.forEach($scope.model, function (item, index) {
                    if (item == option.id) {
                        varClassName = 'glyphicon glyphicon-ok green';
                    }
                });
                return (varClassName);
            };
        }
    }
});

masterApp.directive('dropdownMultiselected', function () {
    return {
        restrict: 'E',
        scope: {
            model: '=',
            options: '=',
        },
        template:"<div class='' data-ng-class='{open: open}'>" +
        "<button class='btn btn-small'>Select...</button>" +
        "<button class='btn btn-small dropdown-toggle'data-ng-click='openDropdown()'><span class='caret'></span></button>" +
    "<ul class='dropdown-menu' aria-labelledby='dropdownMenu'>" +

    "<li data-ng-repeat='option in options'><a data-ng-click='toggleSelectItem(option)'> <span data-ng-class='getClassName(option)'aria-hidden='true'></span><%option.FirstName%> <%option.LastName%></a></li>" +
    "</ul>" +
    "</div>",

        controller: function ($scope) {
            $scope.openDropdown = function () {
                $scope.open = !$scope.open;
            };

            $scope.selectAll = function () {
                $scope.model = [];
                angular.forEach($scope.options, function (item, index) {
                    $scope.model.push(item.CustomerId);
                });
            };

            $scope.deselectAll = function () {
                $scope.model = [];
            };

            $scope.toggleSelectItem = function (option) {
                var intIndex = -1;

                angular.forEach($scope.model, function (item, index) {
                    if (item == option.CustomerId) {
                        intIndex = index;
                    }
                });

                if (intIndex >= 0) {
                    $scope.model.splice(intIndex, 1);
                }
                else {
                    $scope.model.push(option.CustomerId);
                }
            };

            $scope.getClassName = function (option) {//alert(JSON.stringify($scope.model));
                var varClassName = 'glyphicon glyphicon-remove red';
                angular.forEach($scope.model, function (item, index) {
                    if (item == option.CustomerId) {
                        varClassName = 'glyphicon glyphicon-ok green';
                    }
                });
                return (varClassName);
            };
        }
    }
});
masterApp.directive('dropdownMultiselects', function(){
    return {
        restrict: 'E',
        require: 'ngModel',
        scope:{
            model: '=',
            options: '=',
         //   inputRequired: '=',
            pre_selected: '=preSelected'
        },

        template: "<div class='' data-ng-class='{open: open}'>"+

        "<button class='btn btn-small dropdown-toggle btn_select' data-ng-click='open=!open;openDropdown()'>Select Customer Name  <span class='caret'></span></button>"+
        "<ul class='dropdown-menu select_ul' aria-labelledby='dropdownMenu'>" +

        "<li data-ng-repeat='option in options'> <a data-ng-click='setSelectedItem()'><%option.FirstName%> <%option.LastName%> <span data-ng-class='isChecked(option.CustomerId)'></span></a></li>" +
        "</ul>" +

        "</div>" ,
        controller: function($scope){

            $scope.openDropdown = function(){//alert(JSON.stringify($scope.model));
                $scope.selected_items = [];
                for(var i=0; i<$scope.pre_selected.length; i++){
                    $scope.selected_items.push($scope.pre_selected[i].id);
                }
            };

            $scope.selectAll = function () {
                $scope.model = _.pluck($scope.options, 'CustomerId');
                console.log($scope.model);
            };
            $scope.deselectAll = function() {
                $scope.model=[];
                console.log($scope.model);
            };
            $scope.setSelectedItem = function(){
                var id = this.option.CustomerId;
                if (_.contains($scope.model, id)) {
                    $scope.model = _.without($scope.model, id);
                } else {
                    $scope.model.push(id);
                }
                console.log($scope.model);
                return false;
            };
            $scope.isChecked = function (id) {
                if (_.contains($scope.model, id)) {
                    return 'glyphicon glyphicon-ok green';
                }
                return false;
            };
        }
    }
});

masterApp.directive('dropdownMultiselecte', function(){
    return {
        restrict: 'E',
        scope:{
            model: '=',
            options: '=',
            pre_selected: '=preSelected'
        },
        template: "<div class='' data-ng-class='{open: open}'>"+

        "<button class='btn btn-small dropdown-toggle btn_select' data-ng-click='open=!open;openDropdown()'>Select Purpose of Change  <span class='caret'></span></button>"+
        "<ul class='dropdown-menu select_ul' aria-labelledby='dropdownMenu'>" +

        "<li data-ng-repeat='option in options'> <a data-ng-click='setSelectedItem()'><%option.changerequest_purpose%> <span data-ng-class='isChecked(option.id)'></span></a></li>" +
        "</ul>" +
        "</div>" ,
        controller: function($scope){

            $scope.openDropdown = function(){//alert(JSON.stringify($scope.model));
                $scope.selected_items = [];
                for(var i=0; i<$scope.pre_selected.length; i++){
                    $scope.selected_items.push($scope.pre_selected[i].id);
                }
            };

            $scope.selectAll = function () {
                $scope.model = _.pluck($scope.options, 'id');
                console.log($scope.model);
            };
            $scope.deselectAll = function() {
                $scope.model=[];
                console.log($scope.model);
            };
            $scope.setSelectedItem = function(){
                var id = this.option.id;
                if (_.contains($scope.model, id)) {
                    $scope.model = _.without($scope.model, id);
                } else {
                    $scope.model.push(id);
                }
                console.log($scope.model);
                return false;
            };
            $scope.isChecked = function (id) {
                if (_.contains($scope.model, id)) {
                    return 'glyphicon glyphicon-ok green';
                }
                return false;
            };
        }
    }
});

masterApp.controller('EditchangereqCtrl', function ($scope,$http,$location) {

    $scope.addRequest_fdraft = function(requestForm,type,request_id,id) {

        $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {$scope.isDisabled = true;

            if($scope.request.changeType=="3"){

                $scope.request.multi_user=$scope.request.customers_id_single;


            }else
            {

                $scope.request.multi_user=$scope.request.selected_items;
            }
            $scope.request.multi_part=$scope.request_part;

            $scope.request.multi_purpose=$scope.request.selected_items_for_purpose;

            $scope.request.Approval_Authority=$('#Approval_Authority').val();

            if(id==''){

              var temp_id=1;

            }else{

                var temp_id=id;

            }

            var data={};
            $scope.request.type=type;
            data = $scope.request;


          /*  alert();exit;
            $scope.progress=true;

            $scope.request.multi_part=$scope.fields;
            if($scope.selection1!=""){
                $scope.request.multi_user=$scope.selection1;
            }else{
                $scope.request.multi_user=$scope.request.customer_id1;

            }

            var data={};
            $scope.request.type=type;
            data = $scope.request;*/


            $http
                .post(appurl + 'changes/submitrequest/'+request_id+'/'+temp_id+'/'+type, data)
                .success(function(data, status, headers, config) {
                    $scope.progress=false;
                    $scope.submitted= false;
                    $scope.request = '';
                    $scope.fields = '';
                    $scope.purpose1_selection='';
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();






                    location.href = appurl + 'dashboard';


                }).error(function(data, status, headers, config) {
            });
        }
    };

    $scope.EditRequest = function(requestForm,id,type) {

       // var type=5;
        $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {//alert(JSON.stringify($scope.request.customers_id_single));exit;

            if($scope.request.changeType=="3"){

                $scope.request.multi_user=$scope.request.customers_id_single;
               // alert($scope.request.multi_user);exit;


            }else
            {

                $scope.request.multi_user=$scope.request.selected_items;
            }
            $scope.request.multi_part=$scope.request_part;

            $scope.request.multi_purpose=$scope.request.selected_items_for_purpose;

            $scope.request.Approval_Authority=$('#Approval_Authority').val();



            var data={};
            $scope.request.type=type;
            data = $scope.request;

            $http
                .post(appurl + 'changes/updaterequest/'+id, data)
                .success(function(data, status, headers, config) {

                    location.href = appurl + 'dashboard';

                }).error(function(data, status, headers, config) {
            });
        }

    };


    $http
        .get(appurl + 'changes/change_stage')
        .success(function(data, status, headers, config) {

            $scope.changestage=data;


        });

    $http
        .get(appurl + 'changes/get_hod_by_user_dep')
        .success(function(data, status, headers, config) {

            $scope.hod=data[0];


        });



    $http
        .get(appurl + 'changes/customers_for_edit')
        .success(function(data, status, headers, config) {

            $scope.customers=data;
          //  alert(JSON.stringify($scope.allStates));

        });


    $scope.getfunction = function(){

        $http
            .get(appurl + 'changes/department')
            .success(function(data, status, headers, config) {

                $scope.departments=data;
                //  alert(JSON.stringify($scope.departments));
                angular.copy($scope.departments, $scope.copy);

            });
    };
    // var id="2"//Hod department Id

    $http
        .get(appurl + 'changes/getdepartment/4')
        .success(function(data, status, headers, config) {

            $scope.hoddepartments=data;



        });

    $http
        .get(appurl + 'changes/getchangetype')
        .success(function(data, status, headers, config) {

            $scope.changetype=data;
        });
    //For Dynamic Change Type
    $scope.fill_customer_name = function(id){



        if(id=="3"){

            $scope.hideoption='hide';


        }else
        {

            $scope.hideoption='show';
        }



    };

    $scope.fill_sub_department = function(d_id){
        if (d_id !== '') {
            $http
                .get(appurl + 'changerequest/changes/'+ d_id)
                .success(function(data, status, headers, config) {

                    if(data.length){

                        $scope.sub_dep=true;
                        $scope.sub_departments=data;


                    }else{
                        $scope.sub_dep=false;

                    }
                });
        }
    };

    //  To fetch plancode data

    $http
        .get(appurl + 'changes/plantcode')
        .success(function(data, status, headers, config) {

            $scope.plantcodes=data;
            //alert(JSON.stringify($scope.plantcodes));


        });

    $http
        .get(appurl + 'changes/parts_list')
        .success(function(data, status, headers, config) {

            $scope.parts=data;
            //alert(JSON.stringify($scope.plantcodes));


        });

    //  To fetch Changepurpose data



    $scope.getfunction(); //function calls on-page load
    // $scope.getfunction1(); //function calls on-page load


    $scope.array = [];
    $scope.array_ = angular.copy($scope.array);


    $scope.update = function () {
        if ($scope.array.toString() !== $scope.array_.toString()) {
            return "Changed";
        } else {
            return "Not Changed";
        }
    };
    $scope.clear = function () {//alert();
        $scope.selection=[];
        //$scope.selection1=[];

    };

    $scope.toggleSelection = function toggleSelection(employeeName,id) {


        var idx = $scope.selection.indexOf(employeeName);
        var idx1 = $scope.selection.indexOf(id);


        // is currently selected
        if (idx > -1) {
            $scope.selection.splice(idx, 1);
            $scope.selection1.splice(idx1, 1);
            $scope.sc="checked";
        }
        // is newly selected
        else {
            //$scope.selection.push(employeeName);
            $scope.selection.splice(0, 0, employeeName);
            $scope.selection1.splice(0, 0, id);
        }
    };
//====================================================================



    //================================================================//

    $scope.reset=function(){
        $scope.progress=false;
        $scope.purpose1_selection='';
        $scope.selection='';
        $scope.request = '';
        $scope.fields = '';

        $scope.requestForm.$setPristine();
        $scope.requestForm.$setUntouched();
        $scope.submitted= false;

    }

    $scope.request_part = [];

    $scope.add = function () {
        $scope.request_part.push({extNumber: "", extName: ""});
        console.log($scope.request_part);
    };
    $scope.remove = function (index,id) {

        $http
            .post(appurl + 'changes/delete_parts_change_request/'+id)
            .success(function(data, status, headers, config) {
                // $scope.request=data[0];

                $scope.request_part.splice(index,1);
                console.log($scope.request_part);


            })

    };


    $http
        .get(appurl + 'changes/purposechange_for_edit')
        .success(function(data, status, headers, config) {

            $scope.states=data;



        });


    $scope.editrequestinfo=function(id){//alert("first");

        $http
            .get(appurl + 'changes/get_edit_change_request_parts/'+id)
            .success(function(data, status, headers, config) {
                $scope.request_part=data;

            });


        var id1='1';
        $http
            .get(appurl + 'changes/get_edit_change_request/'+id+'/'+id1)
            .success(function(data, status, headers, config) {

                $scope.request=data;
                //$scope.requests="7,9";
                $scope.member='';
                $scope.members='';

                



                $scope.result = data.customers_id;
                $scope.request.selected_items=$scope.result;

                //$scope.selectedStates=$scope.request.selected_items;

               // alert($scope.selectedStates);

                $scope.result1=data.change_purpose;
                $scope.request.selected_items_for_purpose=$scope.result1;

                $scope.fill_sub_department(data.dep_id);
                $scope.fill_customer_name(data.changeType);





            })


    };


 
});





/* Date picker controller */
masterApp.controller("datePicker", function ($scope) {

  var currentTime = new Date();
  $scope.currentTime = currentTime;
  $scope.month = ['Januar', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  $scope.monthShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  $scope.weekdaysFull = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  $scope.weekdaysLetter = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
  $scope.disable = [false, 1, 7];
  $scope.today = 'Today';
  $scope.clear = 'Clear';
  $scope.close = 'Close';
  var days = 15;
  $scope.minDate = (new Date($scope.currentTime.getTime() - ( 1000 * 60 * 60 *24 * days ))).toISOString();
  $scope.maxDate = (new Date($scope.currentTime.getTime() + ( 1000 * 60 * 60 *24 * days ))).toISOString();
  $scope.onStart = function () {
      console.log('onStart');
  };
  $scope.onRender = function () {
      console.log('onRender');
  };
  $scope.onOpen = function () {
      console.log('onOpen');
  };
  $scope.onClose = function () {
      console.log('onClose');
  };
  $scope.onSet = function () {
      console.log('onSet');
  };
  $scope.onStop = function () {
      console.log('onStop');
  };

});

/* multi select dropdown box */
masterApp.controller('homeCtrl', function ($scope) {
    $scope.array = [1, 5];
    $scope.array_ = angular.copy($scope.array);
    $scope.list = [{
        "id": 1,
            "value": "apple",
    }, {
        "id": 3,
            "value": "orange",
    }, {
        "id": 5,
            "value": "pear"
    }];

    $scope.update = function () {
        if ($scope.array.toString() !== $scope.array_.toString()) {
            return "Changed";
        } else {
            return "Not Changed";
        }
    };

})
//==================================== Advance Search controller =========================================  
masterApp.controller('AdvancedsearchCtrl', ['$scope', '$http','$location','$window','$compile',
    function($scope,$http,$location,$window,$compile) {

        $scope.summery=false;
        $scope.search_summery=true;

                   $http
                    .get(appurl + 'changes/change_stage')
                    .success(function(data, status, headers, config) {

                         $scope.changestage=data;


                    });


                      $http
                    .get(appurl + 'changes/customers')
                    .success(function(data, status, headers, config) {

                         $scope.customers=data;

                    });

                $http
                    .get(appurl + 'changes/getchangetype')
                    .success(function(data, status, headers, config) {

                         $scope.changetype=data;
                       });


                      $http
                    .get(appurl + 'changes/purposechange')
                    .success(function(data, status, headers, config) {

                         $scope.purposechange=data;
                       //  alert(JSON.stringify($scope.purposechange));


                    });

        $http
            .get(appurl + 'changes/plantcode')
            .success(function(data, status, headers, config) {

                $scope.plantcodes=data;

            });


    $scope.dosearch = function(requestForm,search) {
        var startDate = Date.parse($scope.search.startdate);
        var endDate = Date.parse($scope.search.enddate);
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            if (startDate > endDate) {
                //  $scope.search.startdate.$setValidity('valid',false);
                $scope.requestForm.startdate.$setValidity('valid', false);

                return;
            }else{

                $scope.requestForm.startdate.$setValidity('valid', true);
            }
            return;
        } else {

      if (startDate > endDate) {
      //  $scope.search.startdate.$setValidity('valid',false);
      $scope.requestForm.startdate.$setValidity('valid', false);

        return;
      }
  /*    if (endDate<startDate) {
      //  $scope.search.startdate.$setValidity('valid',false);
      $scope.requestForm.enddate.$setValidity('valid', false);
        return;
      }
     */    //   return ;

            var data={};
            data = $scope.search;


            $http
                    .post(appurl + 'advance-search', data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Your Search Records.', 'success');


                    $scope.progress=false;
                  //  $scope.fields = '';
                   //     $scope.search = '';
                   // $scope.requestForm.$setPristine();
                  //  $scope.requestForm.$setUntouched();
                  //  $scope.submitted= false;


                   // $scope.summery=true ;
                    $scope.search_summery=false;
                      //  $("#summarysheet").html(data);

                     $scope.summeries=data;

                    $scope.summery=true ;
                    $scope.search_summery=false;
                    $scope.summeries=data;



            }).error(function(data, status, headers, config) {
            });
        }
    };








        $scope.backToSearch=function(){

                $scope.summery=false;
                $scope.search_summery=true;
                $scope.selection=[];
                $scope.selection1=[];
                $scope.ChangeStageselection=[];
                $scope.ChangeStageselection1=[];
                $scope.ChangeTypeselection=[];
                $scope.ChangeTypeselection1=[];
                $scope.purpose1_selection=[];
                $scope.purpose1_selection1=[];
                $scope.plantcode_selection=[];
                $scope.plantcode_selection1=[];
        }

}])


masterApp.controller('AdvancedsearchCtrl_bkp', ['$scope', '$http','$location','$window','$compile',
    function($scope,$http,$location,$window,$compile) {

        $scope.summery=false;
        $scope.search_summery=true;

        $http
            .get(appurl + 'changes/change_stage')
            .success(function(data, status, headers, config) {

                $scope.changestage=data;


            });


        $http
            .get(appurl + 'changes/customers')
            .success(function(data, status, headers, config) {

                $scope.customers=data;

            });

        $http
            .get(appurl + 'changes/getchangetype')
            .success(function(data, status, headers, config) {

                $scope.changetype=data;
            });


        $http
            .get(appurl + 'changes/purposechange')
            .success(function(data, status, headers, config) {

                $scope.purposechange=data;
                //  alert(JSON.stringify($scope.purposechange));


            });

        $http
            .get(appurl + 'changes/plantcode')
            .success(function(data, status, headers, config) {

                $scope.plantcodes=data;

            });





        $scope.dosearch = function(requestForm,search) {
            // $scope.submitted= true;
            if (requestForm.$invalid) {
                $scope.invalidSubmitAttempt = true;
                return;
            } else {
                var startDate = Date.parse($scope.search.startdate);
                var endDate = Date.parse($scope.search.enddate);
                if (startDate > endDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.startdate.$setValidity('valid', false);
                    return;
                }
                if (endDate<startDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.enddate.$setValidity('valid', false);
                    return;
                }

                var data={};
                data = $scope.search;


                $http
                    .post(appurl + 'advance-search', data)
                    .success(function(data, status, headers, config) {

                        $.simplyToast('Your Search Records.', 'success');


                        $scope.progress=false;
                        //  $scope.fields = '';
                        //     $scope.search = '';
                        // $scope.requestForm.$setPristine();
                        //  $scope.requestForm.$setUntouched();
                        //  $scope.submitted= false;


                        // $scope.summery=true ;
                        $scope.search_summery=false;
                        //  $("#summarysheet").html(data);

                        $scope.summeries=data;

                        $scope.summery=true ;
                        $scope.search_summery=false;
                        $scope.summeries=data;



                    }).error(function(data, status, headers, config) {
                });
            }
        };








        $scope.backToSearch=function(){

            $scope.summery=false;
            $scope.search_summery=true;
            $scope.selection=[];
            $scope.selection1=[];
            $scope.ChangeStageselection=[];
            $scope.ChangeStageselection1=[];
            $scope.ChangeTypeselection=[];
            $scope.ChangeTypeselection1=[];
            $scope.purpose1_selection=[];
            $scope.purpose1_selection1=[];
            $scope.plantcode_selection=[];
            $scope.plantcode_selection1=[];
        }

    }])

/* Manage All listing and pagination common function supported to all listing*/

masterApp.filter('startFrom', function () {
    return function (input, start) {
        if (input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

masterApp.controller('ScmaddCtrl',['$scope','$http',function($scope,$http){

    $scope.main_form=true;
    $scope.next_form=false;

    $http
        .get(appurl + 'scm/get_supplier_list')
        .success(function(data, status, headers, config) {
            $scope.suppliers=data;

        });
    $scope.next=function(id){

        location.href = appurl + 'scm/supplier/'+id;

        $scope.main_form=false;
        $scope.next_form=true;

    }

    $scope.add = function(requestForm) {

        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

        }
    }
}])


masterApp.controller('AssignedTaskToMeCtrl',['$scope','$http','$uibModal', '$log',function($scope,$http, $uibModal, $log){
          
   

                    $http
                    .get(appurl + 'changes/assigned_task_to_me')
                    .success(function(data, status, headers, config) {                      
                       $scope.assignedtaskstome=data;
                        

                      
  
  /*  Pagination Code */
    $scope.currentPage = 1;
    $scope.entryLimit = 5;
  //  $scope.total = 100;
    $scope.filteredItems = $scope.assignedtaskstome.length; //Initially for no filter  
    $scope.totalItems = $scope.assignedtaskstome.length;
})



    $scope.range = function(min, max, step){
      step = step || 1;
      var input = [];
      for (var i = min; i <= max; i += step) input.push(i);
      return input;
    };
    $scope.prevPage = function (){

      if($scope.currentPage > 1){
        $scope.currentPage--;
      }
    };
    $scope.nextPage = function (){
      if($scope.currentPage < $scope.pageCount()){
        $scope.currentPage++;
      }
    };
    $scope.pageCount = function (){
      return Math.ceil($scope.filteredItems / $scope.entryLimit);
    };
    $scope.setPage = function (n){
      if(n >= 0 && n <= $scope.pageCount()){
        $scope.currentPage = parseInt(n, 10);
      }
    };
     $scope.filter = function () {
        $timeout(function () {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function (predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
     $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };



     /*  $interval(function(){
                      $scope.getfunction();
                        },15000);
                        */


    $scope.open = function (size,users) {

        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            size: size,
            resolve: {
                users: function () {
                    return users;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };
        
}])

masterApp.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance,users) {
    // alert(name);

    $scope.users = users;




    $scope.ok = function () {
     //   $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

masterApp.controller('SavedCrByMeCtrl',['$scope','$http','$interval',function($scope,$http,$interval){
     
          $scope.getfunction = function(){

                    $http
                    .get(appurl + 'changes/saved_cr_by_me')
                    .success(function(data, status, headers, config) {                      
                       $scope.assignedtaskstome=data;
                       //  alert(JSON.stringify(data));

                      
  
  /*  Pagination Code */
    $scope.currentPage = 1;
    $scope.entryLimit = 5;
  //  $scope.total = 100;
    $scope.filteredItems = $scope.assignedtaskstome.length; //Initially for no filter  
    $scope.totalItems = $scope.assignedtaskstome.length;
})
    $scope.range = function(min, max, step){
      step = step || 1;
      var input = [];
      for (var i = min; i <= max; i += step) input.push(i);
      return input;
    };
    $scope.prevPage = function (){
      if($scope.currentPage > 1){
        $scope.currentPage--;
      }
    };
    $scope.nextPage = function (){
      if($scope.currentPage < $scope.pageCount()){
        $scope.currentPage++;
      }
    };
    $scope.pageCount = function (){
      return Math.ceil($scope.filteredItems / $scope.entryLimit);
    };
    $scope.setPage = function (n){
      if(n >= 0 && n <= $scope.pageCount()){
        $scope.currentPage = parseInt(n, 10);
      }
    };
     $scope.filter = function () {
        $timeout(function () {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function (predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
     $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };
 
      
      }               
       $scope.getfunction();
     /*  $interval(function(){
                      $scope.getfunction();
                        },15000);
                        */


    $scope.change_status=function(index,request_id){
        $http
            .get(appurl + 'change/change_request_status/'+request_id)
            .success(function(data, status, headers, config) {
                // $scope.members=data[0];

                $scope.assignedtaskstome.splice(0, 0, index);

            });

    }

}])


masterApp.controller('AssignedTaskByMeCtrl',['$scope','$http','$interval','$uibModal', '$log',function($scope,$http,$interval,$uibModal, $log){

    $scope.getfunction = function(){

        $http
            .get(appurl + 'changes/assigned_task_by_me')
            .success(function(data, status, headers, config) {
                $scope.assignedtaskstome=data;
                //  alert(JSON.stringify(data));



                /*  Pagination Code */
                $scope.currentPage = 1;
                $scope.entryLimit = 5;
                //  $scope.total = 100;
                $scope.filteredItems = $scope.assignedtaskstome.length; //Initially for no filter
                $scope.totalItems = $scope.assignedtaskstome.length;
            })
        $scope.range = function(min, max, step){
            step = step || 1;
            var input = [];
            for (var i = min; i <= max; i += step) input.push(i);
            return input;
        };
        $scope.prevPage = function (){
            if($scope.currentPage > 1){
                $scope.currentPage--;
            }
        };
        $scope.nextPage = function (){
            if($scope.currentPage < $scope.pageCount()){
                $scope.currentPage++;
            }
        };
        $scope.pageCount = function (){
            return Math.ceil($scope.filteredItems / $scope.entryLimit);
        };
        $scope.setPage = function (n){
            if(n >= 0 && n <= $scope.pageCount()){
                $scope.currentPage = parseInt(n, 10);
            }
        };
        $scope.filter = function () {
            $timeout(function () {
                $scope.filteredItems = $scope.filtered.length;
            }, 10);
        };
        $scope.sort_by = function (predicate) {
            $scope.predicate = predicate;
            $scope.reverse = !$scope.reverse;
        };
        $scope.setPage = function (pageNo) {
            $scope.currentPage = pageNo;
        };


    }
    $scope.getfunction();
    /*  $interval(function(){
     $scope.getfunction();
     },15000);
     */


    $scope.change_status=function(index,request_id){
        $http
            .get(appurl + 'change/change_request_status/'+request_id)
            .success(function(data, status, headers, config) {
                // $scope.members=data[0];

                $scope.assignedtaskstome.splice(0, 0, index);

            });

    }



    $scope.open = function (size,users) {

        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            size: size,
            resolve: {
                users: function () {
                    return users;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };


}])


masterApp.controller('AssignedTaskByMeCtrl',['$scope','$http','$interval','$uibModal', '$log',function($scope,$http,$interval,$uibModal, $log){

    $scope.getfunction = function(){

        $http
            .get(appurl + 'changes/assigned_task_by_me')
            .success(function(data, status, headers, config) {
                $scope.assignedtaskstome=data;
                //  alert(JSON.stringify(data));



                /*  Pagination Code */
                $scope.currentPage = 1;
                $scope.entryLimit = 5;
                //  $scope.total = 100;
                $scope.filteredItems = $scope.assignedtaskstome.length; //Initially for no filter
                $scope.totalItems = $scope.assignedtaskstome.length;
            })
        $scope.range = function(min, max, step){
            step = step || 1;
            var input = [];
            for (var i = min; i <= max; i += step) input.push(i);
            return input;
        };
        $scope.prevPage = function (){
            if($scope.currentPage > 1){
                $scope.currentPage--;
            }
        };
        $scope.nextPage = function (){
            if($scope.currentPage < $scope.pageCount()){
                $scope.currentPage++;
            }
        };
        $scope.pageCount = function (){
            return Math.ceil($scope.filteredItems / $scope.entryLimit);
        };
        $scope.setPage = function (n){
            if(n >= 0 && n <= $scope.pageCount()){
                $scope.currentPage = parseInt(n, 10);
            }
        };
        $scope.filter = function () {
            $timeout(function () {
                $scope.filteredItems = $scope.filtered.length;
            }, 10);
        };
        $scope.sort_by = function (predicate) {
            $scope.predicate = predicate;
            $scope.reverse = !$scope.reverse;
        };
        $scope.setPage = function (pageNo) {
            $scope.currentPage = pageNo;
        };


    }
    $scope.getfunction();
    /*  $interval(function(){
     $scope.getfunction();
     },15000);
     */


    $scope.change_status=function(index,request_id){
        $http
            .get(appurl + 'change/change_request_status/'+request_id)
            .success(function(data, status, headers, config) {
                // $scope.members=data[0];

                $scope.assignedtaskstome.splice(0, 0, index);

            });

    }


    $scope.open = function (size,users) {

        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            size: size,
            resolve: {
                users: function () {
                    return users;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };


}])


masterApp.controller('customerComDecisionCtrl',function($scope,$http){
    $scope.get_info=function(id){

        $scope.request={decision:1}

        $http
            .get(appurl + 'get_request_info_by_id_for_status/'+id)
            .success(function(data, status, headers, config) {
                $scope.status=data;


            });

        $http
            .get(appurl + 'get_request_info_by_id/'+id)
            .success(function(data, status, headers, config) {
                $scope.cmno=data;


            });


        $http
            .get(appurl + 'changes/department1/'+id)
            .success(function(data, status, headers, config) {

                $scope.availableOptions=data;
                // alert(JSON.stringify($scope.availableOptions));
                //customerComDecisionCtrl2

            });


    }
})

masterApp.controller('customerComDecisionCtrl1',function($scope,$http){

    $scope.customerslists=[];
    $scope.lists=[];
    $scope.visibleTable = true;



    $scope.get_cust_data=function(id){

        $http
            .get(appurl + 'changes/get_cust_data/'+id)
            .success(function(data, status, headers, config) {

                $scope.lists=data.list;

            });

        $http
            .get(appurl + 'changes/customers_comm/'+id)
            .success(function(data, status, headers, config) {

                $scope.customers=data;


            });

        $http
            .get(appurl + 'changes/department1/' + id)
            .success(function (data, status, headers, config) {

                $scope.availableOptions = data;

            });




    }

    $scope.AddRecord = function(requestList,request,id) {

        $scope.submitted = true;
        if (requestList.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {


            var data1 = {};
            data1 = $scope.request;


            $http
                .post(appurl + 'changes/save_customer_communication_list/' + id, data1)
                .success(function (data, status, headers, config) {


                    if(data==0) {

                        $.simplyToast('Customer Already Added to List.', 'warning');
                        $scope.request='';
                        //   $scope.search = angular.copy(oriPerson);
                        //    $scope.fields = '';
                        //   $scope.search = '';
                        $scope.requestList.$setPristine();
                        $scope.requestList.$setUntouched();
                        $scope.submitted= false;


                    }else{
                        $scope.get_cust_data(id);
                        $.simplyToast('Record Added Successfully.', 'success');
                        $scope.request='';
                        //   $scope.search = angular.copy(oriPerson);
                        //    $scope.fields = '';
                        //   $scope.search = '';
                        $scope.requestList.$setPristine();
                        $scope.requestList.$setUntouched();
                        $scope.submitted= false;

                    }



                }).error(function (data, status, headers, config) {
            });

        }
    }


    $scope.DelRecord = function(index,id,rid){

        $http
            .get(appurl + 'changes/delete_cust_list/'+id)
            .success(function(data, status, headers, config) {
                $scope.get_cust_data(rid);
            });
    }


})

masterApp.controller('customerComDecision',function($scope,$http) {


    $http
        .get(appurl + 'changes/getdepartment/' + 11)
        .success(function (data, status, headers, config) {
            // $scope.users=[];
            //  $scope.sub_departments=[];
            $scope.users = data;


        });


    $scope.users = [];
    $scope.sub_departments = [];
    // $scope.getfunction = function(){

    $http
        .get(appurl + 'changes/department_for_rp')
        .success(function (data, status, headers, config) {

            $scope.departments = data;
            //  alert(JSON.stringify($scope.departments));
            angular.copy($scope.departments, $scope.copy);

        });
    //  };

    $scope.fill_sub_department = function (id) {
        $http
            .get(appurl + 'changes/get_sub_department_and_user/' + id)
            .success(function (data, status, headers, config) {

                $scope.users = [];
                $scope.sub_departments = [];

                $scope.sub_departments = data.subdep;
                $scope.users = data.users;


            });


    };

    $scope.fill_user = function (id) {
        $http
            .get(appurl + 'changes/get_users_by_subdep/' + id)
            .success(function (data, status, headers, config) {
                $scope.users = [];
                //  $scope.sub_departments=[];
                $scope.users = data.users;


            });

    };
    $scope.isDisabled = false;
    $scope.addRequest = function (requestForm, id, id1) {
        //  $scope.isDisabled=true
        //  $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

            $http
                .get(appurl + 'changes/check_save_customer_communication_decision/'+id)
                .success(function(data1, status, headers, config) {
                    //$scope.tasks=data;
                    if (data1 == 1) {

                        $.simplyToast('Please select at least one customer', 'warning');

                    } else {//exit;


                        $scope.isDisabled = true;

                        var data = {};

                        data = $scope.request;

                        $http
                            .post(appurl + 'changes/save_customer_communication_decision/' + id + '/' + id1, data)
                            .success(function (data, status, headers, config) {

                                $scope.progress = false;
                                $scope.request = '';
                                location.href = appurl + 'dashboard';


                            }).error(function(data, status, headers, config) {
                        });
                    }


                });


        }
    };

    $scope.addRequest_dno = function (requestForm, id, id1) {
        //  $scope.isDisabled=true
        //  $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

            $http
                .get(appurl + 'changes/check_save_customer_communication_decision/'+id)
                .success(function(data1, status, headers, config) {
                    //$scope.tasks=data;
                    if (data1 == 1) {

                        $.simplyToast('Please select at least one customer', 'warning');

                    } else {//exit;


                        $scope.isDisabled = true;

                        var data = {};

                        data = $scope.request;

                        $http
                            .post(appurl + 'changes/save_customer_communication_decision_wno/' + id + '/' + id1, data)
                            .success(function (data, status, headers, config) {

                                $scope.progress = false;
                                $scope.request = '';
                                location.href = appurl + 'dashboard';


                            }).error(function(data, status, headers, config) {
                        });
                    }


                });


        }
    };

})
/*
Same function for reject
 */


masterApp.controller('customerComAttachmentsCtrl_reject',function($scope,$http){
    $scope.lists=[];
    $scope.list1=[];
    $scope.visibleTable = true;
    $scope.lists.attachments=[];
    $scope.isDisabled=false;

    $scope.chk_v=function(id){
        $scope.isDisabled=true;

    }



    $scope.get_cust_data=function(id){

        $http
            .get(appurl + 'changes/get_cust_data_attachments/'+id)
            .success(function(data, status, headers, config) {

                $scope.lists=data;
                $scope.lists1 = data[0].attachments;
                //alert(JSON.stringify($scope.lists1));



                var text = "";
                var x;
                for (x in $scope.lists) {
                    text= $scope.lists[x].attachments;

                    if(text == ''){


                        $scope.isDisabled=true;

                    }else{

                        $scope.isDisabled=false;
                    }
                }




            });

        $http
            .get(appurl + 'get_request_info_by_id/'+id)
            .success(function(data, status, headers, config) {
                $scope.cmno=data;


            });

        $http
            .get(appurl + 'get_request_info_by_id_for_status/'+id)
            .success(function(data, status, headers, config) {
                $scope.status=data;

            });

    }


    $scope.isDisabled=true;
    $scope.check_form_validate=function(id) {alert(id);

        $http
            .get(appurl + 'changes/get_cust_data_attachments/' + id)
            .success(function (data, status, headers, config) {

                $scope.lists = data;
                $scope.lists1 = data.attachments;
                alert(JSON.stringify($scope.lists1));
                if (data1 == 0) {

                    $.simplyToast('Please Submit All Points.', 'warning');
                    $scope.isDisabled=true;

                } else {

                    $scope.isDisabled=false;
                }

            });
    }



    $scope.DelRecord = function(index,id,name){


        var data={};
        $scope.name=name;
        data = $scope.name;


        $http
            .post(appurl + 'changes/delete_attachment_list/'+id, data)
            .success(function(data, status, headers, config) {
                $scope.customer.attachments.splice(0, 0, index);
                $.simplyToast('Deleted successfully.', 'success');



            }).error(function(data, status, headers, config) {
        });

    }

    $scope.update_status=function(selected_id,request_id,list_id){

        $http
            .get(appurl + 'changes/update_customer_list_status/'+selected_id+'/'+request_id+'/'+list_id)
            .success(function(data, status, headers, config) {

                $.simplyToast('Status Changes Successfully.', 'success');


            }).error(function(data, status, headers, config) {
        });

    }

})

masterApp.controller('customerComAttachmentsCtrl',function($scope,$http){
    $scope.lists=[];
    $scope.list1=[];
    $scope.visibleTable = true;
    $scope.lists.attachments=[];
    $scope.isDisabled=false;

    $scope.chk_v=function(id){
        $scope.isDisabled=true;

    }



    $scope.get_cust_data=function(id){

        $http
            .get(appurl + 'changes/get_cust_data_attachments/'+id)
            .success(function(data, status, headers, config) {

                $scope.lists=data;
                $scope.lists1 = data[0].attachments;
                //alert(JSON.stringify($scope.lists1));



                var text = "";
                var x;
                for (x in $scope.lists) {
                    text= $scope.lists[x].attachments;

                    if(text == ''){


                        $scope.isDisabled=true;

                    }else{

                        $scope.isDisabled=false;
                    }
                }




            });

        $http
            .get(appurl + 'get_request_info_by_id/'+id)
            .success(function(data, status, headers, config) {
                $scope.cmno=data;


            });

        $http
            .get(appurl + 'get_request_info_by_id_for_status/'+id)
            .success(function(data, status, headers, config) {
                $scope.status=data;


            });

    }


    $scope.isDisabled=true;
    $scope.check_form_validate=function(id) {alert(id);

            $http
                .get(appurl + 'changes/get_cust_data_attachments/' + id)
                .success(function (data, status, headers, config) {

                    $scope.lists = data;
                    $scope.lists1 = data.attachments;
                 //   alert(JSON.stringify($scope.lists1));
                    if (data1 == 0) {

                        $.simplyToast('Please Submit All Points.', 'warning');
                        $scope.isDisabled=true;

                    } else {

                        $scope.isDisabled=false;
                    }

                });
        }



    $scope.DelRecord = function(index,id,name){


        var data={};
        $scope.name=name;
        data = $scope.name;


        $http
            .post(appurl + 'changes/delete_attachment_list/'+id, data)
            .success(function(data, status, headers, config) {
                $scope.customer.attachments.splice(0, 0, index);
                $.simplyToast('Deleted successfully.', 'success');



            }).error(function(data, status, headers, config) {
        });

    }

    $scope.update_status=function(selected_id,request_id,list_id){

        $http
            .get(appurl + 'changes/update_customer_list_status/'+selected_id+'/'+request_id+'/'+list_id)
            .success(function(data, status, headers, config) {

                $.simplyToast('Status Changes Successfully.', 'success');


            }).error(function(data, status, headers, config) {
        });

    }

})

masterApp.controller('SidebarCtrl', ['$scope', '$http','$location','$window','$interval',
    function($scope,$http,$location,$window,$interval) {
        
        var user_id=$("#user_id").val();
        
      //  alert(user_id);

                     $scope.recentTaskToMe = function(){

                    $http
                    .get(appurl + 'changes/assigned_task_to_me')
                    .success(function(data, status, headers, config) {                      
                         $scope.recentTasksToMe=data;


                    });
                     }
                      $scope.recentTaskByMe = function(){

                    $http
                    .get(appurl + 'changes/assigned_task_by_me')
                    .success(function(data, status, headers, config) {                      
                        $scope.recentTasksByMe=data;
                                    

                    });
                     }
                     
                       $scope.recentTaskByMe();
                       $scope.recentTaskToMe();
   
                     /*  $interval(function(){
                      $scope.recentTaskByMe(user_id);
                       $scope.recentTaskToMe(user_id);
                        },15000);
                        * */
   
}])

/*****************************************************
*
*    Controller to fetch Dashboard counter on dashboard 
*
******************************************************/


masterApp.controller('DashboardCounterCtrl', ['$scope', '$http','$location','$window','$interval',
    function($scope,$http,$location,$window,$interval) {
        
        var user_id=$("#user_id").val();
        
      //  alert(user_id);

     $scope.counters = function(id){

                    $http
                    .get(appurl + 'changes/dashboard_counter')
                    .success(function(data, status, headers, config) {                      
                         $scope.counter=data;
                 
              //   alert(JSON.stringify($scope.counter.accepted[0].total_sales));
                       
                    });
                     }
                   
                     
                       $scope.counters(user_id);
                  
                    /*   $interval(function(){
                    
                       $scope.counters(user_id);
                        },15000);
                        * */
   
}])
/*****************************************************
*
*    Controller to fetch member type from group table 
*
******************************************************/

masterApp.controller('memberfindCtrl', ['$scope', '$http','$location','$window','$interval',
    function($scope,$http,$location,$window,$interval) {
       
    

                  /*  $http
                    .get(appurl + 'dashboard/findmember')
                    .success(function(data, status, headers, config) {                      
                         $scope.members=data[0];
                         
                       
                    });*/

        $scope.member_dep=function(id){

            $http
                .get(appurl + 'dashboard/findmemberdep_by_id/'+id)
                .success(function(data, status, headers, config) {
                    $scope.member=data[0];

                });

        }
                   
   
}])

masterApp.directive('yearDrop',function(){
   	function getYears(offset, range){
        var currentYear = new Date().getFullYear();
        var years = [];
        for (var i = 0; i < range + 1; i++){
            years.push(currentYear + offset - i);
        }
        return years;
    }
    return {
        restrict:'AE',
        replace:true,

        transclude:true,
        link: function(scope,element,attrs){
            scope.years = getYears(+attrs.offset, +attrs.range);
         //   scope.selected = scope.years[0];
        },
        template: '<select >'
                +'<option ng-repeat="y in years" value="<% y%>"><% y%></option>'
                    
                +'</select>'
    }
});


masterApp.directive('monthDrop',function(){
   
    return {
        link: function(scope,element,attrs){
           scope.months =[    
               {"id":"01","name":"January"},
               {"id":"02","name":"February"},
               {"id":"03","name":"March"},
               {"id":"04","name":"April"},
               {"id":"05","name":"May"},
               {"id":"06","name":"June"},
               {"id":"07","name":"July"},
               {"id":"08","name":"August"},
               {"id":"09","name":"September"},
               {"id":"10","name":"October"},
               {"id":"11","name":"November"},
               {"id":"12","name":"December"}
     
           ];
         //   scope.selected = scope.years[0];
        },
        template: '<select ng-model="search.year" name="year" class="browser-default" required>'
                +'<option ng-repeat="y in months" value="<% y.id %>"><% y.name %></option>'
                    
                +'</select>'
    }
});



//ReportCtrl

masterApp.controller('ReportModalInstanceCtrl', function ($scope,$uibModalInstance,$location,data) {
    // alert(name);

   /* $scope.names = names;

    $scope.items = id;
    $scope.selected = {
        item: $scope.items[0]
    };*/

   // alert(JSON.stringify(data));

    $scope.labels=data.name;
    $scope.data1=[data.val1];
    $scope.data2=[data.val2];
    $scope.data3=[data.val3];
    $scope.data4=[data.val4];

    $scope.cdata1=data.val1;

   // alert(JSON.stringify($scope.cdata1));
    $scope.cdata2=data.val2;
    $scope.cdata3=data.val3;
    $scope.cdata4=data.val4;
    $scope.header=data.header;

    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
        location.href=appurl+'reports';
    };
});

masterApp.controller('ReportCtrl', ['$scope', '$http','$location','$window','$uibModal', '$log',
    function($scope,$http,$location,$window,$uibModal, $log) {
        
         $scope.months =[    
               {"id":"01","name":"January"},
               {"id":"02","name":"February"},
               {"id":"03","name":"March"},
               {"id":"04","name":"April"},
               {"id":"05","name":"May"},
               {"id":"06","name":"June"},
               {"id":"07","name":"July"},
               {"id":"08","name":"August"},
               {"id":"09","name":"September"},
               {"id":"10","name":"October"},
               {"id":"11","name":"November"},
               {"id":"12","name":"December"}
     
           ];
        $scope.hideform=false;
        $scope.Depts=false;
        $scope.years=false;
        $scope.Months=false;
        $scope.Customer=false;
        $scope.radio=false;
        $scope.stcm1=false;

        $scope.search={
            status:1
        }

      /*  $scope.select_report_type=function(type){

            if(type==1){

                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;


            }else if(type==2){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=true;
                $scope.stcm1=false;

            }else if(type==3){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==4){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==5){
                $scope.Depts=false;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=true;

            }else if(type==6){
                $scope.Depts=false;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==7){
                $scope.Depts=false;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==8){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==9){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }else if(type==10){
                $scope.Depts=true;
                $scope.years=true;
                $scope.Months=true;
                $scope.Customer=true;
                $scope.radio=false;
                $scope.stcm1=false;

            }


        }*/
        
        
        

                 $scope.getfunction = function(){

                    $http
                    .get(appurl + 'reports/department')
                    .success(function(data, status, headers, config) {
                      
                         $scope.dep=data;

                    });

                     $http
                         .get(appurl + 'get_report_type')
                         .success(function(data, status, headers, config) {

                             $scope.reports=data;

                         });
                     };


                     $scope.getfunction(); //function calls on-page load
                     // $scope.getfunction1(); //function calls on-page load

                        $scope.summery=false;
                        $scope.search_summery=true;

                   $http
                    .get(appurl + 'changes/change_stage')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changestage=data;
                                                  

                    });
                    
                    
                      $http
                    .get(appurl + 'changes/customers')
                    .success(function(data, status, headers, config) {
                      
                         $scope.customers=data;

                    });

                $http
                    .get(appurl + 'changes/getchangetype')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changetype=data;
                       });
                    //For Dynamic Change Type
                    $scope.fill_customer_name = function(id){ 
						   $scope.selection=[];
						   $scope.selection1=[];
						   
                   
                          if(id=="3"){
                          
                           $scope.hideoption='hide';
                           

                         }else
                         {

                          $scope.hideoption='show';
                         }
                                                   

                     };

        $scope.Dosearch = function(requestForm) {

            var startDate = Date.parse($scope.search.startdate);
            var endDate = Date.parse($scope.search.enddate);
            if (requestForm.$invalid) {
                $scope.invalidSubmitAttempt = true;
                if (startDate > endDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.startdate.$setValidity('valid', false);

                    return;
                }else{

                    $scope.requestForm.startdate.$setValidity('valid', true);
                }
                return;
            } else {

                if (startDate > endDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.startdate.$setValidity('valid', false);

                    return;
                }

         /*   $scope.submitted = true;
            if (requestForm.$invalid) {
                $scope.invalidSubmitAttempt = true;
                return;
            } else {*/
                var data = {};

                $("#requestForm").ajaxSubmit({
                    url: appurl + 'generate_report',
                    type:'post',
                    enctype:'multipart/form-data',
                    success: function(data, status, headers, config){
                      //  alert();
                        $scope.Depts=true;
                        $scope.hideform=true;
                        open('lg',data);

                    },
                    error:function(){alert('error');}
                });
            }
        }

        /*    if (requestForm.$invalid) {
                $scope.invalidSubmitAttempt = true;
                return;
            } else {
                var startDate = Date.parse($scope.search.startdate);
                var endDate = Date.parse($scope.search.enddate);
                if (startDate > endDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.startdate.$setValidity('valid', false);
                    return;
                }
                if (endDate<startDate) {
                    //  $scope.search.startdate.$setValidity('valid',false);
                    $scope.requestForm.enddate.$setValidity('valid', false);
                    return;
                }
                return ;

                var data={};
                data = $scope.search;


                $http
                    .post(appurl + 'generate-report', data)
                    .success(function(data, status, headers, config) {//alert(JSON.stringify(data));

                        $scope.labels=data.name;
                        $scope.data1=[data.val1];
                        $scope.data2=[data.val2];
                        $scope.data3=[data.val3];
                        $scope.data4=[data.val4];

                        $scope.cdata1=data.val1;

                        // alert(JSON.stringify($scope.cdata1));
                        $scope.cdata2=data.val2;
                        $scope.cdata3=data.val3;
                        $scope.cdata4=data.val4;
                        $scope.header=data.header;



                    }).error(function(data, status, headers, config) {
                });
            }

        }*/

        var open = function (size,data) {

            var modalInstance = $uibModal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'ReportContent.html',
                controller: 'ReportModalInstanceCtrl',
                size: size,
                resolve: {
                    data: function () {
                        return data;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };

    
    $scope.dosearch = function(requestForm,search) {
       // $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {
      var startDate = Date.parse($scope.search.startdate);
      var endDate = Date.parse($scope.search.enddate);
      if (startDate > endDate) {
      //  $scope.search.startdate.$setValidity('valid',false);
      $scope.requestForm.startdate.$setValidity('valid', false);
        return;
      }
      if (endDate<startDate) {
      //  $scope.search.startdate.$setValidity('valid',false);
      $scope.requestForm.enddate.$setValidity('valid', false);
        return;
      }
         
        if($scope.selection1!=""){
          $scope.search.multi_user=$scope.selection1;
        }else{
        //$scope.search.multi_user=$scope.request.customer_id1;

        }
            var data={};
            data = $scope.search;
        

            $http
                    .post(appurl + 'advance-search', data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Your Search Records.', 'success');

                    
                    $scope.progress=false;
                 //   $scope.search = angular.copy(oriPerson);
                //    $scope.fields = '';
		 //   $scope.search = '';
                 //   $scope.requestForm.$setPristine();
                 //   $scope.requestForm.$setUntouched();
                 //   $scope.submitted= false;

                    $scope.summery=true ;
                    $scope.search_summery=false;
                      //  $("#summarysheet").html(data);
                        
                     $scope.summeries=data;


            }).error(function(data, status, headers, config) {
            });
        }
    };
        $scope.backToSearch=function(){            

                $scope.summery=false;
                $scope.search_summery=true;
        }
          
       $scope.save=function(){            

               alert(JSON.stringify($scope.search));
        }
       
                     
                     
                     
                     

        
   
}])

masterApp.controller('AdvancedsearchCtrl2', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) { 



                $http
                    .get(appurl + 'changes/change_stage')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changestage=data;
                                                  

                    });


                $http
                    .get(appurl + 'changes/customers')
                    .success(function(data, status, headers, config) {
                      
                         $scope.customers=data;

                    });

                $http
                    .get(appurl + 'changes/getchangetype')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changetype=data;
                       });
                    //For Dynamic Change Type
                    $scope.fill_customer_name = function(id){ 
						   $scope.selection=[];
						   $scope.selection1=[];
						   
                   
                          if(id=="3"){
                          
                           $scope.hideoption='hide';
                           

                         }else
                         {

                          $scope.hideoption='show';
                         }
                                                   

                     };
                     
                     
                     $scope.selection=[];
     $scope.selection1=[];
   
    // toggle selection for a given employee by name
    $scope.toggleSelection = function toggleSelection(employeeName,id) {
      var idx = $scope.selection.indexOf(employeeName);
       var idx1 = $scope.selection.indexOf(id);


      // is currently selected
      if (idx > -1) {
        $scope.selection.splice(idx, 1);
        $scope.selection1.splice(idx1, 1);
      }
      // is newly selected
      else {
        //$scope.selection.push(employeeName);
         $scope.selection.splice(0, 0, employeeName);
         $scope.selection1.splice(0, 0, id);
      }
    };


   
}])




masterApp.controller('AdvancedsearchCtrl1', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) { 



                   $http
                    .get(appurl + 'changes/change_stage')
                    .success(function(data, status, headers, config) {
                      
                         $scope.changestage=data;
                                                  

                    });


                 $scope.getfunction = function(){

                    $http
                    .get(appurl + 'changes/department')
                    .success(function(data, status, headers, config) {
                      
                         $scope.departments=data;
                       //  alert(JSON.stringify($scope.departments));
                         angular.copy($scope.departments, $scope.copy);                             

                    });
                     };

                      $scope.fill_sub_department = function(d_id){
                        if (d_id !== '') {
                    $http
                    .get(appurl + 'changerequest/changes/'+ d_id)
                    .success(function(data, status, headers, config) {
                      
                         $scope.sub_departments=data;

                         if($scope.sub_departments==""){
                          //alert("Blank");
                           $scope.hideoption='hide';

                         }else{

                          $scope.hideoption='show';
                         }



                         angular.copy($scope.departments, $scope.copy);
                        // alert(JSON.stringify($scope.sub_departments));
                                                      

                    });
                  }
                     };

                     $scope.getfunction(); //function calls on-page load
                     // $scope.getfunction1(); //function calls on-page load


 

    $scope.update = function () {
        if ($scope.array.toString() !== $scope.array_.toString()) {
            return "Changed";
        } else {
            return "Not Changed";
        }
    };
    //default radio selection
    $scope.changeType="design";


    /* Dynamic fiels for adding services */
   $scope.fields = [];
    $scope.add = function () {
      $scope.fields.push({extNumber: "", extName: ""});
      console.log($scope.fields);
    };
    $scope.remove = function (index) {
      $scope.fields.splice(index,1);
      console.log($scope.fields);
    };
        
          
 $scope.addRequest = function(requestForm) {
        $scope.submitted= true;
        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {
          $scope.progress=true;
			
			
            var data={};
            data = $scope.request;
            
           // alert(JSON.stringify(data));

            $http
                    .post(appurl + 'changes/addrequest/', data)
                    .success(function(data, status, headers, config) {

                    $.simplyToast('Your message was sent successfully. Thank You.', 'success');

                    
                      $scope.progress=false;
                    $scope.contact = angular.copy(oriPerson);
                    $scope.fields = '';
		            $scope.request = '';
                    $scope.requestForm.$setPristine();
                    $scope.requestForm.$setUntouched();
                    $scope.submitted= false;




            }).error(function(data, status, headers, config) {
            });
        }
    };


   
}])

masterApp.directive('myField',function(){
    return{
      restirct:'AE',
      transclude: true,
      scope: true,
      replace:true,
      //priority:1,
      scope: {
              //  value: '=ngModel',
                //rate: '=rate',
              //  fieldlabel:'=fieldlabel',
               // fieldid:'=fieldid'
               data:'=data',
                },
      template:'<tr ng-repeat="data in fetch">'+
                '<td><%data.sub_dep_name%></td>'+
                 '<td><input type="text" id="initiator_name" name="<%data.sub_dep_name%>" ng-model="" placeholder="Write Comment"></td>'+  
                  '</tr> ',
      link:function(scope,ele,attr){ 
        alert(JSON.stringify(scope.data));

        scope.fetch=scope.data;
      
        //  scope.label=scope.fieldlabel;
         // scope.name=scope.fieldid;

        }

      }

    });



masterApp.controller('Approvalpendingriskassessmentadmin',function ($scope,$http,$location) {

    $scope.approval = {
        radioStatus: '1'
    };



    $http
        .get(appurl + 'changes/fetch_sterring_committee_department/'+11)
        .success(function(data, status, headers, config) {
            $scope.fetch_sub_dep=data;



        });
    $scope.fetch1=function(id) {

        $http
            .get(appurl + 'get_request_info_by_id/' + id)
            .success(function (data, status, headers, config) {
                $scope.cmno = data;


            });

        $http
            .get(appurl + 'get_request_info_by_id_for_status/'+id)
            .success(function(data, status, headers, config) {
                $scope.status=data;


            });

        $http
            .get(appurl + 'changes/department1/' + id)
            .success(function (data, status, headers, config) {

                $scope.availableOptions = data;

            });

    }



});
masterApp.controller('ApprovalpendingriskassessmentCTRL',function ($scope,$http,$location) {

    $scope.approval = {
        radioStatus: '1'
      };



                    $scope.DelRecord = function(index,id) {//alert(id);


                        $http
                            .post(appurl+'changes/delete_pending_data_from_table/' +id)
                            .success(function(data, status, headers, config) {

                                $scope.records.splice(index, 1);// for hide deleted data
                            }).error(function(data, status, headers, config) {
                        });
                    };



                   $http
                    .get(appurl + 'changes/get_sterring_committee')
                    .success(function(data, status, headers, config) {                      
                         $scope.approvaldata=data;
                                              

                    });
                    /*

                      Fetching steering committee sub department


                    */

                  /*   $http
                    .get(appurl + 'changes/fetch_sterring_committee_department/'+11)
                    .success(function(data, status, headers, config) {                      
                         $scope.fetch_sub_dep=data;



                    });*/

                    $http
                        .get(appurl + 'changes/fetch_ad_data')
                        .success(function(data, status, headers, config) {
                            $scope.fetch_sub_dep=data;

                           // alert(JSON.stringify($scope.fetch_sub_dep.name));exit;



                        });



                   $scope.fill_committee_member = function(d_id){
                    if (d_id !== '') {
                    $http
                    .get(appurl + 'changes/steering_committee_/'+ d_id)
                    .success(function(data, status, headers, config) {  // alert(JSON.stringify(data));                  
                         $scope.committeeMembers=data;
                       
                    });
                  }
               };





     $scope.fetch1=function(id){
         $http
             .get(appurl + 'changes/get_all_data_as_ds/'+id)
             .success(function(data, status, headers, config) {
                 $scope.records=data;

                 if($scope.records==''){
                     $scope.isDisabled = true;

                 }else{
                     $scope.isDisabled = false;

                 }


             });


         $http
             .get(appurl + 'get_request_info_by_id/'+id)
             .success(function(data, status, headers, config) {
                 $scope.cmno=data;


             });

         $http
             .get(appurl + 'get_request_info_by_id_for_status/'+id)
             .success(function(data, status, headers, config) {
                 $scope.status=data;


             });


     }

    $scope.submitForm = function() {

        // check to make sure the form is completely valid
        if ($scope.approvalpendingForm.$valid) {
           // alert('our form is amazing');

            $scope.approvalpendingForm.$invalid=true;
        }

    };


$scope.records=[];

    $scope.addapprovalrisk1 = function(approval,id) {//alert(JSON.stringify(approval.id));return;
       
          //alert();



          if(approval.sub_dep_id==undefined){

            alert('Please select Department');
          }else if(approval.id==undefined){
             alert('Please select Member');

          }
          if(approval.sub_dep_id!=undefined && approval.id!=undefined){

            var data={};

            $scope.approval.sub_dep_id=approval.sub_dep_id;
            $scope.approval.id=approval.id;
            $scope.approval.request_id=id;

            data = $scope.approval;   


              $http
                    .post(appurl + 'changes/data_as_ds/', data)
                    .success(function(data, status, headers, config) {

                        $scope.approval.sub_dep_id = $scope.fetch_sub_dep[0];
                        $scope.approval.id = $scope.committeeMembers[0];
                        if(data==1) {
                           $scope.fetch1(id);
                            $scope.isDisabled = true;
                            // $scope.records.push({ d_name: $scope.d_name, first_name: $scope.first_name })
                        }else{
                            $.simplyToast('Member Already Added to List.', 'warning');
                        }



            }).error(function(data, status, headers, config) {
            });

          }

    };




})


masterApp.controller('democtrl', function ($scope,$http,$location) {

    $scope.isDisabled = false;
    $scope.check_validation=function(){
        $scope.isDisabled = true;
        $scope.submitted= true;
    }


})

/* Multi select dropdown box */
masterApp.controller('CtrlNewChangeRequest', function ($scope,$http,$location) {

    $scope.isDisabled = false;



 $scope.getrequestinfo=function(id){
	 
	 
	            $http
                    .get(appurl + 'changes/get_request_details/'+id)
                    .success(function(data, status, headers, config) {                      
                         $scope.requestinfos=data[0];
                                              

                    });
     $http
         .get(appurl + 'get_request_info_by_id/'+id)
         .success(function(data, status, headers, config) {
             $scope.cmno=data;


         });

     $http
         .get(appurl + 'get_request_info_by_id_for_status/'+id)
         .success(function(data, status, headers, config) {
             $scope.status=data;


         });
	 }

    $scope.act={radioStatus:2}
	 
	 
	  $scope.changeRequestStatus = function(requestForm,id,id1) {
        $scope.submitted= true;

        if (requestForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {$scope.isDisabled = true;
          $scope.progress=true;
            var data={};
            $scope.act.dt=$('#startdate_status').val();

            data = $scope.act;


            $http
                    .post(appurl + 'changes/changerequeststatus/'+id+'/'+id1, data)
                    .success(function(data, status, headers, config) {
                        $scope.isDisabled = true;
						 location.href = appurl + 'dashboard';                   


            }).error(function(data, status, headers, config) {
            });
        }
    };

   



})

masterApp.controller('profileCtrl',function($scope,$http){
            $scope.getprofileinfo=function(id){
	
	 
	   $http
                    .get(appurl + 'changes/get_profile_info/'+id)
                    .success(function(data, status, headers, config) {                      
                         $scope.requestinfos=data[0];
              
                    });
	 }
         
         
         
	$scope.saveProfile = function(profileForm) {
		if(profileForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        }else{

			var data = {};		
              
			$("#profileForm").ajaxSubmit({
                                                    url: appurl + 'changes/set_profile_info/',
                                                    type:'post',                                                   
                                                    enctype:'multipart/form-data',
                                                    success: function(data, status, headers, config){														
						
                                                  		$.simplyToast('Record Added Successfully!', 'success');
                                                        location.href=appurl +'changes/profile';
                                                        $scope.requestinfos.avatar=data;
       												//	$state.go('dashboard.photo.managephoto');
                                                    },
                                                    error:function(){alert('error');}
                                            });
	}
      
    }
    
    $scope.changePassword = function(passform) {
	if(passform.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        }else{
            
            return;
        }
    }
    

})

masterApp.controller('AllRiskAssessmentApprovalCTRL', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {


      $scope.risks = []; 

      $scope.fetch_allrisk_assessment_approval=function(id){

    

            $http
                    .get(appurl + 'changes/get_allRisk_assessment_approval/'+id)
                    .success(function(data, status, headers, config) {                      
                         $scope.risks=data;
                        
                       });
                  }

   
}])

masterApp.controller('ApprovalriskassessmentBASEDONCOSTCTRL', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {
 $scope.isDisabled = false;
    $scope.approval = {
        radioStatus: '1'
      };



        $http
            .get(appurl + 'changes/get_hod_by_user_dep')
            .success(function(data, status, headers, config) {

                $scope.hod=data[0];


            });

            $http
                    .get(appurl + 'changes/getdepartment/'+6)
                    .success(function(data, status, headers, config) {                      
                         $scope.qaHODS=data;
                        
                       });



           $scope.fetch_dep_for_approval_assessment_on_cost=function(id){

              $http
                    .get(appurl + 'changes/get_allRisk_assessment_approval/'+id)
                    .success(function(data, status, headers, config) {                      
                         $scope.risks=data;

                        
                       });


               $http
                   .get(appurl + 'get_request_info_by_id/'+id)
                   .success(function(data, status, headers, config) {
                       $scope.cmno=data;


                   });

               $http
                   .get(appurl + 'get_request_info_by_id_for_status/'+id)
                   .success(function(data, status, headers, config) {
                       $scope.status=data;


                   });

               $http
                   .get(appurl + 'changes/department1/'+id)
                   .success(function(data, status, headers, config) {

                       $scope.availableOptions=data;

                   });

                  }
$scope.isDisabled=false;
  $scope.addapproval_assessment_based_ONCOST=function(approval_based_costForm,approval,r_id,id){

            if(approval_based_costForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        }else{
                    $scope.isDisabled = true;
                    $scope.approval.request_id=r_id;
                    $scope.approval.id=$('#user_id').val();
                 
                    var data={};
                    
                    data = $scope.approval;

                  
                    $http
                            .post(appurl + 'changes/addapproval_assessment_based_oncost/'+id, data)
                            .success(function(data, status, headers, config) {
                              $scope.isDisabled = true;

                                location.href = appurl + 'dashboard';

                           

                    }).error(function(data, status, headers, config) {
                    });

           }
  }
   
}])

masterApp.controller('customer_verificationCtrl_for_reject', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {

        $scope.verify={radioStatus:1}


        $scope.get_info=function(id){
            $http
                .get(appurl + 'get_request_info_by_id/'+id)
                .success(function(data, status, headers, config) {
                    $scope.cmno=data;


                });

            $http
                .get(appurl + 'get_request_info_by_id_for_status/'+id)
                .success(function(data, status, headers, config) {
                    $scope.status=data;


                });

        }

        $scope.isDisabled=false;
        $scope.verify_customer_for_reject=function(customer_verificationForm,r_id,id){

            if (customer_verificationForm.$invalid) {
                $scope.invalidSubmitAttempt = true;
                return;
            } else {$scope.isDisabled=true;

                var data={};

                $scope.verify.request_id=r_id;
                data = $scope.verify;

                $http
                    .post(appurl + 'changes/customer_verify_for_reject/'+id, data)
                    .success(function(data, status, headers, config) {
                        // $scope.risks=data;
                        $scope.isDisabled=true;
                        location.href=appurl+'dashboard';

                    }).error(function(data, status, headers, config) {
                });

            };
        }

    }])


masterApp.controller('customer_verificationCtrl', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {

        $scope.verify={radioStatus:1}



        $scope.get_info=function(id){
            $http
                .get(appurl + 'get_request_info_by_id/'+id)
                .success(function(data, status, headers, config) {
                    $scope.cmno=data;


                });

            $http
                .get(appurl + 'get_request_info_by_id_for_status/'+id)
                .success(function(data, status, headers, config) {
                    $scope.status=data;


                });


            $http
                .get(appurl + 'changes/department1/'+id)
                .success(function(data, status, headers, config) {

                    $scope.availableOptions=data;

                });

        }
       
        $scope.isDisabled=false;
     $scope.verify_customer=function(customer_verificationForm,r_id,id){

       if (customer_verificationForm.$invalid) {
            $scope.invalidSubmitAttempt = true;
            return;
        } else {$scope.isDisabled=true;
         
            var data={};

            $scope.verify.request_id=r_id;
            data = $scope.verify;           
    

             $http
                 .post(appurl + 'changes/customer_verify/'+id, data)
                    .success(function(data, status, headers, config) {                      
                        // $scope.risks=data;
                     //   $scope.isDisabled=true;
                        location.href=appurl+'dashboard';

                     }).error(function(data, status, headers, config) {
            });
      
    };
}
       
}])

masterApp.controller('ActivityModalInstanceCtrl', function ($scope,$http, $uibModalInstance,request_id,cat_id,risk_assessment_id) {


    $http
        .get(appurl + 'changes/get_data_in_modal/' + request_id + '/' + cat_id + '/' + risk_assessment_id)
        .success(function (data1, status, headers, config) {

            $scope.lists = data1;

        });

    $scope.delete_file = function (index, id, name) {



        $http
            .get(appurl + 'changes/delete_data_in_modal/' + id + '/' + name)
            .success(function (data1, status, headers, config) {



                //  $scope.lists.splice(index, 1);

            });
    }

        $scope.ok = function () {
            $uibModalInstance.close($scope.selected.item);
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

})

masterApp.controller('Activity_monitoringCtrl',function($scope,$http, $uibModal, $log){
   
    $scope.lists=[];
    $scope.isDisabled=true;
  
    $scope.lists.attachments=[];



   /* $scope.fetch_file=function(request_id,risk_assessment_id){

        $http
            .get(appurl + 'changes/get_data_in_modal1/' + request_id + '/' + risk_assessment_id)
            .success(function (data1, status, headers, config) {

                $scope.lists = data1;

            });

    }*/


    /*$scope.check_all_form_data=function(risk_assessment_id,request_id){

        $http
            .get(appurl + 'changes/check_all_form_data_for_next_step/'+risk_assessment_id+'/'+request_id)
            .success(function(data, status, headers, config) {
              if(data!=0) {
                  $scope.isDisabled = false;
              }else{

                  $scope.isDisabled = true;
              }
            })

    }*/


     $scope.update1=function(id,ids,count,request_id){



            var data = {};
            data = $scope.selected_id=id;

         if(count>0 && id==2){

             $http
                 .post(appurl + 'changes/update_status/'+ids, data)
                 .success(function(data, status, headers, config) {
                     $.simplyToast('Status Changed Successfully', 'success');
                   //  $scope.check_all_form_data(ids,request_id)

                 });
         }else if(id==1){

             $http
                 .post(appurl + 'changes/update_status/'+ids, data)
                 .success(function(data, status, headers, config) {
                     $.simplyToast('Status Changed Successfully', 'success');
                    // $scope.check_all_form_data(ids,request_id)
                 });

         }
         else{

             $.simplyToast('Please Attach the file to close the status', 'warning');
            // $scope.check_all_form_data(ids,request_id)
            // location.href=appurl+'dashboard';
             $window.open(appurl, "_self");
                return;

         }

      }


         $scope.verify_data=function(id,ids){

            var data = {};
            data =id;

      $http
                    .post(appurl + 'changes/update_verification/'+ids, data)
                    .success(function(data, status, headers, config) {
                        $.simplyToast('Verification Status Changed Successfully', 'success');

                       });

           
                  } 


      $scope.get_data=function(id){

          $http
              .get(appurl + 'get_request_info_by_id/'+id)
              .success(function(data, status, headers, config) {
                  $scope.cmno=data;


              });

          $http
              .get(appurl + 'get_request_info_by_id_for_status/'+id)
              .success(function(data, status, headers, config) {
                  $scope.status=data;


              });

            $http
                    .get(appurl + 'changes/get_allRisk_assessment_approval1/'+id)
                    .success(function(data, status, headers, config) {                      
                         $scope.lists=data;
                       //  alert(JSON.stringify(data));
                      // $scope.get_cust_data();
                        
                       });


                  }


    $scope.open = function (size,request_id,cat_id,risk_assessment_id) {


        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'ActivityModalContent.html',
            controller: 'ActivityModalInstanceCtrl',
            size: size,
            resolve: {
                request_id: function () {
                    return request_id;
                },
                cat_id: function () {
                    return cat_id;

                },
                risk_assessment_id: function () {
                    return risk_assessment_id;

                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    }


});

masterApp.controller('ActivityCompletionSheetVerifyCTRL', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) { 

        $scope.activity = {
        radioStatus: '1'
      };



        $scope.get_info=function(id){
            $http
                .get(appurl + 'get_request_info_by_id/'+id)
                .success(function(data, status, headers, config) {
                    $scope.cmno=data;


                });

            $http
                .get(appurl + 'get_request_info_by_id_for_status/'+id)
                .success(function(data, status, headers, config) {
                    $scope.status=data;


                });


            $http
                .get(appurl + 'changes/department1/'+id)
                .success(function(data, status, headers, config) {

                    $scope.availableOptions=data;

                });

        }

        $scope.isDisabled=false;

      $scope.activity_completion_sheet_verify=function(approval,request_id,id){//alert(JSON.stringify(approval));return;
          $scope.isDisabled=true;
            var data = {};


          $scope.comment=$('#commentid').val();

          alert(JSON.stringify($scope.comment));exit;
            data =$scope.radioStatus=approval;

      $http
                    .post(appurl + 'changes/verify_activity_completion_sheet/'+request_id+'/'+id, data)
                    .success(function(data, status, headers, config) {
                        $scope.isDisabled=true;
                       location.href=appurl+'dashboard';
                        
                       });
      
           
                  } 

}])

masterApp.controller('HorizontalDeploymentCTRL', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) { 
     $scope.activity = {
        radioStatus: '1'
      };

       $scope.get_customer_for_horizontal_deployment=function(request_id)
        {


            $http
                .get(appurl + 'changes/customers_horizontal/'+request_id)
                .success(function (data, status, headers, config) {

                    $scope.customers = data;

                });
        }
        $scope.isDisabled=false;
        $scope.horizontal_dep=function(HorizontalDepForm,activity,request_id,id){

            if (HorizontalDepForm.$invalid) {//alert();
            $scope.invalidSubmitAttempt = true;
            return;
        } else {

                    $scope.isDisabled = true;

                    var data = {};
                    data = $scope.radioStatus = activity;

                    $http
                        .post(appurl + 'changes/horizontal_deployment_approval/' + request_id + '/' + id, data)
                        .success(function (data, status, headers, config) {
                            $scope.isDisabled = true;
                            location.href = appurl + 'dashboard';


                        });

                }
            }

        $scope.horizontal_dep_acc=function(HorizontalDepForm,activity,request_id,id){

                $scope.isDisabled = true;

                var data = {};
                data = $scope.radioStatus = activity;

                $http
                    .post(appurl + 'changes/horizontal_deployment_approval/' + request_id + '/' + id, data)
                    .success(function (data, status, headers, config) {
                        $scope.isDisabled = true;
                        location.href = appurl + 'dashboard';


                    });

            }


}])

masterApp.controller('BeforeAfterStatusCTRL', ['$scope', '$http','$location','$window',
    function($scope,$http,$location,$window) {

        $scope.fetch_implementation_date=function(request_id){

            $http
                .get(appurl + 'changes/fetch_implementation_date_for_change/'+request_id)
                .success(function(data, status, headers, config) {
                    $scope.result=data;


                });

        }

        $scope.dataf=function() {
            // $scope.submitted= true;


              //  alert();
                $scope.dataf=true;
               // $scope.progress=false;
                // $scope.submitted= false;

                //  return;
            }


      //  $scope.isDisabled=false;
        $scope.beforeafterstatus=function(formdata){
            if(formdata.$invalid) {
                $scope.invalidSubmitAttempt = true;
               // alert("File is Required");
                return;
            }else{

                return true;
            }
        }

      //  $scope.isDisabled1=false;
        $scope.add_status_option=function(formdata,request_id) {
           // $scope.submitted= true;
            if (formdata.$invalid) {$scope.data=false;
                $scope.invalidSubmitAttempt = true;
                return;
            } else {

               // alert();
               // $scope.dataf=true;
                $scope.progress=false;
               // $scope.submitted= false;

              //  return;
            }
        }
}])


masterApp.controller('CMCloserCTRL', ['$scope', '$http','$location','$window',function($scope,$http,$location,$window) {
            $scope.isDisabled=false;
            $scope.closer = {
                radioStatus: '20'
            }

            /**
             * 20-closed
             * 21-open
             * 22-cancelled
             * @param closer
             * @param request_id
             */


            $scope.get_info=function(id){
                $http
                    .get(appurl + 'get_request_info_by_id/'+id)
                    .success(function(data, status, headers, config) {
                        $scope.cmno=data;


                    });

                $http
                    .get(appurl + 'get_request_info_by_id_for_status/'+id)
                    .success(function(data, status, headers, config) {
                        $scope.status=data;


                    });

            }
    $scope.isDisabled=false;
            $scope.closeCM=function(closer,request_id,id){

                $scope.isDisabled=true;
                var data = {};
                data =$scope.radioStatus=closer;

                $http
                    .post(appurl + 'changes/close_cm_management/'+request_id+'/'+id,data)
                    .success(function(data, status, headers, config) {
                        $scope.isDisabled=true;
                        $.simplyToast('Management Closer Status Saved Successfully!', 'success');
                        location.href=appurl+'dashboard';

                    });

            }


        }])






masterApp.controller('Ctrlactivitymonitoring', function($scope,$http){




    $scope.status = {
        isFirstOpen: true,
        oneAtATime: true
    };

    $scope.summeryReport=function(id){



        $http
            .get(appurl + 'view_search_result/'+id)
            .success(function(data, status, headers, config) {

                //$.simplyToast('Your Search Records.', 'success');
                $scope.showReport = true;
                $scope.summeries=data['userjobs'];
                $scope.parts=data['parts'];
               // $scope.before_after=data['before_after_attachement'];
                // $scope.risksdatas1=data['risks'];

                //   alert(data['risks'].length);
               // alert(JSON.stringify($scope.before_after));
            });
        /*$http
         .get(appurl + 'view_risk_asses_data/'+id)
         .success(function(data, status, headers, config) {
         $scope.risksdatas1=data;
         });
         */

        $http
            .get(appurl + 'changes/fetch_dep_team/'+id)
            .success(function(data, status, headers, config) {

                $scope.team_members=data;
            });

        $http
            .get(appurl + 'changes/get_allRisk_assessment_approval/'+id)
            .success(function(data, status, headers, config) {

                $scope.risksdatas1=data;
            });




    }



});
masterApp.filter('startFrom', function () {
    return function (input, start) {
        if (input) {
            start = +start;
            return input.slice(start);
        }
        return [];
    };
});
/*
masterApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start;
        if(input!=null){
            return input.slice(start);
        }
    };
});
*/