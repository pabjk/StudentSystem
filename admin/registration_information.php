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
    case 'selectAllRegistrationInformation':
        try {
            $value['ri.regisID'] = null;
            $value['ri.courseID'] = null;
            $value['ci.courseCode'] = null;
            $value['ci.courseName'] = null;
            $value['ri.userID'] = null;
            $value['us.fullName'] = null;
            $value['ri.classGroup'] = null;
            $value['ri.year'] = null;
            $value['ri.semester'] = null;
            $value['ri.status'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('registration_information ri left outer join course_information ci on ri.courseID=ci.courseID left outer join user us on ri.userID=us.userID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllCourseCode':
        try {
            $value['courseID'] = null;
            $value['courseCode'] = null;
            $value['courseName'] = null;
            $value['status'] = null;
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('course_information', array_keys($value), $request);
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
    case 'insert':
        try {
            $value['courseID'] = $_POST['courseID'];
            $value['userID'] = $_POST['userID'];
            $value['classGroup'] = $_POST['classGroup'];
            $value['year'] = $_POST['year'];
            $value['semester'] = $_POST['semester'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->create('registration_information', array_keys($value), $request, 'regisID');
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
            $value['regisID'] = $_POST['regisID'];
            $value['courseID'] = $_POST['courseID'];
            $value['userID'] = $_POST['userID'];
            $value['classGroup'] = $_POST['classGroup'];
            $value['year'] = $_POST['year'];
            $value['semester'] = $_POST['semester'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->update('registration_information', array_keys($value), $request, 'regisID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'delete':
        try {
            $value['regisID'] = $_POST["regisID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('registration_information', $request, 'regisID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
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
    .dropdown-header {
        border-width: 0 0 1px 0;
        text-transform: uppercase;
    }

    .dropdown-header>span {
        display: inline-block;
        padding: 10px;
    }

    .dropdown-header>span:first-child {
        width: 50px;
    }

    .k-list-container>.k-footer {
        padding: 10px;
    }

    .selected-value {
        display: inline-block;
        vertical-align: middle;
        width: 24px;
        height: 24px;
        background-size: 100%;
        margin-right: 5px;
        border-radius: 50%;
    }

    #courseID .k-item {
        line-height: 1em;
        min-width: 300px;
    }

    /* Material Theme padding adjustment*/

    .k-material #courseID .k-item,
    .k-material #courseID .k-item.k-state-hover,
    .k-materialblack #courseID .k-item,
    .k-materialblack #courseID .k-item.k-state-hover {
        padding-left: 5px;
        border-left: 0;
    }

    #courseID .k-item>span {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: inline-block;
        vertical-align: top;
        margin: 20px 10px 10px 5px;
    }

    #courseID .k-item>span:first-child {
        -moz-box-shadow: inset 0 0 30px rgba(0, 0, 0, .3);
        -webkit-box-shadow: inset 0 0 30px rgba(0, 0, 0, .3);
        box-shadow: inset 0 0 30px rgba(0, 0, 0, .3);
        margin: 10px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-size: 100%;
        background-repeat: no-repeat;
    }

    #courseID h3 {
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 1px 0;
        padding: 0;
    }

    #courseID p {
        margin: 0;
        padding: 0;
        font-size: .8em;
    }
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
                    <h1 class="h2"><?=$_SESSION['setting']['lang'] == 'en' ? 'Register information' : 'ข้อมูลการลงทะเบียน';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item">
                            <?=$_SESSION['setting']['lang'] == 'en' ? 'Register information' : 'ข้อมูลการลงทะเบียน';?>
                        </li>
                    </ol>
                </nav>
                <div id="data-grid"></div>
                <div class="card mt-4">
                    <div class="card-body">
                        <form class="row g-3" id="scriptForm">
                            <div class="col-md-3">
                                <label for="courseID"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Course' : 'วิชา';?>*</label>
                                <div class="col">
                                    <input type="text" id="courseID" name="courseID" style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3"><label for="fullName"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Instructor' : 'ผู้สอน';?></label>
                                <div class="input-group">
                                    <input type="text" class="k-textbox" id="fullName" name="fullName"
                                        placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Select instructor' : 'ค้นหาผู้สอน';?>"
                                        readonly style="width:85%">
                                    <button class="k-button k-primary" type="button" id="btn-window"
                                        style="width:15%"><span class="material-icons">search</span></button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="classGroup"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Section' : 'กลุ่มเรียน';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="classGroup" name="classGroup"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="year"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Year' : 'ปีการศึกษา';?></label>
                                <div class="col"><input type="text" id="year" name="year" style="width:100%"> </div>
                            </div>
                            <div class="col-md-2">
                                <label for="semester"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Semester' : 'ภาคการศึกษา';?></label>
                                <div class="col"><input type="text" id="semester" name="semester" style="width:100%">
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
    <div id="windowUserID">
        <div id="data-grid-user"></div>
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
        <div class="form-row">
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-add"><span class="material-icons">add</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Add" : "เพิ่ม" ?></button>
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-edit"><span class="material-icons">edit</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Edit" : "แก้ไข" ?></button>
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-delete"><span class="material-icons">delete</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Del" : "ลบ" ?></button>
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-cancel"><span class="material-icons">cancel</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Cancel" : "ยกเลิก" ?></button>
            <input type="text" id="search" class="k-textbox">
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-search"><span class="material-icons">search</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Search" : "ค้นหา" ?></button>
        </div>
    </script>
    <script type="text/x-kendo-template" id="usertoolbar">
        <div class="form-row">
            <input type="text" id="txt-search-user" class="k-textbox">
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-search-user"><span class="material-icons">search</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Search" : "ค้นหา" ?></button>
            <button type="button" class="k-button k-primary k-primary k-primary" id="btn-select-user"><span class="material-icons">done</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Select" : "เลือก" ?></button>
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
        this.regisID = "";
        this.userID;
        page.prototype.initial = function() {
            $('#data-grid').kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            dataType: 'json',
                            type: 'POST',
                            data: ({
                                mode: 'selectAllRegistrationInformation'
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
                    sort: { field: "ri.regisID", dir: "desc" }
                },
                groupable: true,
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
                columns: [
                    {
                        field: 'regisID',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "ID" : "รหัสลำดับรายวิชาที่เปิดสอน"?>',
                        id: "ri.regisID",
                    },
                    // {
                    //     field: 'courseID',
                    //     title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Course ID" : "รหัสลำดับรายวิชา"?>',
                    //     id: "ri.courseID",
                    //     hidden: true
                    // },
                    {
                        field: 'courseCode',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Course code" : "รหัสวิชา"?>',
                        id: "ci.courseCode"
                    },
                    {
                        field: 'courseName',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Course name" : "ชื่อวิชา"?>',
                        id: "ci.courseName"
                    },
                    {
                        field: 'fullName',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Instructor" : "ผู้สอน"?>',
                        id: "us.fullName"
                    },
                    {
                        field: 'classGroup',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Section" : "กลุ่มเรียน"?>',
                        id: "ri.classGroup"
                    },
                    {
                        field: 'year',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Year" : "ปีการศึกษา"?>',
                        id: "ri.year"
                    },
                    {
                        field: 'semester',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Semester" : "ภาคการศึกษา"?>',
                        id: "ri.semester"
                    },
                    {
                        field: 'status',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Status" : "สถานะ"?>',
                        template: '#=status==1?"Active":"Inactive"#',
                        id: "ri.status"
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
            $("#courseID").kendoDropDownList({
                optionLabel: "<?=$_SESSION['setting']['lang'] == 'en' ? "Select Course..." : "เลือกวิชา"?>",
                dataTextField: "courseName",
                dataValueField: "courseID",
                valueTemplate: '<span>#: data.courseCode #</span> <span>#: data.courseName #</span>',
                template: '<span class="k-state-default">#: data.courseCode # #: data.courseName #</span>',
                filter: "contains",
                dataSource: {
                    transport: {
                        read: {
                            dataType: "json",
                            type: "POST",
                            data: ({
                                mode: 'selectAllCourseCode'
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
                    
                }
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
                            url: '<?=htmlspecialchars($_SERVER['PHP_SELF']);?>'
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
            $('#data-grid-user').kendoGrid({
                autoBind: false,
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
                    filter: [{
                        field: "us.userTypeID",
                        operator: "eq",
                        value: '2'
                    },
                    {
                        field: "us.status",
                        operator: "eq",
                        value: '1'
                    },
                ]
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
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Fullname" : "ชื่อ สกุล"?>',
                        id: "us.fullName"
                    },
                    {
                        field: 'email',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Email" : "อีเมล"?>',
                        id: "us.email"
                    },
                    {
                        field: 'mbti',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "mbti" : "รูปแบบบุคคลิกภาพ"?>',
                        id: "us.mbti"
                    },
                    {
                        field: 'status',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Status" : "สถานะ"?>',
                        template: '#=status==1?"<?=$_SESSION['setting']['lang'] == 'en' ? "Active" : "เปิดใช้งาน"?>":"<?=$_SESSION['setting']['lang'] == 'en' ? "Inactive" : "ระงับการใช้"?>"#',
                        id: "us.status"
                    },
                ],
                dataBound: function() {
                    var grid = this;
                    for (var i = 0; i < grid.columns.length; i++) {
                        grid.autoFitColumn(i);
                    }
                },
                // change: function(e) {
                //     var selectedItem = this.dataItem(this.select());
                //     if (selectedItem) {
                //         page.userID=selectedItem.userID;
                //         $('#fullName').val(selectedItem.fullName);
                //         $('#windowUserID').data("kendoWindow").close();
                //     }
                // },
                toolbar: kendo.template($("#usertoolbar").html())
            });
            $("#windowUserID").kendoWindow({
                actions: ["Minimize", "Maximize", "Close"],
                width: "75%",
                title: "<?=$_SESSION['setting']['lang'] == 'en' ? 'Select instructor' : 'ค้นหาผู้สอน';?>",
                visible: false,
                open: function() {
                    $('#data-grid-user').data('kendoGrid').dataSource.read();
                }
            });
            $("#year").kendoDatePicker({
                start: "decade",
                depth: "decade",
                format: "yyyy",
                dateInput: true
            });
            $("#semester").kendoNumericTextBox({
                min: 1,
                format: '0'
            });
        }
        page.prototype.bindData = function(selectedItem) {
            page.mode = "update";
            page.regisID = selectedItem.regisID;
            page.userID = selectedItem.userID;
            //$('#courseID').data('kendoDropDownList').value(selectedItem.courseID);
            $('#courseID').data('kendoDropDownList').select(function(dataItem) {
                return dataItem.courseID === selectedItem.courseID;
            });
            $('#fullName').val(selectedItem.fullName);
            $("#classGroup").data('kendoAutoComplete').value(selectedItem.classGroup);
            $("#year").data('kendoDatePicker').value(selectedItem.year);
            $("#semester").data('kendoNumericTextBox').value(selectedItem.semester);
            setCHKValue('status', selectedItem.status);
        }
        page.prototype.eventhandle = function() {
            $('#btn-select-user').click(function() {
                var list = $('#data-grid-user').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                if (selectedItem == null) {
                    kendo.alert(
                        '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please select the record you want to select." : "กรุณาเลือกรายการที่ต้องการ" ?>'
                    );
                    return;
                }
                page.userID = selectedItem.userID;
                $('#fullName').val(selectedItem.fullName);
                $('#windowUserID').data("kendoWindow").close();
            });
            $('#btn-window').click(function() {
                $('#windowUserID').data("kendoWindow").center().open();
            });
            $("#data-grid-user").on("dblclick", "tr.k-state-selected", function() {
                var list = $('#data-grid-user').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                page.userID = selectedItem.userID;
                $('#fullName').val(selectedItem.fullName);
                $('#windowUserID').data("kendoWindow").close();
            });
            $('#btn-add').click(function() {
                if ($('#btn-add').prop('disabled')) return;
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', 'disabled');
                page.clearform();
            });
            $('#btn-edit').click(function() {
                if ($('#btn-edit').prop('disabled')) return;
                var list = $('#data-grid').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                if (selectedItem == null) {
                    kendo.alert(
                        '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please select the record you want to edit." : "กรุณาเลือกรายการที่ต้องการแก้ไข" ?>'
                    );
                    return;
                }
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', 'disabled');
                page.bindData(selectedItem);
            });
            $("#btn-delete").click(function() {
                if ($("#btn-delete").prop("disabled")) return;
                var list = $('#data-grid').data('kendoGrid');
                var selectedItem = list.dataItem(list.select());
                if (selectedItem == null) {
                    kendo.alert(
                        '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please select the record you want to delete." : "กรุณาเลือกรายการที่ต้องการลบ" ?>'
                    );
                    return;
                }
                kendo.confirm("<?php echo $_SESSION['setting']['lang'] == 'en' ? "Are you sure?" : "ยืนยันการลบ" ?>")
                    .then(function() {
                        ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                            mode: 'delete',
                            regisID: selectedItem.regisID
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

            });
            $("#btn-cancel").click(function() {
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', '');
                page.clearform();
            });
            $("#scriptForm").submit(function(e) {
                e.preventDefault();
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', '');
                var options = {
                    success: function(response) {
                        $('.loader-wrapper').hide();
                        if ($.trim(response) == true) {
                            kendo.alert(
                                '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                            );
                            page.reloaddata();
                        } else {
                            kendo.alert(response);
                        }
                    },
                    type: 'POST',
                    data: {
                        mode: page.mode,
                        regisID: page.regisID,
                        userID: page.userID
                    },
                    resetForm: true
                };
                if (page.validator.validate()) {
                    $('.loader-wrapper').show();
                    $("#scriptForm").ajaxSubmit(options);
                }

            });
            $('#btn-search-user').click(function() {
                var searchstring = $('#txt-search-user').val().toUpperCase();
                var kgrid = $('#data-grid-user').data('kendoGrid');
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
                                    andfilter.filters.push({
                                        field: 'us.userTypeID',
                                        operator: 'eq',
                                        value: 2
                                    });
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
                    kgrid.dataSource.filter({
                        field: 'us.userTypeID',
                        operator: 'eq',
                        value: 2
                    });
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
            });
        }
        page.prototype.validation = function() {
            page.validator = $('#scriptForm').kendoValidator({
                rules: {

                },
                messages: {

                }
            }).data("kendoValidator");
        }
        page.prototype.clearform = function() {
            HTMLFormElement.prototype.reset.call($('#scriptForm')[0]);
            page.reloaddata();
        }
        page.prototype.reloaddata = function() {
            page.mode = "insert";
            page.regisID = "";
            $('#search').val('');
            $('#data-grid').data('kendoGrid').dataSource.filter({});
            $('#data-grid').data('kendoGrid').dataSource.read();
            $('#data-grid').data('kendoGrid').refresh();
            $('#data-grid').data('kendoGrid').clearSelection();
        }
    }
    </script>
</body>

</html>