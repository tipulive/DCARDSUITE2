
 //table   
Table_admin:function(){
     //
     oTable = $('#Table_admin').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_admin') }}",
        type:"post",
        data:{
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [

//data




@include('components.Table.jscomponents.table_admin_Superjs')
                                     

//data


    
    ],
       
       
                   
      });

     new $.fn.dataTable.FixedHeader( oTable );
//

},    
  
  //table