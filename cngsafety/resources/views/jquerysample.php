<script>
    $(function () {
        $("#activate").click(function (event)
        {
            event.preventDefault();
            var $post = {};
            var item;
            //var mcity;
            ///$post.petid = $('#petid').val();
            //$post.name = $('#province').val(); //got the province name here.
            //console.log($this);
            
            //console.log( $('#activate').val() );
            ///$post.ocheck = ($("#ocheck").prop("checked") == true ? '1' : '0');
            $post._token = document.getElementsByName("_token")[0].value;
            $post.userid=$(this).attr('alt').value();
            
            //<a href="{{route('enableuser',$user->id)}}">

            
            return;
            $.ajax({
            
                url: 'enableuser',
                type: 'POST',
                data: $post,
                cache: false,
                success: function (data) {
            
                    //console.log(data);
                    //console.log(data[0]["id"]);
                    //$("#msg").html(print_r(data));
                    //alert ($(data).length);
                    if ( $(data).length ){
                        //$('#city').empty();
                        
                        //$("table tbody").remove();
                        /*var $tbody ="<tbody><tr><td>".concat(data[0]["id"],"</td><td>",data[0]["name"],"</td><td>",data[0]["email"],"</td><td>",data[0]["nickname"],"</td></tr></tbody>") ;*/
                        
                        for (item=0;item < data.length;++item)
                        {

                            if (item==0)
                            {
                                mcity="";
                                //mcity="<option value=".concat(data[item]["city"]," selected>",data[item]["city"],"</option>" );

                                //$('#city').append( mcity);
                                //console.log(mcity);

                            }
                            else
                            {
                                //mcity="";
                                //mcity="<option value=".concat(data[item]["city"]," >",data[item]["city"],"</option>" );

                                //console.log(mcity);

                                $('#city').append( mcity);
                            }
                                
                        }

                        
                        //$('#city').append('<option>New Option</option>');                        
                        //$("table").append($tbody);
                      } else { alert("No record found");}

                    return data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    
                    console.write(textStatus);
                    //console.write(errorThrown);
                }
            });
        });
    });
</script>
