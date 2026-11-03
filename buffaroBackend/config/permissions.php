<?php
//$permissions["notification"]["addCaisse"]->name;
/*@php
    $permissions = config('permissions');
@endphp

{{ $permissions["notification"]["addCaisse"]->name }}*/
return [
    "notification" => [
        "addCaisse" => (object) [
            "name" => "Add Caisse",
            "uid"=>"AddCaisse",
            "approvalAction"=>"1",
            "description" => "request Caisse",
            "enabled" => true,
            "error"=>"Error unable to Access Caisse please Ask Permission to Admin or Super Admin please"
        ],
         "updateCaisse" => (object) [
            "name" => "update Caisse",
            "uid"=>"updateCaisse",
            "approvalAction"=>"1",
            "description" => "update Caisse",
            "enabled" => true,
            "error"=>"Error unable to Access update Caisse please Ask Permission to Admin or Super Admin please"
        ],
         "reqSpending" => (object) [
            "name" => "request Spending",
            "uid"=>"reqSpending",
            "approvalAction"=>"1",
            "description" => "request Caisse",
            "enabled" => true,
            "error"=>"Error unable to Access Spending please Ask Permission to Admin or Super Admin please"

        ],
         "updateSpending" => (object) [
            "name" => "update Spending",
            "uid"=>"updateSpending",
            "approvalAction"=>"1",
            "description" => "update Spending",
            "enabled" => true,
            "error"=>"Error unable to Access update Spending please Ask Permission to Admin or Super Admin please"
        ],
        "adminSetPermission" => (object) [
            "name" => "admin SetPermission",
            "uid"=>"adminSetPermission",
            "approvalAction"=>"1",
            "description" => "Admin set permission",
            "enabled" => false,
            "error"=>"Error unable to Access admin SetPermission please Ask Permission to Admin or Super Admin please"
        ],
         "EditPrice" => (object) [
            "name" => "edit Price",
            "uid"=>"editSalePrice",
            "approvalAction"=>"1",
            "description" => "Edit Sale Price",
            "enabled" => false,
            "error"=>"Error unable to Access Edit Sale Price please Ask Permission to Admin or Super Admin please"
        ],
    ],

];
