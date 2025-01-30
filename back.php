<?php
include("db.php");

//Add new User
if (isset($_POST['save_newuser'])) {
    try {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dept = mysqli_real_escape_string($conn, $_POST['dept']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);

        $query = "INSERT INTO crud(name,dept,age) VALUES ('$name', '$dept','$age')";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
                'message' => 'Details Updated Successfully'
            ];
            echo json_encode($res);
        } else {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}

//delete User
if (isset($_POST['delete_user'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);
  
    $query = "DELETE FROM crud WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);
  
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Details Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
  }
//  / /get data for User edit
if (isset($_POST['edit_user'])) {
  $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);

  $query = "SELECT * FROM crud WHERE id='$student_id'";
  $query_run = mysqli_query($conn, $query);

  $User_data = mysqli_fetch_array($query_run);


  if ($query_run) {
    $res = [
      'status' => 200,
      'message' => 'details Fetch Successfully by id',
      'data' => $User_data
  ];
      echo json_encode($res);
      return;
  } else {
      $res = [
          'status' => 500,
          'message' => 'Details Not Deleted'
      ];
      echo json_encode($res);
      return;
  }
}

//User edit
if (isset($_POST['save_edituser'])) {
  $student_id = mysqli_real_escape_string($conn, $_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $dept = mysqli_real_escape_string($conn, $_POST['dept']);
  $age = mysqli_real_escape_string($conn, $_POST['age']);


  $query = "UPDATE crud SET name='$name',dept='$dept',age='$age' WHERE id='$student_id'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {
    $res = [
      'status' => 200,
      'message' => 'details Updated Successfully'
  ];
      echo json_encode($res);
      return;
  } else {
      $res = [
          'status' => 500,
          'message' => 'Details Not Deleted'
      ];
      echo json_encode($res);
      return;
  }
}



?>