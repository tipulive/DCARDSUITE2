
 //table   
Table_Paymenthistory:function(){
     //
     oTable = $('#Table_Paymenthistory').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_payment_history') }}",
        type:"post",
        data:{
         
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [

//data




@if (Auth::guard('Admin')->check())
                                      @if (Auth::guard('Admin')->user()->platform==env('Standard'))
                                      @include('components.Table.jscomponents.table_Paymenthistory_pharmacyjs')
                                        
                                       @else
                                       @include('components.Table.jscomponents.table_Paymenthistory_Superjs')
                                       @endif
 
                                      @elseif (Auth::check())
                                      @if (Auth::user()->platform==env('Client'))
                                    
                                        
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