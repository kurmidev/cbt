<?php

use yii\helpers\Html;
use common\models\Operator;
use common\models\Location;
use common\models\PlanMaster;
use common\ebl\Constants as C;
use yii\helpers\ArrayHelper;
?>

<div class="card-body">
    <div class="row">
        <?= $this->render('create_account/_contact_details', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('create_account/_address', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('create_account/_account_details', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('/account/_add_bouquets', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('/account/_add_static_ip', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('/account/_device_allocation', ['model' => $model, 'form' => $form]) ?>
        <?= $this->render('/account/_add_charges', ['model' => $model, 'form' => $form]) ?>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"></div>
<?php
$js = '
      
    $("#addmore").on("click",function(){
        var length = $("#proof-uploads tbody > tr").length;
        if(length<4){
           var $cloneObj =  $(this).closest("tr").clone();
               $cloneObj.find(".select-chosen").replaceWith(function() {
                    return $(".select-chosen", this);
                });
           $cloneObj.find("select").each(function () {
       
           console.log("exiting Ids",$(this).attr("id"))
           if($(this).attr("id")!=undefined){
            $(this).val("0").attr("id", $(this).attr("id").replace((length>0?length+1:0),length ));
           }
                       $(this).attr("name", $(this).attr("name").replace(/\[\d+]/, "[" + length + "]"));

           console.log($(this).attr("id"),$(this).attr("name").replace(/\[\d+]/, "[" + length + "]"))
            //$(this).val("").attr("name", $(this).attr("name").replace("[0]", "[" + length + "]"));
       }).end()
       $cloneObj.find("input[type=text]").each(function () {
            $(this).attr("name", $(this).attr("name").replace(/\[\d+]/, "[" + length + "]"));
            $(this).attr("id", $(this).attr("id").replace("-0-", "-" + length + "-"));
        }).end()
            
            $cloneObj.find(".select-chosen").chosen({ });
            $cloneObj.find("td:last span").attr("class", "fa fa-minus btn btn-danger btn-xs");
            $cloneObj.find("td:last span").attr("onclick", "$(this).closest(\"tr\").remove();");
           $("#proof-uploads tbody").append($cloneObj);
        }
         $("#proof-uploads tbody > tr").find(".chosen-select").chosen();
    });
';
$js .= '
 
 var $modal = $("#myModal");
    jQuery(".ldmodal").click( function () {
        var height=window.innerHeight;
        var custid=$("#customer-customer_id").val();
        var url = $(this).attr("url");
         $.ajax({
            url: url,
            type: "post",
            dataType: "html",
            data: {height:height,customer_id:custid},
            success: function (data, status) {
                $modal.html(data);
                $modal.modal("show");
                    $(".modal-dialog").css({width:"auto", "height":"auto","max-height":"100%"});
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Desc: " + desc + "\nErr:" + err);
            }
        });
    });
';

$this->registerJs($js);
?>