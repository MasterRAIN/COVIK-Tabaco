<?php

session_start();
require('connect.php');



function dd($value) // to be deleted
{
     echo "<pre>", print_r($value, true), "</pre>";
     die();
}


function executeQuery($sql, $data) {
     global $conn;
     $stmt = $conn->prepare($sql);
     $values = array_values($data);
     $types = str_repeat('s', count($values));
     $stmt->bind_param($types, ...$values);
     $stmt->execute();
     return $stmt;
}

function selectAll($table, $conditions = [])
{
     global $conn;
     $sql = "SELECT * FROM $table";
     if (empty($conditions)) {
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     } else { 
          $i = 0;
          foreach ($conditions as $key => $value) {
               if ($i === 0) {
                    $sql = $sql . " WHERE $key=?";
               } else {
                    $sql = $sql . " AND $key=?";
               }
               $i++;
          }

          $stmt = executeQuery($sql, $conditions);
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     }
}


function selectOne($table, $conditions)
{
     global $conn;
     $sql = "SELECT * FROM $table";
     $i = 0;
     foreach ($conditions as $key => $value) {
          if ($i === 0) {
               $sql = $sql . " WHERE $key=?";
          } else {
               $sql = $sql . " AND $key=?";
          }
          $i++;
     }

     $sql = $sql . " LIMIT 1";
     $stmt = executeQuery($sql, $conditions);
     $records = $stmt->get_result()->fetch_assoc();
     return $records;
}


function create($table, $data) {
     global $conn;
     $sql = "INSERT INTO $table SET ";

     $i = 0;
     foreach ($data as $key => $value) {
          if ($i === 0) {
               $sql = $sql . " $key=?";
          } else {
               $sql = $sql . ", $key=?";
          }
          $i++;
     }

     $stmt = executeQuery($sql, $data);
     $id = $stmt->insert_id;
     return $id;
}

function update($table, $id, $data) {
     global $conn;
     $sql = "UPDATE $table SET ";

     $i = 0;
     foreach ($data as $key => $value) {
          if ($i === 0) {
               $sql = $sql . " $key=?";
          } else {
               $sql = $sql . ", $key=?";
          }
          $i++;
     }

     $sql = $sql . " WHERE id=?";
     $data['id'] = $id;
     $stmt = executeQuery($sql, $data);
     return $stmt->affected_rows;
} 

function delete($table, $id) {
     global $conn;
     $sql = "DELETE FROM $table WHERE id=?";

     $stmt = executeQuery($sql, ['id' => $id]);
     return $stmt->affected_rows;
}

