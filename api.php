<?php

use function PHPSTORM_META\type;

include('config.php');
$course_collection = [];
$coursework_collection = [];
$collection = [];

$flag = 0;
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
    }
}

if (isset($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['access_token']);
    $service = new Google\Service\Classroom($client);
    $data_courses = $service->courses->listCourses()->getCourses();
    $data_courseWorks =  $service->courses_courseWork;
    $data_studentSubmissions = $service->courses_courseWork_studentSubmissions;

    foreach ($data_courses as $course) {
        foreach ($data_courseWorks->listCoursesCourseWork($course->getId()) as $courseWork) {
            foreach ($data_studentSubmissions->listCoursesCourseWorkStudentSubmissions($course->getId(), $courseWork->getId()) as $studentSubmission) {
                if ($studentSubmission->getState() == 'CREATED') {
                    if (is_null($courseWork->getDueDate())) {
                        echo 'No data';
                        $flag = 1;
                        return;
                    } else {
                        $courseWork->courseName = $course->getname();
                        array_push($collection, $courseWork);
                    }
                }
            }
        }
    }
    if($flag==0){
        echo json_encode($collection);
        // echo '<pre>' . var_dump($collection) . '</pre>';
    }
}

if (!isset($_SESSION['access_token'])) {
    echo $client->createAuthUrl();
}
