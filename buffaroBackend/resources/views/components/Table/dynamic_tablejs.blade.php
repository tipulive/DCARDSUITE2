<script>
        var data,
                tableName= '#demotable',
                columns,
                str,
                jqxhr = $.ajax('./test_json')
                        .done(function () {
                            data = JSON.parse(jqxhr.responseText);

                // Iterate each column and print table headers for Datatables
                $.each(data.columns, function (k, colObj) {
                    var countn=k;
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName+'>thead>tr');
                   
                });
                /*this is to calculate where i will append action column,by taking total cumn -1 */
                actionappend=data.columns.length-1;
                /*this is to calculate where i will append action column,by taking total cumn -1 */
               //console.log(data.columns[2].name);
               
          //console.log(data.columns[2]);
        
        
            //
            console.log(data.column_html);
                console.log(data.columname);
             //var dynamic_action=data.columname;
             var action_column=data.columns[2].name;
             var dynamic_action1=data.columname;
             var dynamic_action=data.column_html;
             
                // Add some Render transformations to Columns
                // Not a good practice to add any of this in API/ Json side
                data.columns[actionappend].render = function (data, type, row) {
                   /* var datatest=data[dynamic_action];
            var test=`<a href="#">${datatest}</a>`;
                    return '<h4>' + test + '</h4>';*/
                   
                    if(action_column==="action"){
    var datacol=data[dynamic_action1];
                    dynamic_action=dynamic_action.replace("datatest1",datacol)
                    return '<h4>' + dynamic_action + '</h4>';
                    }
                    else{
                        return '<h4>' + data + '</h4>';
                    }
                    
                
                }
            //
        
              
                        // Debug? console.log(data.columns[0]);
                     
                $(tableName).dataTable({
                    "processing": false,
            
                "responsive": true,
                    "data": data.data,
                    "columns": data.columns,
                    "fnInitComplete": function () {
                        // Event handler to be fired when rendering is complete (Turn off Loading gif for example)
                        console.log('Datatable rendering complete');
                    }
                });
                new $.fn.dataTable.FixedHeader( oTable );
            })
            .fail(function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                console.log(msg);
            });
    </script>
