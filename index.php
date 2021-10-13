<?php
    include('config.php');
    $login_button = '';

    if(isset($_GET['code'])){
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if(!isset($token['error'])){
            $client->setAccessToken($token['access_token']);
            $_SESSION['access_token'] = $token['access_token']; 
        }
    }

    if(!isset($_SESSION['access_token'])){
        $login_button = '<a href="'.$client->createAuthUrl().'">this</a>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if($login_button == ''){
            echo '<br><a href="revoke.php">revoke access</a><br>';

            $client->setAccessToken($_SESSION['access_token']);
            $service = new Google\Service\Classroom($client);
            $data_courses = $service->courses->listCourses()->getCourses();
            $data_courseWorks =  $service->courses_courseWork;
            $data_studentSubmissions = $service->courses_courseWork_studentSubmissions;

            foreach ($data_courses as $course) {
                // echo '<pre>'; var_dump($course); '</pre>';
                // echo $course->getName() . ' | ' . $course->getId() . '<br>';
                foreach ($data_courseWorks->listCoursesCourseWork($course->getId()) as $courseWork) {
                    // echo '<pre>'; var_dump($courseWork); '</pre>';
                    foreach ($data_studentSubmissions->listCoursesCourseWorkStudentSubmissions($course->getId(), $courseWork->getId()) as $studentSubmission) {
                        // echo '<pre>'; var_dump($studentSubmission); '</pre>';
                        if($studentSubmission->getState() == 'CREATED'){
                            if(is_null($courseWork->getDueDate())){
                                echo 'No data';
                                return;
                            }else{
                                $day = $courseWork->getDueDate()->getDay();
                                $month = $courseWork->getDueDate()->getMonth();
                                $year = $courseWork->getDueDate()->getYear();

                                $dateObj   = DateTime::createFromFormat('!m', $month);
                                $monthName = $dateObj->format('F');

                                echo '<br><b>Will only get UNFINISHED course works of ' . $course->getName() . '</b><br>';
                                echo $courseWork->getTitle() . ' | Due date: ' . $monthName . '-' . $day . '-' . $year . '<br>';
                            }
                        }
                    }
                }
            }
        }
        else{
            echo '<div>'.$login_button.'</div>';
        }
    ?>
</body>
</html>