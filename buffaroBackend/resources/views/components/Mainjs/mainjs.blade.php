<script>
var mainmethod={

    @include('components.Table.Table_Medordersjs')
    @include('components.Table.Table_Prescordersjs')

    @include('components.Table.Table_usersjs')
    @include('components.Table.Table_adminjs')
    
   
    @include('components.Table.Table_Paymenthistoryjs')

    Forms_UserMedecine:function(){
    use_location();
    get_profile_detail();
//search_address_profile();
$('.change_area').addClass('d-none');
setTimeout(() => {
  search_address_profile();
}, 1000);
  },
  Forms_UploadPrescription:function(){
    use_location();
    get_profile_detail();
    $('.change_area').addClass('d-none');
    //search_address_profile();
    setTimeout(() => {
  search_address_profile();
}, 1000);
},
Forms_UpdateProfile:function(){
   // use_location();
    get_profile_detail();
    //search_address_profile();
},

}


</script>
@include('components.Sharejs.Sharejs')