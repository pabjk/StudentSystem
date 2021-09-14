<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Student Grouping System</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a class="nav-link" href="#"><?=($_SESSION['setting']['lang']=='en'?'Signed in as ':'ลงชื่อเข้าใช้โดย ').$_SESSION[ 'user' ]['data'][0]['fullName']?></a>
        <a class="nav-link" href="signout.php"><?=$_SESSION['setting']['lang']=='en'?'Sign out':'ออกจากระบบ';?></a>
        <div class="btn-group me-2 mt-1">
            <button type="button" onclick="switchLanguage('en')"
                class="btn btn-sm btn-outline-secondary <?=$_SESSION['setting']['lang']=='en'?'active':'';?>">EN</button>
            <button type="button" onclick="switchLanguage('th')"
                class="btn btn-sm btn-outline-secondary <?=$_SESSION['setting']['lang']=='th'?'active':'';?>">TH</button>
        </div>

    </div>
</header>