<?php

$postsPerPage = 9;

class Post
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchPosts($page)
  {
    global $postsPerPage;

    $offset = ($page - 1) * $postsPerPage;
    $stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :offset, :limit");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchSlugs()
  {
    $stmt = $this->pdo->query("SELECT slug FROM posts");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  public function fetchPostBySlug($slug)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE slug = :slug LIMIT 1");
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function fetchPostByPostId($postId)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function fetchImageUrl($postId)
  {
    $stmt = $this->pdo->prepare("SELECT image_url FROM posts WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchColumn();
  }

  public function updatePost($slug, $title, $imageUrl, $markdown)
  {
    $slugs = $this->fetchSlugs();

    if (in_array($slug, $slugs)) {
      $stmt = $this->pdo->prepare("UPDATE posts SET title = :title, image_url = :image_url, markdown = :markdown WHERE slug = :slug");
    } else {
      $stmt = $this->pdo->prepare("INSERT INTO posts (slug, title, image_url, markdown) VALUES (:slug, :title, :image_url, :markdown)");
    }

    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);
    $stmt->bindParam(':markdown', $markdown, PDO::PARAM_STR);
    $stmt->execute();
  }

  public function deletePost($slug)
  {
    $stmt = $this->pdo->prepare("DELETE FROM posts WHERE slug = :slug");
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
  }
}