<?php
  class Relationship {
    public $id;
    public $user_from;
    public $user_to;
  }

  interface RelationshipDAO {
    public function insert(Relationship $relationship);
    public function getRelationshipFrom($userId);
  }
?>