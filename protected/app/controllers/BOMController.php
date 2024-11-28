<?php
use Carbon\Carbon;
// use Request;

class BOMController extends BaseController
{


   public function index()
    {    //$allUser =$this->getAllUserDept();
        
        return View::make('changes/BOM');
       // return View::make('changes/BOMData');
  }

  public function indexData()
    {   
       return View::make('changes/BOMData');
  }

   public function get_material_data()
    {

        $data = DB::table('tb_materialmaster')
            ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
            ->select('materialCode', 'tb_materialmaster.Description','tb_uom.id as UOM', 'tb_materialmaster.id',DB::raw('CONCAT(materialCode, "-", tb_materialmaster.Description) AS MaterialDesc'),DB::raw("case when(select COUNT(*) FROM bommaster where ItemId=tb_materialmaster.id)=0 then 'Component' else 'Assembly' end as FLAG"))
            ->where('Active', 1)
            ->get();
            // print_r($data);exit();

        return $data;
    }

   public function get_Item_data(){
    $input=Input::All();
    // print_r($input['search']);exit();
    $data = DB::table('tb_materialmaster')
            ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
            ->select('materialCode', 'tb_materialmaster.Description','tb_uom.id as UOM', 'tb_materialmaster.id',DB::raw('CONCAT(materialCode, "-", tb_materialmaster.Description) AS MaterialDesc'),DB::raw("case when(select COUNT(*) FROM bommaster where ItemId=tb_materialmaster.id)=0 then 'Component' else 'Assembly' end as FLAG"))
            ->where('Active', 1)
            // ->where('materialCode', 'LIKE', '%'.$input['search'].'%')
            ->where(DB::raw('CONCAT_WS(" ", materialCode, tb_materialmaster.Description)'), 'like', '%'.$input['search'].'%')
            ->get();

        return $data;
   }

    public function saveData(){
        if(isset($_POST['master'])&&isset($_POST['detail'])){

            $objmaster = json_decode($_POST['master']);
            $objDetails = json_decode($_POST['detail']);

            if($objmaster[0]->BOMid!='0'){
                $getItem=DB::table('bommaster')
                          ->select('bommaster.ItemId as MasterItemId')
                          ->where('bommaster.BOMId',$objmaster[0]->BOMid)
                          ->get(); 

                $RevisionNumber=DB::table('bommaster')
                    ->select(DB::Raw('max(RevisionNumber) as r_no'))
                    ->where('ItemId',$getItem[0]->MasterItemId)
                    ->get();

                $updateAssembly=DB::table('bommaster as b')
                               ->join('bomdetails', 'b.BOMId','=','bomdetails.BOMId')
                               ->select('bomdetails.BOMDtlsId')
                               ->where('RevisionNumber','=', DB::RAW('(select max(RevisionNumber) from bommaster GROUP BY ItemId HAVING ItemId =b.ItemId)'))
                               ->where('bomdetails.ItemId',$objmaster[0]->itemId)
                               ->get();
                  // print_r($updateAssembly);exit();
                  // print_r($RevisionNumber);exit();
                $RevNo=$RevisionNumber[0]->r_no+1;

                $data=DB::table('bommaster')->insertGetId(
                            array(
                                    'ItemId'  =>$objmaster[0]->itemId,
                                    'IsExplorer'=>$objmaster[0]->isExplore,
                                    'UOM'=>$objmaster[0]->UOM,
                                    'RevisionNumber'=>$RevNo
                                )
                            );
                if(isset($updateAssembly)){
                  foreach($updateAssembly as $value){
                    DB::table('bomdetails')
                      ->where('BOMDtlsId',$value->BOMDtlsId)
                      ->update(
                        array('AssemblyLatestRevisionBOMId' => $data
                        )
                    );

                  }
                }
                foreach($objDetails as $value){
                  if($value->deleted!=1){
                    $dada=DB::table('bomdetails')->insert(
                            array(
                                    'BOMId'=>$data,
                                    'ItemId'  =>$value->itemId,
                                    'UOM'=>$value->uom,
                                    'Quantity'=>$value->qty
                                )
                            );
                  }
                }// print_r($RevNo);exit();
            }else{
            $data=DB::table('bommaster')->insertGetId(
                            array(
                                    'ItemId'  =>$objmaster[0]->itemId,
                                    'IsExplorer'=>$objmaster[0]->isExplore,
                                    'UOM'=>$objmaster[0]->UOM,
                                    'RevisionNumber'=>$objmaster[0]->PrevRevNo
                                )
                            );
            // print_r($dada);exit();
            $objDetails = json_decode($_POST['detail']);

                foreach($objDetails as $value){
                  if($value->deleted!=1){
                    $dada=DB::table('bomdetails')->insert(
                            array(
                                    'BOMId'=>$data,
                                    'ItemId'  =>$value->itemId,
                                    'UOM'=>$value->uom,
                                    'Quantity'=>$value->qty
                                )
                            );
                    // print_r($value->qty);exit();
                    }
                }
            }
            
        }
            // return $dada;
          print_r($dada);exit();
        // print_r($objDetails[0]->deleted);exit();
    }

