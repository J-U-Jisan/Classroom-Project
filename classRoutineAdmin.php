<?php
    session_start();

    if(isset($_POST['submit'])){
        include('./Requests/library/Requests.php');
        Requests::register_autoloader();


        $teacherid = $_POST['teacherid'];
        $courseno = $_POST['courseno'];
        $admin_id = $_SESSION['userid'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $data = array('teacherid' => $teacherid, 'courseno' => $courseno, 'admin_id' => $admin_id, 'day' => $day,'start_time' => $start_time,'end_time' => $end_time);

        $response = Requests::post('http://127.0.0.1/apipro/routine/create.php', array(), $data);
        $rt = $response->body;
        ?>
        <div>
            <script>
                window.alert(<?php echo $rt;?>);
            </script>
        </div>
    <?php
    }
    else if(isset($_POST['update'])){
        include('./Requests/library/Requests.php');
        Requests::register_autoloader();

        $id = $_POST['id'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $data = array('id' => $id, 'day' => $day, 'start_time' => $start_time, 'end_time' => $end_time);
        $response = Requests::post('http://127.0.0.1/apipro/routine/update.php', array(), $data);
        $rt = $response->body;
        ?>
        <div>
            <script>
                window.alert(<?php echo $rt;?>);
            </script>
        </div>
    <?php
    }
    else if(isset($_POST['delete'])){
        include('./Requests/library/Requests.php');
        Requests::register_autoloader();

        $id = $_POST['id'];

        $data = array('id' => $id);
        $response = Requests::post('http://127.0.0.1/apipro/routine/delete.php', array(), $data);
        $rt = $response->body;
        ?>
        <div>
			<script>
				window.alert(<?php echo $rt;?>);
			</script>
		</div>
<?php
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="nav.css">
    <title><?php echo $_SESSION['userid'] . '(ADMIN)';?></title>
    <style>

        .format{
            width: 100%;
            padding: 12px 20px;
            font-size:14px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;

        }
        #submit{
            width:50%;
            margin-top: 20px;
            padding:3px 15px;
            margin: 8px,0;
            border-radius: 10px;
            box-sizing: border-box;
            font-size:22px;
            background-color: #3973dd73;
        }
        #submit:hover{
            background-color: #245cc4;
            color:white;
        }
    </style>
</head>
<body style="background-color: #858ea1;" onload="list()">
<div style="background-color: #b0d791;">
    <span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teacher's Zone</span>
    <a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
    <span style="float: right;font-size: 23px;">|&nbsp</span>
    <a href="admin.php" class="hsign"><span style="float: right;font-size: 23px;"><?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
    </br>
    <span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>
</div>
</br>
<header>
    <nav>
        <a class="hsign" href="admin.php">Home</a>
        <a class="hsign"  style="color: blue;" href="classRoutineAdmin.php">Class Routine</a>
        <div class="dropdown" style="margin-left: 10px;">
            <button class="dropbtn">Cancel Course
                <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
            </button>
            <div class="dropdown-content">
                <a href="cancel_course_teacher.php">from Teacher</a>
                <a href="#">from Student</a>

            </div>
        </div>
        <div class="dropdown" style="margin-left: 10px;">
            <button class="dropbtn">Assign Course
                <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
            </button>
            <div class="dropdown-content">
                <a href="assign_course_teacher.php">to Teacher</a>
                <a href="assign_course_student.php">to Student</a>

            </div>
        </div>

        <div class="dropdown" style="margin-left: 10px;">
            <button class="dropbtn">Course
                <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
            </button>
            <div class="dropdown-content">
                <a href="courseregister.php">Add Course</a>
                <a href="course_list.php">Course List</a>
                <a href="delete_course.php">Delete Couse</a>
            </div>
        </div>

        <div class="dropdown" style="margin-left: 10px;">
            <button class="dropbtn">Student
                <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
            </button>
            <div class="dropdown-content">
                <a href="studentregister.php">Admit Student</a>
                <a href="students_list.php">Student List</a>
                <a href="delete_student.php">Delete Student</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn">Teacher
                <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
            </button>
            <div class="dropdown-content">
                <a href="teacherregister.php">Admit Teacher</a>
                <a href="teachers_list.php">Teacher List</a>
                <a href="delete_teacher.php">Delete Teacher</a>
            </div>
        </div>
    </nav>
</header>
<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#66b1a8);padding: 10px;margin-top: 10px;min-height: 415px;">
    <div id="list">
        <button class="button" title="Assign Assignment" onclick="assign()">+</button>

          <?php
            $url = "http://127.0.0.1/apipro/routine/read.php";
            $json = file_get_contents($url);
            $contents = json_decode($json,true);
            $data = $contents['records'];

            $ar = array();

            foreach ($data as $key => $value) {
                if($value['courseno']=='111' && $value['teacherid'] == '111') continue;
                if($value['admin_id'] == $_SESSION['userid']){
                ?>
                <div style="width: 80%; background: #cfd4ef; margin-top: 10px; padding: 10px;">
                    <div style="text-align: center;">
                        <span style="font-size: 20px; margin-right: 10px; margin-left: 10px;"><?php echo 'Teacher Id : ' . $value['teacherid'] . ' ,'; ?></span>
                        <span style="font-size: 20px; margin-right: 10px; display: inline-block;"><?php echo 'Course No : ' . $value['courseno']; ?></span>
                    </div>
                    <div style="margin-top: 15px;">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                            <select name="day" class="format" style="width: 20%; display: inline-block;">
                                <option <?php echo $value['day']=='Saturday'?'selected':''; ?> >Saturday</option>
                                <option <?php echo $value['day']=='Sunday'?'selected':''; ?> >Sunday</option>
                                <option <?php echo $value['day']=='Monday'?'selected':''; ?> >Monday</option>
                                <option <?php echo $value['day']=='Tuesday'?'selected':''; ?> >Tuesday</option>
                                <option <?php echo $value['day']=='Wednesday'?'selected':''; ?> >Wednesday</option>
                                <option <?php echo $value['day']=='Thursday'?'selected':''; ?> >Thursday</option>
                                <option <?php echo $value['day']=='Friday'?'selected':''; ?> >Friday</option>
                            </select>
                            <div style="width: 15%; display: inline-block; margin-left: 15px;">
                                <label>Start Time: </label>
                                <input type="time" name="start_time" value="<?php echo $value['start_time']; ?>" class="format">
                            </div>
                            <div style="width: 15%; display: inline-block; margin-left: 15px;">
                                <label>End Time: </label>
                                <input type="time" name="end_time" value="<?php echo $value['end_time']; ?>" class="format">
                            </div>
                            <div style="width: 40%; display: inline-block; text-align: right;">
                                <input type="submit" value="UPDATE" name="update" style="padding: 10px; background: #4ee782; border-radius: 5px; margin-right: 5px;">
                                <input type="submit" value="DELETE" name="delete" style="padding: 10px; background: #e09fa9; border-radius: 5px; margin-left: 5px;" onclick="return ConfirmDelete();">
                            </div>
                        </form>
                    </div>
                </div>

        <?php
                }
            }
          ?>
    </div>
    <div id="add">
    <div id="Frame0">
        <form action="" method="post">
            <label for="teacherid">Enter Teacher Id:</label>
            <input class="format" type="text" name="teacherid" placeholder="Enter Teacher Id" id="teacher" required>
            <label for="courseno">Enter Course No:</label>
            <input class="format" type="text" name="courseno" placeholder="Enter Course No" id="courseno" required>
            <label for="day">Select Day: </label>
            <select id="day"name="day" class="format" required>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
            <div style="width: 50%; display: inline-block;">
                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time" required>
            </div>
            <div style="width: 50%; float:right;">
                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" id="end_time">
            </div>
            <div style="text-align: center;">
                <input type="submit" value="Submit" name="submit" id="submit" onclick="list()">
            </div>

        </form>
    </div>
    </div>
</div>
<footer>
    <div style="padding: 10px;margin-top: 10px;text-align: center;">

        <hr>
        <a href="home.php">Teacher's Zone </a>© Copyright 2019-<?php echo date("Y").' ';?> Jalal Uddin Jisan
        <br>
        Server time:<?php $timezone = date_default_timezone_set('Asia/Dhaka');
        $date = date('d/m/Y h:i:s A',time());
        echo ' '.$date;?>

    </div></footer>
<script>
    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete?");
        if (x)
            return true;
        else
            return false;
    }
</script>
<script type="text/javascript">
    function list() {
        document.getElementById("list").style.display = "block";
        document.getElementById("add").style.display = "none";
    }

    function assign() {
        document.getElementById("list").style.display = "none";
        document.getElementById("add").style.display = "block";
    }
</script>
<script>
    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete?");
        if (x)
            return true;
        else
            return false;
    }
</script>
</body>
</html>
