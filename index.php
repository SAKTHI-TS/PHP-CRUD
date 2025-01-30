<?php
include("db.php");
$sql = "SELECT* FROM crud";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <div class=container>
        <h1 style="text-align: center;">CRUD OPERATION</h1>

        <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#adduser">Add user</button>
        <table id="addcrud" class="table">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Name</th>
                    <th scope="col">Dept </th>
                    <th scope="col">Age</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $s = 1;
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>

                        <td><?php echo $s; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['dept']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><button type="button" value="<?php echo $row['id']; ?>" class="btn btn-primary btnuseredit">Edit</button>
                            <button type="button" class="btn btn-danger btnuserdelete" value="<?php echo $row['id'] ?>">Delete</button>
                        </td>

                    </tr>
                <?php
                    $s++;
                }
                ?>

            </tbody>
        </table>
        <!-- add user -->
        <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addnewuser">
                        <div class="modal-body">


                            <label for="exampleInputEmail1" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter the name">
                            <label for="exampleInputEmail1" class="form-label">Dept:</label>
                            <select class="form-select" aria-label="Default select example" id="dept" name="dept">
                                <option value=" " selected disabled>select the department</option>

                                <option value="CSE">CSE</option>
                                <option value="EEE">EEE</option>
                                <option value="CSBS">CSBS</option>
                            </select>
                            <label for="exampleInputEmail1" class="form-label">Age:</label>
                            <input type="text" class="form-control" id="age" name="age" placeholder="Enter the age">




                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit user Modal -->
    <div class="modal fade" id="Edituser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="Editnewuser">
                        <input type="hidden" name="id" id="id" required>
                        <label for="exampleInputEmail1" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="Name" name="name" placeholder="Enter the name">
                        <label for="exampleInputEmail1" class="form-label">Dept:</label>
                        <select class="form-select" aria-label="Default select example" id="Dept" name="dept">
                            <option value=" " selected disabled>select the department</option>

                            <option value="CSE">CSE</option>
                            <option value="EEE">EEE</option>
                            <option value="CSBS">CSBS</option>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Age:</label>
                        <input type="text" class="form-control" id="Age" name="age" placeholder="Enter the age">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            //to display data tables
            $('#addcrud').DataTable();
        });

        $(document).on('submit', '#addnewuser', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("save_newuser", true);
            console.log(formData)
            $.ajax({
                type: "POST",
                url: "back.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res)
                    if (res.status == 200) {
                        $('#adduser').modal('hide');
                        $('#addnewuser')[0].reset();
                        $('#addcrud').load(location.href + " #addcrud");
                        alert("added successfully")

                    } else if (res.status == 500) {
                        $('#adduser').modal('hide');
                        $('#addnewuser')[0].reset();
                        console.error("Error:", res.message);
                        alert("Something Went wrong.! try again")
                    }
                }
            });

        });

        $(document).on('click', '.btnuserdelete', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this data?')) {
                var user_id = $(this).val();
                console.log(user_id)
                $.ajax({
                    type: "POST",
                    url: "back.php",
                    data: {
                        'delete_user': true,
                        'user_id': user_id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            $('#addcrud').load(location.href + " #addcrud");
                        }
                    }
                });
            }
        });

        $(document).on('click', '.btnuseredit', function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id)
            $.ajax({
                type: "POST",
                url: "back.php",
                data: {
                    'edit_user': true,
                    'user_id': user_id
                },
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res)
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        //$('#student_id2').val(res.data.uid);

                        $('#id').val(res.data.id);
                        $('#Name').val(res.data.name);
                        $('#Dept').val(res.data.dept);
                        $('#Age').val(res.data.age);

                        $('#Edituser').modal('show');
                    }
                }
            });
        });

        $(document).on('submit', '#Editnewuser', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData)
            formData.append("save_edituser", true);
            $.ajax({
                type: "POST",
                url: "back.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        $('#Edituser').modal('hide');
                        $('#Editnewuser')[0].reset();
                        $('#addcrud').load(location.href + " #addcrud");
                        alert(res.message)

                    } else if (res.status == 500) {
                        $('#Edituser').modal('hide');
                        $('#Editnewuser')[0].reset();
                        console.error("Error:", res.message);
                        alert("Something Went wrong.! try again")
                    }
                }
            });
        });
    </script>

</body>

</html>