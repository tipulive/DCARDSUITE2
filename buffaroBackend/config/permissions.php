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
            "approvalAction"=>"1",
            "description" => "Add a cash register",
            "enabled" => true,
        ],
         "editCaisse" => (object) [
            "name" => "Edit Caisse",
            "description" => "Add a cash register",
            "enabled" => true,
        ],
    ],
];