function getPublishedPosts() {
     global $conn;
     $sql = "SELECT p.*, u.username, t.name FROM posts AS p
     JOIN users AS u ON p.user_id=u.id 
     JOIN topics as t ON t.id = p.topic_id
     WHERE p.published=? ORDER BY RAND() LIMIT 10";

     $stmt = executeQuery($sql, ['published' => 1]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

function getRecentPosts() {
     global $conn;
     $sql = "SELECT p.*, u.username, t.name FROM posts AS p
     JOIN users AS u ON p.user_id=u.id 
     JOIN topics as t ON t.id = p.topic_id
     WHERE p.published=? ORDER BY created_at DESC";

     $stmt = executeQuery($sql, ['published' => 1]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

//PAGINATED RECENT POSTS

function getPaginatedRecentPosts() {
     global $conn;

     $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
     $recordsPerPage = 5;

     $sql = "SELECT p.*, u.username, t.name FROM posts AS p
     JOIN users AS u ON p.user_id=u.id 
     JOIN topics as t ON t.id = p.topic_id
     WHERE p.published=1 ORDER BY created_at DESC LIMIT ?,?";

     $data =[
          'offset' => ($currentPage - 1) * $recordsPerPage,
          'numberOfRecords' => $recordsPerPage
     ];

     $stmt = executeQuery($sql, $data);

     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     $numberOfPages = ceil(totalRows()/ $recordsPerPage);

     $pageData = [
          'records' => $records,
          'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
          'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
      ];

     return $pageData;
}

function totalRows() {
     global $conn;
     $sql = "SELECT * FROM posts WHERE published=?";
     $stmt = executeQuery($sql, ['published' => 1]);
     $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     $total = sizeof($posts);

     return $total;
} 

function getPostsByTopicId($topic_id) {
     global $conn;
     $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=? ORDER BY created_at DESC LIMIT 0,18446744073709551615";
 
     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

//PAGINATED POSTS BY TOPIC ID

function getPaginatedPostsByTopicId($topic_id) {
     global $conn;

     $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
     $recordsPerPage = 5;

     $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=1 AND topic_id=? ORDER BY created_at DESC LIMIT ?,?";

     $data =[
          'topic_id' => $topic_id,
          'offset' => ($currentPage - 1) * $recordsPerPage,
          'numberOfRecords' => $recordsPerPage
     ];
 
     $stmt = executeQuery($sql, $data);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     $numberOfPages = ceil(totalTopicRows()/ $recordsPerPage);

     $pageData = [
          'records' => $records,
          'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
          'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
      ];

     return $pageData;
}

function totalTopicRows() {
     global $conn;
     $sql = "SELECT * FROM posts WHERE published=? AND topic_id=?";
     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $_GET['t_id']]);
     $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     $total = sizeof($posts);
     //echo $total;

     return $total;
}

function getLatestPostByTopicId($topic_id) {
     global $conn;
     $sql = "SELECT p.*, u.username FROM posts as p JOIN topics as t on p.topic_id=t.id JOIN users as u on u.id=p.user_id WHERE p.published=? AND p.topic_id=? ORDER BY created_at DESC LIMIT 1";

     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     
     return $records;
}

/*------------------------ADDED FUNCTIONS------------------------*/
function getLatestPostByTopicId_2($topic_id) {
     global $conn;
     $sql = "SELECT p.*, u.username FROM posts as p JOIN topics as t on p.topic_id=t.id JOIN users as u on u.id=p.user_id WHERE p.published=? AND p.id=? ORDER BY created_at DESC LIMIT 1";

     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

function getPostsByTopicId_2($topic_id, $excluded_post_id) {
     global $conn;
     $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=? AND p.id != ? ORDER BY created_at DESC";
 
     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id, 'p.id' => $excluded_post_id]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

//PAGINATED VERSION OF getPostsByTopicId_2()
function getPaginatedPostsByTopicId_2($topic_id, $excluded_post_id) {
     global $conn;

     $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
     $recordsPerPage = 5;

     $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=1 AND topic_id=? AND p.id != ? ORDER BY created_at DESC LIMIT ?,?";

     $data =[
          'topic_id' => $topic_id, 
          'p.id' => $excluded_post_id,
          'offset' => ($currentPage - 1) * $recordsPerPage,
          'numberOfRecords' => $recordsPerPage
     ];
 
     $stmt = executeQuery($sql, $data);

     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     $numberOfPages = ceil(totalRelatedPostsRows($topic_id, $excluded_post_id)/ $recordsPerPage);
     
     $pageData = [
          'records' => $records,
          'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
          'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
      ];

     return $pageData;
}

function totalRelatedPostsRows($topic_id, $excluded_post_id) {
     global $conn;
     $sql = "SELECT p.* FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=1 AND topic_id=? AND p.id != ?";
     $stmt = executeQuery($sql, ['topic_id' => $topic_id, 'p.id' => $excluded_post_id]);
     $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     $total = sizeof($posts);
     //echo($total);

     return $total;
}

/*------------------------END OF ADDED FUNCTIONS------------------------*/


function getPopularTopics($topic_id) {
     global $conn;
     $sql = "SELECT t.name as 'Topic', COUNT(p.id) 
     FROM `topics` as t 
     INNER JOIN `posts` as p 
     ON t.id = p.topic_id
     GROUP BY t.name";

     $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

function searchPosts($term) {
     $match = '%' . $term . '%';
     global $conn;
     $sql = "SELECT 
               p.*, u.username 
          FROM posts AS p 
          JOIN users AS u 
          ON p.user_id=u.id 
          WHERE p.published=?
          AND p.title LIKE ? OR p.body LIKE ?";

     $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}
// PAGINATED SEARCHED POSTS

function paginatedSearchPosts($term){
     $match = '%' . $term . '%';
     global $conn;

     $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
     $recordsPerPage = 5;

     $sql = "SELECT 
               p.*, u.username 
          FROM posts AS p 
          JOIN users AS u 
          ON p.user_id=u.id 
          WHERE p.published=1
          AND (p.title LIKE ? OR p.body LIKE ?) LIMIT ?,?";

     $data =[
          'title' => $match, 
          'body' => $match,
          'offset' => ($currentPage - 1) * $recordsPerPage,
          'numberOfRecords' => $recordsPerPage
     ];

     $stmt = executeQuery($sql, $data);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     $numberOfPages = ceil(totalSearchRows($match)/ $recordsPerPage);

     $pageData = [
          'records' => $records,
          'prevPage' => $currentPage > 1 ? $currentPage - 1 : false,
          'nextPage' => $currentPage + 1 <= $numberOfPages ? $currentPage + 1 : false,
      ];
     return $pageData;
}

function totalSearchRows($term) {
     global $conn;
     $sql = "SELECT 
     p.*, u.username 
     FROM posts AS p 
     JOIN users AS u 
     ON p.user_id=u.id WHERE p.published=1
     AND p.title LIKE ? OR p.body LIKE ?";
     $stmt = executeQuery($sql, ['title' => $term, 'body' => $term]);
     $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     $total = sizeof($posts);
     //echo $total;

     return $total;
}

function selectAllRecent($table, $conditions = [])
{
     global $conn;
     $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 5";
     if (empty($conditions)) {
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     } else { 
          $i = 0;
          foreach ($conditions as $key => $value) {
               if ($i === 0) {
                    $sql = $sql . " WHERE $key=?";
               } else {
                    $sql = $sql . " AND $key=?";
               }
               $i++;
          }

          $stmt = executeQuery($sql, $conditions);
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     }
}

function selectAllRecents($table, $conditions = [])
{
     global $conn;
     $sql = "SELECT * FROM $table ORDER BY created_at DESC LIMIT 10";
     if (empty($conditions)) {
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     } else { 
          $i = 0;
          foreach ($conditions as $key => $value) {
               if ($i === 0) {
                    $sql = $sql . " WHERE $key=?";
               } else {
                    $sql = $sql . " AND $key=?";
               }
               $i++;
          }

          $stmt = executeQuery($sql, $conditions);
          $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          return $records;
     }
}
//SEARCH POST ON ADMIN SECTION
function adminSearchPosts($term) {
     $match = '%' . $term . '%';
     global $conn;
     $sql = "SELECT * FROM posts
          WHERE title LIKE ? OR body LIKE ?";

     $stmt = executeQuery($sql, ['title' => $match, 'body' => $match]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

//GETTING AUTHOR POSTS
function authPosts(){
     $currentUser = $_SESSION['id'];
     $sql = "SELECT * FROM users LEFT OUTER JOIN posts ON users.id=posts.user_id WHERE users.id = ?";

     $stmt = executeQuery($sql, ['id' => $currentUser]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}

//SEARCH AUTHOR POSTS
function authSearchPosts($term) {
     $currentUser = $_SESSION['id'];
     $match = '%' . $term . '%';
     global $conn;
     $sql = "SELECT * FROM users LEFT OUTER JOIN posts ON users.id=posts.user_id 
     WHERE users.id=? AND (posts.title LIKE ? OR posts.body LIKE ?)";

     $stmt = executeQuery($sql, ['id' => $currentUser, 'title' => $match, 'body' => $match]);
     $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     return $records;
}