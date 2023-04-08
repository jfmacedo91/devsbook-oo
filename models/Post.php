<?php
  class Post {
    public $id;
    public $user_id;
    public $type;
    public $created_at;
    public $body;
    public $mine;
    public $likeCount;
    public $liked;
    public $comments;
    public User $user;
  }

  interface PostDAO {
    public function insert(Post $post);
    public function getHomeFeed($userId);
    public function getUserFeed($userId, $loggedUserId);
    public function getUserPhotos($userId);
  }
?>