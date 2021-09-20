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
    case 'selectAllGroupType':
        try {
                $value['groupTypeID'] = null;
                $value['groupType'] = null;
                $value['status'] = null;
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('group_type', array_keys($value), $request);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'verifyGroupType':
        try {
            $strsql = "select * from group_type where groupType='" . $_POST['groupType'] . "'";
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
            $value['groupType'] = $_POST['groupType'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->create('group_type', array_keys($value), $request, 'groupTypeID');
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
            $value['groupTypeID'] = $_POST['groupTypeID'];
            $value['groupType'] = $_POST['groupType'];
            $value['status'] = isset($_POST['status']) ? 1 : 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->update('group_type', array_keys($value), $request, 'groupTypeID');
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
            $value['groupTypeID'] = $_POST["groupTypeID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('group_type', $request, 'groupTypeID');
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
                    <h1 class="h2"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ข้อมูลประเภทการจับกลุ่ม';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ข้อมูลประเภทการจับกลุ่ม';?>
                        </li>
                    </ol>
                </nav>
                <div id="data-grid"></div>
                <div class="card mt-4">
                    <div class="card-body">
                        <form class="row g-3" id="scriptForm">
                            <div class="col-md-3">
                                <label for="groupType"
                                    class="form-label"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ประเภทการจับกลุ่ม';?>*</label>
                                <div class="col">
                                    <input type="text" class="k-textbox" id="groupType" name="groupType"
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
        <div class="form-row">
            <button type="button" class="k-button k-primary" id="btn-add"><span class="material-icons">add</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Add" : "เพิ่ม" ?></button>
            <button type="button" class="k-button k-primary" id="btn-edit"><span class="material-icons">edit</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Edit" : "แก้ไข" ?></button>
            <button type="button" class="k-button k-primary" id="btn-delete"><span class="material-icons">delete</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Del" : "ลบ" ?></button>
            <button type="button" class="k-button k-primary" id="btn-cancel"><span class="material-icons">cancel</span><?php echo $_SESSION['setting']['lang'] == 'en' ? "Cancel" : "ยกเลิก" ?></button>
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
        this.groupTypeID = "";
        page.prototype.initial = function() {
            $('#data-grid').kendoGrid({
                dataSource: {
                    transport: {
                        read: {
                            dataType: 'json',
                            type: 'POST',
                            data: ({
                                mode: 'selectAllGroupType'
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
                    sort: { field: "groupTypeID", dir: "desc" }
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
                        field: 'groupTypeID',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "ID" : "ลำดับ"?>',
                        id: "groupTypeID"
                    },
                    {
                        field: 'groupType',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Group Type" : "ประเภทผู้ใช้"?>',
                        id: "groupType"
                    },
                    {
                        field: 'status',
                        title: '<?=$_SESSION['setting']['lang'] == 'en' ? "Status" : "สถานะ"?>',
                        template: '#=status==1?"Active":"Inactive"#',
                        id: "status"
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
        page.prototype.bindData = function(selectedItem) {
            page.mode = "update";
            page.groupTypeID = selectedItem.groupTypeID;
            $('#groupType').val(selectedItem.groupType);
            setCHKValue('status', selectedItem.status);
        }
        page.prototype.eventhandle = function() {
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
                            groupTypeID: selectedItem.groupTypeID
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
                        groupTypeID: page.groupTypeID
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
        }
        page.prototype.validation = function() {
            page.validator = $('#scriptForm').kendoValidator({
                rules: {
                    requiregroupType: function(input) {
                        var ret = true;
                        if (input.is('#groupType')) {
                            if ($.trim(input.val()) == '') ret = false;
                        }
                        return ret;
                    },
                    verifyGroupType: function(input) {
                        page.ret = true;
                        if (input.is('#groupType')) {
                            ajax('group_type.php', 'POST', "json", ({
                                mode: 'verifyGroupType',
                                groupType: input.val()
                            }), false, true, function(response) {
                                page.ret = response;
                            }, true);
                        }
                        if (page.mode == 'update') page.ret = true;
                        return page.ret;
                    },
                },
                messages: {
                    requiregroupType: "<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please enter group type." : "กรุณาพิมพ์ประเภทการจับกลุ่ม" ?>",
                    verifyGroupType: "<?php echo $_SESSION['setting']['lang'] == 'en' ? "This group type has already been used!" : "ประเภทการจับกลุ่มนี้ซ้ำ" ?>",
                }
            }).data("kendoValidator");
        }
        page.prototype.clearform = function() {
            HTMLFormElement.prototype.reset.call($('#scriptForm')[0]);
            page.reloaddata();
        }
        page.prototype.reloaddata = function() {
            page.mode = "insert";
            page.groupTypeID = "";
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