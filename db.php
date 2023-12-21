<?php
class DB
{
    public $conn;
    private $user = 'root';
    private $password = '';
    private $db = 'php_shop';
    private $host = 'localhost';
    private $port = 3306;

    function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db, $this->port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function userExist($email)
    {
        $res = mysqli_query($this->conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');
        return mysqli_num_rows($res) > 0;
    }

    function addUser($email, $password, $user_name, $user_surname)
    {
        $query = "INSERT INTO users (name, surname, email, password) VALUES ('$user_name', '$user_surname', '$email', '$password')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;

        $this->conn->close();
    }

    function LoginAuto($email, $pass)
    {
        $query = mysqli_query($this->conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
        if (mysqli_num_rows($query) > 0) {
            return mysqli_fetch_assoc($query);
        }
        return null;
    }

    function getAdmCount()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS admin_count FROM users WHERE user_type = 'admin'");
        $result = mysqli_fetch_assoc($query);
        $adminCount = $result['admin_count'];
        return $adminCount;
    }

    function getUserCount()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS user_count FROM users WHERE user_type = 'user'");
        $result = mysqli_fetch_assoc($query);
        $adminCount = $result['user_count'];
        return $adminCount;
    }

    function getCount()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM users WHERE user_type <> 'owner';");
        $result = mysqli_fetch_assoc($query);
        $adminCount = $result['count'];
        return $adminCount;
    }

    function getMessagesCount()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM messages WHERE viewed='0'");
        $result = mysqli_fetch_assoc($query);
        $adminCount = $result['count'];
        return $adminCount;
    }

    function getUserByID($id)
    {
        $query = "SELECT * FROM users WHERE id='$id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getOwnerByID($id)
    {
        $query = "SELECT * FROM users WHERE id='$id' AND user_type='owner'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getAdminByID($id)
    {
        $query = "SELECT * FROM users WHERE id='$id' AND user_type='admin'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getUserMessages($email)
    {
        $query = "SELECT * FROM messages WHERE email='$email' LIMIT 1 ";
        $result = $this->conn->query($query);

        return $result->num_rows == 1;
    }

    function sendMessage($user_id, $email, $name, $message)
    {
        $query = "INSERT INTO messages (user_id, name, email, message) VALUES ('$user_id', '$name', '$email', '$message')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    function getMessages()
    {
        $query = "SELECT * FROM messages ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function notViewed()
    {
        $query = "SELECT * FROM messages WHERE viewed='0' ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function Viewed()
    {
        $query = "SELECT * FROM messages WHERE viewed='1' ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function MessageByID($id)
    {
        $query = "SELECT * FROM messages WHERE id='$id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function updateUserType($email)
    {
        $query = "UPDATE users SET user_type = 'admin' WHERE email = '$email'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function updateView($id)
    {
        $query = "UPDATE messages SET viewed = '1' WHERE id = '$id'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function getAdmins()
    {
        $query = "SELECT * FROM users WHERE user_type='admin'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getUsers()
    {
        $query = "SELECT * FROM users WHERE user_type='user'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getAllUsers()
    {
        $query = "SELECT * FROM users WHERE user_type <> 'owner'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id='$id'";
        $result = $this->conn->query($query);

        return $result === true;
    }

    function updateUser($id, $name, $surname, $password, $type)
    {
        $query = "UPDATE users SET name='$name', surname='$surname', password='$password', user_type='$type' WHERE id='$id'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function insertFeedback($id, $name, $content, $rate)
    {
        $query = "INSERT INTO feedbacks (user_id, user_name, content, rate) VALUES ('$id', '$name', '$content', '$rate')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;

        $this->conn->close();
    }

    function getFeedbacks($page)
    {
        $query = "SELECT * FROM feedbacks ORDER BY created_at DESC LIMIT $page, 8";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getFeedBacksCount()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS page_count FROM feedbacks");
        $result = mysqli_fetch_assoc($query);
        $page_count = $result['page_count'];
        return $page_count;
    }

    function isViewed($id)
    {
        $query = "SELECT * FROM messages WHERE user_id='$id' AND viewed='1'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function insertProduct($adm, $title, $price, $category, $desc)
    {
        $query = "INSERT INTO products (user_id, title, price, category, description) VALUES ('$adm', '$title', '$price', '$category', '$desc')";
        if ($this->conn->query($query) === TRUE) {
            return $this->conn->insert_id;
        } else {
            return FALSE;
        }
    }

    function getAdminByProduct($pr_id)
    {
        $query = "SELECT * FROM products WHERE id='$pr_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getAllProducts($id)
    {
        $query = "SELECT * FROM products WHERE user_id='$id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();
    }

    function getAll()
    {
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);
        if ($result) {
            if ($result->num_rows > 0) {
                $products = $result->fetch_all(MYSQLI_ASSOC);
                $this->conn->close();
                return $products;
            }
        }
        $this->conn->close();
        return array();
    }

    function getAllByUser($user_id)
    {
        $query = "SELECT * FROM products WHERE user_id='$user_id'";
        $result = $this->conn->query($query);
        if ($result) {
            if ($result->num_rows > 0) {
                $products = $result->fetch_all(MYSQLI_ASSOC);
                $this->conn->close();
                return $products;
            }
        }
        $this->conn->close();
        return array();
    }

    function getProducts($id, $page)
    {
        $query = "SELECT * FROM products WHERE user_id='$id' LIMIT $page, 8";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }


    function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id='$id'";
        $result = $this->conn->query($query);

        return $result === true;
    }

    function getProductsCount($id)
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS products_count FROM products");
        $result = mysqli_fetch_assoc($query);
        $page_count = $result['products_count'];
        return $page_count;
    }

    function getProdCont()
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS prod_cont FROM products");
        $result = mysqli_fetch_assoc($query);
        $likeCount = $result['like_count'];
        return $likeCount;
    }

    function productExists($id)
    {
        $res = mysqli_query($this->conn, "SELECT * FROM `products` WHERE id = '$id'") or die('query failed');
        return mysqli_num_rows($res) > 0;
    }

    function getProductByID($pr_id)
    {
        $query = "SELECT * FROM products WHERE id='$pr_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getProductByIds($user_id, $pr_id)
    {
        $query = "SELECT * FROM products WHERE user_id='$user_id' AND id='$pr_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function updateProduct($id, $title, $price, $category, $desc)
    {
        $query = "UPDATE products SET title='$title', price='$price', category='$category', description='$desc' WHERE id='$id'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function setProductView($pr_id, $user_id)
    {
        $query = "INSERT INTO viewed_products (user_id, product_id, created_at) VALUES ('$user_id', '$pr_id', NOW())";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    function isProductViewedToday($pr_id, $user_id)
    {
        $query = "SELECT * FROM viewed_products WHERE product_id='$pr_id' AND user_id='$user_id' AND DATE(created_at) = CURDATE() LIMIT 1";
        $result = $this->conn->query($query);

        return $result->num_rows > 0;
    }

    function updateViewTime($pr_id, $user_id)
    {
        $query = "UPDATE viewed_products SET created_at = NOW() WHERE user_id = '$user_id' AND product_id = '$pr_id' AND DATE(created_at) = CURDATE()";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function insertComment($user_id, $pr_id, $comment)
    {
        $query = "INSERT INTO product_comments (user_id, product_id, content) VALUES ('$user_id', '$pr_id', '$comment')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    function getComments($pr_id, $limit = null, $offset = null)
    {
        $query = "SELECT * FROM product_comments WHERE product_id='$pr_id'";

        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT $limit OFFSET $offset";
        }

        $result = $this->conn->query($query);
        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }

    function getCommentCount($pr_id)
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS comm_count FROM product_comments WHERE product_id = '$pr_id'");
        $result = mysqli_fetch_assoc($query);
        $commCount = $result['comm_count'];
        return $commCount;
    }

    function insertLike($user_id, $pr_id)
    {
        $query = "INSERT INTO product_likes (user_id, product_id, is_liked) VALUES ('$user_id', '$pr_id', '1')
        ON DUPLICATE KEY UPDATE is_liked = '1'";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;

        $this->conn->close();
    }

    function isLiked($user_id, $pr_id)
    {
        $query = "SELECT * FROM product_likes WHERE product_id='$pr_id' AND user_id='$user_id' AND is_liked='1' LIMIT 1";
        $result = $this->conn->query($query);

        return $result->num_rows == 1;
    }

    function setLike($user_id, $pr_id)
    {
        $query = "UPDATE product_likes SET is_liked = CASE WHEN is_liked = '1' THEN '0' ELSE '1' END WHERE product_id = '$pr_id' AND user_id = '$user_id'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function isLikeExists($user_id, $pr_id)
    {
        $query = "SELECT * FROM product_likes WHERE product_id='$pr_id' AND user_id='$user_id' LIMIT 1";
        $result = $this->conn->query($query);

        return $result->num_rows == 1;
    }

    function getLikeCount($pr_id)
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS like_count FROM product_likes WHERE product_id = '$pr_id' AND is_liked='1'");
        $result = mysqli_fetch_assoc($query);
        $likeCount = $result['like_count'];
        return $likeCount;
    }

    function getProductsLiked($user_id)
    {
        $query = "SELECT * FROM product_likes WHERE user_id='$user_id' AND is_liked='1'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getStatistic($user_id)
    {
        $query = "SELECT MONTHNAME(created_at) as monthname, COUNT(*) as amount FROM viewed_products WHERE user_id='$user_id' GROUP BY monthname";
        return $this->conn->query($query);
    }

    function getCategories()
    {
        $query = "SELECT category FROM products GROUP BY category DESC";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getProductByCategory($category)
    {
        $query = "SELECT * FROM products WHERE category='$category'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getMaxPrice()
    {
        $query = "SELECT MAX(price) as max_price FROM products";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        $maxPrice = $row['max_price'];
        return $maxPrice;
    }

    function getMinPrice()
    {
        $query = "SELECT MIN(price) as min_price FROM products";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        $minPrice = $row['min_price'];
        return $minPrice;
    }

    function LineChart($pr_id)
    {
        $query = "SELECT DATE(created_at) AS date, COUNT(*) AS view_count, product_id FROM viewed_products WHERE product_id = '$pr_id' GROUP BY product_id, date";
        return mysqli_query($this->conn, $query);
    }

    function PieChart($pr_id)
    {
        $query = "SELECT COUNT(*) AS likes FROM product_likes WHERE product_id = '$pr_id' AND is_liked='1' GROUP BY product_id";
        return mysqli_query($this->conn, $query);
    }

    function getViewedProducts($product_id)
    {
        $query = "SELECT * FROM viewed_products WHERE product_id='$product_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getProductBeyond($min, $max)
    {
        $query = "SELECT * FROM `products` WHERE price BETWEEN '$min' AND '$max'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        $this->conn->close();
        return array();
    }


    function insertIntoCard($user_id, $pr_id, $qua)
    {
        $query = "INSERT INTO card (user_id, product_id, quantity) VALUES ('$user_id', '$pr_id', '$qua')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;

        $this->conn->close();
    }

    function checkCardExist($user_id, $pr_id)
    {
        $query = "SELECT * FROM card WHERE user_id='$user_id' AND product_id='$pr_id' LIMIT 1";
        $result = $this->conn->query($query);

        return $result->num_rows == 1;
    }

    function updateCard($card)
    {
        $query = "UPDATE card SET quantity = '{$card['quantity']}' WHERE user_id = '{$card['user_id']}' and product_id='{$card['product_id']}'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }

    function getCardRecByID($user_id, $pr_id)
    {
        $query = "SELECT * FROM card WHERE user_id='$user_id' AND product_id='$pr_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function cardProducts($user_id)
    {
        $query = "SELECT * FROM card WHERE user_id='$user_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        $this->conn->close();
        return array();
    }

    function cardProductsCount($user_id)
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS card_count FROM card WHERE user_id = '$user_id'");
        $result = mysqli_fetch_assoc($query);
        $card_count = $result['card_count'];
        return $card_count;
    }


    function deleteFromCard($id)
    {
        $query = "DELETE FROM card WHERE id='$id'";
        $result = $this->conn->query($query);

        return $result === true;
    }

    function getLastElementFromTable()
    {
        $query = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $lastElement = $result->fetch_assoc()['order_num'];
            return $lastElement;
        } else {
            return null;
        }
    }


    function insertOrder($user_id, $pr_id, $name, $surname, $payment_type, $street, $city, $region, $postal, $country, $total, $order_num, $qua, $adm)
    {
        $query = "INSERT INTO orders (user_id, product_id, name, surname, payment_type, street, city, region, postal, country, total, order_num, quantity, adm_id) VALUES ('$user_id', '$pr_id', '$name', '$surname', '$payment_type', '$street', '$city', '$region', '$postal', '$country', '$total', '$order_num', '$qua', '$adm')";
        if ($this->conn->query($query) === TRUE) {
            return TRUE;
        }
        return FALSE;

        $this->conn->close();
    }

    function getOrderByUserID($user_id)
    {
        $query = "SELECT * FROM orders WHERE user_id='$user_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getOrderCount($order_num)
    {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS order_number FROM orders WHERE order_num='$order_num'");
        $result = mysqli_fetch_assoc($query);
        $orderCount = $result['order_number'];
        return $orderCount;
    }

    function getAllOrderNums($user_id)
    {
        $query = "SELECT order_num FROM `orders` WHERE user_id='$user_id' GROUP BY order_num";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getAllOrderNumsByState($user_id, $state)
    {
        $query = "SELECT order_num FROM `orders` WHERE user_id='$user_id' AND state='$state' GROUP BY order_num";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getOrdersByNum($order_num)
    {
        $query = "SELECT * FROM `orders` WHERE order_num='$order_num'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function isOrderExists($order_num)
    {
        $res = mysqli_query($this->conn, "SELECT * FROM `orders` WHERE order_num = '$order_num'") or die('query failed');
        return mysqli_num_rows($res) > 0;
    }

    function getOrders()
    {
        $query = "SELECT * FROM `orders`";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getOrdersByNumID($order_num, $pr_id)
    {
        $query = "SELECT * FROM `orders` WHERE product_id='$pr_id' AND order_num='$order_num'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        $this->conn->close();
        return array();
    }

    function getOrdersByID($user_id)
    {
        $query = "SELECT * FROM `orders` WHERE adm_id='$user_id'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getAllOrderNumsByID($user_id)
    {
        $query = "SELECT order_num FROM `orders` WHERE adm_id='$user_id' GROUP BY order_num";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }


    // function getOrderByNumID($user_id, $order_num){
    //     $query = "SELECT * FROM `orders` WHERE adm_id='$user_id' AND order_num='$order_num'";
    //     $result = $this->conn->query($query);
    //     if ($result->num_rows > 0) {
    //         return $result->fetch_all(MYSQLI_ASSOC);
    //     } 
    //     return array();

    //     $this->conn->close();
    // }

    function getOrderByNum($order_num, $adm)
    {
        $query = "SELECT * FROM `orders` WHERE order_num='$order_num' AND adm_id='$adm'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();

        $this->conn->close();
    }

    function getOrderInfo($num, $adm)
    {
        $query = "SELECT * FROM `orders` WHERE order_num='$num' AND adm_id='$adm' LIMIT 1";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function updateState($order_num, $adm, $state, $pr_id)
    {
        $query = "UPDATE orders SET state = '$state' WHERE order_num='$order_num' AND adm_id='$adm' AND product_id='$pr_id'";
        $result = $this->conn->query($query);

        return $result === TRUE;
    }
}
