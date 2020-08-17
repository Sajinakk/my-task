<!doctype html>
<html lang="en">
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10"><br><br><br>
                <div class="card">
                    <div class="card-header">
                        <h3>Todo List</h3>
                    </div>
                    <div class="card-body">
                        <form  method="POST" id="form">
                            @csrf
                            <div class="row">
                                <div class="col">


                                        <input type="hidden" name="id" id="id">
                                        <select name="name" id="name" class="form-control">
                                            <option value="">select the name</option>
                                            @foreach($data as $names)
                                        <option value="{{$names->name}}">{{$names->name}}</option>
                                            @endforeach
                                        </select><br>

                                        <p style="color: red" id="nameerror"></p>
                                        <input type="date" class="form-control" placeholder="date" name="date" id="date" class="date" required><br>

                                        <p style="color: red" id="dateerror"></p>

                                        <input type="number" step="0.01" placeholder="amount" class="form-control"  name="amount" id="amount" class="amount"><br>

                                        <p style="color: red" id="amounterror"></p>

                                        <textarea name="description" id="description" cols="81" rows="4" placeholder="description" class="form-control"></textarea>

                                        <p style="color: red" id="descriptionerror"></p>


                                </div>
                                <div class="col">
                                    <center><button type="button" id="btn" class="bttn">SAVE</button></center><br>
                                    <center><button type="button" id="bttnedit" class="bttn">UPDATE</button></center><br>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-dark" id="tbl">
                                    <thead>
                                        <tr>
                                            <th scope="col">User ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" colspan="2"><center>Operations</center></th>
                                        </tr>
                                    </thead>
                                    <tbody id="users">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <script>

            load();
            function load(){

                $.ajax({
                    url:'/usergetdata',
                    type:'GET',
                    success:function(response){
                        data = response.data;
                        $('.tr').remove();

                        for(i=0;i<response.data.length;i++){
                            $("#users").append(
                                "<tr class='tr'><td>"+response.data[i].user_id+"</td><td>"
                                +response.data[i].date+"</td><td>"
                                +response.data[i].amount+"</td><td>"
                                +response.data[i].description+"</td><td><button onclick='delete_("+response.data[i].id+");'>delete</button>"+" "+"<button id='btnedit'data-id='"+response.data[i].id+"'' >edit</button></td></tr>"
                            );
                        }
                    }
                });
                };
                function delete_(sid){
            $.ajax({
                url:'/userdeletedata',
                type:'GET',
                data:{id:sid},
                success: function(response){
                    alert(response.message);
                    load();
                }
            });
        };
            $(document).ready(function(){
            $("#btn").click(function(response){
                event.preventDefault();
                    $.ajax({
                    url:'/usersubmitdata',
                    type:'POST',
                    //data:$("#form").serialize(),
                    data:$("#form").serialize(),
                        success:function(data){
                            load();
                            $("#form :input").each(function(){
                            $(this).val('');
                            });
                        },
                        error:function(error){
                            let errList=error['responseJSON']['errors'];
                            //console.log(error['responseJSON']['errors']['name']==undefined);
                            if(errList['name']){
                                $('#nameerror').html(errList['name']);
                            }
                            if(errList['date']!=undefined){
                                $('#dateerror').html(errList['date']);
                            }
                            if(errList['amount']!=undefined){
                                $('#amounterror').html(errList['amount']);
                            }
                            if(errList['description']!=undefined){
                                $('#descriptionerror').html(errList['description']);
                            }
                    }
                    });
                });
            });
            $(document).on("click","#btnedit",function(){
                var id=$(this).data("id");
                $("#id").val(id);
                $.ajax({
                        url:"userfetchdata/"+id,
                        type:"GET",
                        data:$("#form").serialize(),
                        success:function(data){
                $('#date').val(data.data.date);
                $('#amount').val(data.data.amount);
                $('#description').val(data.data.description);                    }
            });
                });
                $("#bttnedit").click(function(){
                var id=$("#id").val();
                    $.ajax({
                        url:"userupdatedata",
                        type:"GET",
                        data:$("#form").serialize(),
                        success:function(data){
                            load();
                            $("#form :input").each(function(){
                            $(this).val('');
                        });
                        }
                    });
            });
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>

</html>
