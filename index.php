<?php
$dataFile = 'data.txt';
if(isset($_POST['submit'])){
    if(empty($_POST['Ttitle']) || empty($_POST['description'])){
        $error = "*"."please enter all the required fields";
    }
    else{
        $Ttitle = $_POST['Ttitle'];
        $description = $_POST['description'];

        if(isset($_FILES['upload_file'])){
            $uploadDir = 'upload/';
            $file_name = $_FILES['upload_file']['name'];
            $uploadFile = $uploadDir. $file_name;

            if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadFile)){
                $data = $Ttitle ."\n". $description ."\n". $uploadFile."\n===\n";
                file_put_contents($dataFile, $data, FILE_APPEND); 
            }
            else{
                $data = $Ttitle . "\n" . $description . "\n" . "No File Submitted" . "\n===\n";
                file_put_contents($dataFile, $data, FILE_APPEND);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
<form action="" method="post" enctype="multipart/form-data">
<h2>Portfolio Management System</h2>
<?php 
if(isset($_POST['submit'])){
    if(isset($error)){
        echo "<p class='text-danger'>". $error ."</p>";
    }
}
?>
    <!-- Title -->
    <div class="mb-3">
                <label class="form-label">Title</label><span class="text-danger">*</span>
                <input type="text" class="form-control" name="Ttitle" placeholder="Enter Title">
            </div>
            <!-- description -->
            <div class="mb-3">
                <label class="form-label">Description</label><span class="text-danger">*</span>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter Description"></textarea>
            </div>
            <!-- File -->
            <div class="mb-3">
                <label for="formFile" class="form-label">Choose any file</label>
                <input class="form-control" type="file" name="upload_file" id="formFile">
            </div>
            <br>
            <input class="btn btn-primary" type="submit" name="submit" value="upload">
</form>

 <!-- Displaying data -->
 <?php
if(isset($_POST['submit'])){
   if(!isset($error)){
       $hide = 1;
       $dataFile = 'data.txt';
       $records = [];
       if (file_exists($dataFile)) {
           // $fileContents = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
           $fileContents = file($dataFile);
       
           for ($i = 0; $i < count($fileContents); $i += 4) {
               $records[] = [
                   'title' => $fileContents[$i],
                   'description' => $fileContents[$i + 1],
                   'filePath' => $fileContents[$i + 2],
               ];
           }
       }
       
   }
}
?>
<?php if(isset($hide)){ ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Sr. No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">View Uploaded File</th>
      <!-- <th scope="col">Delete</th> -->
    </tr>
  </thead>
  <tbody>
            <?php foreach ($records as $index => $record){ ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <!-- <td><?//php echo htmlspecialchars($record['title']); ?></td> -->
                <td><?php echo $record['title']; ?></td>
                <td><?php echo $record['description']; ?></td>
                <td>
                    <?php if (empty($record['filePath']) || ($record['filePath'] != "No File Submitted")){ ?>
                        <a href="<?php echo $record['filePath']; ?>" target="_blank">View File</a>
                        <?php }
                        else{ ?>
                        No file uploaded
                    <?php } ?>
                </td>
                <!-- <td>
                    <a href="records.php?delete=<?//php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                </td> -->
            </tr>
            <?php } ?>
        </tbody>
</table>

<?php } ?>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
