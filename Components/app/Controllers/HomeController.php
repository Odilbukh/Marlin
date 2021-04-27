<?php
namespace App\controllers;
if( !session_id() ) @session_start();
use App\QueryBuilder;
use Exception;
use League\Plates\Engine;
use PDO;
use Tamtamchik\SimpleFlash\Flash;
use Delight\Auth\Auth;


class HomeController {
    private $flash, $qb, $auth, $templates;
    private $selector, $token;

    public function __construct(QueryBuilder $qb, Flash $flashmessage, Engine $engine, Auth $auth){
        $this->flash = $flashmessage;
        $this->qb = $qb;
        $this->templates = $engine;
        $db = new PDO("mysql:host=localhost;dbname=marlin_4;", "root", "root");
        $this->auth = $auth;
    }

    public function index() {
        $users = $this->qb->getAll('users');
        echo $this->templates->render('homepage', ['users' => $users, 'auth' => $this->auth]);
    }

    public function about() {
        $id = $_GET['id'];
        $users = $this->qb->selectOne($id, 'users');
        echo $this->templates->render('about', ['users' => $users, 'auth' => $this->auth]);

    }

    public function register() {
        if (!empty($_POST)) {
            if($_POST['password'] <> $_POST['password_again']) {
                $this->flash->error('Password mismatch');
            } else {
                try {
                    $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['name']);
                    $this->flash->success('Success registration');
                    header('Location: /register');
                }
                catch (\Delight\auth\InvalidEmailException $e) {
                    $this->flash->error('Invalid email address');
                }
                catch (\Delight\auth\InvalidPasswordException $e) {
                    $this->flash->error('Invalid password');
                }
                catch (\Delight\auth\UserAlreadyExistsException $e) {
                    $this->flash->error('User already exists');
                }
                catch (\Delight\auth\TooManyRequestsException $e) {
                    $this->flash->error('Too many requests');
                }
            }
        }
        echo $this->templates->render('register', ['auth' => $this->auth, 'flash' => $this->flash]);
    }

    public function login() {
        if (!empty($_POST)) {
            try {
                $this->auth->login($_POST['email'], $_POST['password']);
                $this->flash->message('login success');
                header('Location: /profile');
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                $this->flash->error('Wrong email address');
                header('Location:/login');
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                $this->flash->error('Wrong password');
                header('Location:/login');
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                $this->flash->error('Email not verified');
                header('Location:/login');
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                $this->flash->error('Too many requests');
                header('Location:/login');
            }
        }

        echo $this->templates->render('login', ['auth' => $this->auth, 'flash' => $this->flash]);

    }

    public function logout(){
        $this->auth->logOut();
        header('Location: /');
    }

    public function admin(){
        $users = $this->qb->getAll('users');
        echo $this->templates->render('admin', ['users' => $users, 'auth' => $this->auth]);
    }

    public function assignrole(){
        if ($this->auth->isLoggedIn()){
            if ($this->auth->hasRole(1)){
                $id = $_GET['id'];
                if (!empty($_GET)){
                    try {
                        $this->auth->admin()->addRoleForUserById($id, \Delight\Auth\Role::ADMIN);
                    }
                    catch (\Delight\Auth\UnknownIdException $e) {
                        die('Unknown user ID');
                    }
                }
                header('Location: /admin');
            }
        }else{
            header('Location: /');
        }

    }

    public function takeawayrole(){
        if ($this->auth->isLoggedIn()){
            if ($this->auth->hasRole(1)){
                if (!empty($_GET)){
                    try {
                        $id = $_GET['id'];
                        $this->auth->admin()->removeRoleForUserById($id, \Delight\Auth\Role::ADMIN);
                        header('Location: /admin');
                    }
                    catch (\Delight\Auth\UnknownIdException $e) {
                        die('Unknown user ID');
                    }
                }
            }
        }else{
            header('Location: /');
        }

    }

    public function userprofile(){
        if ($this->auth->isLoggedIn()){
            if ($this->auth->hasRole(1)){
                if (!empty($_GET)){
                    $id = $_GET['id'];
                    $users = $this->qb->selectOne($id, 'users');
                    echo $this->templates->render('userprofile', ['users' => $users, 'auth' => $this->auth]);
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function deleteuser(){
        if ($this->auth->isLoggedIn()){
            if ($this->auth->hasRole(1)){
                if (!empty($_GET)){
                    $id = $_GET['id'];
                    try {
                        $this->auth->admin()->deleteUserById($id);
                        header('Location: /admin');
                    }
                    catch (\Delight\Auth\UnknownIdException $e) {
                        die('Unknown ID');
                    }
                }
            }
        }else{
            header('Location: /');
        }
    }

    public function changeuser(){
        if ($this->auth->isLoggedIn()) {
            if ($this->auth->hasRole(1)) {
                if (!empty($_GET)) {
                    $id = $_GET['id'];
                    $users = $this->qb->selectOne($id, 'users');
                    echo $this->templates->render('changeuser', ['users' => $users, 'auth' => $this->auth]);
                }
                if (!empty($_POST)){
                    $this->qb->update([
                        'username' => $_POST['name']
                    ], $id, 'users');
                    header('Location: /admin');
                }
            }
        }else{
            header('Location: /');
        }

    }

    public function profile(){
        if ($this->auth->isLoggedIn()){
            $id = $this->auth->id();
            $users = $this->qb->selectOne($id, 'users');
            echo $this->templates->render('profile', ['users' => $users, 'auth' => $this->auth, 'flash' => $this->flash]);
        }else{
            header('Location:/');
        }

    }

    public function updateprofile(){
        if ($this->auth->isLoggedIn()){
            $id = $this->auth->id();
            $data = $_POST['name'];
            $this->qb->update([
                'username' => $data
            ], $id, 'users');
            header('Location: /profile');
        }else{
            header('Location:/');
        }
    }

    public function changepassword(){
        if ($this->auth->isLoggedIn()){
            echo $this->templates->render('changepassword', ['auth' => $this->auth]);
        }else{
            header('Location:/');
        }
    }

    public function changepasswordrequest(){
        if ($this->auth->isLoggedIn()){
            if ($_POST['oldPassword'] <> $_POST['newPassword']){
                try {
                    $this->auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);

                    echo 'Password has been changed';
                }
                catch (\Delight\Auth\NotLoggedInException $e) {
                    die('Not logged in');
                }
                catch (\Delight\Auth\InvalidPasswordException $e) {
                    die('Invalid password(s)');
                }
                catch (\Delight\Auth\TooManyRequestsException $e) {
                    die('Too many requests');
                }
            }
        }else{
            header('Location:/');
        }
    }
    
}