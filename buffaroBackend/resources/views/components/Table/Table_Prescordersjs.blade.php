
 //table   
Table_Prescorders:function(){
     //
     oTable = $('#Table_Prescorders').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_orders') }}",
        type:"post",
        data:{
          "type_order":'{{env('ordertype2')}}',
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [

//data




@if (Auth::guard('Admin')->check())
                                      @if (Auth::guard('Admin')->user()->platform==env('Standard'))
                                      @include('components.Table.jscomponents.table_Prescorder_pharmacyjs')
                                        
                                       @else
                                       @include('components.Table.jscomponents.table_Prescorder_Superjs')
                                       @endif
 
                                      @elseif (Auth::check())
                                      @if (Auth::user()->platform==env('Client'))
                                      @include('components.Table.jscomponents.table_Prescorder_Clientjs')
                                        
                                       @else
                                     <div>none</div>   
                                       @endif  
                                     
                                      @else
  
                                      @endif
                                     

//data


    
    ],
       
       
                   
      });

     new $.fn.dataTable.FixedHeader( oTable );
//

} ,  
  
  //table