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
    case 'selectAllMBTIAnswer':
        try {
                $value['ans.questionNo'] = null;
                $value['que.question'] = null;
                $value['ans.answer'] = null;
                $value['que.choiceA'] = null;
                $value['que.choiceB'] = null;
                buildstring($_POST, $value);
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('mbti_answer ans LEFT OUTER JOIN mbti_question que ON ans.questionNo=que.questionNo', array_keys($value), $request);
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
                    <h1 class="h2"><?=$_SESSION['setting']['lang'] == 'en' ? 'Personality test result (MBTI)' : 'ผลการทดสอบบุคคลิกภาพ';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item"><?=$_SESSION['setting']['lang'] == 'en' ? 'Personality test result (MBTI)' : 'ผลการทดสอบบุคคลิกภาพ';?>
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
        <div >
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
        this.userTypeID = "";
        this.mbti;
        page.prototype.initial = function() {
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
                    sort: { field: "us.userID", dir: "desc" },
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
                detailInit: page.detailInit,
                columns: [{
                        field: 'userID',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "User ID" : "รหัสลำดับข้อมูลผู้ใช้"?>',
                        id: "us.userID"
                    },
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
                                mode: 'selectAllMBTIAnswer'
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
                        field: "userID",
                        operator: "eq",
                        value: e.data.userID 
                    }],
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
                            id: "ans.questionNo"
                        },
                        {
                            field: 'question',
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Question" : "คำถาม"?>',
                            id: "que.question"
                        },
                        {
                            field: 'answer',
                            title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Answer" : "คำตอบ"?>',
                            id: "ans.answer",
                            template: function(dataItem) {
                                  if(dataItem.answer==1){
                                        return dataItem.choiceA;
                                  }else{
                                        return dataItem.choiceB;
                                  }
                            }
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
                                    andfilter.filters.push({
                                            field: "us.userTypeID",
                                            operator: "eq",
                                            value:'3'
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
                    kgrid.dataSource.filter({});
                }
            }); //btn-search
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