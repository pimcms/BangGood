<!doctype html>
<html lang="en">
<?php
    if(!class_exists("Product")){
        require_once(dirname(__FILE__)."/../model/Product/Product.php");
    }
    if(!function_exists('upload_image'))
    {
        include(dirname(__FILE__)."/../helper_functions.php");
    }
    if(isset($_POST['pro_submit']))
    {
            //$pro=new Product();
            // $cat_id     =$_POST['pro_cat'];
            // $name       =$_POST['pro_name'];
            // $mrp        =$_POST['pro_price'];
            // //echo htmlspecialchars($description);
            // $tags       =$_POST['pro_tags'];
            // $discount   =$_POST['pro_discount'];
            // $qty        =$_POST['pro_quantity'];
            /*$errors = array();
            $uploadedFiles = array();
            $extension = array("jpeg","jpg","png","gif");
            $bytes = 1024;
            $KB = 1024;
            $totalBytes = $bytes * $KB;
            $UploadFolder = "./images";
            $imagesDB="";
            $counter = 0;
            
            foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
                $temp = $_FILES["files"]["tmp_name"][$key];
                $name = $_FILES["files"]["name"][$key];
                if(empty($temp)){break;}
                
                $counter++;
                $UploadOk = true;
                
                if($_FILES["files"]["size"][$key] > $totalBytes)
                {
                    $UploadOk = false;
                    array_push($errors, $name." file size is larger than the 1 MB.");
                }
                
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if(in_array($ext, $extension) == false){
                    $UploadOk = false;
                    array_push($errors, $name." is invalid file type.");
                }
                
                if(file_exists($UploadFolder."/".$name) == true){
                    $UploadOk = false;
                    array_push($errors, $name." file is already exist.");
                }
                
                if($UploadOk == true){
                    move_uploaded_file($temp,".".$UploadFolder."/".$name);
                    //echo $UploadFolder."/".$name;
                    array_push($uploadedFiles, $UploadFolder."/".$name);
                }
            }
            if($counter>0){
                if(count($errors)>0)
                {
                    echo "<b>Errors:</b>";
                    echo "<br/><ul>";
                    foreach($errors as $error)
                    {
                        echo "<li>".$error."</li>";
                    }
                    echo "</ul><br/>";
                }
                //print_r($uploadedFiles);
                $imagesDB=serialize($uploadedFiles);
                //echo "<br>";
                //print_r($imagesDB);
                //$imagesDB=Unserialize($imagesDB);echo "<br>";
                //print_r($imagesDB);
            }
            else{
                echo "Please, Select file(s) to upload.";
            }*/
			
			$images_uploaded = array();
			
			$images_uploaded = upload_multiple_image($_FILES["fileUpload"]);
			//print_r($images_uploaded);
			$imagesDB = serialize($images_uploaded);
			//echo "<br>".$imagesDB;
            $description=$_POST['pro_discription'];
            $description = preg_replace("/\s+|\n+|\r/", ' ', $description);
            $can_buy    =$_POST['pro_canbuy'];
            if($can_buy=='on') $can_buy=1;

            
            $args = [
                "name" =>$_POST['pro_name'],
                "cat_id" =>$_POST['pro_cat'],
                "mrp" =>$_POST['pro_price'],
                "discount" => $_POST['pro_discount'],
                "description" => ".".$description,
                "images" => $imagesDB,
                "qty" => $_POST['pro_quantity'],
                "can_buy" => $can_buy,
                "tags"=> $_POST['pro_tags'],
                "brand"=>$_POST['pro_brand']
            ];

            /*secho "<br>".$cat_id     ;echo "<br>".$name       ;echo "<br>".$mrp        ;
            echo htmlspecialchars($strDesc);echo "<br>".$tags       ;echo "<br>".$discount   ;echo "<br>".$qty        ;echo "<br>".$can_buy    ;*/
            //$pro->addProduct($name,$cat_id,$mrp,$discount,$description,$images,$qty,$can_buy,$tags);
            $result_set=addProduct($args);
            //echo $result_set;
    }
?>
<?php  $title = "Add Product"; ?>

<!-- top-header -->
<?php	require_once('header.php');?>
<!-- //top-header -->

<!-- navigation -->
<?php require_once('nevigation.php');?>
<!-- //navigation -->


    
    

