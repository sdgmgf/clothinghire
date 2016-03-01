<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .popDialog{
            position:absolute;
            z-index:8000;
            background-color: #eee;
            box-shadow: 4px 4px 80px #000;
            opacity: 0.8;
            border:1px solid;
            -moz-transform: translate(-140%, -50%);
            margin-left:-5px;
            margin-top:-10px;
            margin-bottom: 30px;
        }

        .new{
          background-color: #fba558;
        }


    </style>
</head>
<body>  
  <div class="container" ng-app="shippingTemplateApp">
      
      <div  ng-controller="templatesController">
          
            <div class="row" style="margin-bottom: 7px;">
               <button class="new"  type="button" class="btn btn-xs btn-primary" ng-click="newOneShippingTemplateClick()">
                    新建运费模板
               </button>
             </div>

             <!-- <button ng-show="status =='OK' " style="margin-left: 20px;" type="button" class="btn btn-xs btn-primary" ng-click="viewDeleteClick( )"> 
                    查看已删除的模板 
             </button>
             <button ng-show="status =='DELETE' " style="margin-left: 20px;" type="button" class="btn btn-xs btn-primary" ng-click="viewOkClick( )"> 
                    查看有效的模板 
             </button> -->
         
        <div  class="row" ng-repeat="(shippingTemplate_row, shippingTemplate) in shippingTemplates" >
               <!-- <span class="pull-left" style="margin-left: -15px;">{{ (currentPage-1)*limit+shippingTemplate_row+1}} </span> -->
               <div  class="col-md-12" style="border:1px solid;">
               <form name="shippingTemplateForm" class="form-horizontal" role="form" novalidate >
                   
                   <div class="row">
                    <div class="col-md-4 row form-group">
                          <!--  ng-show="shippingTemplate.shipping_template_id == undefined" -->
                          <div class="col-md-3">
                             <label  for="template_name" 
                              class="control-label">名称:
                            </label>
                          </div>
                          <div  class="col-md-8" style="margin-left: 0px;">
                              <input type="text" class="form-control"  name="{{shippingTemplate_row}}-template_name"
                               ng-mousedown="inputMousedown(shippingTemplate.template_name,shippingTemplate_row)"
                               ng-keyup ="inputKeyup(shippingTemplate.shipping_template_name,shippingTemplate_row)"
                               ng-model="shippingTemplate.shipping_template_name" 
                               value="{{shippingTemplate.shipping_template_name}}" ng-required="true">
                               <div ng-show=" shippingTemplateForm['{{shippingTemplate_row}}-template_name'].$error.required "
                                  class=" alert-danger"> 
                               请填入名称 
                               </div> 
                           </div>
                    </div>
                    <div class="col-md-8 row">
                  
                       <span ng-show="shippingTemplate.shipping_template_id == undefined"> 正在新建 </span>
                       <span  class="alert alert-danger" ng-show="input.isChanged[shippingTemplate_row]"> 
                            数据已改变请注意保存，否则会丢失
                       </span>
                       <button   type="button" class="btn btn-xs btn-danger pull-right" style="float:right;" 
                         ng-click="deleteOneShippingTemplateClick(shippingTemplates,shippingTemplate,shippingTemplate_row)">
                          删除该运费模板 
                       </button>
                    </div>
                  </div>  <!-- 第一行显示名称 和 删除按钮 end --> 

                  <table class="table">
                  <thead>
                      <tr>
                      <th>地区</th>
                      <th>首重(kg)</th>
                      <th>运费(元)</th>
                      <th>续重(kg)</th>
                      <th>运费(元)</th>
                      <th>操作</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr ng-repeat="(area_row,area) in shippingTemplate.detail">
                       
                      <td>  
                              <span ng-repeat="(region_row, region) in area.regions">
                               {{region.region_name}}
                              </span>
                              &nbsp;  
                              <button type="button" class="btn btn-xs btn-default" 
                                  ng-click="areaUpdateClick(shippingTemplate.shippingTemplate_id,area,shippingTemplate_row,area_row,$event)"> 
                                修改 
                              </button>
                              <div ng-show="area.regions == undefined || area.regions.length < 1 "
                                  class=" alert-danger"> 
                                请选择城市
                               </div> 
                      </td>
                      <td>
                        <input  type="text" ng-pattern ="/^\d+(\.\d+)?$/" ng-model="area.first_weight"  class="form-control" 
                             ng-mousedown="inputMousedown(first_weight,shippingTemplate_row)"
                             ng-keyup ="inputKeyup(first_weight,shippingTemplate_row)"
                             ng-required="true" name="{{area_row}}-first_weight" value="{{area.first_weight}}">
                           <div ng-show="shippingTemplateForm['{{area_row}}-first_weight'].$error.pattern 
                               || ( shippingTemplateForm['{{area_row}}-first_weight'].$error.required 
                                  && shippingTemplateForm['{{area_row}}-first_weight'].$dirty )"
                             class="alert alert-danger help-block "> 
                               请输入正数
                           </div> 
                        
                      </td>
                      <td>
                        <input type="text" ng-pattern ="/^\d+(\.\d+)?$/" ng-model="area.first_fee" 
                           ng-mousedown="inputMousedown(area.first_fee,shippingTemplate_row)"
                           ng-keyup ="inputKeyup(area.first_fee,shippingTemplate_row)"
                           class="form-control"  ng-required="true" 
                           name= "{{area_row}}-first_fee"  value="{{area.first_fee}}">
                       
                          <div ng-show="shippingTemplateForm['{{area_row}}-first_fee'].$error.pattern 
                               || ( shippingTemplateForm['{{area_row}}-first_fee'].$error.required 
                                  && shippingTemplateForm['{{area_row}}-first_fee'].$dirty )"
                             class="alert alert-danger help-block "> 
                               请输入正数
                           </div> 
                      </td >
                      <td>
                        <input type="text" name="{{area_row}}-continued_weight" ng-pattern ="/^\d+(\.\d+)?$/" ng-model="area.continued_weight" 
                           ng-mousedown="inputMousedown(area.continued_weight,shippingTemplate_row)"
                           ng-keyup ="inputKeyup(area.continued_weight,shippingTemplate_row)"
                           class="form-control"  ng-required="true"  value="{{area.continued_weight}}">   
                          <div ng-show="shippingTemplateForm['{{area_row}}-continued_weight'].$error.pattern 
                               || ( shippingTemplateForm['{{area_row}}-continued_weight'].$error.required 
                                  && shippingTemplateForm['{{area_row}}-continued_weight'].$dirty )"
                             class="alert alert-danger help-block "> 
                               请输入正数
                           </div>
                        
                      </td>
                       <td>
                        <input type="text" ng-pattern ="/^\d+(\.\d+)?$/" ng-model="area.continued_fee"  
                             ng-mousedown="inputMousedown(area.continued_fee,shippingTemplate_row)"
                             ng-keyup ="inputKeyup(area.continued_fee,shippingTemplate_row)"
                            class="form-control"  ng-required="true" name="{{area_row}}-continued_fee" value="{{area.continued_fee}}">
                            <div ng-show="shippingTemplateForm['{{area_row}}-continued_fee'].$error.pattern 
                               || ( shippingTemplateForm['{{area_row}}-continued_fee'].$error.required 
                                  && shippingTemplateForm['{{area_row}}-continued_fee'].$dirty )"
                             class="alert alert-danger help-block "> 
                               请输入正数
                           </div>
                      </td >
                      <td>
                       <!--  <button  ng-show="shippingTemplate.shipping_template_id != undefined" type="button" 
                              ng-disabled = " !shippingTemplateForm.$valid || !shippingTemplateForm.$dirty"
                              class="btn btn-xs btn-success" ng-click="saveClick(shippingTemplate,area,area_row)"> 
                              保存 
                         </button>  -->

                         <button type="button" ng-show="area.status =='OK' || area.status == undefined " class="btn btn-xs btn-danger" 
                                   ng-click="deleteClick(shippingTemplate,area,area_row)"> 删除 </button>
                         <!-- <button type="button" ng-show="area.status=='DELETE' " class="btn btn-xs btn-warning" ng-click="activeClick(shippingTemplate,area,area_row)" > 点击激活 </button> -->
                         <span ng-show="area.status=='DELETE' ">为删除状态</span>
                      </td>
                       <td>   
                      <div class="col-md-7 popDialog " 
                           ng-show="dialog.currentBig == shippingTemplate_row+'-'+area_row"
                           ng-mouseleave="dialog.currentBig = -1"
                          ng-style="{'left':mouseClick.x+'px','margin-top':mouseClick.y+'px'}">  <!-- 城市选择 div  start  -->
                               
                                <div class="row">
                                  <div class="col-md-6 text-left"><B>选择区域 </B></div>
                                  <div class="col-md-6 text-right"> 
                                    <!-- <button type="button"  ng-click="dialog.currentBig = -1" 
                                        class="btn btn-xs btn-default" style="color:blue;" > 
                                        关闭 
                                    </button> -->
                                  </div>
                                </div> 

                                <div class="row">
                                  <div class="col-md-4" ng-repeat="(province_row, province) in cities | typeFilter:1">
                                    <label>
                                        <input type="checkbox" ng-model="myProvinces" 
                                            ng-checked="(area.regions | cityFilter).length != 0 && (cities | cityFilter).length == (area.regions | cityFilter).length"
                                            ng-click="provinceChange(province,myProvinces,area.regions,shippingTemplate_row)"
                                         value = "province.region_id" > 
                                         {{province.region_name}}
                                    </label>
                                    <span>
                                        {{(area.regions | cityFilter:province.region_id).length}}
                                    </span>
                                    <div class="fa fa-chevron-down" 
                                        ng-click="oneProvinceShow($event,shippingTemplate_row,area_row,province.region_id)">
                                        &nbsp;&nbsp;
                                    </div>  
                                </div>
                              </div>   <!-- 省份选择  end --> 

                              <div class="row text-center"  style="background-color: #abc;" >   <!-- 根据省份得到城市的列表 -->

                                  <label class="checkbox-inline"
                                      ng-repeat="(city_row, city) in cities | cityFilter:currentProvinceId " >
                                    <input type="checkbox"  ng-checked="isCityChecked(city,area.regions)"
                                      ng-model="cityChecked" 
                                      ng-click="cityChange(city,cityChecked,area.regions,shippingTemplate_row)"
                                       value="city.region_id"> {{city.region_name}}
                                  </label>
                                 
                              </div>
                                
                         </div>  <!-- 城市选择 div end  -->
                       </td>

                      </tr>
                      
                      <tr>
                        <td> 
                          <button   type="button" class="btn btn-xs btn-warn" ng-click="addAreaClick(shippingTemplate)"> 添加 </button>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td colspan="2" class="text-center">
                          <button  ng-disabled="! ( shippingTemplateForm.$valid && input.isChanged[shippingTemplate_row])"  
                                      type="button" class="btn btn-xs btn-primary" 
                                      ng-click="saveOneShippingTemplateClick(shippingTemplate,shippingTemplate_row)"> 
                                      保存该模板 
                          </button>
                          
                        </td>
                      </tr>
                   </tbody>
                </table>
              </form>
              </div>
              <div>&nbsp;&nbsp;</div>
        </div>

       <div class="container" ng-show="page.length > 1" style="float: right;">   <!--  分页  start   -->
           <nav>
          <ul class="pagination" style="float:right;">
            <li ng-click="prevPageClick()" ng-class="{disabled:currentPage <=1}" >
              <a href="#" aria-label="上一页">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
           <li ng-repeat="(p_row , p) in page"  ng-class="{active:currentPage == p }" >
            <a ng-click="pageClick(p)" href="#">{{p}}</a>
           </li>

            <li  ng-click="nextPageClick()"  >
              <a href="#" aria-label="下一页">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>     <!--  分页 end  -->
        

      </div>   <!--  shippingTemplatesController  end  -->
  </div>  <!-- container    end   -->
 <script  type="text/javascript" src="http://cdn.bootcss.com/angular.js/1.3.15/angular.min.js"></script>
 <script type="text/javascript" src="http://cdn.bootcss.com/angular.js/1.3.15/angular-resource.min.js"></script>
 <script src="assets/js/shippingTemplate.js"></script>
</body>
</html>


