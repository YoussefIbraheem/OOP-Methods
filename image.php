
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Images Uploader</title>
</head>
<body>
    <?php 

class UploadHandler extends Exception{
    public $imgFile , $newName , $imgTmp , $imgExt ;
    public function __construct()
    {?>
    <form action="image.php" method="POST" enctype="multipart/form-data">
        <label>Image Input</label>
        <input name='imgFile' type="file" multiple>
        <br>
        <label for="">file name</label>
        <input name='newName' type="text">
        <br>
        <button name="upload" type="submit" class="btn btn-outline-primary">Upload</button>
    </form>
     <?php
    }

    public function validate(){
        if(isset($_POST['upload'])){
            $this->imgfile = $_FILES['imgFile'] ;
            $imgName = $this->imgfile['name'];
            $this->imgTmp = $this->imgfile['tmp_name'];
            $this->imgExt = strtolower(pathinfo($imgName,PATHINFO_EXTENSION)) ;
            $imgSizeMB = ($this->imgfile['size'])/(1024*1024);
            if(!isset($this->imgfile)){
                throw new Exception("please enter file");
            }elseif(!isset($imgName)){
                throw new Exception("please enter file name") ;
            }elseif ( $imgSizeMB > 5) {
                throw new Exception("please ensure that the file doesn't exceed 5MB") ;
            }elseif (empty($_POST['newName'])) {
                throw new Exception("please enter file name")  ;
            }elseif (!in_array($this->imgExt,["jpg","jpeg","gif","png"])) {
                throw new Exception("please make sure to adhere to photo only formate") ;
            }else{
                return true ;
            }
         
        
        }
    }

public function rename(){
    if($this->validate()){
        $this->newName = $_POST['newName'].".".$this->imgExt ;
        return true;
    }
}

public function upload(){
    if ($this->rename()) {
        move_uploaded_file($this->imgTmp,"images/$this->newName");
    }

}


}

try{
    $imageHandler = new UploadHandler;
    $imageHandler->validate();
    $imageHandler->rename();
    $imageHandler->upload();
}catch(Exception $error){
   echo "<div class='alert alert-danger w-50 m-auto'><ul><li>".$error->getMessage()."</li></ul></div>";
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
   