<!-- Form -->
<div class="ads-grid col-md-12 col-xs-12">
    <div class="container-fluid">
        <h3 class="tittle-w3l text-center col-md-12 col-xs-12">
            <span>A</span>dd
            <span>N</span>ew
            <span>P</span>roduct</h3>
        <div class="row">
            <div class="wrapper col-md-12 col-xs-12">
                <div class="product-sec1 px-sm-4 px-4 py-sm-4 py-4 mb-4">
                    <div class="row">
                        <div class="col-md-12 product-men mt-5">
                            <form action="addProduct.php" method="post" enctype="multipart/form-data">
                                <div class="form-group form-inline">
                                    <label class="col-form-label">Category&nbsp;</label>
                                    <select class="form-control custom-select form-control-sm-2" name="pro_cat" id="" onChange="brandLoad(this)"
                                        required="true">
                                        <option value=0>Select Category</option>
                                        <option value=1>Mobile</option>
                                        <option value=2>Laptop</option>
                                        <option value=3>Accessories</option>
                                    </select>
                                    <div id="brand_dropdown" class="form-group form-inline" > 
                                    &nbsp;
                                    <label for="" class="col-form-label"> Brand :</label>
                                    <select class="form-control form-control-sm-2 custom-select" name="pro_brand" id="" required="true">
                                        <option selected>Select Brand</option>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-form-label">Name</label>
                                    <input type="text" class="form-control" placeholder=" " name="pro_name" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Price</label>
                                    <input type="number" class="form-control" placeholder=" " name="pro_price"
                                        required="">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Discription</label>
                                    <textarea type="text" class="form-control" name="pro_discription"
                                        required=""></textarea>
                                    <script type="text/javascript">
                                        CKEDITOR.replace('pro_discription', { //fullPage : true,
                                            //uiColor : '#efe8ce'
                                        });
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Tags</label>
                                    <input type="text" class="form-control" placeholder=" " name="pro_tags" required>
                                </div>
                                <div class="form-group">
                                        <label class="control-label col-md-8">Upload Image</label>
                                        <div class="col-md-12">
                                            <div class="row" id="coba">
                                            </div>
                                        </div>
                                    </div>
                                <!--<div class="form-group">
                                    <label class="col-form-label">Images</label>
                                    <input type="file" class="form-control" placeholder=" " multiple="multiple"
                                        name="files[]" id="fileupload" required="">
                                    <div id="dvPreview"></div>-->


                                <div class="form-group form-inline col-md-4 col-md-12">
                                    <label class="col-form-label  px-sm-0">Disount&nbsp;</label>
                                    <input type="number" class="form-control" placeholder=" " min="0" max="80"
                                        name="pro_discount" required>

                                    <label class="col-form-label px-sm-4">Quantity</label>
                                    <input type="number" class="form-control" placeholder=" " min="1" max="80"
                                        name="pro_quantity" required>

                                    <div class="form-check">
                                        <label class="form-check-label px-sm-4">Can Buy -
                                            <input type="checkbox" class="form-control  form-check-input"
                                                name="pro_canbuy" id="">
                                        </label>
                                    </div>
                                </div>
                                <div class="right-w3l">
                                    <input type="submit" class="form-control" name="pro_submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //form -->

<script type="text/javascript" src="dist/js/spartan-multi-image-picker.js"></script>
	<script type="text/javascript">
		$("#coba").spartanMultiImagePicker({
				fieldName:        'fileUpload[]',
				maxCount:         5,
				rowHeight:        '200px',
				groupClassName:   'col-md-4 col-sm-4 col-xs-6',
				maxFileSize:      '',
				placeholderImage: {
				    image: 'placeholder.png',
                	width : '100%'
				},
				dropFileLabel : "Drop Here",
				onAddRow:       function(index){
					console.log(index);
					console.log('add new row');
				},
				onRenderedPreview : function(index){
					console.log(index);
					console.log('preview rendered');
				},
				onRemoveRow : function(index){
					console.log(index);
				},
				onExtensionErr : function(index, file){
					console.log(index, file,  'extension err');
					alert('Please only input png or jpg type file')
				},
				onSizeErr : function(index, file){
					console.log(index, file,  'file size too big');
					alert('File size too big');
				}
			});
	
	</script>

<!-- footer -->
<?php require_once('footer.php');?>
<!-- //footer -->
<script language="javascript" type="text/javascript">
    window.onload = function () {
        // var fileUpload = document.getElementById("fileupload");
        // fileUpload.onchange = function () {
        //     if (typeof (FileReader) != "undefined") {
        //         var dvPreview = document.getElementById("dvPreview");
        //         dvPreview.innerHTML = "";
        //         var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        //         for (var i = 0; i < fileUpload.files.length; i++) {
        //             var file = fileUpload.files[i];
        //             if (regex.test(file.name.toLowerCase())) {
        //                 var reader = new FileReader();
        //                 reader.onload = function (e) {
        //                     var img = document.createElement("IMG");
        //                     img.height = "250";
        //                     img.width = "175";
        //                     img.src = e.target.result;
        //                     dvPreview.appendChild(img);
        //                 }
        //                 reader.readAsDataURL(file);
        //             } else {
        //                 alert(file.name + " is not a valid image file.");
        //                 dvPreview.innerHTML = "";
        //                 return false;
        //             }
        //         }
        //     } else {
        //         alert("This browser does not support HTML5 FileReader.");
        //     }
        // }
    };
    function brandLoad(cate_id) {
            var action='brand_load';
            //alert(cate_id.value)
            jQuery.ajax({
            url: "../model/Categories/Categories.php",
            type: "POST",
            data:{action:action,cate_id:cate_id.value},
            success:function(data){
            //alert(data);
            $("#brand_dropdown").html(data);
            },
            error:function (){
                alert("ERROR");
            }
            });
        }
</script>
</body>
</html>