<?php
  class Relationship {
    public $id;
    public $userFrom;
    public $userTo;
  }

  interface RelationshipDAO {
    public function insert(Relationship $relationship);
    public function delete(Relationship $relationship);
    public function getFollowing($userId);
    public function getFollowers($userId);
  }
?>