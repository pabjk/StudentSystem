<?php
/*SERVER CODE*/
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("location:nopermission.php");
}
require_once '../function.php';
$db = new DataSourceResult();
if (isset($_POST) && !empty($_POST)):
/*BEGIN*/
    switch ($_POST['mode']):
    case 'import':
        try {
            ini_set('auto_detect_line_endings',TRUE);
            $handle = fopen($_FILES["file"]["tmp_name"],'r');
            while ( ($data = fgetcsv($handle) ) !== FALSE ) {
                $value['userID'] = $data[0];
                $value['userTypeID'] = $data[1];
                $value['userCode'] = $data[2];
                $value['classGroup'] = $data[3];
                $value['fullName'] = $data[4];
                $value['email'] = $data[5];
                $salt = md5(time());
                $passhash = md5($data[6] . $salt);
                $value['password'] = $passhash . $salt;
                $value['mbti'] = $data[7];
                $value['setting'] = $data[8];
                $value['status'] = $data[9];
                $request = json_decode(json_encode($value), false);
                $result = $db->create('user', array_keys($value), $request, 'userID');
            }
            unlink($_FILES["file"]["tmp_name"]);
            ini_set('auto_detect_line_endings',FALSE);
        } catch (Exception $e) {
            print_r($e->getMessage());
        } finally{
            echo 1;
        }
        break;

    case 'selectAllUserType':
        try {
                $value['userTypeID'] = null;
                $value['userType'] = null;
                $value['status'] = null;
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('user_type', array_keys($value), $request);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllClassGroup':
        try {
            $sql = "select distinct(classGroup) from registration_information";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllUser':
        try {
            $value['us.userID'] = null;
            $value['us.userTypeID'] = null;
            $value['ut.userType'] = null;
            $value['us.userCode'] = null;
            $value['us.classGroup'] = null;
            $value['us.fullName'] = null;
            $value['us.email'] = null;
            $value['us.mbti'] = null;
            $value['us.status'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('user us left outer join user_type ut on ut.userTypeID=us.userTypeID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'verifyEmail':
        try {
            $strsql = "select * from user where email='" . $_POST['email'] . "'";
            $data = $db->select($strsql);
            if ($data['total'] != 0) {
                echo 0;
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'insert':
        try {
            $value['userTypeID'] = $_POST['userTypeID'];
            $value['userCode'] = $_POST['userCode'];
            $value['classGroup'] = $_POST['classGroup'];
            $value['fullName'] = $_POST['fullName'];
            $value['email'] = $_POST['email'];
            if (!empty($_POST['password'])) {
                $salt = md5(time());
                $passhash = md5($_POST['password'] . $salt);
                $value['password'] = $passhash . $salt;
            }
            $value['mbti'] = $_POST['mbti'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->create('user', array_keys($value), $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'update':
        try {
            $value['userID'] = $_POST['userID'];
            $value['userTypeID'] = $_POST['userTypeID'];
            $value['userCode'] = $_POST['userCode'];
            $value['classGroup'] = $_POST['classGroup'];
            $value['fullName'] = $_POST['fullName'];
            if (!empty($_POST['password'])) {
                $salt = md5(time());
                $passhash = md5($_POST['password'] . $salt);
                $value['password'] = $passhash. $salt;
            }
            $value['mbti'] = $_POST['mbti'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->update('user', array_keys($value), $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo true;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'delete':
        try {
            $value['userID'] = $_POST["userID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('user', $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo true;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
        endswitch;
/*END BEGIN*/
        unset($db);
        exit();
    endif;
/*END SERVER CODE*/
    ?>
<!doctype html>
<html lang="<?=$_SESSION['setting']['lang']?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3Spines">
    <meta name="author" content="3Spines">
    <title>Student Grouping System | Sign in</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../kendoui/styles/kendo.common-material.min.css" />
    <link rel="stylesheet" href="../kendoui/styles/kendo.material.min.css" />
    <link rel="stylesheet" href="../kendoui/styles/kendo.material.mobile.min.css" />

    <link href="style.css" rel="stylesheet">
    <style>
    </style>
</head>

<body>
    <?php require_once 'header.php';?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once 'nav.php';?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?=$_SESSION['setting']['lang'] == 'en' ? 'User' : 'ข้อมูลผู้ใช้งานระบบ';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <?=$_SESSION['setting']['lang'] == 'en' ? 'User' : 'ข้อมูลผู้ใช้งานระบบ';?>
                        </li>
                    </ol>
                </nav>
                <div id="data-grid"></div>
                <div class="card mt-4">
                    <div class="card-body">
                        <form class="row g-3" id="scriptForm">
                            <div class="col-md-3">
                                <label for="userTypeID"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'User type' : 'ประเภทผู้ใช้';?>*</label>
                                <div class="col">
                                    <input type="text" id="userTypeID" name="userTypeID" style="width:100%" required
                                        validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please select user type.' : 'กรุณาเลือกประเภทผู้ใช้';?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="userCode"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'User Code' : 'รหัสนักศึกษา/รหัสอาจารย์';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="userCode" name="userCode"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="classGroup"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Section' : 'กลุ่มเรียน';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="classGroup" name="classGroup"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fullName"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Full name' : 'ชื่อ สกุล';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="fullName" name="fullName"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="email"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Email' : 'อีเมล';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="email" name="email" style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="password"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Password' : 'รหัสผ่าน';?></label>
                                <div class="col">
                                    <input type="password" class="k-textbox" id="password" name="password"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="mbti"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'MBTI' : 'รูปแบบบุคคลิกภาพ';?></label>
                                <div class="col">
                                    <input type="password" class="form-control" id="mbti" name="mbti"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                        checked="checked">
                                    <label class="form-check-label" for="status">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Active' : 'ใช้งาน';?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="k-button k-primary"><span
                                        class="material-icons">save</span><?=$_SESSION['setting']['lang'] == 'en' ? 'Save' : 'บันทึก';?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="loader-wrapper" style="display:none">
        <div class="loader"></div>
    </div>
    <script src="../kendoui/js/jquery.min.js"></script>
    <script src="../jquery.form.min.js"></script>
    <script src="../kendoui/js/kendo.all.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="function.js"></script>
    <script type="text/x-kendo-template" id="toolbar">
        <div >
            <button type="button" class="k-button k-primary" id="btn-add"><span class="material-icons">add</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Add" : "เพิ่ม" ?></button>
            <button type="button" class="k-button k-primary" id="btn-edit"><span class="material-icons">edit</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Edit" : "แก้ไข" ?></button>
            <button type="button" class="k-button k-primary" id="btn-delete"><span class="material-icons">delete</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Del" : "ลบ" ?></button>
            <button type="button" class="k-button k-primary" id="btn-cancel"><span class="material-icons">cancel</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Cancel" : "ยกเลิก" ?></button>
            <button type="button" class="k-button k-primary" id="btn-upload"><span class="material-icons">send</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Import CSV" : "นำเข้าข้อมูล CSV" ?></button>
            <form id="formupload"><input type="file" id="file" name="file" style="display:none;" /></form>
            <input type="text" id="search" class="k-textbox">
            <button type="button" class="k-button k-primary" id="btn-search"><span class="material-icons">search</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Search" : "ค้นหา" ?></button>
        </div>
        <div style="margin-left: auto;margin-right: 0;">
            <label style="vertical-align: middle;" for="userType"><?=$_SESSION['setting']['lang'] == 'en' ? "Show user by type" : "แสดงข้อมูลตามประเภทผู้ใช้"?>:</label>
            <input type="search" id="userType" style="width: 150px"/>
        </div>

    </script>
    <script>
    var page = new page();
    $(function() {
        page.initial();
        page.eventhandle();
        page.validation();
    });

    function page() {
        this.validator;
        this.options;
        this.mode = "insert";
        this.userTypeID = "";
        this.mbti;
        page.prototype.initial = function() {
            ajax("../var.json", "Get", "json", ({}), false, false, function(data) {
                page.mbti = data;
            });
            $('#data-grid').kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            dataType: 'json',
                            type: 'POST',
                            data: ({
                                mode: 'selectAllUser'
                            }),
                            url: '<?=$_SERVER['PHP_SELF']?>'
                        }
                    },
                    dataType: 'json',
                    autoSync: false,
                    pageSize: 5,
                    schema: {
                        data: 'data',
                        total: 'total'
                    },
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                    sort: {
                        field: "us.userID",
                        dir: "desc"
                    }
                },
                // groupable: true,
                resizable: true,
                filterable: true,
                reorderable: true,
                sortable: true,
                columnMenu: true,
                selectable: 'row',
                pageable: {
                    pageSizes: true,
                    refresh: true,
                    buttonCount: 5
                },
                columns: [{
                        field: 'userID',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "User ID" : "รหัสลำดับข้อมูลผู้ใช้"?>',
                        id: "us.userID"
                    },
                    // {
                    //     field: "userTypeID",
                    //     hidden: true,
                    //     id: "ut.userTypeID"
                    // },
                    {
                        field: 'userType',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "User type" : "ประเภทผู้ใช้"?>',
                        id: "ut.userType"
                    },
                    {
                        field: 'userCode',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "User Code" : "รหัสนักศึกษา/รหัสอาจารย์"?>',
                        id: "us.userCode"
                    },
                    {
                        field: 'classGroup',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Section" : "กลุ่มเรียน"?>',
                        id: "us.classGroup"
                    },
                    {
                        field: 'fullName',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Fullname" : "ชื่อ สกุล" ?>',
                        id: "us.fullName"
                    },
                    {
                        field: 'email',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Email" : "อีเมล" ?>',
                        id: "us.email"
                    },
                    {
                        field: 'mbti',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "mbti" : "รูปแบบบุคคลิกภาพ" ?>',
                        id: "us.mbti"
                    },
                    {
                        field: 'status',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Status" : "สถานะ" ?>',
                        template: '#=status==1?"<?=$_SESSION['setting']['lang'] == 'en' ? "Active" : "เปิดใช้งาน" ?>":"<?=$_SESSION['setting']['lang'] == 'en' ? "Inactive" : "ระงับการใช้" ?>"#',
                        id: "us.status"
                    },
                ],
                dataBound: function() {
                    var grid = this;
                    for (var i = 0; i < grid.columns.length; i++) {
                        grid.autoFitColumn(i);
                    }
                },
                change: function(e) {
                    var selectedItem = this.dataItem(this.select());
                    if (selectedItem) {
                        page.bindData(selectedItem);
                    }
                },
                toolbar: kendo.template($("#toolbar").html())
            });
            $("#userTypeID").kendoDropDownList({
                optionLabel: "<?=$_SESSION['setting']['lang'] == 'en' ? "Select user type..." : "เลือกประเภทผู้ใช้" ?>",
                dataTextField: "userType",
                dataValueField: "userTypeID",
                dataSource: {
                    transport: {
                        read: {
                            dataType: "json",
                            type: "POST",
                            data: ({
                                mode: 'selectAllUserType'
                            }),
                            url: '<?=$_SERVER['PHP_SELF']?>'
                        }
                    },
                    schema: {
                        data: "data",
                        total: "total"
                    },
                    serverFiltering: true,
                    filter: [{
                        field: "status",
                        operator: "eq",
                        value: '1'
                    }]
                },
                change: function(e) {
                    if (this.value() == '3') {
                        $('#userCode').attr('maxlength', 11).val('');
                    } else {
                        $('#userCode').removeAttr("maxlength").val('');
                    }
                }
            });

            $("#mbti").kendoDropDownList({
                optionLabel: "<?=$_SESSION['setting']['lang'] == 'en' ? "Select MBTI type..." : "เลือกรูปแบบบุคคลิกภาพ" ?>",
                dataTextField: "type",
                dataValueField: "type",
                dataSource: page.mbti.cover_bg,
                index: 0
            });
            $("#userCode").on('change', function() {
                $("#password").val(this.value);
            });
            $("#classGroup").kendoAutoComplete({
                dataTextField: "classGroup",
                dataSource: {
                    transport: {
                        read: {
                            dataType: "json",
                            type: "POST",
                            data: ({
                                mode: 'selectAllClassGroup'
                            }),
                            url: '<?=htmlspecialchars($_SERVER['PHP_SELF']); ?>'
                        }
                    },
                    schema: {
                        data: "data",
                        total: "total"
                    }
                },
                filter: "startswith",
                placeholder: "<?=$_SESSION['setting']['lang'] == 'en' ? "Enter Section" : "พิมพ์กลุ่มเรียน"?>",

            });
        }
        page.prototype.bindData = function(selectedItem) {
            page.mode = "update";
            page.userID = selectedItem.userID;
            //$("#userTypeID").data("kendoDropDownList").value(selectedItem.userTypeID);
            $('#userTypeID').data('kendoDropDownList').select(function(dataItem) {
                return dataItem.userTypeID === selectedItem.userTypeID;
            });
            $('#userCode').val(selectedItem.userCode);
            $('#classGroup').data("kendoAutoComplete").value(selectedItem.classGroup);
            $('#fullName').val(selectedItem.fullName);
            $('#email').val(selectedItem.email).prop('readonly', true);
            $('#mbti').data("kendoDropDownList").value(selectedItem.mbti);
            setCHKValue('status', selectedItem.status);
        }
        page.prototype.eventhandle = function() {
            $('#btn-upload').click(function() {
                $('#file').click();
                $('#file').change(function(e){
                    var options = {
                        success: function(response) {
                            $('.loader-wrapper').hide();
                            if ($.trim(response) == true) {
                                kendo.alert(
                                    '<?=$_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                                );
                                page.reloaddata();
                            } else {
                                kendo.alert(response);
                            }
                        },
                        type: 'POST',
                        data: {
                            mode: 'import',
                        },
                        resetForm: true
                    };
                    $("#formupload").ajaxSubmit(options);
                });
                
            });
            $('#btn-add').click(function() {
                if ($('#btn-add').prop('disabled')) return;
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', 'disabled');
                page.clearform();
            }); //btn-add
            $('#btn-edit').click(function() {
                if ($('#btn-edit').prop('disabled')) return;
                var list = $('#data-grid').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', 'disabled');
                page.bindData(selectedItem);
            }); //btn-edit
            $("#btn-delete").click(function() {
                if ($("#btn-delete").prop("disabled")) return;
                var list = $('#data-grid').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                if (selectedItem == null) {
                    kendo.alert(
                        '<?=$_SESSION['setting']['lang'] == 'en' ? "Please select the record you want to delete." : "กรุณาเลือกรายการที่ต้องการลบ" ?>'
                    );
                    return;
                }
                if (selectedItem.email == 'admin@admin') {
                    kendo.alert(
                        '<?=$_SESSION['setting']['lang'] == 'en' ? "Cannot delete adminstrator record!" : "ไม่สามารถลบรายการผู้ดูแลระบบ" ?>'
                    );
                    return;
                }
                kendo.confirm(
                        "<?php echo $_SESSION['setting']['lang'] == 'en' ? "Are you sure?" : "ยืนยันการลบ" ?>"
                    )
                    .then(function() {
                        ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                            mode: 'delete',
                            userID: selectedItem.userID
                        }), true, true, function(response) {
                            if (response == true) {
                                kendo.alert(
                                    '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                                );
                            } else {
                                kendo.alert(response);
                            }
                            page.clearform();
                        });
                    });
            }); //btn-delete
            $("#btn-cancel").click(function() {
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', '');
                page.clearform();
            }); //btn-cancel
            $("#scriptForm").submit(function(e) {
                e.preventDefault();
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', '');
                var options = {
                    success: function(response) {
                        $('.loader-wrapper').hide();
                        if ($.trim(response) == true) {
                            kendo.alert(
                                '<?=$_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                            );
                            page.reloaddata();
                        } else {
                            kendo.alert(response);
                        }
                    },
                    type: 'POST',
                    data: {
                        mode: page.mode,
                        userID: page.userID
                    },
                    resetForm: true
                };
                if (page.validator.validate()) {
                    $('.loader-wrapper').show();
                    $("#scriptForm").ajaxSubmit(options);
                }

            });
            $('#btn-search').click(function() {
                var searchstring = $('#search').val().toUpperCase();
                var kgrid = $('#data-grid').data('kendoGrid');
                var searchword = searchstring.split(" ");
                if (searchstring) {
                    var orfilter = {
                        logic: 'or',
                        filters: []
                    };
                    var andfilter = {
                        logic: 'and',
                        filters: []
                    };
                    $.each(searchword, function(i, v) {
                        if (v.trim() != '') {
                            $.each(searchword, function(i, v1) {
                                if (v1.trim() != '') {
                                    $.each(kgrid.columns, function(key, column) {
                                        orfilter.filters.push({
                                            field: column.id,
                                            operator: 'contains',
                                            value: v1
                                        });
                                    });
                                    andfilter.filters.push(orfilter);
                                    orfilter = {
                                        logic: 'or',
                                        filters: []
                                    };
                                }
                            });
                        }
                    });
                    kgrid.dataSource.filter(andfilter);
                } else {
                    kgrid.dataSource.filter({});
                }
            }); //btn-search
        }
        page.prototype.validation = function() {
            page.validator = $('#scriptForm').kendoValidator({
                rules: {
                    requireEmail: function(input) {
                        page.ret = true;
                        if (input.is('#email')) {
                            if ($.trim(input.val()) == '') page.ret = false;
                        }
                        return page.ret;
                    },
                    validEmail: function(input) {
                        page.ret = true;
                        if (input.is('#email')) {
                            if (input.val().match(
                                    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
                                )) {
                                page.ret = true;
                            } else {
                                page.ret = false;
                            }
                        }
                        return page.ret;
                    },
                    verifyEmail: function(input) {
                        page.ret = true;
                        if (input.is('#email')) {
                            ajax('<?=$_SERVER['PHP_SELF']?>', 'POST', "json", ({
                                mode: 'verifyEmail',
                                email: input.val()
                            }), false, true, function(response) {
                                page.ret = response;
                            }, true);
                        }
                        if (page.mode == 'update') page.ret = true;
                        return page.ret;
                    },
                },
                messages: {
                    requireEmail: "<?=$_SESSION['setting']['lang'] == 'en' ? "Please enter email." : "กรุณาพิมพ์อีเมล" ?>",
                    validEmail: "<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter valid email.' : 'กรุณาพิมพ์อีเมลที่ถูกต้อง';?>",
                    verifyEmail: "<?=$_SESSION['setting']['lang'] == 'en' ? "This email has already been used!" : "มีผู้ใช้อีเมลนี้แล้ว" ?>",
                }
            }).data("kendoValidator");
        }
        page.prototype.clearform = function() {
            HTMLFormElement.prototype.reset.call($('#scriptForm')[0]);
            page.reloaddata();
            $('#email').prop('readonly', false);
        }
        page.prototype.reloaddata = function() {
            page.mode = "insert";
            page.userTypeID = "";
            $('#search').val('');
            $('#email').prop('readonly', false);
            $('#data-grid').data('kendoGrid').dataSource.filter({});
            $('#data-grid').data('kendoGrid').dataSource.read();
            $('#data-grid').data('kendoGrid').refresh();
            $('#data-grid').data('kendoGrid').clearSelection();
        }
    }
    </script>
</body>

</html>