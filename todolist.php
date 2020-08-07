
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <form action="POST" id="frm">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="Full name" name="fullname" id="fullname" class="fullname" require="">
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="col">
                            <center><button type="submit" id="btn">SAVE</button></center>
                            </div>
                        </div>
                </form>
                        <div class="row">
                            <div class="col-md-6">
                                <ul id="mylist">
                                 <?php
                                 include "db.php";
                                 $q=mysqli_query($conn,"select * from fullname");
                                
                                 while($r=mysqli_fetch_assoc($q)){
                                     echo "<li>"; echo "$r[fullname]";echo "  ";
                                     echo "<button class='btndel' data-id='btndl'>Delete</button>" ;echo "  ";
                                     echo "<button id='btnedit'>Edit</button>" ;echo"</li>";
                                    echo "<br>";
                                    }
                                 ?>
                                </ul>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    
                    
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <script>
        $(document).ready(function(){
            $("#btn").click(function(){
                event.preventDefault()
                var name=$("#fullname").val();
                if (name.length > 0) {
                     $('#fullname').val('');
                    $('#fullname').css({
                        'borderColor': ''
                    });
                    $.ajax({
                    url:'insert.php',
                    method:'POST',
                    data:{
                        name:name
                    },
                    
                    success:function(data){
                        $('#mylist').append("<li class='item'>" + name +"    "+"<button type='button' class='btndel' data-id='btndl'>Delete</button>"+"    "+"<button type='button' id='btnedit'>Edit</button>");
                  
                       
                   }
                   
                });
                } else {
                    $('#fullname').css({
                        'borderColor': 'red'
                    });
                }
                
                
                
            });
            // delete

            $(document).on("click", ".btndel", function() { 
		    var $x = $(this).parents("li");
            var dataId = $(this).attr("data-id");
		    $.ajax({
			url: "delete.php",
			type: "POST",
            
			data:{
				id:dataId
			},
			success: function(data){
                alert("The data-id of clicked item is: " + dataId);
				$x.remove();	
			}
		});
	});
            // delete
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>