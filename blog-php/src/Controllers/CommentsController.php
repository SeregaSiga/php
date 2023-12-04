<?php

namespace Controllers;

use Models\Comments\Comment;
use Models\Users\User;
use View\View;
use Models\Articles\Article;

class CommentsController
{
    private $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function view(int $commentId) {
        $article = Article::getById($commentId);
        $comments = Comment::findAll();

        if ($comments === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('comments/show.php', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(int $commentId): void {
        $comment = Comment::getById($commentId);
        $article = Article::getById($comment->getArticleId());
        if ($comment === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $comment->setText($_POST['text']);
        $comment->save();
        header('Location: http://localhost/project/www/article/show/'.$article->getId());
    }

    public function add(): void {
        $author = User::getById(1);

        $pattern = '~comments/add/(\d+)~';
        preg_match($pattern, $_GET['route'], $matches);

        $article = Article::getById($matches[1]);
        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setArticle($article);
        $comment->setText($_POST["text"]);

        $comment->save();
    }

    public function delete(int $id) {
        $comment = Comment::getById($id);
        $comment->destroy();

    }
}