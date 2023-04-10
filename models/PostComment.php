<?php
  class PostComment {
    public $id;
    public $postId;
    public $userId;
    public $userAvatar;
    public $userName;
    public $createdAt;
    public $body;
  }

  interface PostCommentDAO {
    public function getComments($postId);
    public function addComments(PostComment $postComment);
  }
?>