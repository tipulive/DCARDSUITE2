
  
Table_Medorders:function(){
 
     oTable = $('#Table_orders').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_orders') }}",
        type:"post",
        data:{
          "type_order":'{{env('ordertype1')}}',
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [






@if (Auth::guard('Admin')->check())
                                      @if (Auth::guard('Admin')->user()->platform==env('Standard'))
                                      @include('components.Table.jscomponents.table_Medorder_pharmacyjs')
                                        
                                       @else
                                       @include('components.Table.jscomponents.table_Medorder_Superjs')
                                       @endif
 
                                      @elseif (Auth::check())
                                      @if (Auth::user()->platform==env('Client'))
                                      @include('components.Table.jscomponents.table_Medorder_Clientjs')
                                        
                                       @else
                                     <div>none</div>   
                                       @endif  
                                     
                                      @else
  
                                      @endif
                                     




    
    ],
       
       
                   
      });

     new $.fn.dataTable.FixedHeader( oTable );

     profile_clearnotification();
} ,  


  
  