    public function BOM_CheckIsChild($MasterItemId,$DetailItemId){
      $i=0;
        $Result=$this->DecideDropAllowOnParentCheck($MasterItemId,$DetailItemId,$i);
        return $Result;
    }

   public function DecideDropAllowOnParentCheck($MasterItemId,$DetailItemId,$i){
    // $input=Input::All();
    $FindStatus='FALSE';
    
    $RevisionNumber=DB::table('bommaster')
                    ->select(DB::Raw('max(RevisionNumber) as r_no'))
                    ->where('ItemId',$MasterItemId)
                    ->get();
   
    ${"getParent" . $i}=DB::table('bommaster')
            ->join('bomdetails','bommaster.BOMId','=','bomdetails.BOMId')
            ->select('bommaster.ItemId as MasterItemId','bomdetails.ItemId as DetailsItemId')
            ->where('bommaster.ItemId',$MasterItemId)
            ->where('RevisionNumber','=',$RevisionNumber[0]->r_no)
            ->get();

           // echo '<pre>'; print_r($getParent) ;

        foreach(${"getParent" . $i} as $value){
          // print_r($value->DetailsItemId);
          $i++;
            if($value->DetailsItemId==$DetailItemId){
               echo $FindStatus='TRUE';exit();
            }else{
                $FindStatus=$this->DecideDropAllowOnParentCheck($value->DetailsItemId,$DetailItemId,$i);
            }
            
           // echo '<pre>';print_r($value->DetailsItemId); // print_r($value->DetailsItemId);exit();
        }
       // print_r($FindStatus);exit();
    return $FindStatus;
        // if($FindStatus=='FALSE'){
        //    echo "0";
        // }else{
        //     echo "1";
        // }
        // echo "1"; exit();
   }

   public function BOM_GETAssemblyBOM_OnDrop($ItemId){
        $i=0;
         $RevisionNumber=DB::table('bommaster')
                    ->select(DB::Raw('max(RevisionNumber) as r_no'))
                    ->where('ItemId',$ItemId)
                    ->get();
        $BOMID=DB::table('bommaster')
            ->select('BOMID')
            ->where('bommaster.ItemId',$ItemId)
            ->where('RevisionNumber','=',$RevisionNumber[0]->r_no)
            ->get(); 
         
         $BOMTempTable=array();
         if(isset($BOMID[0]->BOMID)){
            $BOMTempTable=$this->getBOM($BOMID[0]->BOMID,$i,$BOMTempTable);
        }
         // print_r($BOMTempTable);exit();
         return  $BOMTempTable;

   }

