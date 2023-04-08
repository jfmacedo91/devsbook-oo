<?php
  class PostLike {
    public $id;
    public $postId;
    public $userId;
    public $createdAt;
  }

  interface PostLikeDAO {
    public function getLikeCount($postId);
    public function isLiked($postId, $userId);
    public function toggleLike($postId, $userId);
  }
?>