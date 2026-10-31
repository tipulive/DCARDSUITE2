
 //table   
Table_reportusers:function(){
     //
     oTable = $('#Table_reportusers').DataTable({
           "processing": false,
           "serverSide": true,
               "destroy":true,
               "responsive": true,
                ajax: {
       url:"{{route('table_reportusers') }}",
        type:"post",
        data:{
          "_token":'{{ csrf_token() }}'
        }
        
         
    },"columns": [

//data





@if (Auth::guard('Admin')->check())
                                      @if (Auth::guard('Admin')->user()->platform==env('Standard'))
                                      @include('components.Table.jscomponents.table_reportusers_pharmacyjs')
                                        
                                       @else
                                       @include('components.Table.jscomponents.table_reportusers_Superjs')
                                       @endif
 
                                      @elseif (Auth::check())
                                      @if (Auth::user()->platform==env('Client'))
                                      @include('components.Table.jscomponents.table_reportusers_Clientjs')
                                        
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