   public function getBOM($BOMID,$i,$BOMTempTable){
    
    // $BOMTempTable=array();
     // print_r($i); 
    ${"getsubBOM" . $i} =DB::table('bommaster')
               ->join('bomdetails','bommaster.BOMId','=','bomdetails.BOMId')
               ->join('tb_materialmaster','bommaster.ItemId','=','tb_materialmaster.id')
               ->join('tb_materialmaster as material','bomdetails.ItemId','=','material.id')
               ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
               ->join('tb_uom as DtlsUOM','DtlsUOM.id','=','material.UOM')
               ->select('bommaster.BOMId','bomdetails.ItemId as DtlItemId','material.Description as DtlItmDesc','DtlsUOM.id as DtlItmUOM','material.materialCode as DtlMaterialCode','bomdetails.Quantity','bomdetails.BOMDtlsId as BOMDetailsId','bommaster.IsExplorer','bommaster.ItemId as MstrItemId',DB::raw('CONCAT(material.materialCode, "-", material.Description) AS MaterialDesc')) 
               ->where('bommaster.BOMId',$BOMID)
               ->orderBy('bomdetails.BOMDtlsId','asc')
               ->get();
        // print_r(${"getsubBOM" . $i});
            
        foreach(${"getsubBOM" . $i} as $key){
            
            $cnt=count($BOMTempTable);
            
            $BOMTempTable[$cnt]=$key;
            // $cnt=count($BOMTempTable);
            // echo $cnt;
            $i++;
            // print_r($BOMTempTable);exit();
            $count=DB::table('bommaster')
                  ->select(DB::Raw('COUNT(*) as total'))
                  ->where('ItemId',$key->DtlItemId)
                  ->get();
                 // print_r($count[0]->total);exit();
                  
                if($count[0]->total!=0){
                  // echo $count[0]->total;
                     $RevisionNumber=DB::table('bommaster')
                    ->select(DB::Raw('max(RevisionNumber) as r_no'))
                    ->where('ItemId',$key->DtlItemId)
                    ->get();

                    $subBOMID=DB::table('bommaster')
                             ->select('BOMId')
                             ->where('ItemId',$key->DtlItemId)
                             ->where('RevisionNumber',$RevisionNumber[0]->r_no)
                             ->get();
                    // echo $subBOMID[0]->BOMId;exit();
                    // print_r($BOMTempTable[$cnt]);           
                  $BOMTempTable= $this->getBOM($subBOMID[0]->BOMId,$i,$BOMTempTable);        
                }
                           
        }
         // print_r($BOMTempTable[$cnt]);
        // echo 'helloo';
       return $BOMTempTable;
   }

   public function getBOMData(){
        $data=DB::table('bommaster as b')
               ->join('tb_materialmaster','b.ItemId','=','tb_materialmaster.id')
               ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
               ->select('b.BOMId','b.ItemId as MstrItemId','tb_materialmaster.materialCode','tb_materialmaster.Description as desc','tb_uom.Description') 
               // ->whereRaw('RevisionNumber',DB::Raw("Select MAX('RevisionNumber') FROM bommaster WHERE ItemId=bommaster.ItemId"))
               // ->where('RevisionNumber','=',select(DB::Raw('SELECT MAX(RevisionNumber) FROM bommaster GROUP BY ItemId HAVING ItemId =b.ItemId')))
               ->where('RevisionNumber' ,'=', DB::RAW('(select max(RevisionNumber) from bommaster GROUP BY ItemId HAVING ItemId =b.ItemId)'))
               // ->take(10)
               ->get();
               // print_r($data);exit();
        return $data;
   }

   public function remove(){
        echo 'remove';
   }

   public function edit(){
        return View::make('changes/BOM');
   }
  
