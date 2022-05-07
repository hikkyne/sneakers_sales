<?php
// require '../root/checklogin.php';
?>

<?php
require_once '../db.php';
require_once '../func.php';
?>

<?php
$query = 'SELECT id, name FROM manufacture';
$manufacture_list = get_list($query);
// print_r($manufacture_list );
?>

<?php
$query = 'SELECT id, name FROM type';
$type_list = get_list($query);
// print_r($type_list );
?>


<!DOCTYPE html>
<html>
</div>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
    <link rel="stylesheet" href="../css/cssdb.css">
    <link rel="stylesheet" href="../css/cssmf.css">
    <link rel="stylesheet" href="../css/toast.css?v=2">
    <!-- <script src="../js/previewImg.js"></script> -->
    <!-- icon -->
    <script src="https://kit.fontawesome.com/945e1fd97f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #result {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px 0;
        }

        .thumbnail {
            height: 192px;
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="container-header">
            <?php include '../root/header.php' ?>
        </div>
        <div class="container-siderbar">
            <?php include '../root/sidebar.php' ?>

        </div>

        <div class="container-main">

            <div class="container">
                <div class="tag-name">
                    <a href="./index.php">
                        <h2> <span class="fa fa-arrow-circle-left"></span> Thêm sản phẩm</h2>


                        <br>

                    </a>
                </div>

            </div>
            <div class="container-content">

                <div id="toast">

                </div>

                <script src="../js/toast.js"></script>



                <div class="form-content">
                    <p><?php  ?></p>

                    <form action="" method="POST" enctype="multipart/form-data" id="uploadFrom">
                        <input type="text" name="token" hidden value="<?php echo $token = uniqid("product" . '_', true); ?>">
                        <p>Nhập tên sản phẩm </p>
                        <input type="text" name="name" placeholder="Nhập tên sản phẩm" required>
                        <p>Hình ảnh sản phẩm</p>

                        <!-- background -->
                        <div id="image-product-upload">
                            <label for="image-product"> <i class="fas fa-upload"></i>Tải ảnh lên </label>
                            <input type="file" name="files[]" multiple="multiple" multiple accept="image/jpeg, image/png, image/jpg" id="image-product" hidden>
                        </div>
                        <output id="result"></output>



                        <br>
                        <p>Giá bán </p>
                        <input type="text" name="cost" placeholder="" required>
                        <p>Số lượng </p>
                        <input type="text" name="quantity" placeholder="Nhập số lượng" required>
                        <p> Loại sản phẩm</p>
                        <select name="type" id="type" class="select-1">
                            <?php foreach ($type_list as $post) { ?>
                                <option value="<?php echo $post['id'] ?>"> <?php echo $post['name'] ?> </h1>
                                <?php } ?>
                        </select>
                        <p> Nhà sản xuất</p>
                        <select name="manufacture" id="manufacture" class="select-1">
                            <?php foreach ($manufacture_list as $post) { ?>
                                <option value="<?php echo $post['id'] ?>"> <?php echo $post['name'] ?> </option>
                            <?php } ?>
                        </select>
                        <p>Ngày thêm</p>
                        <input type="date" name="date" id="datePicker" required readonly>
                        <p>Mô tả</p>
                        <textarea name="description" cols="170" rows="10" id="txarea"></textarea>

                        <div class="table-button">
                            <div class="btn-ok">
                                <button type="submit" id="btn-update"> OK </button>
                            </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    </div>
</body>
<script type="text/javascript">
    document.getElementById('datePicker').valueAsDate = new Date();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#uploadFrom").on('submit', (function(e) {
            e.preventDefault();
            var submit = 0;
            var name = $('input[name="name"]').val();
            var image = $('input[name="files[]"]').val();
            var cost = parseInt($('input[name="cost"]').val());
            var quantity = parseInt($('input[name="quantity"]').val());
            var type = $('#type').val();
            var manufacture = $('#manufacture').val();
            var date = $('input[name="date"]').val();
            var description = $('#txarea').val();
            if (cost / cost !== 1) {
                // var submit = new Boolean(false);
                showErrorToast("Nhập ngu vl thế", " Kiểm tra chổ GIÁ BÁN kìa bạn ơi!");
                submit += 1;

            }
            if (image == null) {
                // var submit = new Boolean(false);
                showErrorToast("VCL", " Có cái ảnh mà cũng thiếu đm");
                submit += 1;
            }
            if (quantity / quantity !== 1) {
                // var submit = new Boolean(false);
                showErrorToast("Nhập ngu vl thế", " Kiểm tra chổ SỐ LƯỢNG kìa bạn ơi!");
                submit += 1;
            }
            if (name == null || type == null || manufacture == null || date == null || description == null) {
                // var submit = new Boolean(false);
                showErrorToast("Thất bại!", "Đã có lỗi xảy ra ⊙﹏⊙∥");
                submit += 1;
            }
            if (submit === 0) {
                $.ajax({
                    url: "../process_root/productadd.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    // success: function(response) {
                    //     $('#uploadFrom').find('input').val('');
                    //     $('#uploadFrom').find('textarea').val('');
                    //     showSuccessToast("Thành công", "Thêm thành công sản phẩm!")
                    // },
                }).done(function(data) {
                    if (data == 1) {
                        $('#uploadFrom').find('input[type="text"]').val('');
                        $('#uploadFrom').find('textarea').val('');
                        showSuccessToast("Thành công", "Thêm thành công sản phẩm!")
                    } else if (data == 0) {
                        showErrorToast("Thất bại", "Đã có lỗi xãy ra zui lòng kiểm tra lại ⊙﹏⊙∥!")
                    }

                });
            }

        }));
    });
</script>
<script>
    function showSuccessToast(type, message) {
        toast({
            title: type,
            message: message,
            type: "success",
            duration: 5000
        });
    }

    function showErrorToast(type, message) {
        toast({
            title: type,
            message: message,
            type: "error",
            duration: 5000
        });
    }
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script>
    document.querySelector("#image-product").addEventListener("change", (e) => { //CHANGE EVENT FOR UPLOADING PHOTOS
        if (window.File && window.FileReader && window.FileList && window.Blob) { //CHECK IF FILE API IS SUPPORTED
            const files = e.target.files; //FILE LIST OBJECT CONTAINING UPLOADED FILES
            const output = document.querySelector("#result");
            output.innerHTML = "";
            for (let i = 0; i < files.length; i++) { // LOOP THROUGH THE FILE LIST OBJECT
                if (!files[i].type.match("image")) continue; // ONLY PHOTOS (SKIP CURRENT ITERATION IF NOT A PHOTO)
                const picReader = new FileReader(); // RETRIEVE DATA URI 
                picReader.addEventListener("load", function(event) { // LOAD EVENT FOR DISPLAYING PHOTOS
                    const picFile = event.target;
                    const div = document.createElement("div");
                    div.innerHTML = `<img class="thumbnail" src="${picFile.result}" title="${picFile.name}"/>`;
                    output.appendChild(div);
                });
                picReader.readAsDataURL(files[i]); //READ THE IMAGE
            }
        } else {
            alert("Your browser does not support File API");
        }
    });
</script>

</html>