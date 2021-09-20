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
    case 'selectAllGroupInformation':
        try {
                $value['gi.groupInfoID'] = null;
                $value['ci.courseCode'] = null;
                $value['ci.courseName'] = null;
                $value['ass.assignID'] = null;
                $value['ass.assignTitle'] = null;
                $value['ass.assignDescription'] = null;
                $value['ass.assignDate'] = null;
                $value['ass.deadline'] = null;
                $value['ass.numGroup'] = null;
                $value['us2.fullName as instructor'] = null;
                $value['gt.groupType'] = null;
                $value['gi.groupNum'] = null;
                $value['gi.responsibility'] = null;
                $value['gi.userID'] = null;
                $value['us.userCode'] = null;
                $value['us.fullName'] = null;
                $value['ri.classGroup'] = null;
                $value['ri.year'] = null;
                $value['ri.semester'] = null;
                buildstring($_POST, $value);
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('group_information gi 
                LEFT OUTER JOIN user us ON gi.userID=us.userID
                LEFT OUTER JOIN assignment ass ON gi.assignID=ass.assignID
                LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
                LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
                LEFT OUTER JOIN user us2 ON ri.userID=us2.userID
                LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID', array_keys($value), $request);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllAssignment':
        try {
            $value['ass.assignID'] = null;
            $value['ass.regisID'] = null;
            $value['ass.groupTypeID'] = null;
            $value['ass.assignTitle'] = null;
            $value['ass.assignDescription'] = null;
            $value['ass.assignDate'] = null;
            $value['ass.deadline'] = null;
            $value['ass.numGroup'] = null;
            $value['ass.status'] = null;
            $value['ci.courseCode'] = null;
            $value['ci.courseName'] = null;
            $value['us.fullName'] = null;
            $value['ri.classGroup'] = null;
            $value['ri.year'] = null;
            $value['ri.semester'] = null;
            $value['gt.groupType'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('assignment ass 
            LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID
            LEFT OUTER JOIN user us ON ri.userID=us.userID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'insert':
        try {
            $sql="select * from group_information where assignID='".$_POST['assignID']."' and userID='".$_POST['userID']."'";
            $result=$db->select($sql);
            if($result['total']!=0){
                throw new Exception($_SESSION['setting']['lang'] == 'en' ? 'This student has already made the groupings and unable to repeat the groupings.' : 'นักศึกษาได้ทำการจัดกลุ่มไว้แล้วไม่สามารถทำการจัดกลุ่มซ้ำได้อีก');
            }
            $value['assignID'] = $_POST['assignID'];
            $value['groupNum'] = $_POST['groupNum'];
            $value['userID'] = $_POST['userID'];
            $value['responsibility'] = $_POST['responsibility'];
            
            $request = json_decode(json_encode($value), false);
            $result = $db->create('group_information', array_keys($value), $request, 'groupInfoID');
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
            $value['groupInfoID'] = $_POST['groupInfoID'];
            $value['assignID'] = $_POST['assignID'];
            $value['groupNum'] = $_POST['groupNum'];
            $value['userID'] = $_POST['userID'];
            $value['responsibility'] = $_POST['responsibility'];
            $request = json_decode(json_encode($value), false);
            $result = $db->update('group_information', array_keys($value), $request, 'groupInfoID');
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
            $value['groupInfoID'] = $_POST["groupInfoID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('group_information', $request, 'groupInfoID');
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
    }

    .k-list-container>.k-footer {
        padding: 10px;
    }

    #assignID .k-item {
        line-height: 1em;
        min-width: 300px;
    }

    .k-material #assignID .k-item,
    .k-material #assignID .k-item.k-state-hover,
    .k-materialblack #assignID .k-item,
    .k-materialblack #assignID .k-item.k-state-hover {
        padding-left: 5px;
        border-left: 0;
    }

    #assignID .k-item>span {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: inline-block;
        vertical-align: top;
        margin: 20px 10px 10px 5px;
    }

    #assignID .k-item>span:first-child {
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

    #assignID h3 {
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 1px 0;
        padding: 0;
    }

    #assignID p {
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
                    <h1 class="h2">
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Group Information' : 'ข้อมูลการจับกลุ่มของนักศึกษา';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item">
                            <?=$_SESSION['setting']['lang'] == 'en' ? 'Group Information' : 'ข้อมูลการจับกลุ่มของนักศึกษา';?>
                        </li>
                    </ol>
                </nav>
                <div id="data-grid"></div>
                <div class="card mt-4">
                    <div class="card-body">
                        <form class="row g-3" id="scriptForm">
                            <div class="col-md-3"><label for="fullName"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Student' : 'นักศึกษา';?></label>
                                <div class="input-group">
                                    <input type="text" class="k-textbox" id="fullName" name="fullName"
                                        placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Select student' : 'ค้นหานักศึกษา';?>"
                                        readonly style="width:85%">
                                    <button class="k-button k-primary" type="button" id="btn-window"
                                        style="width:15%"><span class="material-icons">search</span></button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="assignID"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment' : 'การมอบหมายงาน';?></label>
                                <div class="col">
                                    <input type="text" id="assignID" name="assignID" style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-1"><label for="groupNum"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group Number' : 'กลุ่มที่';?></label>
                                <div class="input-group">
                                    <input type="text" id="groupNum" name="groupNum" style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-5"><label for="responsibility"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Responsibility' : 'หน้าที่รับผิดชอบ';?></label>
                                <div class="input-group">
                                    <input type="text" class="k-textbox" id="responsibility" name="responsibility"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-3"><label for="Instructor"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Instructor' : 'ผู้สอน';?></label>
                                <div class="input-group">
                                    <input type="text" class="k-textbox" id="Instructor" name="Instructor" readonly
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="classGroup"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Section' : 'กลุ่มเรียน';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="classGroup" name="classGroup" readonly
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="year"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Year' : 'ปีการศึกษา';?></label>
                                <div class="col"><input type="text" class="k-textbox" id="year" name="year" readonly
                                        style="width:100%"> </div>
                            </div>
                            <div class="col-md-1">
                                <label for="semester"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Semester' : 'ภาคการศึกษา';?></label>
                                <div class="col"><input type="text" class="k-textbox" id="semester" name="semester"
                                        readonly style="width:100%">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label for="groupType"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ประเภทการจับกลุ่ม';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="groupType" name="groupType" readonly
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="numGroup"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Number of group' : 'จำนวนกลุ่ม';?></label>
                                <div class="col"><input type="text" class="k-textbox" id="numGroup" name="numGroup"
                                        readonly style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="assignDate"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment date' : 'วันที่มอบหมาย';?></label>
                                <div class="col"><input type="text" class="k-textbox" id="assignDate" name="assignDate"
                                        readonly style="width:100%"> </div>
                            </div>
                            <div class="col-md-2">
                                <label for="deadline"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Deadline' : 'กำหนดส่ง';?></label>
                                <div class="col"><input type="text" class="k-textbox" id="deadline" name="deadline"
                                        readonly style="width:100%"> </div>
                            </div>
                            <div class="col-md-3">
                                <label for="assignTitle"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment Title' : 'หัวข้อการมอบหมายงาน';?></label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="assignTitle" name="assignTitle" readonly
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label for="assignDescription"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Description' : 'รายละเอียดการมอบหมายงาน';?></label>
                                <div class="col">
                                    <textarea class="k-textarea" id="assignDescription" name="assignDescription"
                                        readonly style="width:100%"></textarea>

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
            <button type="button" class="k-button k-primary" id="btn-add"><span class="material-icons">add</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Add" : "เพิ่ม" ?></button>
            <button type="button" class="k-button k-primary" id="btn-edit"><span class="material-icons">edit</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Edit" : "แก้ไข" ?></button>
            <button type="button" class="k-button k-primary" id="btn-delete"><span class="material-icons">delete</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Del" : "ลบ" ?></button>
            <button type="button" class="k-button k-primary" id="btn-cancel"><span class="material-icons">cancel</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Cancel" : "ยกเลิก" ?></button>
            <input type="text" id="search" class="k-textbox">
            <button type="button" class="k-button k-primary" id="btn-search"><span class="material-icons">search</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Search" : "ค้นหา" ?></button>
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
        this.assignID = "";
        this.userID = "";
        page.prototype.initial = function() {
            $('#data-grid').kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            dataType: 'json',
                            type: 'POST',
                            data: ({
                                mode: 'selectAllGroupInformation'
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
                    sort: { field: "gi.groupInfoID", dir: "desc" }
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
                columns: [{
                        field: 'groupInfoID',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "ID" : "ลำดับ"?>',
                        id: "gi.groupInfoID"
                    },
                    {
                        field: 'userCode',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "User code" : "รหัสนักศึกษา"?>',
                        id: "us.userCode"
                    },
                    {
                        field: 'fullName',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Student name" : "ชื่อ สกุลนักศึกษา"?>',
                        id: "us.fullName"
                    },
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
                        field: 'assignTitle',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Assignment Title" : "หัวข้อการมอบหมายงาน"?>',
                        id: "ass.assignTitle"
                    },
                    {
                        field: 'assignDescription',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Description" : "รายละเอียดการมอบหมายงาน"?>',
                        id: "ass.assignDescription"
                    },
                    {
                        field: 'numGroup',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Number of group" : "จำนวนกลุ่ม"?>',
                        id: "ass.numGroup"
                    },
                    {
                        field: 'assignDate',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Assignment date" : "วันที่มอบหมาย"?>',
                        id: "ass.assignDate"
                    },
                    {
                        field: 'deadline',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Deadline" : "กำหนดส่ง"?>',
                        id: "ass.deadline"
                    },
                    {
                        field: 'instructor',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Instructor" : "ผู้สอน"?>',
                        id: "us2.fullName"
                    },
                    {
                        field: 'groupType',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Group type" : "ประเภทการจับกลุ่ม"?>',
                        id: "gt.groupType"
                    },
                    {
                        field: 'groupNum',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Group number" : "กลุ่มที่"?>',
                        id: "gi.groupNum"
                    },
                    {
                        field: 'responsibility',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Responsibility" : "หน้าที่รับผิดชอบในกลุ่ม"?>',
                        id: "gi.responsibility"
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
            $("#assignID").kendoDropDownList({
                optionLabel: "<?=$_SESSION['setting']['lang'] == 'en' ? "Select assignment..." : "เลือกการมอบหมายงาน"?>",
                dataTextField: "courseName",
                dataValueField: "assignID",
                headerTemplate: '<div class="dropdown-header k-widget k-header">' +
                    '<div><?=$_SESSION['setting']['lang'] == 'en' ? "Course code Course name" : "รหัสวิชา ชื่อวิชา"?> </div>' +
                    '<div>[<?=$_SESSION['setting']['lang'] == 'en' ? "Instructor,Section,year,semester" : "ผู้สอน,กลุ่มเรียน,ปีการศึกษา,ภาคการศึกษา"?>]</div>' +
                    '</div>',
                valueTemplate: '<span>#: data.courseCode #</span> <span>#: data.courseName #</span>',
                template: '<div class="k-state-default">#: data.courseCode # #: data.courseName #</div><div>[#: data.fullName #,#: data.classGroup #,#: data.year #,#: data.semester #]</div>',
                filter: "contains",
                height: 500,
                dataSource: {transport: {
                        read: {
                            dataType: "json",
                            type: "POST",
                            data: ({
                                mode: 'selectAllAssignment'
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
                        field: "ass.status",
                        operator: "eq",
                        value: '1'
                    }]},
                select: function(e) {
                    $('#Instructor').val(e.dataItem.fullName);
                    $('#classGroup').val(e.dataItem.classGroup);
                    $('#year').val(e.dataItem.year);
                    $('#semester').val(e.dataItem.semester);
                    $('#groupType').val(e.dataItem.groupType);
                    $('#numGroup').val(e.dataItem.numGroup);
                    $('#assignDate').val(e.dataItem.assignDate);
                    $('#deadline').val(e.dataItem.deadline);
                    $('#assignTitle').val(e.dataItem.assignTitle);
                    $('#assignDescription').val(e.dataItem.assignDescription);
                    $('#groupNum').data('kendoNumericTextBox').enable(true);
                    $("#groupNum").data('kendoNumericTextBox').max($('#numGroup').val());
                    $("#groupNum").data('kendoNumericTextBox').focus();
                    $('#responsibility').prop('disabled',false);
                }
            });
            $("#groupNum").kendoNumericTextBox({
                min: 1,
                value: 1,
                format: '0'
            });

            $('#assignID').data('kendoDropDownList').enable(false);
            $('#groupNum').data('kendoNumericTextBox').enable(false);
            $('#responsibility').prop('disabled',true);

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
                        value: '3'
                    }]
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
        }
        page.prototype.bindData = function(selectedItem) {
            page.mode = "update";
            page.groupInfoID = selectedItem.groupInfoID;
            page.userID = selectedItem.userID;
           
            
            $('#assignID').data('kendoDropDownList').select(function(dataItem) {
                return dataItem.assignID === selectedItem.assignID;
            });
            $('#assignID').data('kendoDropDownList').enable(true);

            $('#groupNum').data('kendoNumericTextBox').value(selectedItem.groupNum);
            $("#groupNum").data('kendoNumericTextBox').max(selectedItem.numGroup);
            $('#groupNum').data('kendoNumericTextBox').enable(true);
            
            $('#fullName').val(selectedItem.fullName);
            $('#Instructor').val(selectedItem.instructor);
            $('#classGroup').val(selectedItem.classGroup);
            $('#year').val(selectedItem.year);
            $('#semester').val(selectedItem.semester);
            $('#groupType').val(selectedItem.groupType);
            $('#numGroup').val(selectedItem.numGroup);
            $('#assignDate').val(selectedItem.assignDate);
            $('#deadline').val(selectedItem.deadline);
            $('#assignTitle').val(selectedItem.assignTitle);
            $('#assignDescription').val(selectedItem.assignDescription);
            $('#responsibility').val(selectedItem.responsibility);
            $('#responsibility').prop('disabled',false);
            
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
                $('#assignID').data('kendoDropDownList').dataSource.filter([{
                    field: "ri.classGroup",
                    operator: "eq",
                    value: selectedItem.classGroup
                },{
                    field: "ass.status",
                    operator: "eq",
                    value: 1
                }]);
                $('#assignID').data('kendoDropDownList').enable(true);
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
                $('#assignID').data('kendoDropDownList').dataSource.filter([{
                    field: "ri.classGroup",
                    operator: "eq",
                    value: selectedItem.classGroup
                },{
                    field: "ass.status",
                    operator: "eq",
                    value: 1
                }]);
                $('#assignID').data('kendoDropDownList').enable(true);
                $('#windowUserID').data("kendoWindow").close();
            });
            $('#btn-add').click(function() {
                if ($('#btn-add').prop('disabled')) return;
                $("#btn-add,#btn-edit,#btn-delete").prop('disabled', 'disabled');
                page.clearform();
                $('#groupType').focus();
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
                            groupInfoID: selectedItem.groupInfoID
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
                        userID: page.userID,
                        groupInfoID:page.groupInfoID
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
                                        value: 3
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
            page.userID = "";
            $('#search').val('');
            $('#assignID').data('kendoDropDownList').enable(false);
            $('#assignID').data('kendoDropDownList').select(-1);

            $('#groupNum').data('kendoNumericTextBox').value(1);
            $('#groupNum').data('kendoNumericTextBox').enable(false);
            $('#responsibility').prop('disabled',true);
            $('#data-grid').data('kendoGrid').dataSource.filter({});
            $('#data-grid').data('kendoGrid').dataSource.read();
            $('#data-grid').data('kendoGrid').refresh();
            $('#data-grid').data('kendoGrid').clearSelection();
        }
    }
    </script>
</body>

</html>