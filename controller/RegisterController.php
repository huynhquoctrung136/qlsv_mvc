<?php

class RegisterController {
    protected $redirectTo="/?c=register";
public function list()
{
  
    $registerRepository = new RegisterRepository();
    $search="";
    if(!empty($_GET["search"])){
        $search=$_GET["search"];
        $registers=$registerRepository->getBySearch($search);
    }
    else{
        $registers = $registerRepository->getAll();
        // var_dump($registers);
    }
    require "views/register/list.php";
}

//add Register
function add()
{
    //Lấy ra danh sách sinh viên
    $studentRepository = new StudentRepository();
    $students=$studentRepository->getAll();

    //Lấy ra danh sách môn học
    $subjectRepository = new SubjectRepository();
    $subjects=$subjectRepository->getAll();

    require "views/register/add.php";
}

function save(){
    $data = $_POST;
    $registerRepository = new RegisterRepository();
    if($registerRepository->save($data)){
    $_SESSION["success"] = "Đã tạo đăng ký môn học thành công";
    }
    else{
    $_SESSION["error"] = $registerRepository->error;
    }

    header("Location: {$this->redirectTo}");
}

//Edit
function edit(){
    $id=$_GET["id"];
    $registerRepository = new RegisterRepository();
    $register=$registerRepository->find($id);
    require "views/register/edit.php";
}

//update

function update(){
    $id = $_POST["id"];
    $register=$registerRepository = new RegisterRepository();
    $register=$registerRepository->find($id);
    $register->student_id=$_POST["student_id"];
    $register->subject_id=$_POST["subject_id"];
    $register->score=$_POST["score"];
  
    if($registerRepository->update($register)){
    $_SESSION["success"] = "Đã cập nhật đăng ký môn học thành công";
    }
    else{
    $_SESSION["error"] = $registerRepository->error;
    }

    header("Location: {$this->redirectTo}");
}

function delete(){
    $id = $_GET["id"];
    $register=$registerRepository = new RegisterRepository();
    if($registerRepository->delete($id)){
        $_SESSION["success"] = "Đã xóa đăng ký môn học thành công";
        }
        else{
        $_SESSION["error"] = $registerRepository->error;
        }
    
        header("Location: {$this->redirectTo}");
}

}