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
        case 'selectAllEvaluationResult':
            try {
                    $sql="SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND ans.questionNo=1  
                    UNION ALL
                    SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND ans.questionNo=2 
                    UNION ALL
                    SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND ans.questionNo=3 
                    UNION ALL
                    SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND ans.questionNo=4  
                    UNION ALL
                    SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND  ans.questionNo=5 
                    UNION ALL
                    SELECT ans.questionNo, que.question ,GROUP_CONCAT(ans.suggestion SEPARATOR ',') AS result
                    FROM evaluation_answer ans 
                    LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                    WHERE ans.assignID='".$_POST['filter']['filters'][0]['value']."' AND ans.groupNum='".$_POST['filter']['filters'][1]['value']."' AND ans.userID='".$_POST['filter']['filters'][2]['value']."' AND ans.questionNo=6  ";
                    $data = $db->select($sql);
                    echo json_encode($data);
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
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Team work evaluation result' : 'ผลประเมินการปฏิบัติงานกลุ่ม';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item">
                            <?=$_SESSION['setting']['lang'] == 'en' ? 'Team work evaluation result' : 'ผลประเมินการปฏิบัติงานกลุ่ม';?>
                        </li>
                    </ol>
                </nav>
                <div id="data-grid"></div>
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
        <div class="form-row">
            <input type="text" id="search" class="k-textbox">
            <button type="button" class="k-button k-primary" id="btn-search"><span class="material-icons">search</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Search" : "ค้นหา" ?></button>
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
                detailInit: page.detailInit,
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
            
        }
        page.prototype.detailInit = function (e) {
            $("<div/>").appendTo(e.detailCell).kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            dataType: 'json',
                            type: 'POST',
                            data: ({
                                mode: 'selectAllEvaluationResult'
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
                    filter: [
                        {
                        field: "assignID",
                        operator: "eq",
                        value: e.data.assignID 
                        },
                        {
                        field: "groupNum",
                        operator: "eq",
                        value: e.data.groupNum 
                        },
                        {
                        field: "userID",
                        operator: "eq",
                        value: e.data.userID 
                        },
                    ],
                },
                selectable: 'row',
                pageable: {
                    pageSizes: true,
                    refresh: true,
                    buttonCount: 5
                },
                columns: [{
                            field: 'questionNo',
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "No." : "ข้อที่"?>',
                            id: "questionNo"
                        },
                        {
                            field: 'question',
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Question" : "คำถาม"?>',
                            id: "question"
                        },
                        {
                            field: 'result',
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Answer" : "คำตอบ"?>',
                            id: "result",
                            template: function(dataItem) {
                                  if(dataItem.questionNo!=6 && dataItem.result!=null){
                                        if(dataItem.result>=0 && dataItem.result<1){
                                            return 'ปรับปรุง'
                                        }else if(dataItem.result>=1 && dataItem.result<2){
                                            return 'ไม่พอใจ'
                                        }else if(dataItem.result>=2 && dataItem.result<3){
                                            return 'พอใจ'
                                        }else if(dataItem.result>=3 && dataItem.result<4){
                                            return 'พอใจมาก'
                                        }else if(dataItem.result>=4){
                                            return 'ดีเด่น'
                                        }
                                  }else{
                                      return dataItem.result;
                                  }
                            }
                        },
                        {
                            
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Score" : "คะแนน"?>',
                            template: "#:result#"
                        },
                    ],
                dataBound: function() {
                    var grid = this;
                    for (var i = 0; i < grid.columns.length; i++) {
                        grid.autoFitColumn(i);
                    }
                },
            });
        }
        page.prototype.eventhandle = function() {
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