  public function BOM_GetById($BOMID)
  {
    // print_r($BOMID);
     $data=DB::table('bommaster')
          ->join('tb_materialmaster','bommaster.ItemId','=','tb_materialmaster.id')
          ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
          ->select('bommaster.BOMId','bommaster.ItemId as MstrItemId',DB::raw('CONCAT(tb_materialmaster.materialCode, "-", tb_materialmaster.Description) AS MaterialDesc'),'tb_materialmaster.materialCode as MstrMaterialCode','tb_materialmaster.Description as MstrItmDesc','tb_uom.id as MstrItmUOM','bommaster.RevisionNumber','bommaster.IsExplorer') 
          ->where('bommaster.BOMId',$BOMID)
          ->get();

        $i=0;
        $BOMTempTable=array();
         if(!empty($BOMID)){
            $BOMTempTable=$this->getBOM($BOMID,$i,$BOMTempTable);
            // print_r($BOMTempTable);exit();
        }
        // echo 'hello';
        echo json_encode(array('result1'=>$data,'result2'=>$BOMTempTable));
  }

  public function searchBOM($criteria){
    if($criteria!='N:A'){
    $data=DB::table('bommaster as b')
               ->join('tb_materialmaster','b.ItemId','=','tb_materialmaster.id')
               ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
               ->select('b.BOMId','b.ItemId as MstrItemId','tb_materialmaster.materialCode','tb_materialmaster.Description as desc','tb_uom.Description') 
               // ->whereRaw('RevisionNumber',DB::Raw("Select MAX('RevisionNumber') FROM bommaster WHERE ItemId=bommaster.ItemId"))
               // ->where('RevisionNumber','=',select(DB::Raw('SELECT MAX(RevisionNumber) FROM bommaster GROUP BY ItemId HAVING ItemId =b.ItemId')))
               ->where('RevisionNumber' ,'=', DB::RAW('(select max(RevisionNumber) from bommaster GROUP BY ItemId HAVING ItemId =b.ItemId)'))
               ->where(DB::raw('CONCAT_WS(" ", materialCode, tb_materialmaster.Description)'), 'like', '%'.$criteria.'%')
               ->get();
        }else{
            $data=DB::table('bommaster as b')
               ->join('tb_materialmaster','b.ItemId','=','tb_materialmaster.id')
               ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
               ->select('b.BOMId','b.ItemId as MstrItemId','tb_materialmaster.materialCode','tb_materialmaster.Description as desc','tb_uom.Description') 
               // ->whereRaw('RevisionNumber',DB::Raw("Select MAX('RevisionNumber') FROM bommaster WHERE ItemId=bommaster.ItemId"))
               // ->where('RevisionNumber','=',select(DB::Raw('SELECT MAX(RevisionNumber) FROM bommaster GROUP BY ItemId HAVING ItemId =b.ItemId')))
               ->where('RevisionNumber' ,'=', DB::RAW('(select max(RevisionNumber) from bommaster GROUP BY ItemId HAVING ItemId =b.ItemId)'))
               // ->where(DB::raw('CONCAT_WS(" ", materialCode, tb_materialmaster.Description)'), 'like', '%'.$criteria.'%')
               ->get();
        }
    return $data;
  }

  public function searchBOMRecords($criteria){
    
            $data=DB::table('bommaster as b')
               ->join('tb_materialmaster','b.ItemId','=','tb_materialmaster.id')
               ->join('tb_uom','tb_uom.id','=','tb_materialmaster.UOM')
               ->select('b.BOMId','b.ItemId as MstrItemId','tb_materialmaster.materialCode','tb_materialmaster.Description as desc','tb_uom.Description') 
               // ->whereRaw('RevisionNumber',DB::Raw("Select MAX('RevisionNumber') FROM bommaster WHERE ItemId=bommaster.ItemId"))
               // ->where('RevisionNumber','=',select(DB::Raw('SELECT MAX(RevisionNumber) FROM bommaster GROUP BY ItemId HAVING ItemId =b.ItemId')))
               ->where('RevisionNumber' ,'=', DB::RAW('(select max(RevisionNumber) from bommaster GROUP BY ItemId HAVING ItemId =b.ItemId)'))
               // ->where(DB::raw('CONCAT_WS(" ", materialCode, tb_materialmaster.Description)'), 'like', '%'.$criteria.'%')
               ->take($criteria)
               ->get();
        // print_r($data);exit();
    return $data;
  }

}
