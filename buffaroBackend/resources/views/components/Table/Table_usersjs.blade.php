
 //table   
Table_users:function(){
     //
     oTable = $('#Table_users').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_users') }}",
        type:"post",
        data:{
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [

//data




@include('components.Table.jscomponents.table_user_Superjs')
                                     

//data


    
    ],
       
       
                   
      });

     new $.fn.dataTable.FixedHeader( oTable );
//

} ,   
  
  //table