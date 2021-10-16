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
                $sql = "SELECT gi.assignID, gi.groupNum,ci.courseCode,ci.courseName,us.fullName,ass.assignTitle,ass.assignDescription,ass.assignDate,ass.deadline,ri.year,ri.semester from group_information gi
		                LEFT OUTER JOIN assignment ass ON gi.assignID=ass.assignID
		                LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
		                LEFT OUTER JOIN user us ON ri.userID=us.userID
		                LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID GROUP BY gi.assignID,gi.groupNum ORDER BY gi.assignID desc,gi.groupNum";
                $data = $db->select($sql);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllChat':
        try {
            $sql = "SELECT di.*,us.fullName FROM discussion di LEFT OUTER JOIN user us ON di.userID=us.userID WHERE di.assignID='" . $_POST['assignID'] . "' AND di.groupNum='" . $_POST['groupNum'] . "'";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllChatRefresh':
        try {
            $sql = "SELECT di.*,us.fullName FROM discussion di LEFT OUTER JOIN user us ON di.userID=us.userID WHERE discussID>'" . $_POST['lastDiscussID'] . "' and  di.assignID='" . $_POST['assignID'] . "' AND di.groupNum='" . $_POST['groupNum'] . "'";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'post_message':
        try {
            $strsql="SELECT AUTO_INCREMENT AS lastID FROM information_schema.tables WHERE table_name='discussion' AND table_schema='".TABLE_SCHEMA."'";
            $data=$db->select($strsql);
            $lastID= $data['data'][0]['lastID'];
            if ( !empty( $_FILES[ 'photo' ] ) ){
                $path = $_SERVER['DOCUMENT_ROOT'] . "/studentgroupingsystem/images/chat_images/assignID" . $_POST['assignID'] . "/groupNum". $_POST['groupNum']."/" ;              
                $name = $_FILES[ 'photo' ][ "name" ];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $name=$lastID.'.'.$ext;
                if ( $_FILES[ 'photo' ][ "error" ]== 1 ) {
                    throw new Exception('The file size exceeds the limit allowed and cannot be saved');
                }
                if ( !file_exists( $path ) ){mkdir( $path, 0755, true ) or die("cannot create directory".$path);}
                if ( move_uploaded_file( $_FILES[ 'photo' ][ "tmp_name" ], $path . $name ) ){
                    $value[ 'photo' ]  = $name;
                }else{
                    throw new Exception("Not uploaded because of error #".$_FILES["photo"]["error"]);
                }
            }
            $value['discussID'] = $lastID;
            $value['assignID'] = $_POST['assignID'];
            $value['groupNum'] = $_POST['groupNum'];
            $value['userID'] = $_POST['userID'];
            $value['message'] = $_POST['message'];
            
            $value['dateTimeSend'] = date("Y-m-d h:i:s");
            $request = json_decode(json_encode($value), false);
            $result = $db->create('discussion', array_keys($value), $request, 'discussID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo json_encode($result);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'delete_message':
        try {
            $strsql="select * from discussion where discussID='".$_POST["discussID"]."'";
            $data=$db->select($strsql);
            if($data['total']!=0 && $data['data'][0]['photo']!=null || $data['data'][0]['photo']!=""){
                $path = $_SERVER['DOCUMENT_ROOT'] . "/studentgroupingsystem/images/chat_images/assignID" . $data['data'][0]['assignID'] . "/groupNum". $data['data'][0]['groupNum']."/".$data['data'][0]['photo'] ;              
                unlink($path);
            }
            $value['discussID'] = $_POST["discussID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('discussion', $request, 'discussID');
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
    body {

        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    .profile-image {
        width: 50px;
        height: 50px;
        border-radius: 40px;
    }

    .settings-tray {
        background: #eee;
        padding: 10px 15px;
    }

    .settings-tray .g-0 {
        padding: 0;
    }




    .search-box {
        background: #fafafa;
        padding: 10px 13px;
    }

    .search-box .input-wrapper {
        background: #fff;
        border-radius: 40px;
    }

    .search-box .input-wrapper i {
        color: grey;
        margin-left: 7px;
        vertical-align: middle;
    }

    input {
        border: none;
        border-radius: 30px;
        width: 80%;
    }

    input::placeholder {
        color: #e3e3e3;
        font-weight: 300;
        margin-left: 20px;
    }

    input:focus {
        outline: none;
    }

    .friend-drawer {
        padding: 10px 15px;
        display: flex;
        vertical-align: baseline;
        background: #fff;
        transition: 0.3s ease;
    }

    .friend-drawer--grey {
        background: #eee;
    }

    .friend-drawer .text {
        margin-left: 12px;
        width: 70%;
    }

    .friend-drawer .text h6 {
        margin-top: 6px;
        margin-bottom: 0;
    }

    .friend-drawer .text p {
        margin: 0;
    }

    .friend-drawer .time {
        color: grey;
    }

    .friend-drawer--onhover:hover {
        background: #74b9ff;
        cursor: pointer;
    }

    .friend-drawer--onhover:hover p,
    .friend-drawer--onhover:hover h6,
    .friend-drawer--onhover:hover .time {
        color: #fff !important;
    }

    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        width: 5px;
        background: #f5f5f5;
    }

    ::-webkit-scrollbar-thumb {
        width: 1em;
        background-color: #ddd;
        border-radius: 1rem;
    }

    .chat-panel {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .chat-list {
        overflow: auto;
        max-height: 62vh;
    }

    .him {
        background: #eee;
        width: fit-content;
        /* margin-left: 0;
        margin-right: auto; */
        padding: 10px;
        border-radius: 30px;
        margin-bottom: 2px;
        /* border-top-left-radius: 5px;
        border-bottom-left-radius: 5px; */
        cursor: pointer;
    }

    .me {
        background: #0084ff;
        color: #fff;
        width: fit-content;
        /* margin-left: auto;
        margin-right: 0; */
        padding: 10px;
        border-radius: 30px;
        margin-bottom: 2px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        cursor: pointer;
    }

    .photo img{
        padding: 2px;
        max-width: 200px;
        cursor: pointer;
    }


    /* .him {
        border-bottom-left-radius: 5px;
    }

    .him+.him {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }


    .him:last-of-type {
        border-bottom-left-radius: 30px;
    }

  

    .him+.me {
        border-bottom-right-radius: 5px;
    }

    .me+.me {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .me:last-of-type {
        border-bottom-right-radius: 30px;
    } */

    .chat-box-tray {
        width: 100%;
        background: #eee;
        display: flex;
        align-items: baseline;
        padding: 10px 15px;
        align-items: center;
        margin-top: 19px;
        bottom: 0;
    }

    .chat-box-tray input {
        margin: 0 10px;
        padding: 6px 2px;
    }

    .chat-box-tray i {
        color: grey;
        font-size: 30px;
        vertical-align: middle;
    }

    .chat-box-tray i:last-of-type {
        margin-left: 25px;
    }

    #listView {
        min-height: 65vh;
        display: flex;
    }

    .k-drag-clue.k-state-selected,
    .k-draghandle.k-state-selected:hover,
    .k-ghost-splitbar-horizontal,
    .k-ghost-splitbar-vertical,
    .k-list>.k-state-highlight,
    .k-list>.k-state-selected,
    .k-marquee-color,
    .k-panel>.k-state-selected,
    .k-scheduler .k-today.k-state-selected,
    .k-state-selected,
    .k-state-selected:link,
    .k-state-selected:visited {

        background-color: #74b9ff;
        border-color: #74b9ff;
    }

    .more_option {
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
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
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Discussion' : 'ข้อมูลการอภิปรายผล';?></h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="main.php"><?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?></a></li>
                        <li class="breadcrumb-item">
                            <?=$_SESSION['setting']['lang'] == 'en' ? 'Discussion' : 'ข้อมูลการอภิปรายผล';?>
                        </li>
                    </ol>
                </nav>
                <div class="container">
                    <div class="row g-0">
                        <div class="col-md-4 border-right">
                            <div class="settings-tray">
                                <img class="profile-image" src="../images/studentGroupingLogo.png" alt="Profile img">
                            </div>
                            <div class="search-box">
                                <div class="input-wrapper">
                                    <i class="material-icons">search</i>
                                    <input placeholder="Search here" type="text" id="search">
                                </div>
                            </div>
                            <div id="listView"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="settings-tray">
                                <div class="friend-drawer g-0 friend-drawer--grey">
                                    <img class="profile-image" src="../images/studentGroupingLogo.png" alt="">
                                    <div class="text">
                                        <h6 id="chatTitle"></h6>
                                        <p class="text-muted" id="chatDescription"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-panel">
                                <div class="chat-list g-0"></div>
                                <div class="chat-box-tray">
                                    <input type="text" placeholder="Type your message here..." id="chat_input" style="width:100%">
                                    <span class="name"></span>
                                    <i class="material-icons" id="btn-photo" style="cursor:pointer" >photo_camera</i>
                                    <input  name="photo" id="photo" type="file" accept="image/*" capture style="display:none">
                                    <i class="material-icons" id="btn-send" style="cursor:pointer">send</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="dialog">
    </div>
    <div class="loader-wrapper" style="display:none">
        <div class="loader"></div>
    </div>
    <script src="../kendoui/js/jquery.min.js"></script>
    <script src="../jquery.form.min.js"></script>
    <script src="../kendoui/js/kendo.all.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="function.js"></script>
    <script type="text/x-kendo-template" id="template">
        <div class="friend-drawer friend-drawer--onhover">
        <img class="profile-image"
            src="../images/studentGroupingLogo.png"
            alt="">
        <div class="text">
            <h6>#: assignTitle # <?=$_SESSION['setting']['lang'] == 'en' ? "Group" : "กลุ่มที่"?>: #: groupNum #</h6>
            <p class="text-muted">#: courseCode  # #: courseName  #</p>
            <p class="text-muted"><?=$_SESSION['setting']['lang'] == 'en' ? "Assignment date" : "วันที่มอบหมาย"?>: #: assignDate  #  </p>
        </div>
        <span class="time text-muted small">#: semester  #/#: year  # </span>
    </div>
    </script>
    <script>
    var page = new page();
    var IMAGE_CARD_TEMPLATE1 = kendo.template(
        '<div class="template1">' +
        '<div class="k-card" >' +
        '<a href="#: images[0].url #" target="_blank"><img src="#: images[0].url #" alt="undefined" style="min-width:100%"></a>' +
        '</div>' +
        '</div>'
    );
    kendo.chat.registerTemplate("template1", IMAGE_CARD_TEMPLATE1);

    var dataSource = new kendo.data.DataSource({
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
        pageSize: 10,
        schema: {
            data: 'data',
            total: 'total'
        },
    });
    $(function() {
        page.initial();
        page.eventhandle();
    });

    function page() {
        this.validator;
        this.options;
        this.mode = "insert";
        this.assignID = "";
        this.userID = "";
        this.lastUserID = "";
        this.dialogData;
        this.selected=null;
        this.lastDiscussID="";
        page.prototype.initial = function() {
            $("#listView").kendoListView({
                dataSource: dataSource,
                height: 350,
                selectable: true,
                scrollable: "endless",
                template: kendo.template($("#template").html()),
                change: function() {
                    var data = dataSource.view();
                    page.selected = $.map(this.select(), function(item) {
                        return {
                            courseCode: data[$(item).index()].courseCode,
                            courseName: data[$(item).index()].courseName,
                            assignTitle: data[$(item).index()].assignTitle,
                            assignID: data[$(item).index()].assignID,
                            groupNum: data[$(item).index()].groupNum
                        };
                    });
                    page.selected = page.selected[0];
                    page.userID = "";
                    page.lastUserID = "";
                    $('.chat-list').html('');
                    ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                        mode: 'selectAllChat',
                        assignID: page.selected.assignID,
                        groupNum: page.selected.groupNum,
                    }), true, true, function(response) {
                        if (response.total != 0) {
                            $('#chatTitle').html(page.selected.courseCode + ' ' + page.selected
                                .courseName);
                            $('#chatDescription').html(page.selected.assignTitle +
                                ' <?=$_SESSION['setting']['lang'] == 'en' ? "Group" : "กลุ่มที่"?>: ' +
                                page.selected.groupNum);
                            $.each(response.data, function(i, v) {
                                page.userID=v.userID;
                                if (v.userID !='<?=$_SESSION['user']['data'][0]['userID']?>') {
                                    page.renderMessage(v, 'him');
                                } else {
                                    page.renderMessage(v, 'me');
                                }
                            });
                            $(".chat-list").animate({ scrollTop: $('.chat-panel').prop("scrollHeight")}, 1000);
                        }
                    });
                    setInterval(function(){
                        ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                            mode: 'selectAllChatRefresh',
                            assignID: page.selected.assignID,
                            groupNum: page.selected.groupNum,
                            lastDiscussID:page.lastDiscussID
                        }), true, false, function(response) {
                            if (response.total != 0) {
                                $.each(response.data, function(i, v) {
                                    page.userID=v.userID;
                                    if (v.userID !='<?=$_SESSION['user']['data'][0]['userID']?>') {
                                        page.renderMessage(v, 'him');
                                    } else {
                                        page.renderMessage(v, 'me');
                                    }
                                });
                                $(".chat-list").animate({ scrollTop: $('.chat-panel').prop("scrollHeight")}, 1000);
                            }
                        });
                     }, 6000);
                    
                    
                },
            });
            $('#dialog').kendoDialog({
                width: "450px",
                title: "<?php echo $_SESSION['setting']['lang'] == 'en' ? "What do you want to do?" : "คุณต้องการที่จะ" ?>",
                closable: true,
                modal: true,
                visible: false,
                actions: [
                    {   text: '<?php echo $_SESSION['setting']['lang'] == 'en' ? "View photo" : "ดูรูปภาพ" ?>', 
                        primary: true,
                        visible: false,
                        action: function(){
                            redirect('../images/chat_images/assignID'+page.dialogData.assignID+'/groupNum'+page.dialogData.groupNum+'/'+page.dialogData.photo,'_blank');
                        } 
                    },
                    {   text: '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Delete" : "ลบ" ?>',
                        action:function(){
                            page.deleteMessage(page.dialogData.discussID);
                        } 
                    },
                   
                ],
            });
        }
        page.prototype.renderMessage = function(obj, who) {
            if (who == 'him') {
                var html='';
                if(page.userID!=page.lastUserID){
                    html+='<div class="row g-0" id="discussID' +obj.discussID + '">';
                    html+='<span class="text-muted" style="font-size: 0.6rem;">'+obj.fullName+'</span>';
                    html+='<div class="rounded-circle"style="background-color:#FCA9C4;max-width:40px;max-height:40px;text-align: center;"><i class="material-icons" style="padding-top: 8px;">face</i></div>';
                }else{
                    html+='<div class="row g-0" style="padding-left: 40px;" id="discussID' +obj.discussID + '">';
                }
                if(obj.message!=null && obj.message!=''){
                    html+='<span class="col-sm-auto ' + who + '"  onclick="page.more_option(' + obj.discussID + ')">' + obj.message +'</span>';
                    html+='<span class="col-sm-auto more_option" id="more_option' + obj.discussID +'" onclick="page.more_option_action(\''+obj.discussID+'\',\''+obj.photo+'\',\''+obj.assignID+'\',\''+obj.groupNum+'\')">';
                        html+='<div style="padding-left: 5px;">';
                            html+='<i class="material-icons" >more_horiz</i>';
                            html+='<div class="text-muted" style="font-size: 0.6rem;">' +obj.dateTimeSend + '</div>';
                        html+='</div>';
                    html+='</span>';
                }
                if(obj.photo!=null && obj.photo!=''){
                    if(obj.message!=null && obj.photo!=null)html+='<div style="padding-left: 40px;">';
                        html+='<span class="col-sm-auto photo"  onclick="page.more_option(' + obj.discussID + ')"><img src="../images/chat_images/assignID' +obj.assignID + '/groupNum'+obj.groupNum+'/'+obj.photo+'"/></span>';
                        html+='<span class="col-sm-auto more_option" id="more_option' + obj.discussID +'" onclick="page.more_option_action(\''+obj.discussID+'\',\''+obj.photo+'\',\''+obj.assignID+'\',\''+obj.groupNum+'\')">';
                            html+='<div style="padding-left: 5px;">';
                                html+='<span class="material-icons">more_horiz</span>';
                                html+='<div class="text-muted" style="font-size: 0.6rem;">' +obj.dateTimeSend + '</div>';
                            html+='</div>';
                        html+='</span>';
                    if(obj.message!=null && obj.photo!=null)html+='</div>';
                }
                html+='</div>';
                $('.chat-list').append(html);
            } else {//me
                var html='<div class="row g-0" id="discussID' + obj.discussID + '">';
                    if(obj.message!=null && obj.message!=''){
                        html+='<div style="display: flex;flex-direction: row-reverse;">';
                            html+='<span class="col-sm-auto ' +who +'"  onclick="page.more_option(' + obj.discussID + ')">' +obj.message + '</span>';
                            html+='<span class="col-sm-auto more_option" id="more_option' + obj.discussID +'" onclick="page.more_option_action(\''+obj.discussID+'\',\''+obj.photo+'\',\''+obj.assignID+'\',\''+obj.groupNum+'\')">';
                                html+='<div style="padding-right: 5px;text-align: right;">';
                                    html+='<i class="material-icons" >more_horiz</i>';
                                    html+='<div class="text-muted" style="font-size: 0.6rem;">' +obj.dateTimeSend + '</div>';
                                html+='</div>';
                            html+='</span>';
                        html+='</div>';
                    }
                    if(obj.photo!=null && obj.photo!=''){
                        html+='<div style="display: flex;flex-direction: row-reverse;">';
                            html+='<span class="col-sm-auto photo"  onclick="page.more_option(' + obj.discussID + ')"><img src="../images/chat_images/assignID' +obj.assignID + '/groupNum'+obj.groupNum+'/'+obj.photo+'"/></span>';
                            html+='<span class="col-sm-auto more_option" id="more_option' + obj.discussID +'" onclick="page.more_option_action(\''+obj.discussID+'\',\''+obj.photo+'\',\''+obj.assignID+'\',\''+obj.groupNum+'\')">';
                                html+='<div style="padding-right: 5px;text-align: right;">';
                                    html+='<span class="material-icons">more_horiz</span>';
                                    html+='<div class="text-muted" style="font-size: 0.6rem;">' +obj.dateTimeSend + '</div>';
                                html+='</div>';
                            html+='</span>';
                        html+='</div>';
                    }


                    html+='</div>';
                $('.chat-list').append(html);
                
            }
            page.lastUserID=page.userID;
            page.lastDiscussID=obj.discussID;
        }
        page.prototype.more_option = function(id) {
            $('.more_option').css("display", "none");
            $('#more_option' + id).css("display", "flex");
        }
        page.prototype.more_option_action = function(discussID,photo,assignID,groupNum) {
            page.dialogData={discussID,photo,assignID,groupNum};
            $('#dialog').data("kendoDialog").open();
            if(photo==='' || photo=='null'){
                $('#dialog').data("kendoDialog").content('<p><?php echo $_SESSION['setting']['lang'] == 'en' ? "Would you like to delete them?" : "คุณต้องการที่จะลบข้อมูลหรือไม่" ?><p>');
                $("#dialog").closest(".k-window").find(".k-button.k-primary").hide();
            }else{
                $('#dialog').data("kendoDialog").content('<p><?php echo $_SESSION['setting']['lang'] == 'en' ? "Would you like to view pictures or delete them?" : "คุณต้องการที่จะ ดูรูปภาพ หรือ ลบข้อมูล" ?><p>');
                $("#dialog").closest(".k-window").find(".k-button.k-primary").show();
            }
        }
        page.prototype.postMessage=function(assignID,groupNum,userID,message,photo){
            ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                mode: 'post_message',
                assignID: assignID,
                groupNum: groupNum,
                userID: userID,
                message: message,
                photo: photo
            }), true, true, function(response) {
                var html='<div class="row g-0" id="discussID' + response.data[0].discussID + '">';
                html+='<div style="display: flex;flex-direction: row-reverse;">';
                html+='<span class="col-sm-auto me"  onclick="page.more_option(' + response.data[0].discussID + ')">' +response.data[0].message + '</span>';
                html+='<span class="col-sm-auto more_option" id="more_option' + response.data[0].discussID +'" onclick="page.more_option_action(\''+response.data[0].discussID+'\',\''+response.data[0].photo+'\',\''+response.data[0].assignID+'\',\''+response.data[0].groupNum+'\')">';
                html+='<div style="padding-right: 5px;text-align: right;">';
                html+='<i class="material-icons">more_horiz</i>';
                html+='<div class="text-muted" style="font-size: 0.6rem;">' +response.data[0].dateTimeSend + '</div>';
                html+='</div>';
                html+='</span>';
                html+='</div>';
                html+='</div>';
                $('.chat-list').append(html);
                $('#chat_input').val('');
                page.lastUserID=page.userID;
                page.lastDiscussID=response.data[0].discussID;
                $(".chat-list").animate({ scrollTop: $('.chat-panel').prop("scrollHeight")}, 1000);
            });

        }
        page.prototype.postMessageWithAttach=function(assignID,groupNum,userID,message,photo){
            var myFormData = new FormData();
            myFormData.append('photo', $("#photo")[0].files[0]);
            myFormData.append('mode', 'post_message');
            myFormData.append('assignID', assignID);
            myFormData.append('groupNum', groupNum);
            myFormData.append('userID', userID);
            myFormData.append('message', message);
            $.ajax({
                url: '<?=$_SERVER['PHP_SELF']?>',
                type: 'POST',
                async:true,
                processData: false, // important
                contentType: false, // important
                dataType : 'json',
                data: myFormData,
                beforeSend:function(){
                    $('.loader-wrapper').show();
                },
                success: function (response) {
                    $('.loader-wrapper').hide();
                    var html='<div class="row g-0" id="discussID' + response.data[0].discussID + '">';
                        if(response.data[0].message!=null && response.data[0].message!=''){
                            html+='<div style="display: flex;flex-direction: row-reverse;">';
                                html+='<span class="col-sm-auto me"  onclick="page.more_option(' + response.data[0].discussID + ')">' +response.data[0].message + '</span>';
                                html+='<span class="col-sm-auto more_option" id="more_option' + response.data[0].discussID +'" onclick="page.more_option_action(\''+response.data[0].discussID+'\',\''+response.data[0].photo+'\',\''+response.data[0].assignID+'\',\''+response.data[0].groupNum+'\')">';
                                    html+='<div style="padding-right: 5px;text-align: right;">';
                                        html+='<i class="material-icons">more_horiz</i>';
                                        html+='<div class="text-muted" style="font-size: 0.6rem;">' +response.data[0].dateTimeSend + '</div>';
                                    html+='</div>';
                                html+='</span>';
                            html+='</div>';
                        }
                        if(response.data[0].photo!=null && response.data[0].photo!=''){
                            html+='<div style="display: flex;flex-direction: row-reverse;">';
                                html+='<span class="col-sm-auto photo"  onclick="page.more_option(' + response.data[0].discussID + ')"><img src="../images/chat_images/assignID' +response.data[0].assignID + '/groupNum'+response.data[0].groupNum+'/'+response.data[0].photo+'"/></span>';
                                html+='<span class="col-sm-auto more_option" id="more_option' + response.data[0].discussID +'" onclick="page.more_option_action(\''+response.data[0].discussID+'\',\''+response.data[0].photo+'\',\''+response.data[0].assignID+'\',\''+response.data[0].groupNum+'\')">';
                                    html+='<div style="padding-right: 5px;text-align: right;">';
                                        html+='<span class="material-icons">more_horiz</span>';
                                        html+='<div class="text-muted" style="font-size: 0.6rem;">' +response.data[0].dateTimeSend + '</div>';
                                    html+='</div>';
                                html+='</span>';
                            html+='</div>';
                        }
                        html+='</div>';
                    $('.chat-list').append(html);
                    
                    $("#photo").val('');
                    $("#photo").siblings('span').text('');
                    $('#chat_input').val('');
                    page.lastUserID=page.userID;
                    page.lastDiscussID=response.data[0].discussID;
                    $(".chat-list").animate({ scrollTop: $('.chat-panel').prop("scrollHeight")}, 1000); 
                },
            });
            
                
           

        }
        page.prototype.deleteMessage=function(discussID){
            ajax("<?=$_SERVER['PHP_SELF']?>", "POST", "json", ({
                mode: 'delete_message',
                discussID: discussID
            }), true, true, function(response) {
                if (response == true) {
                    $('#discussID'+discussID).remove();
                    // kendo.alert(
                    //     '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                    // );
                    
                } else {
                    kendo.alert(response);
                }
            });
        }
        page.prototype.eventhandle = function() {
            $('#search').on('keypress',function(e){
                if(e.which == 13) {
                    var searchstring = $('#search').val().toUpperCase();
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
                                        orfilter.filters.push({field: 'courseCode',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'courseName',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'fullName',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'assignTitle',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'assignDescription',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'assignDate',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'deadline',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'year',operator: 'contains',value: v1});
                                        orfilter.filters.push({field: 'semester',operator: 'contains',value: v1});
                                        
                                        andfilter.filters.push(orfilter);
                                        orfilter = {
                                            logic: 'or',
                                            filters: []
                                        };
                                    }
                                });
                            }
                        });
                        dataSource.filter(andfilter);
                    } else {
                        dataSource.filter({});
                    }
                }
            });
            $('#chat_input').on('keypress',function(e){
                if(e.which == 13) {
                    if(typeof page.selected==='undefined' || page.selected === null ){
                        kendo.alert(
                            '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please select the assignment you want to discuss.." : "กรุณาเลือกการมอบหมายงานที่ต้องการอภิปราย" ?>'
                        );
                        return;
                    }
                    if($.trim($('#chat_input').val())!='' && $('#photo').val()!='' || $.trim($('#chat_input').val())=='' && $('#photo').val()!=''){//มีทั้งรูปและข้อความ หรือ ไม่มีข้อความมีรูป
                        page.postMessageWithAttach(page.selected.assignID,page.selected.groupNum,'<?=$_SESSION['user']['data'][0]['userID']?>',$('#chat_input').val(),null);
                    }else if($.trim($('#chat_input').val())!='' && $('#photo').val()==''){//มีแต่ข้อความ
                        page.postMessage(page.selected.assignID,page.selected.groupNum,'<?=$_SESSION['user']['data'][0]['userID']?>',$('#chat_input').val(),null);
                    }
                }
            });
            $("#btn-send").click(function() {
                if(typeof page.selected==='undefined' || page.selected === null ){
                    kendo.alert(
                        '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Please select the assignment you want to discuss.." : "กรุณาเลือกการมอบหมายงานที่ต้องการอภิปราย" ?>'
                    );
                    return;
                }
                if($.trim($('#chat_input').val())!='' && $('#photo').val()!='' || $.trim($('#chat_input').val())=='' && $('#photo').val()!=''){//มีทั้งรูปและข้อความ หรือ ไม่มีข้อความมีรูป
                        page.postMessageWithAttach(page.selected.assignID,page.selected.groupNum,'<?=$_SESSION['user']['data'][0]['userID']?>',$('#chat_input').val(),null);
                    }else if($.trim($('#chat_input').val())!='' && $('#photo').val()==''){//มีแต่ข้อความ
                        page.postMessage(page.selected.assignID,page.selected.groupNum,'<?=$_SESSION['user']['data'][0]['userID']?>',$('#chat_input').val(),null);
                    }
            });
            $("#btn-photo").click(function () {
                $("#photo").trigger('click');
            });
            $('#photo').on('change', function() {
                var val = $(this).val();
                $(this).siblings('span').text(val);
            })
        }
    }
    </script>
</body>

</html>