<?php
require __DIR__ . '/core/BaseController.php';
require __DIR__ . '/core/Authorization.php';
require __DIR__ . '/core/Posts.php';

class ApplicationController extends BaseController
{
    private $authorization = null;
    private $posts = null;

    private $alert = null;
    private $data = [];

    public function __construct()
    {
        parent::__construct('db/app.db');
        $this->authorization = new Authorization($this->db);
        $this->posts = new Posts($this->db);
    }

    public function start()
    {
        $route = $this->request->get['route'] ?? 'index';

        $actionName = 'Action' . ucfirst(strtolower($route));

        if (method_exists($this, 'Action' . ucfirst($route))) {
            return $this->$actionName();
        } else {
            http_response_code(404);
            return 'Error 404';
        }

    }

    private function setAlert($text, $type = 'danger')
    {
        $this->alert = [
            'type' => $type,
            'text' => $text
        ];
    }

    private function render($viewName, $data = [])
    {
        extract($this->data);
        extract($data);

        $user = $this->authorization->isAuthorized() ? $this->authorization->getCurrentUser() : null;
        $alert = $this->alert;

        ob_start();

        include 'views/' . $viewName . '.php';

        return ob_get_clean();
    }

    private function ActionIndex()
    {
        $this->data['post'] = [
            'title' => '',
            'text' => ''
        ];

        if (!empty($this->request->get['action'])) {
            $action = $this->request->get['action'];

            if ($action == 'register') {
                return $this->register();
            } else if ($action == 'login') {
                return $this->authorize();
            } else if ($action == 'logout') {
                return $this->logout();
            } else if ($action == 'post') {
                $actionType = $this->request->get['actionType'] ?? 'add';

                if ($actionType == 'add') {
                    return $this->addPost();
                } else if ($actionType == 'edit') {
                    return $this->editPost();
                } else if ($actionType == 'delete') {
                    return $this->deletePost();
                }
            }
        }

        $this->data['posts'] = $this->posts->getAll();

        return $this->render('index');
    }

    private function authorize()
    {
        if ($this->authorization->isAuthorized()) {
            $this->setAlert('???? ?????? ????????????????????????');
            return $this->render('index');
        }

        $login = $this->db->escapeValue(htmlspecialchars($this->request->post['login'], ENT_QUOTES) ?? '');
        $password = $this->db->escapeValue(htmlspecialchars($this->request->post['password'], ENT_QUOTES) ?? '');

        if (!$this->authorization->authorizeUser($login, $password)) {
            $this->setAlert('?????????? ???????????????????????? ???? ????????????');
            return $this->render('index');
        }

        return $this->redirect('index');
    }

    private function logout()
    {
        if (!$this->authorization->isAuthorized()) {
            $this->setAlert('???? ???? ????????????????????????');
            return $this->render('index');
        }

        $this->authorization->logout();
        return $this->redirect('index');
    }

    private function register()
    {
        if ($this->authorization->isAuthorized()) {
            $this->setAlert('???? ?????? ????????????????????????');
            return $this->render('index');
        }

        $login = $this->db->escapeValue(htmlspecialchars($this->request->post['login'], ENT_QUOTES) ?? '');
        $password = $this->db->escapeValue(htmlspecialchars($this->request->post['password'], ENT_QUOTES) ?? '');

        if (empty($login) || empty($password)) {
            $this->setAlert('?????????????? ??????????');
            return $this->render('index');
        }

        if (!$this->authorization->registerUser($login, $password)) {
            $this->setAlert('?????????? ???????????????????????? ?????? ????????????????????');
            return $this->render('index');
        }

        return $this->redirect('index');
    }

    private function addPost()
    {
        if (!$this->authorization->isAuthorized()) {
            $this->setAlert('???? ???? ????????????????????????');
            return $this->render('index');
        }

        $title = $this->db->escapeValue(htmlspecialchars($this->request->post['title'], ENT_QUOTES) ?? '');
        $text = $this->db->escapeValue(htmlspecialchars($this->request->post['text'], ENT_QUOTES) ?? '');

        if (empty($title) || empty($text)) {
            $this->setAlert('?????????????? ???????????? ??????????');
            return $this->render('index');
        }

        $this->posts->addPost($this->authorization->getCurrentUserId(), $title, $text);
        return $this->redirect('index');
    }

    private function deletePost()
    {
        if (!$this->authorization->isAuthorized()) {
            $this->setAlert('???? ???? ????????????????????????');
            return $this->render('index');
        }

        $postId = $this->request->get['post_id'];
        if(!is_numeric($postId)){
            return $this->redirect('index');
        }
        $post = $this->posts->getPostById($postId);

        if ($post['user_id'] == $this->authorization->getCurrentUserId()) {
            $this->posts->deletePost($postId);
        }
        return $this->redirect('index');
    }

    private function editPost()
    {
        if (!$this->authorization->isAuthorized()) {
            $this->setAlert('???? ???? ????????????????????????');
            return $this->render('index');
        }

        $postId = $this->request->get['post_id'];
        if(!is_numeric($postId)){
            return $this->redirect('index');
        }

        $this->data['post'] = $this->posts->getPostById($postId);

        if (empty($this->data['post'])) {
            $this->setAlert('?????????????? ?????????? ???? ????????????????????');
            return $this->render('index');
        }

        if ($this->data['post']['user_id'] == $this->authorization->getCurrentUserId()) {
            $title = $this->db->escapeValue(htmlspecialchars($this->request->post['title'], ENT_QUOTES) ?? '');
            $text = $this->db->escapeValue(htmlspecialchars($this->request->post['text'], ENT_QUOTES) ?? '');

            if (empty($title) || empty($text)) {
                return $this->render('index');
            }

            $this->posts->updatePost($postId, $title, $text);
        }
        return $this->redirect('index');
    }


    private function redirect($route): string
    {
        header("Location: index.php?route={$route}");
        return '';
    }
}